<?php

class runIRCR{

	private $AGIvars = array();
	public $nationalityArray = array(1,2,3,4,5,6,7);
	public $FeedBack;
	public $serviceArray = array(1,2,3,4,5,6,7,8);
	public $fiveAnswers = array(1,2,3,4,5);
	public $fourAnswers = array(1,2,3,4);

	public $languageArray = array(1,2,3);
	public $MappingArray = array();
	public $SP = array();

	public function __construct($AGIvars = array())
	{
		$this->AGIvars = $AGIvars;

		foreach($this->AGIvars as $k=>$v)
		{
			self::log_agi("Got $k=$v");
		}
		self::log_agi("DB name ".DB_NAME);
	}

	public function runIvr()
	{
		extract($this->AGIvars);
		$language = '';
		$this->FeedBack["RANI"] = $agi_callerid;

		runIRCR::log_agi("**************** Play Welcom Rec ******************");
		//play welcom record
		self::execute_agi('STREAM FILE IRC/1IRC0100 ""' );
		self::execute_agi('STREAM FILE IRC/1IRC0100 ""' );
		self::execute_agi('STREAM FILE IRC/2IRC0100 ""' );
		self::execute_agi('STREAM FILE IRC/3IRC0100 ""' );

		runIRCR::log_agi("**************** Play Select Language ******************");
		//Call Select Language Function
		$language = self::SelectLanguage();

		runIRCR::log_agi("**************** Start Account Menu ******************");
		//Call Account Menu Function
		$ext = self::RefugeeMenu($language);


		self::log_agi("Got extension $ext");
		// self::execute_agi("SAY DIGITS $ext \"\"");

		// self::execute_agi('STREAM FILE IRC/'.$language.'IRC0095 ""');
		self::execute_agi('HANGUP');
	}

	public function SelectLanguage()
	{
		$result = self::execute_agi("GET DATA IRC/IRC0002 2000 1");
		$language = $result['result'];
		if(in_array($language, $this->languageArray))
		{
			return $language;
		}
		else
		{
			return self::SelectLanguage();
		}
	}

	public function RefugeeMenu($language)
	{
		$result = self::execute_agi("GET DATA IRC/".$language."IRC0101 2000 1");
		
		if($result['result'] == 1 )
			return self::ServiceMapping($language);

		if($result['result'] == 2)
			return self::AddFeedBack($language);

		else
			return self::RefugeeMenu($language);
	}


	// ***********************************************************************************************
	// 									New Feedback
	// ***********************************************************************************************

	public function AddFeedBack($language)
	{
		return self::RecordRefugeeName($language);
	}

	public function RecordRefugeeName($language)
	{
		self::log_agi("**************** Start New Feedback ******************");
		$RecNamePath = R_RECPATH."/".$this->FeedBack["RANI"]."/NAME";

		if (!is_dir($RecNamePath))
		{
			mkdir($RecNamePath, 0755, true);
		}

		self::execute_agi('STREAM FILE IRC/'.$language.'IRC0102 ""' );

		$this->FeedBack["RefugeeNamePath"] = $RecNamePath.'/R_NAME_'.date("Ymd").'_'.date("His");

		$result = self::execute_agi('RECORD FILE '. $this->FeedBack["RefugeeNamePath"] .' wav "0123456789*#" 20000 1000 1');
		
		if($result >= 0)
			return self::ConfirmRefugeeNameRecord($language);	
		else
			return self::RecordRefugeeName($language);
	}

	public function ConfirmRefugeeNameRecord($language)
	{
		self::execute_agi('STREAM FILE IRC/'.$language.'IRC0014 ""');
		self::execute_agi('STREAM FILE '. $this->FeedBack["RefugeeNamePath"] .' ""' );
		$result = self::execute_agi("GET DATA IRC/".$language."IRC0015 1000 1");

		if($result["result"] == 1)
		{
			return self::SelectRefugeeNationality($language);
		}
		if($result["result"] == 2)
		{
			unlink($this->FeedBack["RefugeeNamePath"].".wav");
			return self::RecordRefugeeName($language);
		}
		else
			return self::ConfirmRefugeeNameRecord($language);
	}

	public function SelectRefugeeNationality($language)
	{
		self::execute_agi('STREAM FILE IRC/'.$language.'IRC0103 ""');
		$result = self::execute_agi("GET DATA IRC/".$language."IRC0104 1000 1");

		if(in_array($result["result"],$this->nationalityArray))
		{
			$this->FeedBack["NationalityID"] = $result["result"];
			return self::GetRefugeeAge($language);
		}
		else
			return self::SelectRefugeeNationality($language);
	}

	public function GetRefugeeAge($language)
	{
		$result = self::execute_agi("GET DATA IRC/".$language."IRC0111 2000 2");
		if($result["result"] > 0)
		{
			$this->FeedBack["Age"] = $result["result"];
			return self::SetRefugeeAnonymous($language);
		}
		else
			return self::GetRefugeeAge($language);
	}

	public function SetRefugeeAnonymous($language)
	{
		$result = self::execute_agi("GET DATA IRC/".$language."IRC0112 2000 1");
		self::log_agi($result["result"]);

		if($result["result"] == 1)
		{
			$this->FeedBack["IsAnonymous"] = 1;
		}
		else if($result["result"] == 2)
		{
			$this->FeedBack["IsAnonymous"] = 0;
		}
		else
			return self::SetRefugeeAnonymous($language);

		return self::SetServiceTypeFeedBack($language);
	}

	public function SetServiceTypeFeedBack($language)
	{
		self::execute_agi('STREAM FILE IRC/'.$language.'IRC0113 ""');
		$result = self::execute_agi("GET DATA IRC/".$language."IRC0047 2000 1");

		if(in_array($result["result"], $this->serviceArray))
		{
			$this->FeedBack["ServiceType"] = $result["result"];
			self::log_agi("Service Type ID ". $this->FeedBack["ServiceType"]);
			return self::SetGovernorateFeedBack($language);
		}
		else
			return self::SetServiceTypeFeedBack($language);
	}

	public function SetGovernorateFeedBack($language)
	{
		self::execute_agi('STREAM FILE IRC/'.$language.'IRC0114 ""' );
		self::execute_agi('STREAM FILE IRC/'.$language.'IRC0056 ""' );

		$allGovernorates = IRCModel::getGovernorate();
		if(empty($allGovernorates))
			self::log_agi("emtpy array");
		else
			self::log_agi("not emtpy array");
		
		reset($allGovernorates);
		$firstKey = key($allGovernorates);
		end($allGovernorates);
		$lastKey = key($allGovernorates);
		reset($allGovernorates);

		$selected = 0;

		while($selected != 3)
		{
			$current = current($allGovernorates);
			self::log_agi("current ". $current->GovID);
			self::log_agi("First Key ". $firstKey);
			self::log_agi("Last Key ". $lastKey);
			self::execute_agi('STREAM FILE IRC/'.$language.''.$current->GovNamePath.' "123"' );
			$result = self::execute_agi('WAIT FOR DIGIT 2000');
			if ($result['result'] >= 49 && $result['result'] <= 51) {
				$selected = chr($result['result']);
			}
			else 
			{
				if($lastKey == key($allGovernorates))
					$current = reset($allGovernorates);
				else
					$current = next($allGovernorates);

				self::log_agi("current ". $current->GovID);
				continue;
			}
			if($selected == 1)
			{
				if($firstKey == key($allGovernorates))
					$current = end($allGovernorates);
				else
					$current = prev($allGovernorates);

				self::log_agi("current ". $current->GovID);
				continue;
			}
			if($selected == 2)
			{
				if($lastKey == key($allGovernorates))
					$current = reset($allGovernorates);
				else
					$current = next($allGovernorates);

				self::log_agi("current ". $current->GovID);
				continue;
			}
			if($selected == 3)
			{
				$this->FeedBack["ServiceGov"] = $current->GovID;
				break;
			}
		}
		return self::SetDistrictFeedBack($language);
	}

	public function SetDistrictFeedBack($language)
	{
		self::execute_agi('STREAM FILE IRC/'.$language.'IRC0115 ""' );
		self::execute_agi('STREAM FILE IRC/'.$language.'IRC0056 ""' );

		$allDistricts = IRCModel::getDistrict($this->FeedBack["ServiceGov"]);
		if(empty($allDistricts))
			self::log_agi("emtpy array");
		else
			self::log_agi("not emtpy array");

		reset($allDistricts);
		$firstKey = key($allDistricts);
		end($allDistricts);
		$lastKey = key($allDistricts);
		reset($allDistricts);

		$selected = 0;

		while($selected != 3)
		{
			$current = current($allDistricts);
			self::log_agi("current ". $current->DistID);
			self::log_agi("First Key ". $firstKey);
			self::log_agi("Last Key ". $lastKey);
			self::execute_agi('STREAM FILE IRC/'.$language.''.$current->DistNamePath.' "123"' );
			$result = self::execute_agi('WAIT FOR DIGIT 2000');
			if ($result['result'] >= 49 && $result['result'] <= 51) {
				$selected = chr($result['result']);
			}
			else {
				if($lastKey == key($allDistricts))
					$current = reset($allDistricts);
				else
					$current = next($allDistricts);

				self::log_agi("current ". $current->DistID);
				continue;
			}
			if($selected == 1)
			{
				if($firstKey == key($allDistricts))
					$current = end($allDistricts);
				else
					$current = prev($allDistricts);

				self::log_agi("current ". $current->DistID);
				continue;
			}
			if($selected == 2)
			{
				if($lastKey == key($allDistricts))
					$current = reset($allDistricts);
				else
					$current = next($allDistricts);

				self::log_agi("current ". $current->DistID);
				continue;
			}
			if($selected == 3)
			{
				$this->FeedBack["ServiceDist"] = $current->DistID;
				break;
			}
		}
		return self::SetServiceProviderName($language);
	}

	public function SetServiceProviderName($language)
	{
		$allSP = IRCModel::getServiceProviders($this->FeedBack["ServiceType"], $this->FeedBack["ServiceDist"]);

		foreach ($allSP as $sp) 
		{
			self::log_agi("SP => ".$sp->SPID);
		}
		if(empty($allSP))
		{
			self::log_agi("**************** No Services ******************");
			self::execute_agi('STREAM FILE IRC/'.$language.'IRC0172 ""' );
			return self::RefugeeMenu($language);
		}
		else
		{
			self::execute_agi('STREAM FILE IRC/'.$language.'IRC0116 ""' );
			self::execute_agi('STREAM FILE IRC/'.$language.'IRC0056 ""' );

			reset($allSP);
			$firstKey = key($allSP);
			end($allSP);
			$lastKey = key($allSP);
			reset($allSP);

			$selected = 0;

			while($selected != 3)
			{
				$current = current($allSP);
				self::log_agi("current ". $current->SPID);
				self::log_agi("First Key ". $firstKey);
				self::log_agi("Last Key ". $lastKey);
				self::execute_agi('STREAM FILE '.$current->SPNamePath.' "123"' );
				$result = self::execute_agi('WAIT FOR DIGIT 2000');
				if ($result['result'] >= 49 && $result['result'] <= 51) {
					$selected = chr($result['result']);
				}
				else 
				{
					if($lastKey == key($allSP))
						$current = reset($allSP);
					else
						$current = next($allSP);

					self::log_agi("current ". $current->SPID);
					continue;
				}
				if($selected == 1)
				{
					if($firstKey == key($allSP))
						$current = end($allSP);
					else
						$current = prev($allSP);

					self::log_agi("current ". $current->SPID);
					continue;
				}
				if($selected == 2)
				{
					if($lastKey == key($allSP))
						$current = reset($allSP);
					else
						$current = next($allSP);

					self::log_agi("current ". $current->SPID);
					continue;
				}
				if($selected == 3)
				{
					$this->FeedBack["SPID"] = $current->SPID;
					break;
				}
			}
		}

		return self::SetServiceName($language);
	}

	public function SetServiceName($language)
	{
		$allServices = IRCModel::getServiceByTypeAndDist($this->FeedBack["ServiceType"], $this->FeedBack["ServiceDist"], $this->FeedBack["SPID"]);

		foreach ($allServices as $sp) 
		{
			self::log_agi("SP => ".$sp->SPID);
		}
		if(empty($allServices))
		{
			self::log_agi("**************** No Services ******************");
			self::execute_agi('STREAM FILE IRC/'.$language.'IRC0172 ""' );
			return self::RefugeeMenu($language);
		}
		else
		{
			self::execute_agi('STREAM FILE IRC/'.$language.'IRC0117 ""' );
			self::execute_agi('STREAM FILE IRC/'.$language.'IRC0056 ""' );

			reset($allServices);
			$firstKey = key($allServices);
			end($allServices);
			$lastKey = key($allServices);
			reset($allServices);

			$selected = 0;

			while($selected != 3)
			{
				$current = current($allServices);
				self::log_agi("current ". $current->ServiceID);
				self::log_agi("First Key ". $firstKey);
				self::log_agi("Last Key ". $lastKey);
				self::execute_agi('STREAM FILE '.$current->ServiceNamePath.' "123"' );
				$result = self::execute_agi('WAIT FOR DIGIT 2000');
				if ($result['result'] >= 49 && $result['result'] <= 51) {
					$selected = chr($result['result']);
				}
				else 
				{
					if($lastKey == key($allServices))
						$current = reset($allServices);
					else
						$current = next($allServices);

					self::log_agi("current ". $current->ServiceID);
					continue;
				}
				if($selected == 1)
				{
					if($firstKey == key($allServices))
						$current = end($allServices);
					else
						$current = prev($allServices);

					self::log_agi("current ". $current->ServiceID);
					continue;
				}
				if($selected == 2)
				{
					if($lastKey == key($allServices))
						$current = reset($allServices);
					else
						$current = next($allServices);

					self::log_agi("current ". $current->ServiceID);
					continue;
				}
				if($selected == 3)
				{
					$this->FeedBack["ServiceID"] = $current->ServiceID;
					break;
				}
			}
		}

		return self::DeliveryFeedBack($language);
	}

	// public function SetFeedBackType($language)
	// {
	// 	$result = self::execute_agi("GET DATA IRC/".$language."IRC0118 2000 1");
	// 	if($result["result"] == 1)
	// 		return self::DeliveryFeedBack($language);
		
	// 	if($result["result"] == 2)
	// 		return self::WaitingFeedBack($language);

	// 	if($result["result"] == 3)
	// 		return self::AccessFeedBack($language);

	// 	if($result["result"] == 4)
	// 		return self::StuffFeedBack($language);

	// 	if($result["result"] == 5)
	// 		return self::OtherFeedBack($language);

	// 	else
	// 		return self::SetFeedBackType($language);
	// }

	public function DeliveryFeedBack($language)
	{
		self::execute_agi('STREAM FILE IRC/'.$language.'IRC0119 ""' );
		$result = self::execute_agi("GET DATA IRC/".$language."IRC0120 2000 1");
		if($result["result"] == 1)
		{
			$this->FeedBack["Answer1"] = $result["result"];
			return self::DeliverySuccessReviewFeedBack($language);
		}
		
		if($result["result"] == 2)
		{
			$this->FeedBack["Answer1"] = $result["result"];
			return self::DeliveryFaildReviewFeedBack($language);
		}
		else
			return self::DeliveryFeedBack($language);
	}

	public function DeliverySuccessReviewFeedBack($language)
	{
		self::execute_agi('STREAM FILE IRC/'.$language.'IRC0121 ""' );
		self::execute_agi('STREAM FILE IRC/'.$language.'IRC0132 ""' );
		$result = self::execute_agi("GET DATA IRC/".$language."IRC0122 2000 1");
		if(in_array($result["result"], $this->fiveAnswers))
		{
			$this->FeedBack["Answer2"] =  $result["result"];
			$this->FeedBack["Answer3"] =  0;
			return self::WaitingFeedBack($language);
		}
		else
			return self::DeliveryFeedBack($language);

	}

	public function DeliveryFaildReviewFeedBack($language)
	{
		self::execute_agi('STREAM FILE IRC/'.$language.'IRC0127 ""' );
		// self::execute_agi('STREAM FILE IRC/'.$language.'IRC0132 ""' );
		$result = self::execute_agi("GET DATA IRC/".$language."IRC0128 2000 1");
		if(in_array($result["result"], $this->fourAnswers))
		{
			$this->FeedBack["Answer3"] =  $result["result"];
			$this->FeedBack["Answer2"] =  0;
			return self::WaitingFeedBack($language);
		}
		else
			return self::DeliveryFaildReviewFeedBack($language);
	}

	public function WaitingFeedBack($language)
	{
		self::execute_agi('STREAM FILE IRC/'.$language.'IRC0133 ""' );
		self::execute_agi('STREAM FILE IRC/'.$language.'IRC0132 ""' );
		$result = self::execute_agi("GET DATA IRC/".$language."IRC0134 2000 1");
		if(in_array($result["result"], $this->fiveAnswers))
		{
			$this->FeedBack["Answer4"] =  $result["result"];
			return self::WaitingReviewFeedBack($language);
		}
		else
			return self::WaitingFeedBack($language);
	}

	public function WaitingReviewFeedBack($language)
	{
		self::execute_agi('STREAM FILE IRC/'.$language.'IRC0139 ""' );
		self::execute_agi('STREAM FILE IRC/'.$language.'IRC0132 ""' );
		$result = self::execute_agi("GET DATA IRC/".$language."IRC0122 2000 1");
		if(in_array($result["result"], $this->fiveAnswers))
		{
			$this->FeedBack["Answer5"] =  $result["result"];
			return self::AccessFeedBack($language);
		}
		else
			return self::WaitingReviewFeedBack($language);
	}

	public function AccessFeedBack($language)
	{
		self::execute_agi('STREAM FILE IRC/'.$language.'IRC0140 ""' );
		$result = self::execute_agi("GET DATA IRC/".$language."IRC0120 2000 1");
		if($result["result"] == 1)
		{
			return self::SetAccessFeedBack($language);
		}
		
		if($result["result"] == 2)
		{
			$this->FeedBack["Answer6"] = 0;
			return self::StuffFeedBack($language);
		}
		else
			return self::AccessFeedBack($language);
	}

	public function SetAccessFeedBack($language)
	{
		self::execute_agi('STREAM FILE IRC/'.$language.'IRC0141 ""' );

		$result = self::execute_agi("GET DATA IRC/".$language."IRC0142 2000 1");
		if(in_array($result["result"], $this->fiveAnswers))
		{
			$this->FeedBack["Answer6"] =  $result["result"];
			if($result["result"] == 5)
				return self::RecExtraExplanation($language);

			return self::StuffFeedBack($language);
		}
		else
			return self::SetAccessFeedBack($language);
	}

	public function RecExtraExplanation($language)
	{
		self::execute_agi('STREAM FILE IRC/'.$language.'IRC0147 ""' );

		$RecNamePath = R_RECPATH."/".$this->FeedBack["RANI"]."/EXTRA_EXPLANATION";

		if (!is_dir($RecNamePath))
		{
			mkdir($RecNamePath, 0755, true);
		}

		$this->FeedBack["ExtraExplanation"] = $RecNamePath.'/R_EXTRA_EXP_'.date("Ymd").'_'.date("His");

		$result = self::execute_agi('RECORD FILE '. $this->FeedBack["ExtraExplanation"] .' wav "0123456789*#" 20000 1000 1');
		if($result["result"] >= 0)
		{
			self::execute_agi('STREAM FILE IRC/'.$language.'IRC0148 ""');
			self::execute_agi('STREAM FILE '. $this->FeedBack["ExtraExplanation"] .' ""' );
		}
		else
			return self::RecExtraExplanation($language);

		return self::StuffFeedBack($language);
	}

	public function StuffFeedBack($language)
	{
		self::execute_agi('STREAM FILE IRC/'.$language.'IRC0149 ""' );
		self::execute_agi('STREAM FILE IRC/'.$language.'IRC0132 ""' );
		$result = self::execute_agi("GET DATA IRC/".$language."IRC0122 2000 1");
		if(in_array($result["result"], $this->fiveAnswers))
		{
			$this->FeedBack["Answer7"] =  $result["result"];
			return self::OtherFeedBack($language);
		}
		else
			return self::StuffFeedBack($language);
	}

	public function OtherFeedBack($language)
	{
		self::execute_agi('STREAM FILE IRC/'.$language.'IRC0150 ""' );

		$RecNamePath = R_RECPATH."/".$this->FeedBack["RANI"]."/EXTRA_COMMENT";

		if (!is_dir($RecNamePath))
		{
			mkdir($RecNamePath, 0755, true);
		}

		$this->FeedBack["ExtraComments"] = $RecNamePath.'/R_EXTRA_CMT_'.date("Ymd").'_'.date("His");

		$result = self::execute_agi('RECORD FILE '. $this->FeedBack["ExtraComments"] .' wav "0123456789*#" 20000 1000 1');
		if($result["result"] >= 0)
		{
			self::execute_agi('STREAM FILE IRC/'.$language.'IRC0151 ""');
			self::execute_agi('STREAM FILE '. $this->FeedBack["ExtraComments"] .' ""' );
			
		}
		else
			return self::OtherFeedBack($language);

		return self::EndFeedBack($language);
	}

	public function EndFeedBack($language)
	{
		$addFeedBack = new feedbackjiracreation();
		$addFeedBack->fromArray($this->FeedBack);
		
		foreach ($this->FeedBack as $key => $value) 
		{
			self::log_agi("Feedbak ".$key." => ". $value);
		}

		if($addFeedBack->insert())
		{
			self::log_agi("Feedback success");
			self::execute_agi('STREAM FILE IRC/'.$language.'IRC0154 ""');
			self::execute_agi('STREAM FILE IRC/'.$language.'IRC0155 ""');
			return 1;	
		}
		else
			self::log_agi("Feedback Faild");

		return 2;
	}

	// **********************************************************************************
	// 							ServiceMapping
	// **********************************************************************************

	public function ServiceMapping($language)
	{
		$result = self::execute_agi("GET DATA IRC/".$language."IRC0157 2000 1");
		
		if($result['result'] == 1 )
			return self::EnterSPPin($language);

		if($result['result'] == 2)
			return self::SetMappingServiceType($language);

		else
			return self::ServiceMapping($language);
	}

	public function EnterSPPin($language)
	{
		$result = self::execute_agi("GET DATA IRC/".$language."IRC0158 4000 4");
		
		if(strlen($result["result"]) == 4)
		{
			$this->SP = IRCModel::exsitSPAccount($result["result"]);
			if($this->SP)
			{
				foreach ($this->SP as $key => $value) {
					self::log_agi("Account ".$key." => ".$value);
				}

				$this->MappingArray["SPID"] = $this->SP->SPID;
				$this->MappingArray["SPFocalPointPhone"] = $this->SP->SPFocalPointPhone;
				$this->MappingArray["SPFocalPointPath"] = $this->SP->SPFocalPointPath;
				$this->MappingArray["SPNamePath"] = $this->SP->SPNamePath;
				$this->MappingArray["SPPhone"] = $this->SP->SPPhone;

				self::execute_agi('STREAM FILE IRC/'.$language.'IRC0159 ""' );
				self::execute_agi('STREAM FILE '.$this->SP->SPNamePath.' ""' );

				return self::ContinueMapping($language);
			}
			else
			{
				self::execute_agi('STREAM FILE IRC/'.$language.'IRC0172 ""' );
				return self::ServiceMapping($language);
			}
		}
		else
			return self::EnterSPPin($language);
	}

	public function ContinueMapping($language)
	{
		$result = self::execute_agi("GET DATA IRC/".$language."IRC0160 2000 1");

		if($result["result"] == 1)
			return self::ServiceMappingByPin($language);

		if($result["result"] == 2)
			return self::EnterSPPin($language);

		else
			return self::ContinueMapping($language);
	}

	public function SetMappingServiceType($language)
	{
		self::execute_agi('STREAM FILE IRC/'.$language.'IRC0161 ""');
		$result = self::execute_agi("GET DATA IRC/".$language."IRC0162 2000 1");

		if(in_array($result["result"], $this->serviceArray))
		{
			$this->MappingArray["ServiceType"] = $result["result"];
			self::log_agi("Service Type ID ". $this->MappingArray["ServiceType"]);
			return self::SetMappingGovernorate($language);
		}
		else
			return self::SetMappingServiceType($language);
	}

	public function SetMappingGovernorate($language)
	{
		self::execute_agi('STREAM FILE IRC/'.$language.'IRC0170 ""' );
		self::execute_agi('STREAM FILE IRC/'.$language.'IRC0056 ""' );

		$allGovernorates = IRCModel::getGovernorate();
		if(empty($allGovernorates))
			self::log_agi("emtpy array");
		else
			self::log_agi("not emtpy array");

		reset($allGovernorates);
		$firstKey = key($allGovernorates);
		end($allGovernorates);
		$lastKey = key($allGovernorates);
		reset($allGovernorates);

		$selected = 0;

		while($selected != 3)
		{
			$current = current($allGovernorates);
			self::log_agi("current ". $current->GovID);
			self::log_agi("First Key ". $firstKey);
			self::log_agi("Last Key ". $lastKey);
			self::execute_agi('STREAM FILE IRC/'.$language.''.$current->GovNamePath.' "123"' );
			$result = self::execute_agi('WAIT FOR DIGIT 2000');
			if ($result['result'] >= 49 && $result['result'] <= 51) {
				$selected = chr($result['result']);
			}
			else {
				if($lastKey == key($allGovernorates))
					$current = reset($allGovernorates);
				else
					$current = next($allGovernorates);

				self::log_agi("current ". $current->GovID);
				continue;
			}
			if($selected == 1)
			{
				if($firstKey == key($allGovernorates))
					$current = end($allGovernorates);
				else
					$current = prev($allGovernorates);

				self::log_agi("current ". $current->GovID);
				continue;
			}
			if($selected == 2)
			{
				if($lastKey == key($allGovernorates))
					$current = reset($allGovernorates);
				else
					$current = next($allGovernorates);

				self::log_agi("current ". $current->GovID);
				continue;
			}
			if($selected == 3)
			{
				$this->MappingArray["ServiceGov"] = $current->GovID;
				break;
			}
		}
		return self::SetMappingDistrict($language);
	}

	public function SetMappingDistrict($language)
	{
		self::execute_agi('STREAM FILE IRC/'.$language.'IRC0171 ""' );
		self::execute_agi('STREAM FILE IRC/'.$language.'IRC0056 ""' );

		$allDistricts = IRCModel::getDistrict($this->MappingArray["ServiceGov"]);
		if(empty($allDistricts))
			self::log_agi("emtpy array");
		else
			self::log_agi("not emtpy array");

		reset($allDistricts);
		$firstKey = key($allDistricts);
		end($allDistricts);
		$lastKey = key($allDistricts);
		reset($allDistricts);

		$selected = 0;

		while($selected != 3)
		{
			$current = current($allDistricts);
			self::log_agi("current ". $current->DistID);
			self::log_agi("First Key ". $firstKey);
			self::log_agi("Last Key ". $lastKey);
			self::execute_agi('STREAM FILE IRC/'.$language.''.$current->DistNamePath.' "123"' );
			$result = self::execute_agi('WAIT FOR DIGIT 2000');
			if ($result['result'] >= 49 && $result['result'] <= 51) {
				$selected = chr($result['result']);
			}
			else {
				if($lastKey == key($allDistricts))
					$current = reset($allDistricts);
				else
					$current = next($allDistricts);

				self::log_agi("current ". $current->DistID);
				continue;
			}
			if($selected == 1)
			{
				if($firstKey == key($allDistricts))
					$current = end($allDistricts);
				else
					$current = prev($allDistricts);

				self::log_agi("current ". $current->DistID);
				continue;
			}
			if($selected == 2)
			{
				if($lastKey == key($allDistricts))
					$current = reset($allDistricts);
				else
					$current = next($allDistricts);

				self::log_agi("current ". $current->DistID);
				continue;
			}
			if($selected == 3)
			{
				$this->MappingArray["ServiceDist"] = $current->DistID;
				break;
			}
		}
		return self::SetMappingSP($language);
	}

	public function SetMappingSP($language)
	{
		$allSP = IRCModel::getServiceProviders($this->MappingArray["ServiceType"], $this->MappingArray["ServiceDist"]);

		foreach ($allSP as $sp) 
		{
			self::log_agi("SP => ".$sp->SPID);
		}
		if(empty($allSP))
		{
			self::log_agi("**************** No Services ******************");
			self::execute_agi('STREAM FILE IRC/'.$language.'IRC0172 ""' );
			return self::RefugeeMenu($language);
		}
		else
		{
			self::execute_agi('STREAM FILE IRC/'.$language.'IRC0173 ""' );
			self::execute_agi('STREAM FILE IRC/'.$language.'IRC0056 ""' );

			reset($allSP);
			$firstKey = key($allSP);
			end($allSP);
			$lastKey = key($allSP);
			reset($allSP);

			$selected = 0;

			while($selected != 3)
			{
				$current = current($allSP);
				self::log_agi("current ". $current->SPID);
				self::log_agi("First Key ". $firstKey);
				self::log_agi("Last Key ". $lastKey);
				self::execute_agi('STREAM FILE '.$current->SPNamePath.' "123"' );
				$result = self::execute_agi('WAIT FOR DIGIT 2000');
				if ($result['result'] >= 49 && $result['result'] <= 51) {
					$selected = chr($result['result']);
				}
				else {
					if($lastKey == key($allSP))
						$current = reset($allSP);
					else
						$current = next($allSP);

					self::log_agi("current ". $current->SPID);
					continue;
				}
				if($selected == 1)
				{
					if($firstKey == key($allSP))
						$current = end($allSP);
					else
						$current = prev($allSP);

					self::log_agi("current ". $current->SPID);
					continue;
				}
				if($selected == 2)
				{
					if($lastKey == key($allSP))
						$current = reset($allSP);
					else
						$current = next($allSP);

					self::log_agi("current ". $current->SPID);
					continue;
				}
				if($selected == 3)
				{
					$this->MappingArray["SPID"] = $current->SPID;
					$this->MappingArray["SPFocalPointPhone"] = $current->SPFocalPointPhone;
					$this->MappingArray["SPFocalPointPath"] = $current->SPFocalPointPath;
					$this->MappingArray["SPNamePath"] = $current->SPNamePath;
					$this->MappingArray["SPPhone"] = $current->SPPhone;
					break;
				}
			}
		}
		return self::SetMappingServiceName($language);
	}

	public function SetMappingServiceName($language)
	{
		$allServices = IRCModel::getServiceByTypeAndDist($this->MappingArray["ServiceType"], $this->MappingArray["ServiceDist"], $this->MappingArray["SPID"]);

		foreach ($allServices as $sp) 
		{
			self::log_agi("Service ID => ".$sp->ServiceID);
		}
		if(empty($allServices))
		{
			self::log_agi("**************** No Services ******************");
			self::execute_agi('STREAM FILE IRC/'.$language.'IRC0172 ""' );
			return self::RefugeeMenu($language);
		}
		else
		{
			self::execute_agi('STREAM FILE IRC/'.$language.'IRC0174 ""' );
			self::execute_agi('STREAM FILE IRC/'.$language.'IRC0056 ""' );

			reset($allServices);
			$firstKey = key($allServices);
			end($allServices);
			$lastKey = key($allServices);
			reset($allServices);

			$selected = 0;

			while($selected != 3)
			{
				$current = current($allServices);
				self::log_agi("current ". $current->ServiceID);
				self::log_agi("First Key ". $firstKey);
				self::log_agi("Last Key ". $lastKey);
				self::execute_agi('STREAM FILE '.$current->ServiceNamePath.' "123"' );
				$result = self::execute_agi('WAIT FOR DIGIT 2000');
				if ($result['result'] >= 49 && $result['result'] <= 51) {
					$selected = chr($result['result']);
				}
				else {
					if($lastKey == key($allServices))
						$current = reset($allServices);
					else
						$current = next($allServices);

					self::log_agi("current ". $current->ServiceID);
					continue;
				}
				if($selected == 1)
				{
					if($firstKey == key($allServices))
						$current = end($allServices);
					else
						$current = prev($allServices);

					self::log_agi("current ". $current->ServiceID);
					continue;
				}
				if($selected == 2)
				{
					if($lastKey == key($allServices))
						$current = reset($allServices);
					else
						$current = next($allServices);

					self::log_agi("current ". $current->ServiceID);
					continue;
				}
				if($selected == 3)
				{
					$this->MappingArray["ServiceID"] = $current->ServiceID;
					break;
				}
			}
		}

		return self::PlaySPData($language);
	}

	public function ServiceMappingByPin($language)
	{
		$allServices = IRCModel::getServiceBySPID($this->MappingArray["SPID"]);

		foreach ($allServices as $sp) 
		{
			self::log_agi("SP => ".$sp->SPID);
		}
		if(empty($allServices))
		{
			self::log_agi("**************** No Services ******************");
			self::execute_agi('STREAM FILE IRC/'.$language.'IRC0172 ""' );
			return self::RefugeeMenu($language);
		}
		else
		{
			self::execute_agi('STREAM FILE IRC/'.$language.'IRC0174 ""' );
			self::execute_agi('STREAM FILE IRC/'.$language.'IRC0056 ""' );

			reset($allServices);
			$firstKey = key($allServices);
			end($allServices);
			$lastKey = key($allServices);
			reset($allServices);

			$selected = 0;

			while($selected != 3)
			{
				$current = current($allServices);
				self::log_agi("current ". $current->ServiceID);
				self::log_agi("First Key ". $firstKey);
				self::log_agi("Last Key ". $lastKey);
				self::execute_agi('STREAM FILE '.$current->ServiceNamePath.' "123"' );
				$result = self::execute_agi('WAIT FOR DIGIT 2000');
				if ($result['result'] >= 49 && $result['result'] <= 51) {
					$selected = chr($result['result']);
				}
				else {
					if($lastKey == key($allServices))
						$current = reset($allServices);
					else
						$current = next($allServices);

					self::log_agi("current ". $current->ServiceID);
					continue;
				}
				if($selected == 1)
				{
					if($firstKey == key($allServices))
						$current = end($allServices);
					else
						$current = prev($allServices);

					self::log_agi("current ". $current->ServiceID);
					continue;
				}
				if($selected == 2)
				{
					if($lastKey == key($allServices))
						$current = reset($allServices);
					else
						$current = next($allServices);

					self::log_agi("current ". $current->ServiceID);
					continue;
				}
				if($selected == 3)
				{
					$this->MappingArray["ServiceID"] = $current->ServiceID;
					break;
				}
			}
		}

		return self::PlaySPData($language);
	}
	// **********************************************************************************
	// 								General Functions
	// **********************************************************************************
	
	public function PlaySPData($language)
	{
		if(isset($this->MappingArray["SPFocalPointPath"]) && !empty($this->MappingArray["SPFocalPointPath"]) && isset($this->MappingArray["SPFocalPointPhone"]) && !empty($this->MappingArray["SPFocalPointPhone"]))
		{
			self::execute_agi('STREAM FILE IRC/'.$language.'IRC0175 ""');
			self::execute_agi('STREAM FILE '.$this->MappingArray["SPFocalPointPath"].' ""');
			self::execute_agi('STREAM FILE IRC/'.$language.'IRC0176 ""');
			self::SayDigit($language, $this->MappingArray["SPFocalPointPhone"]);
		}
		else
		{
			self::execute_agi('STREAM FILE IRC/'.$language.'IRC0177 ""');
			self::execute_agi('STREAM FILE '.$this->MappingArray["SPNamePath"].' ""');
			self::execute_agi('STREAM FILE IRC/'.$language.'IRC0178 ""');
			self::SayDigit($language, $this->MappingArray["SPPhone"]);
		}
		return self::SendSMS($language);
		// to send success sms
		// self::execute_agi('STREAM FILE IRC/'.$language.'IRC0028 ""');
	}

	public function SendSMS($language)
	{
		$result = self::execute_agi("GET DATA IRC/".$language."IRC0179 2000 1");

		if($result["result"] == 1)
		{
			self::execute_agi('STREAM FILE IRC/'.$language.'IRC0180 ""');
			self::execute_agi('STREAM FILE IRC/'.$language.'IRC0181 ""');
			return 1;
		}

		if($result["result"] == 2)
			return self::ServiceMapping($language);

		else
			return self::ContinueMapping($language);
	}

	public function GeneratePIN()
	{
		$rand = sprintf("%04d",rand(1,9999));

		// while(IRCModel::existPIN($rand))
		// 	$rand = sprintf("%06d",rand(1,999999));

		self::log_agi("SP PIN ".$rand);

		return $rand;
	}

	public function SayDigit($language, $number)
	{
		self::log_agi("Say number ".$number);
		$numberArray = str_split($number);
		foreach ($numberArray as $key => $value) {
			self::execute_agi('STREAM FILE IRC/'.$language.'/digits/'.$value.' ""' );
		}
	}

	public static function execute_agi($command)
	{
		$debug_mode = false; //debug mode writes extra data to the log file below whenever an AGI command is executed
		$log_file = '/tmp/agitest.log'; //log file to use in debug mode
		fwrite(STDOUT, "$command\n");
		fflush(STDOUT);
		$result = trim(fgets(STDIN));
		$ret = array('code'=> -1, 'result'=> -1, 'timeout'=> false, 'data'=> '');
		if (preg_match("/^([0-9]{1,3}) (.*)/", $result, $matches))
		{
			$ret['code'] = $matches[1];
			$ret['result'] = 0;
			if (preg_match('/^result=([0-9a-zA-Z]*)\s?(?:\(?(.*?)\)?)?$/', $matches[2], $match))
			{
				$ret['result'] = $match[1];
				$ret['timeout'] = ($match[2] === 'timeout') ? true : false;
				$ret['data'] = $match[2];
			}
		}
		if ($debug_mode && !empty($log_file))
		{
			$fh = fopen($log_file, 'a');
			if ($fh !== false) 
			{
				$res = $ret['result'] . (empty($ret['data']) ? '' : " / $ret[data]");
				fwrite($fh, "-------\n>> $command\n<< $result\n<<     parsed $res\n");
				fclose($fh);
			}
		}
		return $ret;
	}

	public static function log_agi($entry, $level = 1)
	{
		if (!is_numeric($level))
		{
			$level = 1;
		}
		$result = self::execute_agi("VERBOSE \"$entry\" $level");
	}

}
?>
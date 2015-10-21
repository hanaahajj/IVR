<?php

class runIRC{

	private $AGIvars = array();

	public $languageArray = array(1,2,3);
	public $AccountMenuArray = array(1,2);
	public $serviceArray = array(1,2,3,4,5,6,7,8);

	public $SP;
	public $myServices;
	public $editService = array();
	// public $newAccountArray = array();
	public $AccountArray = array();

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
		$this->AccountArray["SPANI"] = $agi_callerid;

		runIRC::log_agi("**************** Play Welcom Rec ******************");
		//play welcom record
		self::execute_agi('STREAM FILE IRC/1IRC0001 ""' );
		self::execute_agi('STREAM FILE IRC/1IRC0001 ""' );
		self::execute_agi('STREAM FILE IRC/2IRC0001 ""' );
		self::execute_agi('STREAM FILE IRC/3IRC0001 ""' );

		runIRC::log_agi("**************** Play Select Language ******************");
		//Call Select Language Function
		$language = self::SelectLanguage();

		runIRC::log_agi("**************** Start Account Menu ******************");
		//Call Account Menu Function
		$ext = self::AccountMenu($language);


		self::log_agi("Got extension $ext");
		// self::execute_agi("SAY DIGITS $ext \"\"");

		self::execute_agi('STREAM FILE IRC/'.$language.'IRC0095 ""');
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

	public function AccountMenu($language)
	{
		$result = self::execute_agi("GET DATA IRC/".$language."IRC0003 1000 1");
		
		if($result['result'] == 1 )
			return self::SetSPName($language);

		if($result['result'] == 2)
			return self::MyAccount($language);

		else
			return self::AccountMenu($language);

	}



	// ***********************************************************************************************
	// 									New Account
	// ***********************************************************************************************

	public function SetSPName($language)
	{
		runIRC::log_agi("**************** Start New Account Menu ******************");
		$RecNamePath = SPRECPATH."/".$this->AccountArray["SPANI"]."/NAME";

		if (!is_dir($RecNamePath))
		{
			mkdir($RecNamePath, 0755, true);
		}

		self::execute_agi('STREAM FILE IRC/'.$language.'IRC0013 ""' );

		$this->AccountArray["SPNamePath"] = $RecNamePath.'/SP_NAME_'.date("Ymd").'_'.date("His");

		$result = runIRC::execute_agi('RECORD FILE '. $this->AccountArray["SPNamePath"] .' wav "0123456789*#" 20000 1000 1');
		
		if($result >= 0)
			return self::ConfirmNameRecord($language);	
		else
			return self::SetSPName($language);
	}

	public function ConfirmNameRecord($language)
	{
		self::execute_agi('STREAM FILE IRC/'.$language.'IRC0014 ""');
		self::execute_agi('STREAM FILE '. $this->AccountArray["SPNamePath"] .' ""' );
		$result = self::execute_agi("GET DATA IRC/".$language."IRC0015 1000 1");

		if($result["result"] == 1)
		{
			return self::SelectSPType($language);
		}
		if($result["result"] == 2)
		{
			unlink($this->AccountArray["SPNamePath"].".wav");
			return self::SetSPName($language);
		}
		else
			return self::ConfirmNameRecord($language);
	}

	public function SelectSPType($language)
	{
		self::execute_agi('STREAM FILE IRC/'.$language.'IRC0004 ""' );
		$result = self::execute_agi("GET DATA IRC/".$language."IRC0005 1000 1");

		self::log_agi($result["result"]);

		if(in_array($result["result"], $this->serviceArray))
		{
			$this->AccountArray["SPTypeID"] = $result["result"];
			self::log_agi("SP Type ID ". $result["result"]);
			return self::SetSPPhoneNumber($language);
		}
		else
			return self::SelectSPType($language);
	}

	public function SetSPPhoneNumber($language)
	{
		$result = self::execute_agi("GET DATA IRC/".$language."IRC0016 5000");
		if($result["result"] >= 0)
		{
			$this->AccountArray["SPPhone"] = $result["result"];
			self::log_agi("phone number ".$result["result"]);
			return self::ConfirmSPPhoneNumber($language);
		}
		else
			return self::SetSPPhoneNumber($language);
	}

	public function ConfirmSPPhoneNumber($language)
	{
		self::execute_agi('STREAM FILE IRC/'.$language.'IRC0021 ""');
		
		self::SayDigit($language,$this->AccountArray["SPPhone"]);
		$result = self::execute_agi("GET DATA IRC/".$language."IRC0022 1000 1");

		if($result["result"] == 1)
		{
			return self::SetSPAddress($language);
		}
		if($result["result"] == 2)
		{
			return self::SetSPPhoneNumber($language);
		}
		else
			return self::ConfirmSPPhoneNumber($language);
	}

	public function SetSPAddress($language)
	{
		$RecNamePath = SPRECPATH."/".$this->AccountArray["SPANI"]."/ADDRESS";

		if (!is_dir($RecNamePath))
		{
			mkdir($RecNamePath, 0755, true);
		}

		self::execute_agi('STREAM FILE IRC/'.$language.'IRC0023 ""' );

		$this->AccountArray["SPAddressPath"] = $RecNamePath.'/SP_ADDRESS_'.date("Ymd").'_'.date("His");

		$result = runIRC::execute_agi('RECORD FILE '. $this->AccountArray["SPAddressPath"] .' wav "0123456789*#" 1800000 1000 1');
		
		if($result >= 0)
			return self::ConfirmSPAddressRec($language);	
		else
			return self::SetSPAddress($language);
	}

	public function ConfirmSPAddressRec($language)
	{
		self::execute_agi('STREAM FILE IRC/'.$language.'IRC0024 ""');
		self::execute_agi('STREAM FILE '. $this->AccountArray["SPAddressPath"] .' ""' );
		$result = self::execute_agi("GET DATA IRC/".$language."IRC0025 2000 1");

		if($result["result"] == 1)
		{
			return self::SetSPFocalPoint($language);
		}
		if($result["result"] == 2)
		{
			unlink($this->AccountArray["SPAddressPath"].".wav");
			return self::SetSPAddress($language);
		}
		else
			return self::ConfirmSPAddressRec($language);
	}

	public function SetSPFocalPoint($language)
	{
		$RecNamePath = SPRECPATH."/".$this->AccountArray["SPANI"]."/FOCALPOINT";

		if (!is_dir($RecNamePath))
		{
			mkdir($RecNamePath, 0755, true);
		}

		self::execute_agi('STREAM FILE IRC/'.$language.'IRC0079 ""' );

		$this->AccountArray["SPFocalPointPath"] = $RecNamePath.'/SP_FOCALPIONT_'.date("Ymd").'_'.date("His");

		$result = runIRC::execute_agi('RECORD FILE '. $this->AccountArray["SPFocalPointPath"] .' wav "0123456789*#" 1800000 1000 1');
		
		if($result >= 0)
			return self::ConfirmSPFocalPointRec($language);	
		else
			return self::SetSPFocalPoint($language);
	}

	public function ConfirmSPFocalPointRec($language)
	{
		self::execute_agi('STREAM FILE IRC/'.$language.'IRC0014 ""');
		self::execute_agi('STREAM FILE '. $this->AccountArray["SPFocalPointPath"] .' ""' );
		$result = self::execute_agi("GET DATA IRC/".$language."IRC0015 2000 1");

		if($result["result"] == 1)
		{
			return self::SetSPFocalPointPhoneNumber($language);
		}
		if($result["result"] == 2)
		{
			unlink($this->AccountArray["SPFocalPointPath"].".wav");
			return self::SetSPFocalPoint($language);
		}
		else
			return self::ConfirmSPFocalPointRec($language);
	}

	public function SetSPFocalPointPhoneNumber($language)
	{
		$result = self::execute_agi("GET DATA IRC/".$language."IRC0080 5000");
		if($result["result"] >= 0)
		{
			$this->AccountArray["SPFocalPointPhone"] = $result["result"];
			self::log_agi("phone number ".$result["result"]);
			return self::ConfirmSPFocalPointPhoneNumber($language);
		}
		else
			return self::SetSPFocalPointPhoneNumber($language);
	}

	public function ConfirmSPFocalPointPhoneNumber($language)
	{
		self::execute_agi('STREAM FILE IRC/'.$language.'IRC0021 ""');
		
		self::SayDigit($language,$this->AccountArray["SPFocalPointPhone"]);
		$result = self::execute_agi("GET DATA IRC/".$language."IRC0022 1000 1");

		if($result["result"] == 1)
		{
			return self::CreateAccountComplete($language);
		}
		if($result["result"] == 2)
		{
			return self::SetSPFocalPointPhoneNumber($language);
		}
		else
			return self::ConfirmSPFocalPointPhoneNumber($language);
	}

	public function CreateAccountComplete($language)
	{	
		$this->AccountArray["SPPIN"] = self::GeneratePIN();

		$newSP = new serviceprovider();
		$newSP->fromArray($this->AccountArray);
		self::log_agi("SP ANI ". $newSP->SPANI);
		foreach ($newSP as $key => $value) {
			self::log_agi("Account ".$key." => ".$value);
		}

		if($this->AccountArray["SPID"] = $newSP->insert())
		{
			self::execute_agi('STREAM FILE IRC/'.$language.'IRC0026 ""');
			self::execute_agi('STREAM FILE IRC/'.$language.'IRC0027 ""');
			self::log_agi("Create Account Success SPID = ".$this->AccountArray["SPID"] );

			$newSPPin = new pin();
			$newSPPin->SPID = $this->AccountArray["SPID"];
			$newSPPin->PIN = $this->AccountArray["SPPIN"];
			if($newSPPin->insert())
			{
				self::SayDigit($language, $this->AccountArray["SPPIN"]);

				$newSPJira = new spjiracreation();
				$newSPJira->spPin = $newSPPin->PIN;
				$newSPJira->spANI = $newSP->SPANI;
				$newSPJira->spType = $newSP->SPTypeID;
				$newSPJira->Links = $newSP->SPNamePath.";".$newSP->SPAddressPath.";".$newSP->SPFocalPointPath;

				if($newSPJira->insert())
					self::log_agi("************ SPJira Success ******************");
				else
					self::log_agi("************ SPJira Faild ******************");

				$newFocalJira = new focalpointjiracreation();
				$newFocalJira->SPID = $this->AccountArray["SPID"];
				$newFocalJira->JiraLable = "IVRFocalPointCreation";
				$newFocalJira->Links = $newSP->SPFocalPointPath;

				if($newFocalJira->insert())
					self::log_agi("************ FocalJira Success ******************");
				else
					self::log_agi("************ FocalJira Faild ******************");

			}
			else
				self::log_agi("PIN Insert Error");
		}
		else
		{
			self::log_agi("Create Account Faild");
		}

		self::SendSMS($language);

		return self::FinishAccountMenu($language);
	}

	public function FinishAccountMenu($language)
	{
		$result = self::execute_agi("GET DATA IRC/".$language."IRC0029 2000 1");
		
		if($result["result"] == 1)
		{
			return self::SelectServiceType($language);
		}
		if($result["result"] == 2)
		{
			// hangup call
			return 1; //self::execute_agi('HANGUP');
		}
		else
			return self::FinishAccountMenu($language);
	}


	// ***********************************************************************************************
	// 									Existing Account
	// ***********************************************************************************************
	
	public function MyAccount($language)
	{
		runIRC::log_agi("**************** Start My Account Menu ******************");
		$result = self::execute_agi("GET DATA IRC/".$language."IRC0040 1000 1");

		if($result["result"] == 1)
		{
			return self::EnterSPPIN($language);
		}
		if($result["result"] == 2)
		{
			return self::CheckIfCallerExsit($language);
		}
		else
			return self::MyAccount($language);
	}

	public function EnterSPPIN($language)
	{
		runIRC::log_agi("**************** Enter Pin ******************");

		$result = self::execute_agi("GET DATA IRC/".$language."IRC0041 4000 4");
		$this->SP = IRCModel::exsitSPAccount($result["result"]);
		$this->AccountArray["SPID"] = $this->SP->SPID;
		if($this->SP)
		{
			foreach ($this->SP as $key => $value) {
				self::log_agi("Account ".$key." => ".$value);
			}
			return self::LoadMyAccount($language);
		}
		else
		{
			self::execute_agi('STREAM FILE IRC/'.$language.'IRC0042 ""' );
			return self::MyAccount($language);
		}
	}

	public function CheckIfCallerExsit($language)
	{
		runIRC::log_agi("**************** CheckIfCallerExsit ******************");

		$this->SP = IRCModel::exsitCallerID($this->AccountArray["SPANI"]);
		$this->AccountArray["SPID"] = $this->SP->SPID;

		if($this->SP)
		{
			foreach ($this->SP as $key => $value) {
				self::log_agi("Account ".$key." => ".$value);
			}
			return self::LoadMyAccount($language);
		}
		else
		{
			self::execute_agi('STREAM FILE IRC/'.$language.'IRC0043 ""' );
			return self::AccountMenu($language);
		}
	}

	public function LoadMyAccount($language)
	{

		runIRC::log_agi("**************** LoadMyAccount ******************");

		self::log_agi("Account SPID ".$this->AccountArray["SPID"]);

		$result = self::execute_agi("GET DATA IRC/".$language."IRC0044 4000 1");

		if($result['result'] == 1)
			return self::LoadSPServices($language);
		
		if($result['result'] == 2)
			return self::SelectServiceType($language);
		
		if($result['result'] == 3)
			return self::PlayMyPin($language);
		
		if($result['result'] == 4)
			return self::EditFocalPoint($language);
		
		else
			return self::LoadMyAccount($language);
	}

	public function PlayMyPin($language)
	{
		runIRC::log_agi("**************** PlayMyPin ******************");
		self::execute_agi('STREAM FILE IRC/'.$language.'IRC0082 ""' );
		self::SayDigit($language, $this->SP->SPPIN);
		return self::LoadMyAccount($language);
	}

	public function LoadSPServices($language)
	{
		self::log_agi("SP ID => ".$this->SP->SPID);
		runIRC::log_agi("**************** LoadSPServices ******************");
		$myServices = IRCModel::loadSPServices($this->SP->SPID);
		foreach ($myServices as $myService) 
		{
			self::log_agi("Service => ".$myService->ServiceID);
		}

		if(empty($myServices))
		{
			self::log_agi("**************** No Services ******************");
			self::execute_agi('STREAM FILE IRC/'.$language.'IRC0083 ""' );
			return self::LoadMyAccount($language);
		}
		else
		{
			self::execute_agi('STREAM FILE IRC/'.$language.'IRC0086 ""' );
			self::execute_agi('STREAM FILE IRC/'.$language.'IRC0056 ""' );

			reset($myServices);
			$firstKey = key($myServices);
			end($myServices);
			$lastKey = key($myServices);
			reset($myServices);

			$selected = 0;

			while($selected != 3)
			{
				$current = current($myServices);
				self::log_agi("current ". $current->ServiceID);
				self::log_agi("First Key ". $firstKey);
				self::log_agi("Last Key ". $lastKey);
				self::execute_agi('STREAM FILE '.$current->ServiceNamePath.' "123"' );
				$result = self::execute_agi('WAIT FOR DIGIT 2000');
				if ($result['result'] >= 49 && $result['result'] <= 51) {
					$selected = chr($result['result']);
				}
				else {
					if($lastKey == key($myServices))
						$current = reset($myServices);
					else
						$current = next($myServices);

					self::log_agi("current ". $current->ServiceID);
					continue;
				}
				if($selected == 1)
				{
					if($firstKey == key($myServices))
						$current = end($myServices);
					else
						$current = prev($myServices);

					self::log_agi("current ". $current->ServiceID);
					continue;
				}
				if($selected == 2)
				{
					if($lastKey == key($myServices))
						$current = reset($myServices);
					else
						$current = next($myServices);

					self::log_agi("current ". $current->ServiceID);
					continue;
				}
				if($selected == 3)
				{
					$this->editService = $current;
					break;
				}
			}
		}
		return self::EditServiceMenu($language);
	}

	public function EditServiceMenu($language)
	{
		self::log_agi("Edit Service ID ". $this->editService->ServiceID);

		$result = self::execute_agi("GET DATA IRC/".$language."IRC0087 2000 1");
		if($result["result"] == 1)
		{
			return self::EditServiceAction($language);
		}
		if($result["result"] == 2)
		{
			return self::DeleteServiceAction($language);
		}
		else
			return self::EditServiceMenu($language);
	}

	public function DeleteServiceAction($language)
	{
		$deleteService = new service();
		$deleteService->ServiceID = $this->editService->ServiceID;

		if($deleteService->delete())
        {
        	self::log_agi("Success Delete Service ID ". $deleteService->ServiceID);
        	self::execute_agi('STREAM FILE IRC/'.$language.'IRC0088 ""' );
        	return self::LoadMyAccount($language);
        }
        else
        {
            self::log_agi("Faild Delete Service ID ". $deleteService->ServiceID);
        	return 2;
        }
	}

	public function EditServiceAction($language)
	{
		$result = self::execute_agi("GET DATA IRC/".$language."IRC0089 2000 1");

		if($result["result"] == 1)
			return self::EditServiceName($language);
		if($result["result"] == 2)
			return self::EditServiceAddInfo($language);
		if($result["result"] == 3)
			return self::EditServiceAddressGovernorate($language);
		else
			return self::EditServiceAction($language);
	}


	public function EditServiceName($language)
	{
		$RecNamePath = SPRECPATH."/".$this->AccountArray["SPANI"]."/SERVICES";

		if (!is_dir($RecNamePath))
		{
			mkdir($RecNamePath, 0755, true);
		}

		self::execute_agi('STREAM FILE IRC/'.$language.'IRC0073 ""' );

		$this->AccountArray["ServiceNamePath"] = $RecNamePath.'/SP_SERVICE_'.date("Ymd").'_'.date("His");

		$result = runIRC::execute_agi('RECORD FILE '. $this->AccountArray["ServiceNamePath"] .' wav "0123456789*#" 20000 1000 1');
		
		if($result >= 0)
			return self::ConfirmEditServiceNameRecord($language);
		else
			return self::EditServiceName($language);
	}

	public function ConfirmEditServiceNameRecord($language)
	{
		self::execute_agi('STREAM FILE IRC/'.$language.'IRC0074 ""');
		self::execute_agi('STREAM FILE '. $this->AccountArray["ServiceNamePath"] .' ""' );
		$result = self::execute_agi("GET DATA IRC/".$language."IRC0075 1000 1");

		if($result["result"] == 1)
		{
			unlink($this->editService->ServiceNamePath.".wav");
			$this->editService->ServiceNamePath = $this->AccountArray["ServiceNamePath"];
			$editServiceArray = $this->editService;
			$updateService = new service($this->editService->ServiceID);
			$updateService->fromArray($editServiceArray);

			if($updateService->update())
			{
				$editServiceJira = new servicejiracreation();
				$editServiceJira->ServiceID = $this->editService->ServiceID;
				$editServiceJira->Links = $this->editService->ServiceNamePath;
				$editServiceJira->JiraLable = "IVRServiceNameUpdate";

				if($editServiceJira->insert())
					self::log_agi("****************** ServiceJira Success ********************");
				else
					self::log_agi("****************** ServiceJira Faild   ********************");

				self::log_agi("Success Update Service ID ". $updateService->ServiceID);
	        	self::execute_agi('STREAM FILE IRC/'.$language.'IRC0090 ""' );
	        	return self::LoadMyAccount($language);
	        }
	        else
	        {
	            self::log_agi("Faild Update Service ID ". $updateService->ServiceID);
	        	return 2;
	        }
		}
		if($result["result"] == 2)
		{
			unlink($this->AccountArray["ServiceNamePath"].".wav");
			return self::EditServiceName($language);
		}
		else
			return self::ConfirmEditServiceNameRecord($language);
	}


	public function EditServiceAddInfo($language)
	{
		$RecNamePath = SPRECPATH."/".$this->AccountArray["SPANI"]."/SERVICES";

		if (!is_dir($RecNamePath))
		{
			mkdir($RecNamePath, 0755, true);
		}

		self::execute_agi('STREAM FILE IRC/'.$language.'IRC0076 ""' );

		$this->AccountArray["ServiceAddInfoPath"] = $RecNamePath.'/SP_SERVICE_ADD_INFO_'.date("Ymd").'_'.date("His");

		$result = runIRC::execute_agi('RECORD FILE '. $this->AccountArray["ServiceAddInfoPath"] .' wav "0123456789*#" 20000 1000 1');
		
		if($result >= 0)
			return self::ConfirmEditServiceAddInfoRecord($language);
		else
			return self::EditServiceAddInfo($language);
	}

	public function ConfirmEditServiceAddInfoRecord($language)
	{
		self::execute_agi('STREAM FILE IRC/'.$language.'IRC0077 ""');
		self::execute_agi('STREAM FILE '. $this->AccountArray["ServiceAddInfoPath"] .' ""' );
		$result = self::execute_agi("GET DATA IRC/".$language."IRC0075 1000 1");

		if($result["result"] == 1)
		{
			unlink($this->editService->ServiceAddInfoPath.".wav");
			$this->editService->ServiceAddInfoPath = $this->AccountArray["ServiceAddInfoPath"];
			$editServiceArray = $this->editService;
			$updateService = new service($this->editService->ServiceID);
			$updateService->fromArray($editServiceArray);
			
			if($updateService->update())
			{
				$editServiceJira = new servicejiracreation();
				$editServiceJira->ServiceID = $this->editService->ServiceID;
				$editServiceJira->Links = $updateService->ServiceAddInfoPath;
				$editServiceJira->JiraLable = "IVRServiceAddInfoUpdate";

				if($editServiceJira->insert())
					self::log_agi("****************** ServiceJira Success ********************");
				else
					self::log_agi("****************** ServiceJira Faild   ********************");

				self::log_agi("Success Update Service ID ". $updateService->ServiceID);
	        	self::execute_agi('STREAM FILE IRC/'.$language.'IRC0091 ""' );
	        	return self::LoadMyAccount($language);
	        }
	        else
	        {
	            self::log_agi("Faild Update Service ID ". $updateService->ServiceID);
	        	return 2;
	        }
		}
		if($result["result"] == 2)
		{
			unlink($this->AccountArray["ServiceAddInfoPath"].".wav");
			return self::EditServiceAddInfo($language);
		}
		else
			return self::ConfirmEditServiceAddInfoRecord($language);
	}

	public function EditServiceAddressGovernorate($language)
	{
		self::execute_agi('STREAM FILE IRC/'.$language.'IRC0055 ""' );
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
				$this->AccountArray["GovID"] = $current->GovID;
				break;
			}
		}
		return self::EditServiceAddressDistrict($language);
	}

	public function EditServiceAddressDistrict($language)
	{
		self::execute_agi('STREAM FILE IRC/'.$language.'IRC0059 ""' );
		self::execute_agi('STREAM FILE IRC/'.$language.'IRC0056 ""' );

		$allDistricts = IRCModel::getDistrict($this->AccountArray["GovID"]);
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
				$this->AccountArray["ServiceDistID"] = $current->DistID;
				break;
			}
		}
		return self::UpdateServiceAddress($language);
	}

	public function UpdateServiceAddress($language)
	{
		$this->editService->ServiceDistID = $this->AccountArray["ServiceDistID"];
		$editServiceArray = $this->editService;
		$updateService = new service($this->editService->ServiceID);
		$updateService->fromArray($editServiceArray);
		if($updateService->update())
		{
			self::log_agi("Success Update Service ID ". $updateService->ServiceID);
        	self::execute_agi('STREAM FILE IRC/'.$language.'IRC0092 ""' );
        	return self::LoadMyAccount($language);
        }
        else
        {
            self::log_agi("Faild Update Service ID ". $updateService->ServiceID);
        	return 2;
        }
	}

	public function EditFocalPoint($language)
	{
		$RecNamePath = SPRECPATH."/".$this->AccountArray["SPANI"]."/FOCALPOINT";

		if (!is_dir($RecNamePath))
		{
			mkdir($RecNamePath, 0755, true);
		}

		self::execute_agi('STREAM FILE IRC/'.$language.'IRC0079 ""' );

		$this->AccountArray["SPFocalPointPath"] = $RecNamePath.'/SP_FOCALPIONT_'.date("Ymd").'_'.date("His");

		$result = runIRC::execute_agi('RECORD FILE '. $this->AccountArray["SPFocalPointPath"] .' wav "0123456789*#" 1800000 1000 1');
		
		if($result >= 0)
			return self::ConfirmEditSPFocalPointRec($language);	
		else
			return self::EditFocalPoint($language);
	}

	public function ConfirmEditSPFocalPointRec($language)
	{
		self::execute_agi('STREAM FILE IRC/'.$language.'IRC0014 ""');
		self::execute_agi('STREAM FILE '. $this->AccountArray["SPFocalPointPath"] .' ""' );
		$result = self::execute_agi("GET DATA IRC/".$language."IRC0015 2000 1");

		if($result["result"] == 1)
		{
			return self::EditFocalPointPhoneNumber($language);
		}
		if($result["result"] == 2)
		{
			unlink($this->AccountArray["SPFocalPointPath"].".wav");
			return self::EditFocalPoint($language);
		}
		else
			return self::ConfirmEditSPFocalPointRec($language);
	}

	public function EditFocalPointPhoneNumber($language)
	{
		$result = self::execute_agi("GET DATA IRC/".$language."IRC0080 5000");
		if($result["result"] >= 0)
		{
			$this->AccountArray["SPFocalPointPhone"] = $result["result"];
			self::log_agi("phone number ".$result["result"]);
			return self::ConfirmEditSPFocalPointPhoneNumber($language);
		}
		else
			return self::EditFocalPointPhoneNumber($language);
	}

	public function ConfirmEditSPFocalPointPhoneNumber($language)
	{
		self::execute_agi('STREAM FILE IRC/'.$language.'IRC0021 ""');
		
		self::SayDigit($language,$this->AccountArray["SPFocalPointPhone"]);
		$result = self::execute_agi("GET DATA IRC/".$language."IRC0022 1000 1");

		if($result["result"] == 1)
		{
			return self::UpdateSPFocalPointAction($language);
		}
		if($result["result"] == 2)
		{
			return self::EditFocalPointPhoneNumber($language);
		}
		else
			return self::ConfirmEditSPFocalPointPhoneNumber($language);
	}

	public function UpdateSPFocalPointAction($language)
	{
		$this->SP->SPFocalPointPhone = $this->AccountArray["SPFocalPointPhone"];
		$this->SP->SPFocalPointPath = $this->AccountArray["SPFocalPointPath"];

		$updateSP = new serviceprovider($this->SP->SPID);
		$updateSP = $this->SP;

		if($updateSP->update())
		{

			$newFocalJira = new focalpointjiracreation();
			$newFocalJira->SPID = $this->SP->SPID;
			$newFocalJira->JiraLable = "IVRFocalPointUpdate";
			$newFocalJira->Links = $this->SP->SPFocalPointPath;

			if($newFocalJira->insert())
				self::log_agi("************ FocalJira Success ******************");
			else
				self::log_agi("************ FocalJira Faild ******************");

			self::log_agi("Success Update SP ID ". $updateSP->SPID);
        	self::execute_agi('STREAM FILE IRC/'.$language.'IRC0093 ""' );
        	
        	return self::LoadMyAccount($language);
        }
        else
        {
            self::log_agi("Faild Update Service ID ". $updateSP->SPID);
        	return 2;
        }

	}


	// **************************************************************************************************
	// 									Create New Service
	// **************************************************************************************************

	public function SelectServiceType($language)
	{

		if(isset($this->AccountArray["ServiceID"]) && !empty($this->AccountArray["ServiceID"]))
			unset($this->AccountArray["ServiceID"]);

		runIRC::log_agi("**************** Start New Service ******************");

		self::execute_agi('STREAM FILE IRC/'.$language.'IRC0046 ""' );
		$result = self::execute_agi("GET DATA IRC/".$language."IRC0047 2000 1");

		if(in_array($result["result"], $this->serviceArray))
		{
			$this->AccountArray["ServiceTypeID"] = $result["result"];
			self::log_agi("Service Type ID ". $this->AccountArray["ServiceTypeID"]);
			return self::SetGovernorate($language);
		}
		else
			return self::SelectServiceType($language);
	}

	public function SetGovernorate($language)
	{
		self::execute_agi('STREAM FILE IRC/'.$language.'IRC0055 ""' );
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
				$this->AccountArray["GovID"] = $current->GovID;
				break;
			}
		}
		return self::SetDistrict($language);
	}

	public function SetDistrict($language)
	{
		self::execute_agi('STREAM FILE IRC/'.$language.'IRC0059 ""' );
		self::execute_agi('STREAM FILE IRC/'.$language.'IRC0056 ""' );

		$allDistricts = IRCModel::getDistrict($this->AccountArray["GovID"]);
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
				$this->AccountArray["ServiceDistID"] = $current->DistID;
				break;
			}
		}
		return self::SetServiceName($language);
	}

	public function SetServiceName($language)
	{
		$RecNamePath = SPRECPATH."/".$this->AccountArray["SPANI"]."/SERVICES";

		if (!is_dir($RecNamePath))
		{
			mkdir($RecNamePath, 0755, true);
		}

		self::execute_agi('STREAM FILE IRC/'.$language.'IRC0073 ""' );

		$this->AccountArray["ServiceNamePath"] = $RecNamePath.'/SP_SERVICE_'.date("Ymd").'_'.date("His");

		$result = runIRC::execute_agi('RECORD FILE '. $this->AccountArray["ServiceNamePath"] .' wav "0123456789*#" 20000 1000 1');
		
		if($result >= 0)
			return self::ConfirmServiceNameRecord($language);
		else
			return self::SetServiceName($language);
	}

	public function ConfirmServiceNameRecord($language)
	{
		self::execute_agi('STREAM FILE IRC/'.$language.'IRC0074 ""');
		self::execute_agi('STREAM FILE '. $this->AccountArray["ServiceNamePath"] .' ""' );
		$result = self::execute_agi("GET DATA IRC/".$language."IRC0075 1000 1");

		if($result["result"] == 1)
		{
			return self::SetServiceAddInfo($language);
		}
		if($result["result"] == 2)
		{
			unlink($this->AccountArray["ServiceNamePath"].".wav");
			return self::SetServiceName($language);
		}
		else
			return self::ConfirmServiceNameRecord($language);
	}

	public function SetServiceAddInfo($language)
	{
		$RecNamePath = SPRECPATH."/".$this->AccountArray["SPANI"]."/SERVICES";

		if (!is_dir($RecNamePath))
		{
			mkdir($RecNamePath, 0755, true);
		}

		self::execute_agi('STREAM FILE IRC/'.$language.'IRC0076 ""' );

		$this->AccountArray["ServiceAddInfoPath"] = $RecNamePath.'/SP_SERVICE_ADD_INFO_'.date("Ymd").'_'.date("His");

		$result = runIRC::execute_agi('RECORD FILE '. $this->AccountArray["ServiceAddInfoPath"] .' wav "0123456789*#" 20000 1000 1');
		
		if($result >= 0)
			return self::ConfirmServiceAddInfoRecord($language);	
		else
			return self::SetServiceAddInfo($language);
	}

	public function ConfirmServiceAddInfoRecord($language)
	{
		self::execute_agi('STREAM FILE IRC/'.$language.'IRC0077 ""');
		self::execute_agi('STREAM FILE '. $this->AccountArray["ServiceAddInfoPath"] .' ""' );
		$result = self::execute_agi("GET DATA IRC/".$language."IRC0075 1000 1");

		if($result["result"] == 1)
		{
			return self::CompleteServiceCreation($language);
		}
		if($result["result"] == 2)
		{
			unlink($this->AccountArray["ServiceAddInfoPath"].".wav");
			return self::SetServiceAddInfo($language);
		}
		else
			return self::ConfirmServiceAddInfoRecord($language);
	}

	public function CompleteServiceCreation($language)
	{
		$newService = new service();
		$newService->fromArray($this->AccountArray);

		foreach ($newService as $key => $value) {
			self::log_agi("newService ".$key." => ".$value);
		}

		if($this->AccountArray["ServiceID"] = $newService->insert())
		{
			$newServiceJira = new servicejiracreation();
			$newServiceJira->ServiceID = $this->AccountArray["ServiceID"];
			$newServiceJira->Links = $newService->ServiceNamePath.";".$newService->ServiceAddInfoPath;
			$newServiceJira->JiraLable = "IVRServiceCreation";

			if($newServiceJira->insert())
				self::log_agi("****************** ServiceJira Success ********************");
			else
				self::log_agi("****************** ServiceJira Faild   ********************");
			
			return self::FinishServiceMenu($language);
		}
		else
		{
			self::log_agi("Create Service Faild");
			return 1;
		}

		// return self::FinishServiceMenu($language);
	}

	public function FinishServiceMenu($language)
	{
		$result = self::execute_agi("GET DATA IRC/".$language."IRC0081 2000 1");
		
		if($result["result"] == 1)
		{
			return self::SelectServiceType($language);
		}
		if($result["result"] == 2)
		{
			// hangup call
			return 1; //self::execute_agi('HANGUP');
		}
		else
			return self::FinishServiceMenu($language);
	}

	// **********************************************************************************
	// 								General Functions
	// **********************************************************************************
	
	public function SendSMS($language)
	{
		// to send success sms
		self::execute_agi('STREAM FILE IRC/'.$language.'IRC0028 ""');
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
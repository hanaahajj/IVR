<?php
class feedbackjiracreation{

	public $FeedbackJiraCreationID;
	public $RefugeeNamePath;
	public $NationalityID;
	public $Age;
	public $IsAnonymous;
	public $SPID;
	public $ServiceID;
	public $ServiceType;
	public $ServiceGov;
	public $ServiceDist;
	public $Summary;
	public $Answer1;
	public $Answer2;
	public $Answer3;
	public $Answer4;
	public $Answer5;
	public $Answer6;
	public $Answer7;
	public $ExtraExplanation;
	public $ExtraComnments;
	public $DateAdded;
	public $IssueKey;
	public $JiraCreated;
	public $JiraVetted;
	public $JiraLabel;

	public function __construct($id=null)
	{
		if(!empty($id) && is_numeric($id))
		{
			$sql = "SELECT * FROM `feedbackjiracreation` WHERE  FeedbackJiraCreationID={$id}";
			$qry=DB_query($sql,$b);
			while ($result=DB_fetch_assoc($qry))
			{
				try
				{
					$this->fromArray($result);
					break;
				}
				catch(Exception $e){}
			}
		}
	}

	public function insert()
	{
		if((!empty($this->FeedbackJiraCreationID)) and (!is_numeric($this->FeedbackJiraCreationID)))
		{
			return false;
		}
		if((!empty($this->NationalityID)) and (!is_numeric($this->NationalityID)))
		{
			return false;
		}
		if((!empty($this->Age)) and (!is_numeric($this->Age)))
		{
			return false;
		}
		if((!empty($this->IsAnonymous)) and (!is_numeric($this->IsAnonymous)))
		{
			return false;
		}
		if((!empty($this->SPID)) and (!is_numeric($this->SPID)))
		{
			return false;
		}
		if((!empty($this->ServiceID)) and (!is_numeric($this->ServiceID)))
		{
			return false;
		}
		if((!empty($this->ServiceType)) and (!is_numeric($this->ServiceType)))
		{
			return false;
		}
		if((!empty($this->ServiceGov)) and (!is_numeric($this->ServiceGov)))
		{
			return false;
		}
		if((!empty($this->ServiceDist)) and (!is_numeric($this->ServiceDist)))
		{
			return false;
		}

		$dt = new DateTime();
		$this->DateAdded = $dt->format('Y-m-d H:i:s');
		
		$sql="INSERT INTO `feedbackjiracreation` 
			(".((!empty($this->FeedbackJiraCreationID))?'`FeedbackJiraCreationID`,':'').
				((!empty($this->RefugeeNamePath))?'`RefugeeNamePath`,':'').
				((!empty($this->NationalityID))?'`NationalityID`,':'').
				((!empty($this->Age))?'`Age`,':'').
				((!empty($this->IsAnonymous))?'`IsAnonymous`,':'').
				((!empty($this->SPID))?'`SPID`,':'').
				((!empty($this->ServiceID))?'`ServiceID`,':'').
				((!empty($this->ServiceType))?'`ServiceType`,':'').
				((!empty($this->ServiceGov))?'`ServiceGov`,':'').
				((!empty($this->ServiceDist))?'`ServiceDist`,':'').
				((!empty($this->Summary))?'`Summary`,':'').
				((!empty($this->Answer1))?'`Answer1`,':'').
				((!empty($this->Answer2))?'`Answer2`,':'').
				((!empty($this->Answer3))?'`Answer3`,':'').
				((!empty($this->Answer4))?'`Answer4`,':'').
				((!empty($this->Answer5))?'`Answer5`,':'').
				((!empty($this->Answer6))?'`Answer6`,':'').
				((!empty($this->Answer7))?'`Answer7`,':'').
				((!empty($this->ExtraExplanation))?'`ExtraExplanation`,':'').
				((!empty($this->ExtraComnments))?'`ExtraComnments`,':'').
				((!empty($this->DateAdded))?'`DateAdded`,':'').
				((!empty($this->IssueKey))?'`IssueKey`,':'').
				((!empty($this->JiraCreated))?'`JiraCreated`,':'').
				((!empty($this->JiraVetted))?'`JiraVetted`,':'').
				((!empty($this->JiraLabel))?'`JiraLabel`,':'').
				") VALUES (". ((!empty($this->FeedbackJiraCreationID))?$this->FeedbackJiraCreationID.',':'').
				((!empty($this->RefugeeNamePath))?'"'.$this->RefugeeNamePath.'"'.',':'').
				((!empty($this->NationalityID))?$this->NationalityID.',':'').
				((!empty($this->Age))?$this->Age.',':'').
				((!empty($this->IsAnonymous))?$this->IsAnonymous.',':'').
				((!empty($this->SPID))?$this->SPID.',':'').
				((!empty($this->ServiceID))?$this->ServiceID.',':'').
				((!empty($this->ServiceType))?$this->ServiceType.',':'').
				((!empty($this->ServiceGov))?$this->ServiceGov.',':'').
				((!empty($this->ServiceDist))?$this->ServiceDist.',':'').
				((!empty($this->Summary))?'"'.$this->Summary.'"'.',':'').
				((!empty($this->Answer1))?'"'.$this->Answer1.'"'.',':'').
				((!empty($this->Answer2))?'"'.$this->Answer2.'"'.',':'').
				((!empty($this->Answer3))?'"'.$this->Answer3.'"'.',':'').
				((!empty($this->Answer4))?'"'.$this->Answer4.'"'.',':'').
				((!empty($this->Answer5))?'"'.$this->Answer5.'"'.',':'').
				((!empty($this->Answer6))?'"'.$this->Answer6.'"'.',':'').
				((!empty($this->Answer7))?'"'.$this->Answer7.'"'.',':'').
				((!empty($this->ExtraExplanation))?'"'.$this->ExtraExplanation.'"'.',':'').
				((!empty($this->ExtraComnments))?'"'.$this->ExtraComnments.'"'.',':'').
				((!empty($this->DateAdded))?'"'.$this->DateAdded.'"'.',':'').
				((!empty($this->IssueKey))?'"'.$this->IssueKey.'"'.',':'').
				((!empty($this->JiraCreated))?'"'.$this->JiraCreated.'"'.',':'').
				((!empty($this->JiraVetted))?'"'.$this->JiraVetted.'"'.',':'').
				((!empty($this->JiraLabel))?'"'.$this->JiraLabel.'"'.',':'').
				")"; 
		$sql=str_replace(',)',')',$sql);
		if($qry=DB_query ($sql,$b))
		{
			return DB_Last_Insert_ID();
		}
		return false;
	}

	public function update()
	{
		if(empty($this->FeedbackJiraCreationID))
		{
			return false;
		}
		if((!empty($this->FeedbackJiraCreationID)) and (!is_numeric($this->FeedbackJiraCreationID)))
		{
			return false;
		}
		if((!empty($this->NationalityID)) and (!is_numeric($this->NationalityID)))
		{
			return false;
		}
		if((!empty($this->Age)) and (!is_numeric($this->Age)))
		{
			return false;
		}
		if((!empty($this->IsAnonymous)) and (!is_numeric($this->IsAnonymous)))
		{
			return false;
		}
		if((!empty($this->SPID)) and (!is_numeric($this->SPID)))
		{
			return false;
		}
		if((!empty($this->ServiceID)) and (!is_numeric($this->ServiceID)))
		{
			return false;
		}
		if((!empty($this->ServiceType)) and (!is_numeric($this->ServiceType)))
		{
			return false;
		}
		if((!empty($this->ServiceGov)) and (!is_numeric($this->ServiceGov)))
		{
			return false;
		}
		if((!empty($this->ServiceDist)) and (!is_numeric($this->ServiceDist)))
		{
			return false;
		}
		$sql="UPDATE `feedbackjiracreation` SET ".
			((!empty($this->FeedbackJiraCreationID))?'`FeedbackJiraCreationID`=':'').((!empty($this->FeedbackJiraCreationID))?$this->FeedbackJiraCreationID.',':'').
			((!empty($this->RefugeeNamePath))?'`RefugeeNamePath`=':'').((!empty($this->RefugeeNamePath))?'"'.$this->RefugeeNamePath.'"'.',':'').
			((!empty($this->NationalityID))?'`NationalityID`=':'').((!empty($this->NationalityID))?$this->NationalityID.',':'').
			((!empty($this->Age))?'`Age`=':'').((!empty($this->Age))?$this->Age.',':'').
			((!empty($this->IsAnonymous))?'`IsAnonymous`=':'').((!empty($this->IsAnonymous))?$this->IsAnonymous.',':'').
			((!empty($this->SPID))?'`SPID`=':'').((!empty($this->SPID))?$this->SPID.',':'').
			((!empty($this->ServiceID))?'`ServiceID`=':'').((!empty($this->ServiceID))?$this->ServiceID.',':'').
			((!empty($this->ServiceType))?'`ServiceType`=':'').((!empty($this->ServiceType))?$this->ServiceType.',':'').
			((!empty($this->ServiceGov))?'`ServiceGov`=':'').((!empty($this->ServiceGov))?$this->ServiceGov.',':'').
			((!empty($this->ServiceDist))?'`ServiceDist`=':'').((!empty($this->ServiceDist))?$this->ServiceDist.',':'').
			((!empty($this->Summary))?'`Summary`=':'').((!empty($this->Summary))?'"'.$this->Summary.'"'.',':'').
			((!empty($this->Answer1))?'`Answer1`=':'').((!empty($this->Answer1))?'"'.$this->Answer1.'"'.',':'').
			((!empty($this->Answer2))?'`Answer2`=':'').((!empty($this->Answer2))?'"'.$this->Answer2.'"'.',':'').
			((!empty($this->Answer3))?'`Answer3`=':'').((!empty($this->Answer3))?'"'.$this->Answer3.'"'.',':'').
			((!empty($this->Answer4))?'`Answer4`=':'').((!empty($this->Answer4))?'"'.$this->Answer4.'"'.',':'').
			((!empty($this->Answer5))?'`Answer5`=':'').((!empty($this->Answer5))?'"'.$this->Answer5.'"'.',':'').
			((!empty($this->Answer6))?'`Answer6`=':'').((!empty($this->Answer6))?'"'.$this->Answer6.'"'.',':'').
			((!empty($this->Answer7))?'`Answer7`=':'').((!empty($this->Answer7))?'"'.$this->Answer7.'"'.',':'').
			((!empty($this->ExtraExplanation))?'`ExtraExplanation`=':'').((!empty($this->ExtraExplanation))?'"'.$this->ExtraExplanation.'"'.',':'').
			((!empty($this->ExtraComnments))?'`ExtraComnments`=':'').((!empty($this->ExtraComnments))?'"'.$this->ExtraComnments.'"'.',':'').
			((!empty($this->DateAdded))?'`DateAdded`=':'').((!empty($this->DateAdded))?'"'.$this->DateAdded.'"'.',':'').
			((!empty($this->IssueKey))?'`IssueKey`=':'').((!empty($this->IssueKey))?'"'.$this->IssueKey.'"'.',':'').
			((!empty($this->JiraCreated))?'`JiraCreated`=':'').((!empty($this->JiraCreated))?'"'.$this->JiraCreated.'"'.',':'').
			((!empty($this->JiraVetted))?'`JiraVetted`=':'').((!empty($this->JiraVetted))?'"'.$this->JiraVetted.'"'.',':'').
			((!empty($this->JiraLabel))?'`JiraLabel`=':'').((!empty($this->JiraLabel))?'"'.$this->JiraLabel.'"'.',':'').
			" WHERE FeedbackJiraCreationID=".$this->FeedbackJiraCreationID; 
		$sql=str_replace(', WHERE',' WHERE',$sql);
		if($qry=DB_query ($sql,$b))
		{
			return True;
		}
		return false;
	}

	public function activate()
	{
		if(empty($this->FeedbackJiraCreationID))
		{
			return false;
		}
		if((!empty($this->FeedbackJiraCreationID)) and (!is_numeric($this->FeedbackJiraCreationID)))
		{
			return false;
		}
		$sql="UPDATE `feedbackjiracreation` SET IsActive=1 where FeedbackJiraCreationID=".$this->FeedbackJiraCreationID ; 
		if($qry=DB_query ($sql,$b))
		{
			return True;
		}
		return false;
	}

	public function deactivate()
	{
		if(empty($this->FeedbackJiraCreationID))
		{
			return false;
		}
		if((!empty($this->FeedbackJiraCreationID)) and (!is_numeric($this->FeedbackJiraCreationID)))
		{
			return false;
		}
		$sql="UPDATE `feedbackjiracreation` SET IsActive=0 where FeedbackJiraCreationID=".$this->FeedbackJiraCreationID ; 
		if($qry=DB_query ($sql,$b))
		{
			return True;
		}
		return false;
	}

	public function delete()
	{
		if(empty($this->FeedbackJiraCreationID))
		{
			return false;
		}
		if((!empty($this->FeedbackJiraCreationID)) and (!is_numeric($this->FeedbackJiraCreationID)))
		{
			return false;
		}
		$sql="UPDATE `feedbackjiracreation` SET IsDeleted=1 where FeedbackJiraCreationID=".$this->FeedbackJiraCreationID ; 
		if($qry=DB_query ($sql,$b))
		{
			return True;
		}
		return false;
	}

	public function perDelete()
	{
		if(empty($this->FeedbackJiraCreationID))
		{
			return false;
		}
		if((!empty($this->FeedbackJiraCreationID)) and (!is_numeric($this->FeedbackJiraCreationID)))
		{
			return false;
		}

		$sql="DELETE FROM `feedbackjiracreation` where FeedbackJiraCreationID=".$this->FeedbackJiraCreationID ; 
		if($qry=DB_query ($sql,$b))
		{
			return True;
		}
		return false;
	}

	public function fromArray($array)
	{
		foreach ($array as $key => $value)
		{
			try
			{
				$this->$key = $value;
			}
			catch(Exception $e)
			{
			}
		}
	}
}
?>
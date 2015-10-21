<?php
class spjiracreation{

	public $SPJiraCreationID;
	public $spANI;
	public $spPIN;
	public $spType;
	public $Links;
	public $DateAdded;
	public $IssueKey;
	public $JiraCreated;
	public $JiraVetted;
	public $JiraLabel;

	public function __construct($id=null)
	{
		if(!empty($id) && is_numeric($id))
		{
			$sql = "SELECT * FROM `spjiracreation` WHERE  SPJiraCreationID={$id}";
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
		if((!empty($this->SPJiraCreationID)) and (!is_numeric($this->SPJiraCreationID)))
		{
			return false;
		}
		if((!empty($this->spType)) and (!is_numeric($this->spType)))
		{
			return false;
		}


		$dt = new DateTime();
		$this->DateAdded = $dt->format('Y-m-d H:i:s');
		
		$sql="INSERT INTO `spjiracreation` 
			(".((!empty($this->SPJiraCreationID))?'`SPJiraCreationID`,':'').
				((!empty($this->spANI))?'`spANI`,':'').
				((!empty($this->spPIN))?'`spPIN`,':'').
				((!empty($this->spType))?'`spType`,':'').
				((!empty($this->Links))?'`Links`,':'').
				((!empty($this->DateAdded))?'`DateAdded`,':'').
				((!empty($this->IssueKey))?'`IssueKey`,':'').
				((!empty($this->JiraCreated))?'`JiraCreated`,':'').
				((!empty($this->JiraVetted))?'`JiraVetted`,':'').
				((!empty($this->JiraLabel))?'`JiraLabel`,':'').
				") VALUES (". ((!empty($this->SPJiraCreationID))?$this->SPJiraCreationID.',':'').
				((!empty($this->spANI))?'"'.$this->spANI.'"'.',':'').
				((!empty($this->spPIN))?'"'.$this->spPIN.'"'.',':'').
				((!empty($this->spType))?$this->spType.',':'').
				((!empty($this->Links))?'"'.$this->Links.'"'.',':'').
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
		if(empty($this->SPJiraCreationID))
		{
			return false;
		}
		if((!empty($this->SPJiraCreationID)) and (!is_numeric($this->SPJiraCreationID)))
		{
			return false;
		}
		if((!empty($this->spType)) and (!is_numeric($this->spType)))
		{
			return false;
		}
		$sql="UPDATE `spjiracreation` SET ".
			((!empty($this->SPJiraCreationID))?'`SPJiraCreationID`=':'').((!empty($this->SPJiraCreationID))?$this->SPJiraCreationID.',':'').
			((!empty($this->spANI))?'`spANI`=':'').((!empty($this->spANI))?'"'.$this->spANI.'"'.',':'').
			((!empty($this->spPIN))?'`spPIN`=':'').((!empty($this->spPIN))?'"'.$this->spPIN.'"'.',':'').
			((!empty($this->spType))?'`spType`=':'').((!empty($this->spType))?$this->spType.',':'').
			((!empty($this->Links))?'`Links`=':'').((!empty($this->Links))?'"'.$this->Links.'"'.',':'').
			((!empty($this->DateAdded))?'`DateAdded`=':'').((!empty($this->DateAdded))?'"'.$this->DateAdded.'"'.',':'').
			((!empty($this->IssueKey))?'`IssueKey`=':'').((!empty($this->IssueKey))?'"'.$this->IssueKey.'"'.',':'').
			((!empty($this->JiraCreated))?'`JiraCreated`=':'').((!empty($this->JiraCreated))?'"'.$this->JiraCreated.'"'.',':'').
			((!empty($this->JiraVetted))?'`JiraVetted`=':'').((!empty($this->JiraVetted))?'"'.$this->JiraVetted.'"'.',':'').
			((!empty($this->JiraLabel))?'`JiraLabel`=':'').((!empty($this->JiraLabel))?'"'.$this->JiraLabel.'"'.',':'').
			" WHERE SPJiraCreationID=".$this->SPJiraCreationID; 
		$sql=str_replace(', WHERE',' WHERE',$sql);
		if($qry=DB_query ($sql,$b))
		{
			return True;
		}
		return false;
	}

	public function activate()
	{
		if(empty($this->SPJiraCreationID))
		{
			return false;
		}
		if((!empty($this->SPJiraCreationID)) and (!is_numeric($this->SPJiraCreationID)))
		{
			return false;
		}
		$sql="UPDATE `spjiracreation` SET IsActive=1 where SPJiraCreationID=".$this->SPJiraCreationID ; 
		if($qry=DB_query ($sql,$b))
		{
			return True;
		}
		return false;
	}

	public function deactivate()
	{
		if(empty($this->SPJiraCreationID))
		{
			return false;
		}
		if((!empty($this->SPJiraCreationID)) and (!is_numeric($this->SPJiraCreationID)))
		{
			return false;
		}
		$sql="UPDATE `spjiracreation` SET IsActive=0 where SPJiraCreationID=".$this->SPJiraCreationID ; 
		if($qry=DB_query ($sql,$b))
		{
			return True;
		}
		return false;
	}

	public function delete()
	{
		if(empty($this->SPJiraCreationID))
		{
			return false;
		}
		if((!empty($this->SPJiraCreationID)) and (!is_numeric($this->SPJiraCreationID)))
		{
			return false;
		}
		$sql="UPDATE `spjiracreation` SET IsDeleted=1 where SPJiraCreationID=".$this->SPJiraCreationID ; 
		if($qry=DB_query ($sql,$b))
		{
			return True;
		}
		return false;
	}

	public function perDelete()
	{
		if(empty($this->SPJiraCreationID))
		{
			return false;
		}
		if((!empty($this->SPJiraCreationID)) and (!is_numeric($this->SPJiraCreationID)))
		{
			return false;
		}

		$sql="DELETE FROM `spjiracreation` where SPJiraCreationID=".$this->SPJiraCreationID ; 
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
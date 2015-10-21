<?php
class servicejiracreation{

	public $ServiceJiraCreationID;
	public $SerivceID;
	public $Links;
	public $DateAdded ;
	public $IssueKey;
	public $JiraCreated;
	public $JiraVetted;
	public $JiraLabel;

	public function __construct($id=null)
	{
		if(!empty($id) && is_numeric($id))
		{
			$sql = "SELECT * FROM `servicejiracreation` WHERE  ServiceJiraCreationID={$id}";
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
		if((!empty($this->ServiceJiraCreationID)) and (!is_numeric($this->ServiceJiraCreationID)))
		{
			return false;
		}
		if((!empty($this->SerivceID)) and (!is_numeric($this->SerivceID)))
		{
			return false;
		}

		$dt = new DateTime();
		$this->DateAdded = $dt->format('Y-m-d H:i:s');

		$sql="INSERT INTO `servicejiracreation` 
			(".((!empty($this->ServiceJiraCreationID))?'`ServiceJiraCreationID`,':'').
				((!empty($this->SerivceID))?'`SerivceID`,':'').
				((!empty($this->Links))?'`Links`,':'').
				((!empty($this->DateAdded))?'`DateAdded`,':'').
				((!empty($this->IssueKey))?'`IssueKey`,':'').
				((!empty($this->JiraCreated))?'`JiraCreated`,':'').
				((!empty($this->JiraVetted))?'`JiraVetted`,':'').
				((!empty($this->JiraLabel))?'`JiraLabel`,':'').
				") VALUES (". ((!empty($this->ServiceJiraCreationID))?$this->ServiceJiraCreationID.',':'').
				((!empty($this->SerivceID))?$this->SerivceID.',':'').
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
		if(empty($this->ServiceJiraCreationID))
		{
			return false;
		}
		if((!empty($this->ServiceJiraCreationID)) and (!is_numeric($this->ServiceJiraCreationID)))
		{
			return false;
		}
		if((!empty($this->SerivceID)) and (!is_numeric($this->SerivceID)))
		{
			return false;
		}
		$sql="UPDATE `servicejiracreation` SET ".
			((!empty($this->ServiceJiraCreationID))?'`ServiceJiraCreationID`=':'').((!empty($this->ServiceJiraCreationID))?$this->ServiceJiraCreationID.',':'').
			((!empty($this->SerivceID))?'`SerivceID`=':'').((!empty($this->SerivceID))?$this->SerivceID.',':'').
			((!empty($this->Links))?'`Links`=':'').((!empty($this->Links))?'"'.$this->Links.'"'.',':'').
			((!empty($this->DateAdded))?'`DateAdded`=':'').((!empty($this->DateAdded))?'"'.$this->DateAdded.'"'.',':'').
			((!empty($this->IssueKey))?'`IssueKey`=':'').((!empty($this->IssueKey))?'"'.$this->IssueKey.'"'.',':'').
			((!empty($this->JiraCreated))?'`JiraCreated`=':'').((!empty($this->JiraCreated))?'"'.$this->JiraCreated.'"'.',':'').
			((!empty($this->JiraVetted))?'`JiraVetted`=':'').((!empty($this->JiraVetted))?'"'.$this->JiraVetted.'"'.',':'').
			((!empty($this->JiraLabel))?'`JiraLabel`=':'').((!empty($this->JiraLabel))?'"'.$this->JiraLabel.'"'.',':'').
			" WHERE ServiceJiraCreationID=".$this->ServiceJiraCreationID; 
		$sql=str_replace(', WHERE',' WHERE',$sql);
		if($qry=DB_query ($sql,$b))
		{
			return True;
		}
		return false;
	}

	public function activate()
	{
		if(empty($this->ServiceJiraCreationID))
		{
			return false;
		}
		if((!empty($this->ServiceJiraCreationID)) and (!is_numeric($this->ServiceJiraCreationID)))
		{
			return false;
		}
		$sql="UPDATE `servicejiracreation` SET IsActive=1 where ServiceJiraCreationID=".$this->ServiceJiraCreationID ; 
		if($qry=DB_query ($sql,$b))
		{
			return True;
		}
		return false;
	}

	public function deactivate()
	{
		if(empty($this->ServiceJiraCreationID))
		{
			return false;
		}
		if((!empty($this->ServiceJiraCreationID)) and (!is_numeric($this->ServiceJiraCreationID)))
		{
			return false;
		}
		$sql="UPDATE `servicejiracreation` SET IsActive=0 where ServiceJiraCreationID=".$this->ServiceJiraCreationID ; 
		if($qry=DB_query ($sql,$b))
		{
			return True;
		}
		return false;
	}

	public function delete()
	{
		if(empty($this->ServiceJiraCreationID))
		{
			return false;
		}
		if((!empty($this->ServiceJiraCreationID)) and (!is_numeric($this->ServiceJiraCreationID)))
		{
			return false;
		}
		$sql="UPDATE `servicejiracreation` SET IsDeleted=1 where ServiceJiraCreationID=".$this->ServiceJiraCreationID ; 
		if($qry=DB_query ($sql,$b))
		{
			return True;
		}
		return false;
	}

	public function perDelete()
	{
		if(empty($this->ServiceJiraCreationID))
		{
			return false;
		}
		if((!empty($this->ServiceJiraCreationID)) and (!is_numeric($this->ServiceJiraCreationID)))
		{
			return false;
		}

		$sql="DELETE FROM `servicejiracreation` where ServiceJiraCreationID=".$this->ServiceJiraCreationID ; 
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
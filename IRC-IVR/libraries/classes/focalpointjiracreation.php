<?php
class focalpointjiracreation{

	public $FocalPointJiraCreationID;
	public $SPID;
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
			$sql = "SELECT * FROM `focalpointjiracreation` WHERE  FocalPointJiraCreationID={$id}";
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
		if((!empty($this->FocalPointJiraCreationID)) and (!is_numeric($this->FocalPointJiraCreationID)))
		{
			return false;
		}
		if((!empty($this->SPID)) and (!is_numeric($this->SPID)))
		{
			return false;
		}

		$dt = new DateTime();
		$this->DateAdded = $dt->format('Y-m-d H:i:s');
		
		$sql="INSERT INTO `focalpointjiracreation` 
			(".((!empty($this->FocalPointJiraCreationID))?'`FocalPointJiraCreationID`,':'').
				((!empty($this->SPID))?'`SPID`,':'').
				((!empty($this->Links))?'`Links`,':'').
				((!empty($this->DateAdded))?'`DateAdded`,':'').
				((!empty($this->IssueKey))?'`IssueKey`,':'').
				((!empty($this->JiraCreated))?'`JiraCreated`,':'').
				((!empty($this->JiraVetted))?'`JiraVetted`,':'').
				((!empty($this->JiraLabel))?'`JiraLabel`,':'').
				") VALUES (". ((!empty($this->FocalPointJiraCreationID))?$this->FocalPointJiraCreationID.',':'').
				((!empty($this->SPID))?$this->SPID.',':'').
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
		if(empty($this->FocalPointJiraCreationID))
		{
			return false;
		}
		if((!empty($this->FocalPointJiraCreationID)) and (!is_numeric($this->FocalPointJiraCreationID)))
		{
			return false;
		}
		if((!empty($this->SPID)) and (!is_numeric($this->SPID)))
		{
			return false;
		}
		$sql="UPDATE `focalpointjiracreation` SET ".
			((!empty($this->FocalPointJiraCreationID))?'`FocalPointJiraCreationID`=':'').((!empty($this->FocalPointJiraCreationID))?$this->FocalPointJiraCreationID.',':'').
			((!empty($this->SPID))?'`SPID`=':'').((!empty($this->SPID))?$this->SPID.',':'').
			((!empty($this->Links))?'`Links`=':'').((!empty($this->Links))?'"'.$this->Links.'"'.',':'').
			((!empty($this->DateAdded))?'`DateAdded`=':'').((!empty($this->DateAdded))?'"'.$this->DateAdded.'"'.',':'').
			((!empty($this->IssueKey))?'`IssueKey`=':'').((!empty($this->IssueKey))?'"'.$this->IssueKey.'"'.',':'').
			((!empty($this->JiraCreated))?'`JiraCreated`=':'').((!empty($this->JiraCreated))?'"'.$this->JiraCreated.'"'.',':'').
			((!empty($this->JiraVetted))?'`JiraVetted`=':'').((!empty($this->JiraVetted))?'"'.$this->JiraVetted.'"'.',':'').
			((!empty($this->JiraLabel))?'`JiraLabel`=':'').((!empty($this->JiraLabel))?'"'.$this->JiraLabel.'"'.',':'').
			" WHERE FocalPointJiraCreationID=".$this->FocalPointJiraCreationID; 
		$sql=str_replace(', WHERE',' WHERE',$sql);
		if($qry=DB_query ($sql,$b))
		{
			return True;
		}
		return false;
	}

	public function activate()
	{
		if(empty($this->FocalPointJiraCreationID))
		{
			return false;
		}
		if((!empty($this->FocalPointJiraCreationID)) and (!is_numeric($this->FocalPointJiraCreationID)))
		{
			return false;
		}
		$sql="UPDATE `focalpointjiracreation` SET IsActive=1 where FocalPointJiraCreationID=".$this->FocalPointJiraCreationID ; 
		if($qry=DB_query ($sql,$b))
		{
			return True;
		}
		return false;
	}

	public function deactivate()
	{
		if(empty($this->FocalPointJiraCreationID))
		{
			return false;
		}
		if((!empty($this->FocalPointJiraCreationID)) and (!is_numeric($this->FocalPointJiraCreationID)))
		{
			return false;
		}
		$sql="UPDATE `focalpointjiracreation` SET IsActive=0 where FocalPointJiraCreationID=".$this->FocalPointJiraCreationID ; 
		if($qry=DB_query ($sql,$b))
		{
			return True;
		}
		return false;
	}

	public function delete()
	{
		if(empty($this->FocalPointJiraCreationID))
		{
			return false;
		}
		if((!empty($this->FocalPointJiraCreationID)) and (!is_numeric($this->FocalPointJiraCreationID)))
		{
			return false;
		}
		$sql="UPDATE `focalpointjiracreation` SET IsDeleted=1 where FocalPointJiraCreationID=".$this->FocalPointJiraCreationID ; 
		if($qry=DB_query ($sql,$b))
		{
			return True;
		}
		return false;
	}

	public function perDelete()
	{
		if(empty($this->FocalPointJiraCreationID))
		{
			return false;
		}
		if((!empty($this->FocalPointJiraCreationID)) and (!is_numeric($this->FocalPointJiraCreationID)))
		{
			return false;
		}

		$sql="DELETE FROM `focalpointjiracreation` where FocalPointJiraCreationID=".$this->FocalPointJiraCreationID ; 
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
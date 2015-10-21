<?php
class feedbackresult{

	public $FBResultID;
	public $FBQuestionID;
	public $FBAnswerID;
	public $FBNextQuestionID;
	public $IsActive = 1;
	public $IsDeleted = 0;
	public $DateCreated ;

	public function __construct($id=null)
	{
		if(!empty($id) && is_numeric($id))
		{
			$sql = "SELECT * FROM `feedbackresult` WHERE  FBResultID={$id}";
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
		if((!empty($this->FBResultID)) and (!is_numeric($this->FBResultID)))
		{
			return false;
		}
		if((!empty($this->FBQuestionID)) and (!is_numeric($this->FBQuestionID)))
		{
			return false;
		}
		if((!empty($this->FBAnswerID)) and (!is_numeric($this->FBAnswerID)))
		{
			return false;
		}
		if((!empty($this->FBNextQuestionID)) and (!is_numeric($this->FBNextQuestionID)))
		{
			return false;
		}
		$sql="INSERT INTO `feedbackresult` 
			(".((!empty($this->FBResultID))?'`FBResultID`,':'').
				((!empty($this->FBQuestionID))?'`FBQuestionID`,':'').
				((!empty($this->FBAnswerID))?'`FBAnswerID`,':'').
				((!empty($this->FBNextQuestionID))?'`FBNextQuestionID`,':'').
				((!empty($this->IsActive))?'`IsActive`,':'').
				((!empty($this->IsDeleted))?'`IsDeleted`,':'').
				((!empty($this->DateCreated))?'`DateCreated`,':'').
				") VALUES (". ((!empty($this->FBResultID))?$this->FBResultID.',':'').
				((!empty($this->FBQuestionID))?$this->FBQuestionID.',':'').
				((!empty($this->FBAnswerID))?$this->FBAnswerID.',':'').
				((!empty($this->FBNextQuestionID))?$this->FBNextQuestionID.',':'').
				((!empty($this->IsActive))?'"'.$this->IsActive.'"'.',':'').
				((!empty($this->IsDeleted))?'"'.$this->IsDeleted.'"'.',':'').
				((!empty($this->DateCreated))?'"'.$this->DateCreated.'"'.',':'').
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
		if(empty($this->FBResultID))
		{
			return false;
		}
		if((!empty($this->FBResultID)) and (!is_numeric($this->FBResultID)))
		{
			return false;
		}
		if((!empty($this->FBQuestionID)) and (!is_numeric($this->FBQuestionID)))
		{
			return false;
		}
		if((!empty($this->FBAnswerID)) and (!is_numeric($this->FBAnswerID)))
		{
			return false;
		}
		if((!empty($this->FBNextQuestionID)) and (!is_numeric($this->FBNextQuestionID)))
		{
			return false;
		}
		$sql="UPDATE `feedbackresult` SET ".
			((!empty($this->FBResultID))?'`FBResultID`=':'').((!empty($this->FBResultID))?$this->FBResultID.',':'').
			((!empty($this->FBQuestionID))?'`FBQuestionID`=':'').((!empty($this->FBQuestionID))?$this->FBQuestionID.',':'').
			((!empty($this->FBAnswerID))?'`FBAnswerID`=':'').((!empty($this->FBAnswerID))?$this->FBAnswerID.',':'').
			((!empty($this->FBNextQuestionID))?'`FBNextQuestionID`=':'').((!empty($this->FBNextQuestionID))?$this->FBNextQuestionID.',':'').
			((!empty($this->IsActive))?'`IsActive`=':'').((!empty($this->IsActive))?'"'.$this->IsActive.'"'.',':'').
			((!empty($this->IsDeleted))?'`IsDeleted`=':'').((!empty($this->IsDeleted))?'"'.$this->IsDeleted.'"'.',':'').
			((!empty($this->DateCreated))?'`DateCreated`=':'').((!empty($this->DateCreated))?'"'.$this->DateCreated.'"'.',':'').
			" WHERE FBResultID=".$this->FBResultID; 
		$sql=str_replace(', WHERE',' WHERE',$sql);
		if($qry=DB_query ($sql,$b))
		{
			return True;
		}
		return false;
	}

	public function activate()
	{
		if(empty($this->FBResultID))
		{
			return false;
		}
		if((!empty($this->FBResultID)) and (!is_numeric($this->FBResultID)))
		{
			return false;
		}
		$sql="UPDATE `feedbackresult` SET IsActive=1 where FBResultID=".$this->FBResultID ; 
		if($qry=DB_query ($sql,$b))
		{
			return True;
		}
		return false;
	}

	public function deactivate()
	{
		if(empty($this->FBResultID))
		{
			return false;
		}
		if((!empty($this->FBResultID)) and (!is_numeric($this->FBResultID)))
		{
			return false;
		}
		$sql="UPDATE `feedbackresult` SET IsActive=0 where FBResultID=".$this->FBResultID ; 
		if($qry=DB_query ($sql,$b))
		{
			return True;
		}
		return false;
	}

	public function delete()
	{
		if(empty($this->FBResultID))
		{
			return false;
		}
		if((!empty($this->FBResultID)) and (!is_numeric($this->FBResultID)))
		{
			return false;
		}
		$sql="UPDATE `feedbackresult` SET IsDeleted=1 where FBResultID=".$this->FBResultID ; 
		if($qry=DB_query ($sql,$b))
		{
			return True;
		}
		return false;
	}

	public function perDelete()
	{
		if(empty($this->FBResultID))
		{
			return false;
		}
		if((!empty($this->FBResultID)) and (!is_numeric($this->FBResultID)))
		{
			return false;
		}

		$sql="DELETE FROM `feedbackresult` where FBResultID=".$this->FBResultID ; 
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
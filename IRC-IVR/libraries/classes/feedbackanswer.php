<?php
class feedbackanswer{

	public $FBAnswerID;
	public $FBAnswer;
	public $FBAnswerEn;
	public $FBAnswerFr;
	public $FBAnswerPath;
	public $IsActive = 1;
	public $IsDeleted = 0;
	public $DateCreated ;

	public function __construct($id=null)
	{
		if(!empty($id) && is_numeric($id))
		{
			$sql = "SELECT * FROM `feedbackanswer` WHERE  FBAnswerID={$id}";
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
		if((!empty($this->FBAnswerID)) and (!is_numeric($this->FBAnswerID)))
		{
			return false;
		}
		$sql="INSERT INTO `feedbackanswer` 
			(".((!empty($this->FBAnswerID))?'`FBAnswerID`,':'').
				((!empty($this->FBAnswer))?'`FBAnswer`,':'').
				((!empty($this->FBAnswerEn))?'`FBAnswerEn`,':'').
				((!empty($this->FBAnswerFr))?'`FBAnswerFr`,':'').
				((!empty($this->FBAnswerPath))?'`FBAnswerPath`,':'').
				((!empty($this->IsActive))?'`IsActive`,':'').
				((!empty($this->IsDeleted))?'`IsDeleted`,':'').
				((!empty($this->DateCreated))?'`DateCreated`,':'').
				") VALUES (". ((!empty($this->FBAnswerID))?$this->FBAnswerID.',':'').
				((!empty($this->FBAnswer))?'"'.$this->FBAnswer.'"'.',':'').
				((!empty($this->FBAnswerEn))?'"'.$this->FBAnswerEn.'"'.',':'').
				((!empty($this->FBAnswerFr))?'"'.$this->FBAnswerFr.'"'.',':'').
				((!empty($this->FBAnswerPath))?'"'.$this->FBAnswerPath.'"'.',':'').
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
		if(empty($this->FBAnswerID))
		{
			return false;
		}
		if((!empty($this->FBAnswerID)) and (!is_numeric($this->FBAnswerID)))
		{
			return false;
		}
		$sql="UPDATE `feedbackanswer` SET ".
			((!empty($this->FBAnswerID))?'`FBAnswerID`=':'').((!empty($this->FBAnswerID))?$this->FBAnswerID.',':'').
			((!empty($this->FBAnswer))?'`FBAnswer`=':'').((!empty($this->FBAnswer))?'"'.$this->FBAnswer.'"'.',':'').
			((!empty($this->FBAnswerEn))?'`FBAnswerEn`=':'').((!empty($this->FBAnswerEn))?'"'.$this->FBAnswerEn.'"'.',':'').
			((!empty($this->FBAnswerFr))?'`FBAnswerFr`=':'').((!empty($this->FBAnswerFr))?'"'.$this->FBAnswerFr.'"'.',':'').
			((!empty($this->FBAnswerPath))?'`FBAnswerPath`=':'').((!empty($this->FBAnswerPath))?'"'.$this->FBAnswerPath.'"'.',':'').
			((!empty($this->IsActive))?'`IsActive`=':'').((!empty($this->IsActive))?'"'.$this->IsActive.'"'.',':'').
			((!empty($this->IsDeleted))?'`IsDeleted`=':'').((!empty($this->IsDeleted))?'"'.$this->IsDeleted.'"'.',':'').
			((!empty($this->DateCreated))?'`DateCreated`=':'').((!empty($this->DateCreated))?'"'.$this->DateCreated.'"'.',':'').
			" WHERE FBAnswerID=".$this->FBAnswerID; 
		$sql=str_replace(', WHERE',' WHERE',$sql);
		if($qry=DB_query ($sql,$b))
		{
			return True;
		}
		return false;
	}

	public function activate()
	{
		if(empty($this->FBAnswerID))
		{
			return false;
		}
		if((!empty($this->FBAnswerID)) and (!is_numeric($this->FBAnswerID)))
		{
			return false;
		}
		$sql="UPDATE `feedbackanswer` SET IsActive=1 where FBAnswerID=".$this->FBAnswerID ; 
		if($qry=DB_query ($sql,$b))
		{
			return True;
		}
		return false;
	}

	public function deactivate()
	{
		if(empty($this->FBAnswerID))
		{
			return false;
		}
		if((!empty($this->FBAnswerID)) and (!is_numeric($this->FBAnswerID)))
		{
			return false;
		}
		$sql="UPDATE `feedbackanswer` SET IsActive=0 where FBAnswerID=".$this->FBAnswerID ; 
		if($qry=DB_query ($sql,$b))
		{
			return True;
		}
		return false;
	}

	public function delete()
	{
		if(empty($this->FBAnswerID))
		{
			return false;
		}
		if((!empty($this->FBAnswerID)) and (!is_numeric($this->FBAnswerID)))
		{
			return false;
		}
		$sql="UPDATE `feedbackanswer` SET IsDeleted=1 where FBAnswerID=".$this->FBAnswerID ; 
		if($qry=DB_query ($sql,$b))
		{
			return True;
		}
		return false;
	}

	public function perDelete()
	{
		if(empty($this->FBAnswerID))
		{
			return false;
		}
		if((!empty($this->FBAnswerID)) and (!is_numeric($this->FBAnswerID)))
		{
			return false;
		}

		$sql="DELETE FROM `feedbackanswer` where FBAnswerID=".$this->FBAnswerID ; 
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
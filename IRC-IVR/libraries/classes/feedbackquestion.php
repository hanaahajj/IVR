<?php
class feedbackquestion{

	public $FBQuestionID;
	public $FBQuestion;
	public $FBQuestionEn;
	public $FBQuestionFr;
	public $FBQuestionPath;
	public $FBTypeID;
	public $IsActive = 1;
	public $IsDeleted = 0;
	public $DateCreated ;

	public function __construct($id=null)
	{
		if(!empty($id) && is_numeric($id))
		{
			$sql = "SELECT * FROM `feedbackquestion` WHERE  FBQuestionID={$id}";
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
		if((!empty($this->FBQuestionID)) and (!is_numeric($this->FBQuestionID)))
		{
			return false;
		}
		if((!empty($this->FBTypeID)) and (!is_numeric($this->FBTypeID)))
		{
			return false;
		}
		$sql="INSERT INTO `feedbackquestion` 
			(".((!empty($this->FBQuestionID))?'`FBQuestionID`,':'').
				((!empty($this->FBQuestion))?'`FBQuestion`,':'').
				((!empty($this->FBQuestionEn))?'`FBQuestionEn`,':'').
				((!empty($this->FBQuestionFr))?'`FBQuestionFr`,':'').
				((!empty($this->FBQuestionPath))?'`FBQuestionPath`,':'').
				((!empty($this->FBTypeID))?'`FBTypeID`,':'').
				((!empty($this->IsActive))?'`IsActive`,':'').
				((!empty($this->IsDeleted))?'`IsDeleted`,':'').
				((!empty($this->DateCreated))?'`DateCreated`,':'').
				") VALUES (". ((!empty($this->FBQuestionID))?$this->FBQuestionID.',':'').
				((!empty($this->FBQuestion))?'"'.$this->FBQuestion.'"'.',':'').
				((!empty($this->FBQuestionEn))?'"'.$this->FBQuestionEn.'"'.',':'').
				((!empty($this->FBQuestionFr))?'"'.$this->FBQuestionFr.'"'.',':'').
				((!empty($this->FBQuestionPath))?'"'.$this->FBQuestionPath.'"'.',':'').
				((!empty($this->FBTypeID))?$this->FBTypeID.',':'').
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
		if(empty($this->FBQuestionID))
		{
			return false;
		}
		if((!empty($this->FBQuestionID)) and (!is_numeric($this->FBQuestionID)))
		{
			return false;
		}
		if((!empty($this->FBTypeID)) and (!is_numeric($this->FBTypeID)))
		{
			return false;
		}
		$sql="UPDATE `feedbackquestion` SET ".
			((!empty($this->FBQuestionID))?'`FBQuestionID`=':'').((!empty($this->FBQuestionID))?$this->FBQuestionID.',':'').
			((!empty($this->FBQuestion))?'`FBQuestion`=':'').((!empty($this->FBQuestion))?'"'.$this->FBQuestion.'"'.',':'').
			((!empty($this->FBQuestionEn))?'`FBQuestionEn`=':'').((!empty($this->FBQuestionEn))?'"'.$this->FBQuestionEn.'"'.',':'').
			((!empty($this->FBQuestionFr))?'`FBQuestionFr`=':'').((!empty($this->FBQuestionFr))?'"'.$this->FBQuestionFr.'"'.',':'').
			((!empty($this->FBQuestionPath))?'`FBQuestionPath`=':'').((!empty($this->FBQuestionPath))?'"'.$this->FBQuestionPath.'"'.',':'').
			((!empty($this->FBTypeID))?'`FBTypeID`=':'').((!empty($this->FBTypeID))?$this->FBTypeID.',':'').
			((!empty($this->IsActive))?'`IsActive`=':'').((!empty($this->IsActive))?'"'.$this->IsActive.'"'.',':'').
			((!empty($this->IsDeleted))?'`IsDeleted`=':'').((!empty($this->IsDeleted))?'"'.$this->IsDeleted.'"'.',':'').
			((!empty($this->DateCreated))?'`DateCreated`=':'').((!empty($this->DateCreated))?'"'.$this->DateCreated.'"'.',':'').
			" WHERE FBQuestionID=".$this->FBQuestionID; 
		$sql=str_replace(', WHERE',' WHERE',$sql);
		if($qry=DB_query ($sql,$b))
		{
			return True;
		}
		return false;
	}

	public function activate()
	{
		if(empty($this->FBQuestionID))
		{
			return false;
		}
		if((!empty($this->FBQuestionID)) and (!is_numeric($this->FBQuestionID)))
		{
			return false;
		}
		$sql="UPDATE `feedbackquestion` SET IsActive=1 where FBQuestionID=".$this->FBQuestionID ; 
		if($qry=DB_query ($sql,$b))
		{
			return True;
		}
		return false;
	}

	public function deactivate()
	{
		if(empty($this->FBQuestionID))
		{
			return false;
		}
		if((!empty($this->FBQuestionID)) and (!is_numeric($this->FBQuestionID)))
		{
			return false;
		}
		$sql="UPDATE `feedbackquestion` SET IsActive=0 where FBQuestionID=".$this->FBQuestionID ; 
		if($qry=DB_query ($sql,$b))
		{
			return True;
		}
		return false;
	}

	public function delete()
	{
		if(empty($this->FBQuestionID))
		{
			return false;
		}
		if((!empty($this->FBQuestionID)) and (!is_numeric($this->FBQuestionID)))
		{
			return false;
		}
		$sql="UPDATE `feedbackquestion` SET IsDeleted=1 where FBQuestionID=".$this->FBQuestionID ; 
		if($qry=DB_query ($sql,$b))
		{
			return True;
		}
		return false;
	}

	public function perDelete()
	{
		if(empty($this->FBQuestionID))
		{
			return false;
		}
		if((!empty($this->FBQuestionID)) and (!is_numeric($this->FBQuestionID)))
		{
			return false;
		}

		$sql="DELETE FROM `feedbackquestion` where FBQuestionID=".$this->FBQuestionID ; 
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
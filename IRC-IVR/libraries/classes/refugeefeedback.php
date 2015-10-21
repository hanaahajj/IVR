<?php
class refugeefeedback{

	public $RFBID;
	public $FBQuestionID;
	public $FBAnswerID;
	public $DateCreated ;

	public function __construct($id=null)
	{
		if(!empty($id) && is_numeric($id))
		{
			$sql = "SELECT * FROM `refugeefeedback` WHERE  RFBID={$id}";
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
		if((!empty($this->RFBID)) and (!is_numeric($this->RFBID)))
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
		$sql="INSERT INTO `refugeefeedback` 
			(".((!empty($this->RFBID))?'`RFBID`,':'').
				((!empty($this->FBQuestionID))?'`FBQuestionID`,':'').
				((!empty($this->FBAnswerID))?'`FBAnswerID`,':'').
				((!empty($this->DateCreated))?'`DateCreated`,':'').
				") VALUES (". ((!empty($this->RFBID))?$this->RFBID.',':'').
				((!empty($this->FBQuestionID))?$this->FBQuestionID.',':'').
				((!empty($this->FBAnswerID))?$this->FBAnswerID.',':'').
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
		if(empty($this->RFBID))
		{
			return false;
		}
		if((!empty($this->RFBID)) and (!is_numeric($this->RFBID)))
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
		$sql="UPDATE `refugeefeedback` SET ".
			((!empty($this->RFBID))?'`RFBID`=':'').((!empty($this->RFBID))?$this->RFBID.',':'').
			((!empty($this->FBQuestionID))?'`FBQuestionID`=':'').((!empty($this->FBQuestionID))?$this->FBQuestionID.',':'').
			((!empty($this->FBAnswerID))?'`FBAnswerID`=':'').((!empty($this->FBAnswerID))?$this->FBAnswerID.',':'').
			((!empty($this->DateCreated))?'`DateCreated`=':'').((!empty($this->DateCreated))?'"'.$this->DateCreated.'"'.',':'').
			" WHERE RFBID=".$this->RFBID; 
		$sql=str_replace(', WHERE',' WHERE',$sql);
		if($qry=DB_query ($sql,$b))
		{
			return True;
		}
		return false;
	}

	public function activate()
	{
		if(empty($this->RFBID))
		{
			return false;
		}
		if((!empty($this->RFBID)) and (!is_numeric($this->RFBID)))
		{
			return false;
		}
		$sql="UPDATE `refugeefeedback` SET IsActive=1 where RFBID=".$this->RFBID ; 
		if($qry=DB_query ($sql,$b))
		{
			return True;
		}
		return false;
	}

	public function deactivate()
	{
		if(empty($this->RFBID))
		{
			return false;
		}
		if((!empty($this->RFBID)) and (!is_numeric($this->RFBID)))
		{
			return false;
		}
		$sql="UPDATE `refugeefeedback` SET IsActive=0 where RFBID=".$this->RFBID ; 
		if($qry=DB_query ($sql,$b))
		{
			return True;
		}
		return false;
	}

	public function delete()
	{
		if(empty($this->RFBID))
		{
			return false;
		}
		if((!empty($this->RFBID)) and (!is_numeric($this->RFBID)))
		{
			return false;
		}
		$sql="UPDATE `refugeefeedback` SET IsDeleted=1 where RFBID=".$this->RFBID ; 
		if($qry=DB_query ($sql,$b))
		{
			return True;
		}
		return false;
	}

	public function perDelete()
	{
		if(empty($this->RFBID))
		{
			return false;
		}
		if((!empty($this->RFBID)) and (!is_numeric($this->RFBID)))
		{
			return false;
		}

		$sql="DELETE FROM `refugeefeedback` where RFBID=".$this->RFBID ; 
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
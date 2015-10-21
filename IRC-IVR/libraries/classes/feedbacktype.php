<?php
class feedbacktype{

	public $FBTypeID;
	public $FBTypeName;
	public $FBTypeNameEn;
	public $FBTypeNameFr;
	public $FBTypeNamePath;
	public $FisrtQuestion;
	public $IsActive = 1;
	public $IsDeleted = 0;
	public $DateCreated ;

	public function __construct($id=null)
	{
		if(!empty($id) && is_numeric($id))
		{
			$sql = "SELECT * FROM `feedbacktype` WHERE  FBTypeID={$id}";
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
		if((!empty($this->FBTypeID)) and (!is_numeric($this->FBTypeID)))
		{
			return false;
		}
		if((!empty($this->FisrtQuestion)) and (!is_numeric($this->FisrtQuestion)))
		{
			return false;
		}
		$sql="INSERT INTO `feedbacktype` 
			(".((!empty($this->FBTypeID))?'`FBTypeID`,':'').
				((!empty($this->FBTypeName))?'`FBTypeName`,':'').
				((!empty($this->FBTypeNameEn))?'`FBTypeNameEn`,':'').
				((!empty($this->FBTypeNameFr))?'`FBTypeNameFr`,':'').
				((!empty($this->FBTypeNamePath))?'`FBTypeNamePath`,':'').
				((!empty($this->FisrtQuestion))?'`FisrtQuestion`,':'').
				((!empty($this->IsActive))?'`IsActive`,':'').
				((!empty($this->IsDeleted))?'`IsDeleted`,':'').
				((!empty($this->DateCreated))?'`DateCreated`,':'').
				") VALUES (". ((!empty($this->FBTypeID))?$this->FBTypeID.',':'').
				((!empty($this->FBTypeName))?'"'.$this->FBTypeName.'"'.',':'').
				((!empty($this->FBTypeNameEn))?'"'.$this->FBTypeNameEn.'"'.',':'').
				((!empty($this->FBTypeNameFr))?'"'.$this->FBTypeNameFr.'"'.',':'').
				((!empty($this->FBTypeNamePath))?'"'.$this->FBTypeNamePath.'"'.',':'').
				((!empty($this->FisrtQuestion))?$this->FisrtQuestion.',':'').
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
		if(empty($this->FBTypeID))
		{
			return false;
		}
		if((!empty($this->FBTypeID)) and (!is_numeric($this->FBTypeID)))
		{
			return false;
		}
		if((!empty($this->FisrtQuestion)) and (!is_numeric($this->FisrtQuestion)))
		{
			return false;
		}
		$sql="UPDATE `feedbacktype` SET ".
			((!empty($this->FBTypeID))?'`FBTypeID`=':'').((!empty($this->FBTypeID))?$this->FBTypeID.',':'').
			((!empty($this->FBTypeName))?'`FBTypeName`=':'').((!empty($this->FBTypeName))?'"'.$this->FBTypeName.'"'.',':'').
			((!empty($this->FBTypeNameEn))?'`FBTypeNameEn`=':'').((!empty($this->FBTypeNameEn))?'"'.$this->FBTypeNameEn.'"'.',':'').
			((!empty($this->FBTypeNameFr))?'`FBTypeNameFr`=':'').((!empty($this->FBTypeNameFr))?'"'.$this->FBTypeNameFr.'"'.',':'').
			((!empty($this->FBTypeNamePath))?'`FBTypeNamePath`=':'').((!empty($this->FBTypeNamePath))?'"'.$this->FBTypeNamePath.'"'.',':'').
			((!empty($this->FisrtQuestion))?'`FisrtQuestion`=':'').((!empty($this->FisrtQuestion))?$this->FisrtQuestion.',':'').
			((!empty($this->IsActive))?'`IsActive`=':'').((!empty($this->IsActive))?'"'.$this->IsActive.'"'.',':'').
			((!empty($this->IsDeleted))?'`IsDeleted`=':'').((!empty($this->IsDeleted))?'"'.$this->IsDeleted.'"'.',':'').
			((!empty($this->DateCreated))?'`DateCreated`=':'').((!empty($this->DateCreated))?'"'.$this->DateCreated.'"'.',':'').
			" WHERE FBTypeID=".$this->FBTypeID; 
		$sql=str_replace(', WHERE',' WHERE',$sql);
		if($qry=DB_query ($sql,$b))
		{
			return True;
		}
		return false;
	}

	public function activate()
	{
		if(empty($this->FBTypeID))
		{
			return false;
		}
		if((!empty($this->FBTypeID)) and (!is_numeric($this->FBTypeID)))
		{
			return false;
		}
		$sql="UPDATE `feedbacktype` SET IsActive=1 where FBTypeID=".$this->FBTypeID ; 
		if($qry=DB_query ($sql,$b))
		{
			return True;
		}
		return false;
	}

	public function deactivate()
	{
		if(empty($this->FBTypeID))
		{
			return false;
		}
		if((!empty($this->FBTypeID)) and (!is_numeric($this->FBTypeID)))
		{
			return false;
		}
		$sql="UPDATE `feedbacktype` SET IsActive=0 where FBTypeID=".$this->FBTypeID ; 
		if($qry=DB_query ($sql,$b))
		{
			return True;
		}
		return false;
	}

	public function delete()
	{
		if(empty($this->FBTypeID))
		{
			return false;
		}
		if((!empty($this->FBTypeID)) and (!is_numeric($this->FBTypeID)))
		{
			return false;
		}
		$sql="UPDATE `feedbacktype` SET IsDeleted=1 where FBTypeID=".$this->FBTypeID ; 
		if($qry=DB_query ($sql,$b))
		{
			return True;
		}
		return false;
	}

	public function perDelete()
	{
		if(empty($this->FBTypeID))
		{
			return false;
		}
		if((!empty($this->FBTypeID)) and (!is_numeric($this->FBTypeID)))
		{
			return false;
		}

		$sql="DELETE FROM `feedbacktype` where FBTypeID=".$this->FBTypeID ; 
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
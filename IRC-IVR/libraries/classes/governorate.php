<?php
class governorate{

	public $GovID;
	public $GovName;
	public $GovNameEn;
	public $GovNameFr;
	public $GovNamePath;
	public $IsActive = 1;
	public $IsDeleted = 0;
	public $DateCreated ;

	public function __construct($id=null)
	{
		if(!empty($id) && is_numeric($id))
		{
			$sql = "SELECT * FROM `governorate` WHERE  GovID={$id}";
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
		if((!empty($this->GovID)) and (!is_numeric($this->GovID)))
		{
			return false;
		}
		$sql="INSERT INTO `governorate` 
			(".((!empty($this->GovID))?'`GovID`,':'').
				((!empty($this->GovName))?'`GovName`,':'').
				((!empty($this->GovNameEn))?'`GovNameEn`,':'').
				((!empty($this->GovNameFr))?'`GovNameFr`,':'').
				((!empty($this->GovNamePath))?'`GovNamePath`,':'').
				((!empty($this->IsActive))?'`IsActive`,':'').
				((!empty($this->IsDeleted))?'`IsDeleted`,':'').
				((!empty($this->DateCreated))?'`DateCreated`,':'').
				") VALUES (". ((!empty($this->GovID))?$this->GovID.',':'').
				((!empty($this->GovName))?'"'.$this->GovName.'"'.',':'').
				((!empty($this->GovNameEn))?'"'.$this->GovNameEn.'"'.',':'').
				((!empty($this->GovNameFr))?'"'.$this->GovNameFr.'"'.',':'').
				((!empty($this->GovNamePath))?'"'.$this->GovNamePath.'"'.',':'').
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
		if(empty($this->GovID))
		{
			return false;
		}
		if((!empty($this->GovID)) and (!is_numeric($this->GovID)))
		{
			return false;
		}
		$sql="UPDATE `governorate` SET ".
			((!empty($this->GovID))?'`GovID`=':'').((!empty($this->GovID))?$this->GovID.',':'').
			((!empty($this->GovName))?'`GovName`=':'').((!empty($this->GovName))?'"'.$this->GovName.'"'.',':'').
			((!empty($this->GovNameEn))?'`GovNameEn`=':'').((!empty($this->GovNameEn))?'"'.$this->GovNameEn.'"'.',':'').
			((!empty($this->GovNameFr))?'`GovNameFr`=':'').((!empty($this->GovNameFr))?'"'.$this->GovNameFr.'"'.',':'').
			((!empty($this->GovNamePath))?'`GovNamePath`=':'').((!empty($this->GovNamePath))?'"'.$this->GovNamePath.'"'.',':'').
			((!empty($this->IsActive))?'`IsActive`=':'').((!empty($this->IsActive))?'"'.$this->IsActive.'"'.',':'').
			((!empty($this->IsDeleted))?'`IsDeleted`=':'').((!empty($this->IsDeleted))?'"'.$this->IsDeleted.'"'.',':'').
			((!empty($this->DateCreated))?'`DateCreated`=':'').((!empty($this->DateCreated))?'"'.$this->DateCreated.'"'.',':'').
			" WHERE GovID=".$this->GovID; 
		$sql=str_replace(', WHERE',' WHERE',$sql);
		if($qry=DB_query ($sql,$b))
		{
			return True;
		}
		return false;
	}

	public function activate()
	{
		if(empty($this->GovID))
		{
			return false;
		}
		if((!empty($this->GovID)) and (!is_numeric($this->GovID)))
		{
			return false;
		}
		$sql="UPDATE `governorate` SET IsActive=1 where GovID=".$this->GovID ; 
		if($qry=DB_query ($sql,$b))
		{
			return True;
		}
		return false;
	}

	public function deactivate()
	{
		if(empty($this->GovID))
		{
			return false;
		}
		if((!empty($this->GovID)) and (!is_numeric($this->GovID)))
		{
			return false;
		}
		$sql="UPDATE `governorate` SET IsActive=0 where GovID=".$this->GovID ; 
		if($qry=DB_query ($sql,$b))
		{
			return True;
		}
		return false;
	}

	public function delete()
	{
		if(empty($this->GovID))
		{
			return false;
		}
		if((!empty($this->GovID)) and (!is_numeric($this->GovID)))
		{
			return false;
		}
		$sql="UPDATE `governorate` SET IsDeleted=1 where GovID=".$this->GovID ; 
		if($qry=DB_query ($sql,$b))
		{
			return True;
		}
		return false;
	}

	public function perDelete()
	{
		if(empty($this->GovID))
		{
			return false;
		}
		if((!empty($this->GovID)) and (!is_numeric($this->GovID)))
		{
			return false;
		}

		$sql="DELETE FROM `governorate` where GovID=".$this->GovID ; 
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
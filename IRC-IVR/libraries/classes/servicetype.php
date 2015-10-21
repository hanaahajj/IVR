<?php
class ServiceType{

	public $ServiceTypeID;
	public $ServiceType;
	public $ServiceTypeEn;
	public $ServiceTypeFr;
	public $ServiceTypePath;
	public $IsActive = 1;
	public $IsDeleted = 0;
	public $DateCreated ;

	public function __construct($id=null)
	{
		if(!empty($id) && is_numeric($id))
		{
			$sql = "SELECT * FROM `servicetype` WHERE  ServiceTypeID={$id}";
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
		if((!empty($this->ServiceTypeID)) and (!is_numeric($this->ServiceTypeID)))
		{
			return false;
		}
		$sql="INSERT INTO `servicetype` 
			(".((!empty($this->ServiceTypeID))?'`ServiceTypeID`,':'').
				((!empty($this->ServiceType))?'`ServiceType`,':'').
				((!empty($this->ServiceTypeEn))?'`ServiceTypeEn`,':'').
				((!empty($this->ServiceTypeFr))?'`ServiceTypeFr`,':'').
				((!empty($this->ServiceTypePath))?'`ServiceTypePath`,':'').
				((!empty($this->IsActive))?'`IsActive`,':'').
				((!empty($this->IsDeleted))?'`IsDeleted`,':'').
				((!empty($this->DateCreated))?'`DateCreated`,':'').
				") VALUES (". ((!empty($this->ServiceTypeID))?$this->ServiceTypeID.',':'').
				((!empty($this->ServiceType))?'"'.$this->ServiceType.'"'.',':'').
				((!empty($this->ServiceTypeEn))?'"'.$this->ServiceTypeEn.'"'.',':'').
				((!empty($this->ServiceTypeFr))?'"'.$this->ServiceTypeFr.'"'.',':'').
				((!empty($this->ServiceTypePath))?'"'.$this->ServiceTypePath.'"'.',':'').
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
		if(empty($this->ServiceTypeID))
		{
			return false;
		}
		if((!empty($this->ServiceTypeID)) and (!is_numeric($this->ServiceTypeID)))
		{
			return false;
		}
		$sql="UPDATE `servicetype` SET ".
			((!empty($this->ServiceTypeID))?'`ServiceTypeID`=':'').((!empty($this->ServiceTypeID))?$this->ServiceTypeID.',':'').
			((!empty($this->ServiceType))?'`ServiceType`=':'').((!empty($this->ServiceType))?'"'.$this->ServiceType.'"'.',':'').
			((!empty($this->ServiceTypeEn))?'`ServiceTypeEn`=':'').((!empty($this->ServiceTypeEn))?'"'.$this->ServiceTypeEn.'"'.',':'').
			((!empty($this->ServiceTypeFr))?'`ServiceTypeFr`=':'').((!empty($this->ServiceTypeFr))?'"'.$this->ServiceTypeFr.'"'.',':'').
			((!empty($this->ServiceTypePath))?'`ServiceTypePath`=':'').((!empty($this->ServiceTypePath))?'"'.$this->ServiceTypePath.'"'.',':'').
			((!empty($this->IsActive))?'`IsActive`=':'').((!empty($this->IsActive))?'"'.$this->IsActive.'"'.',':'').
			((!empty($this->IsDeleted))?'`IsDeleted`=':'').((!empty($this->IsDeleted))?'"'.$this->IsDeleted.'"'.',':'').
			((!empty($this->DateCreated))?'`DateCreated`=':'').((!empty($this->DateCreated))?'"'.$this->DateCreated.'"'.',':'').
			" WHERE ServiceTypeID=".$this->ServiceTypeID; 
		$sql=str_replace(', WHERE',' WHERE',$sql);
		if($qry=DB_query ($sql,$b))
		{
			return True;
		}
		return false;
	}

	public function activate()
	{
		if(empty($this->ServiceTypeID))
		{
			return false;
		}
		if((!empty($this->ServiceTypeID)) and (!is_numeric($this->ServiceTypeID)))
		{
			return false;
		}
		$sql="UPDATE `servicetype` SET IsActive=1 where ServiceTypeID=".$this->ServiceTypeID ; 
		if($qry=DB_query ($sql,$b))
		{
			return True;
		}
		return false;
	}

	public function deactivate()
	{
		if(empty($this->ServiceTypeID))
		{
			return false;
		}
		if((!empty($this->ServiceTypeID)) and (!is_numeric($this->ServiceTypeID)))
		{
			return false;
		}
		$sql="UPDATE `servicetype` SET IsActive=0 where ServiceTypeID=".$this->ServiceTypeID ; 
		if($qry=DB_query ($sql,$b))
		{
			return True;
		}
		return false;
	}

	public function delete()
	{
		if(empty($this->ServiceTypeID))
		{
			return false;
		}
		if((!empty($this->ServiceTypeID)) and (!is_numeric($this->ServiceTypeID)))
		{
			return false;
		}
		$sql="UPDATE `servicetype` SET IsDeleted=1 where ServiceTypeID=".$this->ServiceTypeID ; 
		if($qry=DB_query ($sql,$b))
		{
			return True;
		}
		return false;
	}

	public function perDelete()
	{
		if(empty($this->ServiceTypeID))
		{
			return false;
		}
		if((!empty($this->ServiceTypeID)) and (!is_numeric($this->ServiceTypeID)))
		{
			return false;
		}

		$sql="DELETE FROM `servicetype` where ServiceTypeID=".$this->ServiceTypeID ; 
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
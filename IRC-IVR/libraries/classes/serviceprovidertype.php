<?php
class serviceprovidertype{

	public $SPTypeID;
	public $SPType;
	public $SPTypeEn;
	public $SPTypeFr;
	public $SPTypePath;
	public $IsActive = 1;
	public $IsDeleted = 0;
	public $DateCreated ;

	public function __construct($id=null)
	{
		if(!empty($id) && is_numeric($id))
		{
			$sql = "SELECT * FROM `serviceprovidertype` WHERE  SPTypeID={$id}";
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
		if((!empty($this->SPTypeID)) and (!is_numeric($this->SPTypeID)))
		{
			return false;
		}
		$sql="INSERT INTO `serviceprovidertype` 
			(".((!empty($this->SPTypeID))?'`SPTypeID`,':'').
				((!empty($this->SPType))?'`SPType`,':'').
				((!empty($this->SPTypeEn))?'`SPTypeEn`,':'').
				((!empty($this->SPTypeFr))?'`SPTypeFr`,':'').
				((!empty($this->SPTypePath))?'`SPTypePath`,':'').
				((!empty($this->IsActive))?'`IsActive`,':'').
				((!empty($this->IsDeleted))?'`IsDeleted`,':'').
				((!empty($this->DateCreated))?'`DateCreated`,':'').
				") VALUES (". ((!empty($this->SPTypeID))?$this->SPTypeID.',':'').
				((!empty($this->SPType))?'"'.$this->SPType.'"'.',':'').
				((!empty($this->SPTypeEn))?'"'.$this->SPTypeEn.'"'.',':'').
				((!empty($this->SPTypeFr))?'"'.$this->SPTypeFr.'"'.',':'').
				((!empty($this->SPTypePath))?'"'.$this->SPTypePath.'"'.',':'').
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
		if(empty($this->SPTypeID))
		{
			return false;
		}
		if((!empty($this->SPTypeID)) and (!is_numeric($this->SPTypeID)))
		{
			return false;
		}
		$sql="UPDATE `serviceprovidertype` SET ".
			((!empty($this->SPTypeID))?'`SPTypeID`=':'').((!empty($this->SPTypeID))?$this->SPTypeID.',':'').
			((!empty($this->SPType))?'`SPType`=':'').((!empty($this->SPType))?'"'.$this->SPType.'"'.',':'').
			((!empty($this->SPTypeEn))?'`SPTypeEn`=':'').((!empty($this->SPTypeEn))?'"'.$this->SPTypeEn.'"'.',':'').
			((!empty($this->SPTypeFr))?'`SPTypeFr`=':'').((!empty($this->SPTypeFr))?'"'.$this->SPTypeFr.'"'.',':'').
			((!empty($this->SPTypePath))?'`SPTypePath`=':'').((!empty($this->SPTypePath))?'"'.$this->SPTypePath.'"'.',':'').
			((!empty($this->IsActive))?'`IsActive`=':'').((!empty($this->IsActive))?'"'.$this->IsActive.'"'.',':'').
			((!empty($this->IsDeleted))?'`IsDeleted`=':'').((!empty($this->IsDeleted))?'"'.$this->IsDeleted.'"'.',':'').
			((!empty($this->DateCreated))?'`DateCreated`=':'').((!empty($this->DateCreated))?'"'.$this->DateCreated.'"'.',':'').
			" WHERE SPTypeID=".$this->SPTypeID; 
		$sql=str_replace(', WHERE',' WHERE',$sql);
		if($qry=DB_query ($sql,$b))
		{
			return True;
		}
		return false;
	}

	public function activate()
	{
		if(empty($this->SPTypeID))
		{
			return false;
		}
		if((!empty($this->SPTypeID)) and (!is_numeric($this->SPTypeID)))
		{
			return false;
		}
		$sql="UPDATE `serviceprovidertype` SET IsActive=1 where SPTypeID=".$this->SPTypeID ; 
		if($qry=DB_query ($sql,$b))
		{
			return True;
		}
		return false;
	}

	public function deactivate()
	{
		if(empty($this->SPTypeID))
		{
			return false;
		}
		if((!empty($this->SPTypeID)) and (!is_numeric($this->SPTypeID)))
		{
			return false;
		}
		$sql="UPDATE `serviceprovidertype` SET IsActive=0 where SPTypeID=".$this->SPTypeID ; 
		if($qry=DB_query ($sql,$b))
		{
			return True;
		}
		return false;
	}

	public function delete()
	{
		if(empty($this->SPTypeID))
		{
			return false;
		}
		if((!empty($this->SPTypeID)) and (!is_numeric($this->SPTypeID)))
		{
			return false;
		}
		$sql="UPDATE `serviceprovidertype` SET IsDeleted=1 where SPTypeID=".$this->SPTypeID ; 
		if($qry=DB_query ($sql,$b))
		{
			return True;
		}
		return false;
	}

	public function perDelete()
	{
		if(empty($this->SPTypeID))
		{
			return false;
		}
		if((!empty($this->SPTypeID)) and (!is_numeric($this->SPTypeID)))
		{
			return false;
		}

		$sql="DELETE FROM `serviceprovidertype` where SPTypeID=".$this->SPTypeID ; 
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
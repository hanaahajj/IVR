<?php
class serviceprovider{

	public $SPID;
	public $SPANI;
	public $SPTypeID;
	public $SPPhone;
	public $SPName;
	public $SPNameEn;
	public $SPNameFr;
	public $SPNamePath;
	public $SPAddress;
	public $SPAddressEn;
	public $SPAddressFr;
	public $SPAddressPath;
	public $SPPIN;
	public $SPFocalPoint;
	public $SPFocalPointEn;
	public $SPFocalPointFr;
	public $SPFocalPointPath;
	public $SPFocalPointPhone;
	public $IsActive = 1;
	public $IsDeleted = 0;

	public function __construct($id=null)
	{
		if(!empty($id) && is_numeric($id))
		{
			$sql = "SELECT * FROM `asterisk`.`serviceprovider` WHERE  SPID={$id}";
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
		if((!empty($this->SPID)) and (!is_numeric($this->SPID)))
		{
			return false;
		}
		if((!empty($this->SPTypeID)) and (!is_numeric($this->SPTypeID)))
		{
			return false;
		}
		
		$dt = new DateTime();
		$this->DateCreated = $dt->format('Y-m-d H:i:s');

		$sql="INSERT INTO `asterisk`.`serviceprovider` 
			(".((!empty($this->SPID))?'`SPID`,':'').
				((!empty($this->SPANI))?'`SPANI`,':'').
				((!empty($this->SPTypeID))?'`SPTypeID`,':'').
				((!empty($this->SPPhone))?'`SPPhone`,':'').
				((!empty($this->SPName))?'`SPName`,':'').
				((!empty($this->SPNameEn))?'`SPNameEn`,':'').
				((!empty($this->SPNameFr))?'`SPNameFr`,':'').
				((!empty($this->SPNamePath))?'`SPNamePath`,':'').
				((!empty($this->SPAddress))?'`SPAddress`,':'').
				((!empty($this->SPAddressEn))?'`SPAddressEn`,':'').
				((!empty($this->SPAddressFr))?'`SPAddressFr`,':'').
				((!empty($this->SPAddressPath))?'`SPAddressPath`,':'').
				((!empty($this->SPPIN))?'`SPPIN`,':'').
				((!empty($this->SPFocalPoint))?'`SPFocalPoint`,':'').
				((!empty($this->SPFocalPointEn))?'`SPFocalPointEn`,':'').
				((!empty($this->SPFocalPointFr))?'`SPFocalPointFr`,':'').
				((!empty($this->SPFocalPointPath))?'`SPFocalPointPath`,':'').
				((!empty($this->SPFocalPointPhone))?'`SPFocalPointPhone`,':'').
				((!empty($this->IsActive))?'`IsActive`,':'').
				((!empty($this->IsDeleted))?'`IsDeleted`,':'').
				((!empty($this->DateCreated))?'`DateCreated`,':'').
				") VALUES (". ((!empty($this->SPID))?$this->SPID.',':'').
				((!empty($this->SPANI))?'"'.$this->SPANI.'"'.',':'').
				((!empty($this->SPTypeID))?$this->SPTypeID.',':'').
				((!empty($this->SPPhone))?'"'.$this->SPPhone.'"'.',':'').
				((!empty($this->SPName))?'"'.$this->SPName.'"'.',':'').
				((!empty($this->SPNameEn))?'"'.$this->SPNameEn.'"'.',':'').
				((!empty($this->SPNameFr))?'"'.$this->SPNameFr.'"'.',':'').
				((!empty($this->SPNamePath))?'"'.$this->SPNamePath.'"'.',':'').
				((!empty($this->SPAddress))?'"'.$this->SPAddress.'"'.',':'').
				((!empty($this->SPAddressEn))?'"'.$this->SPAddressEn.'"'.',':'').
				((!empty($this->SPAddressFr))?'"'.$this->SPAddressFr.'"'.',':'').
				((!empty($this->SPAddressPath))?'"'.$this->SPAddressPath.'"'.',':'').
				((!empty($this->SPPIN))?'"'.$this->SPPIN.'"'.',':'').
				((!empty($this->SPFocalPoint))?'"'.$this->SPFocalPoint.'"'.',':'').
				((!empty($this->SPFocalPointEn))?'"'.$this->SPFocalPointEn.'"'.',':'').
				((!empty($this->SPFocalPointFr))?'"'.$this->SPFocalPointFr.'"'.',':'').
				((!empty($this->SPFocalPointPath))?'"'.$this->SPFocalPointPath.'"'.',':'').
				((!empty($this->SPFocalPointPhone))?'"'.$this->SPFocalPointPhone.'"'.',':'').
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
		if(empty($this->SPID))
		{
			return false;
		}
		if((!empty($this->SPID)) and (!is_numeric($this->SPID)))
		{
			return false;
		}
		if((!empty($this->SPTypeID)) and (!is_numeric($this->SPTypeID)))
		{
			return false;
		}
		$sql="UPDATE `asterisk`.`serviceprovider` SET ".
			((!empty($this->SPID))?'`SPID`=':'').((!empty($this->SPID))?$this->SPID.',':'').
			((!empty($this->SPANI))?'`SPANI`=':'').((!empty($this->SPANI))?'"'.$this->SPANI.'"'.',':'').
			((!empty($this->SPTypeID))?'`SPTypeID`=':'').((!empty($this->SPTypeID))?$this->SPTypeID.',':'').
			((!empty($this->SPPhone))?'`SPPhone`=':'').((!empty($this->SPPhone))?'"'.$this->SPPhone.'"'.',':'').
			((!empty($this->SPName))?'`SPName`=':'').((!empty($this->SPName))?'"'.$this->SPName.'"'.',':'').
			((!empty($this->SPNameEn))?'`SPNameEn`=':'').((!empty($this->SPNameEn))?'"'.$this->SPNameEn.'"'.',':'').
			((!empty($this->SPNameFr))?'`SPNameFr`=':'').((!empty($this->SPNameFr))?'"'.$this->SPNameFr.'"'.',':'').
			((!empty($this->SPNamePath))?'`SPNamePath`=':'').((!empty($this->SPNamePath))?'"'.$this->SPNamePath.'"'.',':'').
			((!empty($this->SPAddress))?'`SPAddress`=':'').((!empty($this->SPAddress))?'"'.$this->SPAddress.'"'.',':'').
			((!empty($this->SPAddressEn))?'`SPAddressEn`=':'').((!empty($this->SPAddressEn))?'"'.$this->SPAddressEn.'"'.',':'').
			((!empty($this->SPAddressFr))?'`SPAddressFr`=':'').((!empty($this->SPAddressFr))?'"'.$this->SPAddressFr.'"'.',':'').
			((!empty($this->SPAddressPath))?'`SPAddressPath`=':'').((!empty($this->SPAddressPath))?'"'.$this->SPAddressPath.'"'.',':'').
			((!empty($this->SPPIN))?'`SPPIN`=':'').((!empty($this->SPPIN))?'"'.$this->SPPIN.'"'.',':'').
			((!empty($this->SPFocalPoint))?'`SPFocalPoint`=':'').((!empty($this->SPFocalPoint))?'"'.$this->SPFocalPoint.'"'.',':'').
			((!empty($this->SPFocalPointEn))?'`SPFocalPointEn`=':'').((!empty($this->SPFocalPointEn))?'"'.$this->SPFocalPointEn.'"'.',':'').
			((!empty($this->SPFocalPointFr))?'`SPFocalPointFr`=':'').((!empty($this->SPFocalPointFr))?'"'.$this->SPFocalPointFr.'"'.',':'').
			((!empty($this->SPFocalPointPath))?'`SPFocalPointPath`=':'').((!empty($this->SPFocalPointPath))?'"'.$this->SPFocalPointPath.'"'.',':'').
			((!empty($this->SPFocalPointPhone))?'`SPFocalPointPhone`=':'').((!empty($this->SPFocalPointPhone))?'"'.$this->SPFocalPointPhone.'"'.',':'').
			((!empty($this->IsActive))?'`IsActive`=':'').((!empty($this->IsActive))?'"'.$this->IsActive.'"'.',':'').
			((!empty($this->IsDeleted))?'`IsDeleted`=':'').((!empty($this->IsDeleted))?'"'.$this->IsDeleted.'"'.',':'').
			((!empty($this->DateCreated))?'`DateCreated`=':'').((!empty($this->DateCreated))?'"'.$this->DateCreated.'"'.',':'').
			" WHERE SPID=".$this->SPID; 
		$sql=str_replace(', WHERE',' WHERE',$sql);
		if($qry=DB_query ($sql,$b))
		{
			return True;
		}
		return false;
	}

	public function activate()
	{
		if(empty($this->SPID))
		{
			return false;
		}
		if((!empty($this->SPID)) and (!is_numeric($this->SPID)))
		{
			return false;
		}
		$sql="UPDATE `asterisk`.`serviceprovider` SET IsActive=1 where SPID=".$this->SPID ; 
		if($qry=DB_query ($sql,$b))
		{
			return True;
		}
		return false;
	}

	public function deactivate()
	{
		if(empty($this->SPID))
		{
			return false;
		}
		if((!empty($this->SPID)) and (!is_numeric($this->SPID)))
		{
			return false;
		}
		$sql="UPDATE `asterisk`.`serviceprovider` SET IsActive=0 where SPID=".$this->SPID ; 
		if($qry=DB_query ($sql,$b))
		{
			return True;
		}
		return false;
	}

	public function delete()
	{
		if(empty($this->SPID))
		{
			return false;
		}
		if((!empty($this->SPID)) and (!is_numeric($this->SPID)))
		{
			return false;
		}
		$sql="UPDATE `asterisk`.`serviceprovider` SET IsDeleted=1 where SPID=".$this->SPID ; 
		if($qry=DB_query ($sql,$b))
		{
			return True;
		}
		return false;
	}

	public function perDelete()
	{
		if(empty($this->SPID))
		{
			return false;
		}
		if((!empty($this->SPID)) and (!is_numeric($this->SPID)))
		{
			return false;
		}

		$sql="DELETE FROM `asterisk`.`serviceprovider` where SPID=".$this->SPID ; 
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
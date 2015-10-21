<?php
class service{

	public $ServiceID;
	public $SPID;
	public $ServiceTypeID;
	public $ServiceDistID;
	public $ServiceName;
	public $ServiceNameEn;
	public $ServiceNameFr;
	public $ServiceNamePath;
	public $ServiceAddInfoPath;
	public $ServiceAddInfo;
	public $IsActive = 1;
	public $IsDeleted = 0;
	public $DateCreated ;

	public function __construct($id=null)
	{
		if(!empty($id) && is_numeric($id))
		{
			$sql = "SELECT * FROM `asterisk`.`service` WHERE  ServiceID={$id}";
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
		if((!empty($this->ServiceID)) and (!is_numeric($this->ServiceID)))
		{
			return false;
		}
		if((!empty($this->SPID)) and (!is_numeric($this->SPID)))
		{
			return false;
		}
		if((!empty($this->ServiceTypeID)) and (!is_numeric($this->ServiceTypeID)))
		{
			return false;
		}
		if((!empty($this->ServiceDistID)) and (!is_numeric($this->ServiceDistID)))
		{
			return false;
		}

		$dt = new DateTime();
		$this->DateCreated = $dt->format('Y-m-d H:i:s');

		$sql="INSERT INTO `asterisk`.`service` (".((!empty($this->ServiceID))?'`ServiceID`,':'').
				((!empty($this->SPID))?'`SPID`,':'').
				((!empty($this->ServiceTypeID))?'`ServiceTypeID`,':'').
				((!empty($this->ServiceDistID))?'`ServiceDistID`,':'').
				((!empty($this->ServiceName))?'`ServiceName`,':'').
				((!empty($this->ServiceNameEn))?'`ServiceNameEn`,':'').
				((!empty($this->ServiceNameFr))?'`ServiceNameFr`,':'').
				((!empty($this->ServiceNamePath))?'`ServiceNamePath`,':'').
				((!empty($this->ServiceAddInfoPath))?'`ServiceAddInfoPath`,':'').
				((!empty($this->ServiceAddInfo))?'`ServiceAddInfo`,':'').
				((!empty($this->IsActive))?'`IsActive`,':'').
				((!empty($this->IsDeleted))?'`IsDeleted`,':'').
				((!empty($this->DateCreated))?'`DateCreated`,':'').
				") VALUES (". ((!empty($this->ServiceID))?$this->ServiceID.',':'').
				((!empty($this->SPID))?$this->SPID.',':'').
				((!empty($this->ServiceTypeID))?$this->ServiceTypeID.',':'').
				((!empty($this->ServiceDistID))?$this->ServiceDistID.',':'').
				((!empty($this->ServiceName))?'"'.$this->ServiceName.'"'.',':'').
				((!empty($this->ServiceNameEn))?'"'.$this->ServiceNameEn.'"'.',':'').
				((!empty($this->ServiceNameFr))?'"'.$this->ServiceNameFr.'"'.',':'').
				((!empty($this->ServiceNamePath))?'"'.$this->ServiceNamePath.'"'.',':'').
				((!empty($this->ServiceAddInfoPath))?'"'.$this->ServiceAddInfoPath.'"'.',':'').
				((!empty($this->ServiceAddInfo))?'"'.$this->ServiceAddInfo.'"'.',':'').
				((!empty($this->IsActive))?'"'.$this->IsActive.'"'.',':'').
				((!empty($this->IsDeleted))?'"'.$this->IsDeleted.'"'.',':'').
				((!empty($this->DateCreated))?'"'.$this->DateCreated.'"'.',':'').
				")"; 
		$sql=str_replace(',)',')',$sql);

		runIRC::log_agi($sql);
		if($qry=DB_query ($sql,$b))
		{
			return DB_Last_Insert_ID();
		}
		return false;
	}

	public function update()
	{
		if(empty($this->ServiceID))
		{
			return false;
		}
		if((!empty($this->ServiceID)) and (!is_numeric($this->ServiceID)))
		{
			return false;
		}
		if((!empty($this->SPID)) and (!is_numeric($this->SPID)))
		{
			return false;
		}
		if((!empty($this->ServiceTypeID)) and (!is_numeric($this->ServiceTypeID)))
		{
			return false;
		}
		if((!empty($this->ServiceDistID)) and (!is_numeric($this->ServiceDistID)))
		{
			return false;
		}
		$sql="UPDATE `asterisk`.`service` SET ".
			((!empty($this->ServiceID))?'`ServiceID`=':'').((!empty($this->ServiceID))?$this->ServiceID.',':'').
			((!empty($this->SPID))?'`SPID`=':'').((!empty($this->SPID))?$this->SPID.',':'').
			((!empty($this->ServiceTypeID))?'`ServiceTypeID`=':'').((!empty($this->ServiceTypeID))?$this->ServiceTypeID.',':'').
			((!empty($this->ServiceDistID))?'`ServiceDistID`=':'').((!empty($this->ServiceDistID))?$this->ServiceDistID.',':'').
			((!empty($this->ServiceName))?'`ServiceName`=':'').((!empty($this->ServiceName))?'"'.$this->ServiceName.'"'.',':'').
			((!empty($this->ServiceNameEn))?'`ServiceNameEn`=':'').((!empty($this->ServiceNameEn))?'"'.$this->ServiceNameEn.'"'.',':'').
			((!empty($this->ServiceNameFr))?'`ServiceNameFr`=':'').((!empty($this->ServiceNameFr))?'"'.$this->ServiceNameFr.'"'.',':'').
			((!empty($this->ServiceNamePath))?'`ServiceNamePath`=':'').((!empty($this->ServiceNamePath))?'"'.$this->ServiceNamePath.'"'.',':'').
			((!empty($this->ServiceAddInfoPath))?'`ServiceAddInfoPath`=':'').((!empty($this->ServiceAddInfoPath))?'"'.$this->ServiceAddInfoPath.'"'.',':'').
			((!empty($this->ServiceAddInfo))?'`ServiceAddInfo`=':'').((!empty($this->ServiceAddInfo))?'"'.$this->ServiceAddInfo.'"'.',':'').
			((!empty($this->IsActive))?'`IsActive`=':'').((!empty($this->IsActive))?'"'.$this->IsActive.'"'.',':'').
			((!empty($this->IsDeleted))?'`IsDeleted`=':'').((!empty($this->IsDeleted))?'"'.$this->IsDeleted.'"'.',':'').
			((!empty($this->DateCreated))?'`DateCreated`=':'').((!empty($this->DateCreated))?'"'.$this->DateCreated.'"'.',':'').
			" WHERE ServiceID=".$this->ServiceID; 
		$sql=str_replace(', WHERE',' WHERE',$sql);
		if($qry=DB_query ($sql,$b))
		{
			return True;
		}
		return false;
	}

	public function activate()
	{
		if(empty($this->ServiceID))
		{
			return false;
		}
		if((!empty($this->ServiceID)) and (!is_numeric($this->ServiceID)))
		{
			return false;
		}
		$sql="UPDATE `asterisk`.`service` SET IsActive=1 where ServiceID=".$this->ServiceID ; 
		if($qry=DB_query ($sql,$b))
		{
			return True;
		}
		return false;
	}

	public function deactivate()
	{
		if(empty($this->ServiceID))
		{
			return false;
		}
		if((!empty($this->ServiceID)) and (!is_numeric($this->ServiceID)))
		{
			return false;
		}
		$sql="UPDATE `asterisk`.`service` SET IsActive=0 where ServiceID=".$this->ServiceID ; 
		if($qry=DB_query ($sql,$b))
		{
			return True;
		}
		return false;
	}

	public function delete()
	{
		if(empty($this->ServiceID))
		{
			return false;
		}
		if((!empty($this->ServiceID)) and (!is_numeric($this->ServiceID)))
		{
			return false;
		}
		$sql="UPDATE `asterisk`.`service` SET IsDeleted=1 where ServiceID=".$this->ServiceID ; 
		if($qry=DB_query ($sql,$b))
		{
			return True;
		}
		return false;
	}

	public function perDelete()
	{
		if(empty($this->ServiceID))
		{
			return false;
		}
		if((!empty($this->ServiceID)) and (!is_numeric($this->ServiceID)))
		{
			return false;
		}

		$sql="DELETE FROM `asterisk`.`service` where ServiceID=".$this->ServiceID ; 
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
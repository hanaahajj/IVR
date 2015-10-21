<?php
require(dirname(__FILE__)."/classes/cdr.php");
require(dirname(__FILE__)."/classes/governorate.php");
require(dirname(__FILE__)."/classes/district.php");
require(dirname(__FILE__)."/classes/serviceprovider.php");
require(dirname(__FILE__)."/classes/pin.php");
require(dirname(__FILE__)."/classes/service.php");

class IRCModel {

	public static function exsitCallerID($ani)
	{
		$sql="SELECT * FROM `asterisk`.`serviceprovider` WHERE IsActive = 1 AND IsDeleted = 0 AND SPANI=".$ani;

		$qry=DB_query ($sql,$b);

		if ($result=$qry)
		{
			$numrows=DB_num_rows($result);
			if($numrows)
			{
				$row = DB_fetch_array($result);
				$SP = new serviceprovider();
				$SP->fromArray($row);
				return $SP;
			}
			else
				return false;
		}
		return false;
	}

	public static function exsitSPAccount($SPPIN)
	{

		$sql="SELECT * FROM `asterisk`.`serviceprovider` WHERE IsActive = 1 AND IsDeleted = 0 AND SPPIN=".$SPPIN;

		$qry=DB_query ($sql,$b);
		if ($result=$qry)
		{
			$numrows=DB_num_rows($result);
			if($numrows)
			{
				$row = DB_fetch_array($result);
				$SP = new serviceprovider();
				$SP->fromArray($row);
				return $SP;
			}
			else
				return false;
		}
		return false;
	}

	public static function loadSPServices($SPID)
	{
		$sql="SELECT * FROM `asterisk`.`service` WHERE IsActive = 1 AND IsDeleted = 0 AND SPID=".$SPID;

		$qry=DB_query($sql,$b);

		if($result = $qry)
		{
			while ($row = DB_fetch_array($result))
			{
				$service=new service();
				$service->fromArray($row);
				// print_r($row);
				runIRC::log_agi($service->ServiceID);
				$allServices[$service->ServiceID]=$service;
			}
		}

		return $allServices;
	}
	public static function existPIN($pin)
	{
		$sql="SELECT * FROM pin WHERE PIN='".$pin;

		$qry=DB_query ($sql,$b);

		if ($result=$qry)
		{
			$numrows=DB_num_rows($result);
			if($numrows)
			{
				return true;
			}
			else
				return false;
		}
		return false;
	}

	public static function selectCDR()
	{
		$sql="SELECT * FROM `asterisk`.`cdr`";

		runIRC::log_agi($sql);
		$qry=DB_query($sql,$b);
		runIRC::log_agi("after query");
		if($result = $qry)
		{
			while ($row = DB_fetch_array($result))
			{
				$cdr=new cdr();
				$cdr->fromArray($row);
				$allCDR[$cdr->cdrID]=$cdr ;
			}
		}

		return $allCDR;
	}

	public static function getGovernorate()
	{
		$sql = "SELECT * FROM `asterisk`.`governorate` WHERE IsActive = 1 AND IsDeleted = 0";

		$qry = DB_query($sql, $b);

		if($result = $qry)
		{
			while($row = DB_fetch_array($result))
			{
				$governorate = new governorate();
				$governorate->fromArray($row);
				$allGovernorates[$governorate->GovID] = $governorate;
			}
		}

		return $allGovernorates;
	}

	public static function getDistrict($GovID)
	{
		if(empty($GovID))
			return false;
		if(!empty($GovID) && !is_numeric($GovID))
			return false;

		$sql = "SELECT * FROM `asterisk`.`district` WHERE GovID = {$GovID} AND IsActive = 1 AND IsDeleted = 0";

		$qry = DB_query($sql, $b);

		if($result = $qry)
		{
			while($row = DB_fetch_array($result))
			{
				$district = new district();
				$district->fromArray($row);
				$allDistricts[$district->DistID] = $district;
			}
		}

		return $allDistricts;
	}
}
?>
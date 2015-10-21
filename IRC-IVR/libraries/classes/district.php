<?php
class district{

	public $DistID;
	public $GovID;
	public $DistName;
	public $DistNameEn;
	public $DistNameFr;
	public $DistNamePath;
	public $IsActive = 1;
	public $IsDeleted = 0;
	public $DateCreated;

	public function __construct($id=null)
	{
		if(!empty($id) && is_numeric($id))
		{
			$sql = "SELECT * FROM `district` WHERE  DistID={$id}";
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
		if((!empty($this->DistID)) and (!is_numeric($this->DistID)))
		{
			return false;
		}
		if((!empty($this->GovID)) and (!is_numeric($this->GovID)))
		{
			return false;
		}
		$sql="INSERT INTO `district` 
			(".((!empty($this->DistID))?'`DistID`,':'').
				((!empty($this->GovID))?'`GovID`,':'').
				((!empty($this->DistName))?'`DistName`,':'').
				((!empty($this->DistNameEn))?'`DistNameEn`,':'').
				((!empty($this->DistNameFr))?'`DistNameFr`,':'').
				((!empty($this->DistNamePath))?'`DistNamePath`,':'').
				((!empty($this->IsActive))?'`IsActive`,':'').
				((!empty($this->IsDeleted))?'`IsDeleted`,':'').
				((!empty($this->DateCreated))?'`DateCreated`,':'').
				") VALUES (". ((!empty($this->DistID))?$this->DistID.',':'').
				((!empty($this->GovID))?$this->GovID.',':'').
				((!empty($this->DistName))?'"'.$this->DistName.'"'.',':'').
				((!empty($this->DistNameEn))?'"'.$this->DistNameEn.'"'.',':'').
				((!empty($this->DistNameFr))?'"'.$this->DistNameFr.'"'.',':'').
				((!empty($this->DistNamePath))?'"'.$this->DistNamePath.'"'.',':'').
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
		if(empty($this->DistID))
		{
			return false;
		}
		if((!empty($this->DistID)) and (!is_numeric($this->DistID)))
		{
			return false;
		}
		if((!empty($this->GovID)) and (!is_numeric($this->GovID)))
		{
			return false;
		}
		$sql="UPDATE `district` SET ".
			((!empty($this->DistID))?'`DistID`=':'').((!empty($this->DistID))?$this->DistID.',':'').
			((!empty($this->GovID))?'`GovID`=':'').((!empty($this->GovID))?$this->GovID.',':'').
			((!empty($this->DistName))?'`DistName`=':'').((!empty($this->DistName))?'"'.$this->DistName.'"'.',':'').
			((!empty($this->DistNameEn))?'`DistNameEn`=':'').((!empty($this->DistNameEn))?'"'.$this->DistNameEn.'"'.',':'').
			((!empty($this->DistNameFr))?'`DistNameFr`=':'').((!empty($this->DistNameFr))?'"'.$this->DistNameFr.'"'.',':'').
			((!empty($this->DistNamePath))?'`DistNamePath`=':'').((!empty($this->DistNamePath))?'"'.$this->DistNamePath.'"'.',':'').
			((!empty($this->IsActive))?'`IsActive`=':'').((!empty($this->IsActive))?'"'.$this->IsActive.'"'.',':'').
			((!empty($this->IsDeleted))?'`IsDeleted`=':'').((!empty($this->IsDeleted))?'"'.$this->IsDeleted.'"'.',':'').
			((!empty($this->DateCreated))?'`DateCreated`=':'').((!empty($this->DateCreated))?'"'.$this->DateCreated.'"'.',':'').
			" WHERE DistID=".$this->DistID; 
		$sql=str_replace(', WHERE',' WHERE',$sql);
		if($qry=DB_query ($sql,$b))
		{
			return True;
		}
		return false;
	}

	public function activate()
	{
		if(empty($this->DistID))
		{
			return false;
		}
		if((!empty($this->DistID)) and (!is_numeric($this->DistID)))
		{
			return false;
		}
		$sql="UPDATE `district` SET IsActive=1 where DistID=".$this->DistID ; 
		if($qry=DB_query ($sql,$b))
		{
			return True;
		}
		return false;
	}

	public function deactivate()
	{
		if(empty($this->DistID))
		{
			return false;
		}
		if((!empty($this->DistID)) and (!is_numeric($this->DistID)))
		{
			return false;
		}
		$sql="UPDATE `district` SET IsActive=0 where DistID=".$this->DistID ; 
		if($qry=DB_query ($sql,$b))
		{
			return True;
		}
		return false;
	}

	public function delete()
	{
		if(empty($this->DistID))
		{
			return false;
		}
		if((!empty($this->DistID)) and (!is_numeric($this->DistID)))
		{
			return false;
		}
		$sql="UPDATE `district` SET IsDeleted=1 where DistID=".$this->DistID ; 
		if($qry=DB_query ($sql,$b))
		{
			return True;
		}
		return false;
	}

	public function perDelete()
	{
		if(empty($this->DistID))
		{
			return false;
		}
		if((!empty($this->DistID)) and (!is_numeric($this->DistID)))
		{
			return false;
		}

		$sql="DELETE FROM `district` where DistID=".$this->DistID ; 
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
<?php
class sysdiagram{

	public $SysDiagramID;
	public $Name;
	public $PrincipalID;
	public $Version;
	public $Definition;

	public function __construct($id=null)
	{
		if(!empty($id) && is_numeric($id))
		{
			$sql = "SELECT * FROM `sysdiagram` WHERE  SysDiagramID={$id}";
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
		if((!empty($this->SysDiagramID)) and (!is_numeric($this->SysDiagramID)))
		{
			return false;
		}
		if((!empty($this->PrincipalID)) and (!is_numeric($this->PrincipalID)))
		{
			return false;
		}
		if((!empty($this->Version)) and (!is_numeric($this->Version)))
		{
			return false;
		}
		$sql="INSERT INTO `sysdiagram` 
			(".((!empty($this->SysDiagramID))?'`SysDiagramID`,':'').
				((!empty($this->Name))?'`Name`,':'').
				((!empty($this->PrincipalID))?'`PrincipalID`,':'').
				((!empty($this->Version))?'`Version`,':'').
				((!empty($this->Definition))?'`Definition`,':'').
				") VALUES (". ((!empty($this->SysDiagramID))?$this->SysDiagramID.',':'').
				((!empty($this->Name))?'"'.$this->Name.'"'.',':'').
				((!empty($this->PrincipalID))?$this->PrincipalID.',':'').
				((!empty($this->Version))?$this->Version.',':'').
				((!empty($this->Definition))?'"'.$this->Definition.'"'.',':'').
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
		if(empty($this->SysDiagramID))
		{
			return false;
		}
		if((!empty($this->SysDiagramID)) and (!is_numeric($this->SysDiagramID)))
		{
			return false;
		}
		if((!empty($this->PrincipalID)) and (!is_numeric($this->PrincipalID)))
		{
			return false;
		}
		if((!empty($this->Version)) and (!is_numeric($this->Version)))
		{
			return false;
		}
		$sql="UPDATE `sysdiagram` SET ".
			((!empty($this->SysDiagramID))?'`SysDiagramID`=':'').((!empty($this->SysDiagramID))?$this->SysDiagramID.',':'').
			((!empty($this->Name))?'`Name`=':'').((!empty($this->Name))?'"'.$this->Name.'"'.',':'').
			((!empty($this->PrincipalID))?'`PrincipalID`=':'').((!empty($this->PrincipalID))?$this->PrincipalID.',':'').
			((!empty($this->Version))?'`Version`=':'').((!empty($this->Version))?$this->Version.',':'').
			((!empty($this->Definition))?'`Definition`=':'').((!empty($this->Definition))?'"'.$this->Definition.'"'.',':'').
			" WHERE SysDiagramID=".$this->SysDiagramID; 
		$sql=str_replace(', WHERE',' WHERE',$sql);
		if($qry=DB_query ($sql,$b))
		{
			return True;
		}
		return false;
	}

	public function activate()
	{
		if(empty($this->SysDiagramID))
		{
			return false;
		}
		if((!empty($this->SysDiagramID)) and (!is_numeric($this->SysDiagramID)))
		{
			return false;
		}
		$sql="UPDATE `sysdiagram` SET IsActive=1 where SysDiagramID=".$this->SysDiagramID ; 
		if($qry=DB_query ($sql,$b))
		{
			return True;
		}
		return false;
	}

	public function deactivate()
	{
		if(empty($this->SysDiagramID))
		{
			return false;
		}
		if((!empty($this->SysDiagramID)) and (!is_numeric($this->SysDiagramID)))
		{
			return false;
		}
		$sql="UPDATE `sysdiagram` SET IsActive=0 where SysDiagramID=".$this->SysDiagramID ; 
		if($qry=DB_query ($sql,$b))
		{
			return True;
		}
		return false;
	}

	public function delete()
	{
		if(empty($this->SysDiagramID))
		{
			return false;
		}
		if((!empty($this->SysDiagramID)) and (!is_numeric($this->SysDiagramID)))
		{
			return false;
		}
		$sql="UPDATE `sysdiagram` SET IsDeleted=1 where SysDiagramID=".$this->SysDiagramID ; 
		if($qry=DB_query ($sql,$b))
		{
			return True;
		}
		return false;
	}

	public function perDelete()
	{
		if(empty($this->SysDiagramID))
		{
			return false;
		}
		if((!empty($this->SysDiagramID)) and (!is_numeric($this->SysDiagramID)))
		{
			return false;
		}

		$sql="DELETE FROM `sysdiagram` where SysDiagramID=".$this->SysDiagramID ; 
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
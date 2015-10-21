<?php
class pin{

	public $SPID;
	public $PIN;

	public function __construct($id=null)
	{
		if(!empty($id) && is_numeric($id))
		{
			$sql = "SELECT * FROM `asterisk`.`pin` WHERE  SPID={$id}";
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
		if(empty($this->SPID))
		{
			return false;
		}
		if((!empty($this->SPID)) and (!is_numeric($this->SPID)))
		{
			return false;
		}
		$sql="INSERT INTO `asterisk`.`pin` 
			(".((!empty($this->SPID))?'`SPID`,':'').
				((!empty($this->PIN))?'`PIN`,':'').
				") VALUES (". ((!empty($this->SPID))?$this->SPID.',':'').
				((!empty($this->PIN))?'"'.$this->PIN.'"'.',':'').
				")"; 
		$sql=str_replace(',)',')',$sql);
		if($qry=DB_query ($sql,$b))
		{
			return true;
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
		$sql="UPDATE `asterisk`.`pin` SET ".
			((!empty($this->SPID))?'`SPID`=':'').((!empty($this->SPID))?$this->SPID.',':'').
			((!empty($this->PIN))?'`PIN`=':'').((!empty($this->PIN))?'"'.$this->PIN.'"'.',':'').
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
		$sql="UPDATE `asterisk`.`pin` SET IsActive=1 where SPID=".$this->SPID ; 
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
		$sql="UPDATE `asterisk`.`pin` SET IsActive=0 where SPID=".$this->SPID ; 
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
		$sql="UPDATE `asterisk`.`pin` SET IsDeleted=1 where SPID=".$this->SPID ; 
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

		$sql="DELETE FROM `asterisk`.`pin` where SPID=".$this->SPID ; 
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
<?php
class sms{

	public $id;
	public $GovId;
	public $Text;
	public $IsActive = 1;
	public $IsDeleted = 0;
	public $DateCreated ;

	public function __construct($id=null)
	{
		if(!empty($id) && is_numeric($id))
		{
			$sql = "SELECT * FROM `sms` WHERE  id={$id}";
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
		if((!empty($this->id)) and (!is_numeric($this->id)))
		{
			return false;
		}
		$sql="INSERT INTO `sms` 
			(".((!empty($this->id))?'`id`,':'').
				((!empty($this->Text))?'`Text`,':'').
				((!empty($this->IsActive))?'`IsActive`,':'').
				((!empty($this->IsDeleted))?'`IsDeleted`,':'').
				((!empty($this->DateCreated))?'`DateCreated`,':'').
				") VALUES (". ((!empty($this->id))?$this->id.',':'').
				((!empty($this->GovId))?$this->GovId.',':'').
				((!empty($this->Text))?'"'.$this->Text.'"'.',':'').
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
		if(empty($this->id))
		{
			return false;
		}
		if((!empty($this->id)) and (!is_numeric($this->id)))
		{
			return false;
		}
		$sql="UPDATE `sms` SET ".
			((!empty($this->id))?'`id`=':'').((!empty($this->id))?$this->id.',':'').
			((!empty($this->Text))?'`Text`=':'').((!empty($this->Text))?'"'.$this->Text.'"'.',':'').
			((!empty($this->IsActive))?'`IsActive`=':'').((!empty($this->IsActive))?'"'.$this->IsActive.'"'.',':'').
			((!empty($this->IsDeleted))?'`IsDeleted`=':'').((!empty($this->IsDeleted))?'"'.$this->IsDeleted.'"'.',':'').
			((!empty($this->DateCreated))?'`DateCreated`=':'').((!empty($this->DateCreated))?'"'.$this->DateCreated.'"'.',':'').
			" WHERE id=".$this->id; 
		$sql=str_replace(', WHERE',' WHERE',$sql);
		if($qry=DB_query ($sql,$b))
		{
			return True;
		}
		return false;
	}

	public function activate()
	{
		if(empty($this->id))
		{
			return false;
		}
		if((!empty($this->id)) and (!is_numeric($this->id)))
		{
			return false;
		}
		$sql="UPDATE `sms` SET IsActive=1 where id=".$this->id ; 
		if($qry=DB_query ($sql,$b))
		{
			return True;
		}
		return false;
	}

	public function deactivate()
	{
		if(empty($this->id))
		{
			return false;
		}
		if((!empty($this->id)) and (!is_numeric($this->id)))
		{
			return false;
		}
		$sql="UPDATE `sms` SET IsActive=0 where id=".$this->id ; 
		if($qry=DB_query ($sql,$b))
		{
			return True;
		}
		return false;
	}

	public function delete()
	{
		if(empty($this->id))
		{
			return false;
		}
		if((!empty($this->id)) and (!is_numeric($this->id)))
		{
			return false;
		}
		$sql="UPDATE `sms` SET IsDeleted=1 where id=".$this->id ; 
		if($qry=DB_query ($sql,$b))
		{
			return True;
		}
		return false;
	}

	public function perDelete()
	{
		if(empty($this->id))
		{
			return false;
		}
		if((!empty($this->id)) and (!is_numeric($this->id)))
		{
			return false;
		}

		$sql="DELETE FROM `sms` where id=".$this->id ; 
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
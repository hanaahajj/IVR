<?php
class cdr{

	public $cdrID;
	public $calldate;
	public $clid;
	public $src;
	public $dst;
	public $dcontext;
	public $channel;
	public $dstchannel;
	public $lastapp;
	public $lastdata;
	public $duration;
	public $billsec;
	public $disposition;
	public $amaflags;
	public $accountcode;
	public $uniqueid;
	public $userfield;

	public function __construct($id=null)
	{
		if(!empty($id) && is_numeric($id))
		{
			$sql = "SELECT * FROM `cdr` WHERE  cdrID={$id}";
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
		if((!empty($this->cdrID)) and (!is_numeric($this->cdrID)))
		{
			return false;
		}
		if(empty($this->calldate))
		{
			return false;
		}
		if(empty($this->clid))
		{
			return false;
		}
		if(empty($this->src))
		{
			return false;
		}
		if(empty($this->dst))
		{
			return false;
		}
		if(empty($this->dcontext))
		{
			return false;
		}
		if(empty($this->channel))
		{
			return false;
		}
		if(empty($this->dstchannel))
		{
			return false;
		}
		if(empty($this->lastapp))
		{
			return false;
		}
		if(empty($this->lastdata))
		{
			return false;
		}
		if(empty($this->duration))
		{
			return false;
		}
		if((!empty($this->duration)) and (!is_numeric($this->duration)))
		{
			return false;
		}
		if(empty($this->billsec))
		{
			return false;
		}
		if((!empty($this->billsec)) and (!is_numeric($this->billsec)))
		{
			return false;
		}
		if(empty($this->disposition))
		{
			return false;
		}
		if(empty($this->amaflags))
		{
			return false;
		}
		if((!empty($this->amaflags)) and (!is_numeric($this->amaflags)))
		{
			return false;
		}
		if(empty($this->accountcode))
		{
			return false;
		}
		if(empty($this->uniqueid))
		{
			return false;
		}
		if(empty($this->userfield))
		{
			return false;
		}
		$sql="INSERT INTO `cdr` 
			(".((!empty($this->cdrID))?'`cdrID`,':'').
				((!empty($this->calldate))?'`calldate`,':'').
				((!empty($this->clid))?'`clid`,':'').
				((!empty($this->src))?'`src`,':'').
				((!empty($this->dst))?'`dst`,':'').
				((!empty($this->dcontext))?'`dcontext`,':'').
				((!empty($this->channel))?'`channel`,':'').
				((!empty($this->dstchannel))?'`dstchannel`,':'').
				((!empty($this->lastapp))?'`lastapp`,':'').
				((!empty($this->lastdata))?'`lastdata`,':'').
				((!empty($this->duration))?'`duration`,':'').
				((!empty($this->billsec))?'`billsec`,':'').
				((!empty($this->disposition))?'`disposition`,':'').
				((!empty($this->amaflags))?'`amaflags`,':'').
				((!empty($this->accountcode))?'`accountcode`,':'').
				((!empty($this->uniqueid))?'`uniqueid`,':'').
				((!empty($this->userfield))?'`userfield`,':'').
				") VALUES (". ((!empty($this->cdrID))?$this->cdrID.',':'').
				((!empty($this->calldate))?'"'.$this->calldate.'"'.',':'').
				((!empty($this->clid))?'"'.$this->clid.'"'.',':'').
				((!empty($this->src))?'"'.$this->src.'"'.',':'').
				((!empty($this->dst))?'"'.$this->dst.'"'.',':'').
				((!empty($this->dcontext))?'"'.$this->dcontext.'"'.',':'').
				((!empty($this->channel))?'"'.$this->channel.'"'.',':'').
				((!empty($this->dstchannel))?'"'.$this->dstchannel.'"'.',':'').
				((!empty($this->lastapp))?'"'.$this->lastapp.'"'.',':'').
				((!empty($this->lastdata))?'"'.$this->lastdata.'"'.',':'').
				((!empty($this->duration))?$this->duration.',':'').
				((!empty($this->billsec))?$this->billsec.',':'').
				((!empty($this->disposition))?'"'.$this->disposition.'"'.',':'').
				((!empty($this->amaflags))?$this->amaflags.',':'').
				((!empty($this->accountcode))?'"'.$this->accountcode.'"'.',':'').
				((!empty($this->uniqueid))?'"'.$this->uniqueid.'"'.',':'').
				((!empty($this->userfield))?'"'.$this->userfield.'"'.',':'').
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
		if(empty($this->cdrID))
		{
			return false;
		}
		if((!empty($this->cdrID)) and (!is_numeric($this->cdrID)))
		{
			return false;
		}
		if(empty($this->calldate))
		{
			return false;
		}
		if(empty($this->clid))
		{
			return false;
		}
		if(empty($this->src))
		{
			return false;
		}
		if(empty($this->dst))
		{
			return false;
		}
		if(empty($this->dcontext))
		{
			return false;
		}
		if(empty($this->channel))
		{
			return false;
		}
		if(empty($this->dstchannel))
		{
			return false;
		}
		if(empty($this->lastapp))
		{
			return false;
		}
		if(empty($this->lastdata))
		{
			return false;
		}
		if(empty($this->duration))
		{
			return false;
		}
		if((!empty($this->duration)) and (!is_numeric($this->duration)))
		{
			return false;
		}
		if(empty($this->billsec))
		{
			return false;
		}
		if((!empty($this->billsec)) and (!is_numeric($this->billsec)))
		{
			return false;
		}
		if(empty($this->disposition))
		{
			return false;
		}
		if(empty($this->amaflags))
		{
			return false;
		}
		if((!empty($this->amaflags)) and (!is_numeric($this->amaflags)))
		{
			return false;
		}
		if(empty($this->accountcode))
		{
			return false;
		}
		if(empty($this->uniqueid))
		{
			return false;
		}
		if(empty($this->userfield))
		{
			return false;
		}
		$sql="UPDATE `cdr` SET ".
			((!empty($this->cdrID))?'`cdrID`=':'').((!empty($this->cdrID))?$this->cdrID.',':'').
			((!empty($this->calldate))?'`calldate`=':'').((!empty($this->calldate))?'"'.$this->calldate.'"'.',':'').
			((!empty($this->clid))?'`clid`=':'').((!empty($this->clid))?'"'.$this->clid.'"'.',':'').
			((!empty($this->src))?'`src`=':'').((!empty($this->src))?'"'.$this->src.'"'.',':'').
			((!empty($this->dst))?'`dst`=':'').((!empty($this->dst))?'"'.$this->dst.'"'.',':'').
			((!empty($this->dcontext))?'`dcontext`=':'').((!empty($this->dcontext))?'"'.$this->dcontext.'"'.',':'').
			((!empty($this->channel))?'`channel`=':'').((!empty($this->channel))?'"'.$this->channel.'"'.',':'').
			((!empty($this->dstchannel))?'`dstchannel`=':'').((!empty($this->dstchannel))?'"'.$this->dstchannel.'"'.',':'').
			((!empty($this->lastapp))?'`lastapp`=':'').((!empty($this->lastapp))?'"'.$this->lastapp.'"'.',':'').
			((!empty($this->lastdata))?'`lastdata`=':'').((!empty($this->lastdata))?'"'.$this->lastdata.'"'.',':'').
			((!empty($this->duration))?'`duration`=':'').((!empty($this->duration))?$this->duration.',':'').
			((!empty($this->billsec))?'`billsec`=':'').((!empty($this->billsec))?$this->billsec.',':'').
			((!empty($this->disposition))?'`disposition`=':'').((!empty($this->disposition))?'"'.$this->disposition.'"'.',':'').
			((!empty($this->amaflags))?'`amaflags`=':'').((!empty($this->amaflags))?$this->amaflags.',':'').
			((!empty($this->accountcode))?'`accountcode`=':'').((!empty($this->accountcode))?'"'.$this->accountcode.'"'.',':'').
			((!empty($this->uniqueid))?'`uniqueid`=':'').((!empty($this->uniqueid))?'"'.$this->uniqueid.'"'.',':'').
			((!empty($this->userfield))?'`userfield`=':'').((!empty($this->userfield))?'"'.$this->userfield.'"'.',':'').
			" WHERE cdrID=".$this->cdrID; 
		$sql=str_replace(', WHERE',' WHERE',$sql);
		if($qry=DB_query ($sql,$b))
		{
			return True;
		}
		return false;
	}

	public function activate()
	{
		if(empty($this->cdrID))
		{
			return false;
		}
		if((!empty($this->cdrID)) and (!is_numeric($this->cdrID)))
		{
			return false;
		}
		$sql="UPDATE `cdr` SET IsActive=1 where cdrID=".$this->cdrID ; 
		if($qry=DB_query ($sql,$b))
		{
			return True;
		}
		return false;
	}

	public function deactivate()
	{
		if(empty($this->cdrID))
		{
			return false;
		}
		if((!empty($this->cdrID)) and (!is_numeric($this->cdrID)))
		{
			return false;
		}
		$sql="UPDATE `cdr` SET IsActive=0 where cdrID=".$this->cdrID ; 
		if($qry=DB_query ($sql,$b))
		{
			return True;
		}
		return false;
	}

	public function delete()
	{
		if(empty($this->cdrID))
		{
			return false;
		}
		if((!empty($this->cdrID)) and (!is_numeric($this->cdrID)))
		{
			return false;
		}
		$sql="UPDATE `cdr` SET IsDeleted=1 where cdrID=".$this->cdrID ; 
		if($qry=DB_query ($sql,$b))
		{
			return True;
		}
		return false;
	}

	public function perDelete()
	{
		if(empty($this->cdrID))
		{
			return false;
		}
		if((!empty($this->cdrID)) and (!is_numeric($this->cdrID)))
		{
			return false;
		}

		$sql="DELETE FROM `cdr` where cdrID=".$this->cdrID ; 
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
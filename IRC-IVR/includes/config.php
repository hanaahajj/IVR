<?php

ini_set("log_errors", 1);
ini_set("error_log", "/tmp/asteriskphp.log");

define('DB_HOST','localhost');
define('DB_NAME','asterisk');
define('DB_USER','root');
define('DB_PASS','@$terisk');
define('DB_TYPE','mysql');

define('IRCPATH','IRC');
define('SPRECPATH','/tmp/asterisk/records/SP');
define('R_RECPATH','/tmp/asterisk/records/REFUGEES');


function filterdata ($str) {
$str =str_replace("'","\'",$str);
$str =str_replace('"','&quot;',$str);
return $str;

}

/* $Revision: 1.15 $ */

define ('LIKE','LIKE');

$db0 = mysqli_connect( DB_HOST , DB_USER , DB_PASS );

if ( !$db0 ) {
	echo '<BR>' . _('The configuration in the file config.php for the database user name and password do not provide the information required to connect to the database server');
	exit;
}


//DB wrapper functions to change only once for whole application

function DB_query($SQL,
		&$Conn,
		$ErrorMessage='',
		$DebugMessage= '',
		$Transaction=false,
		$TrapErrors=true){


$Conn=mysqli_connect( DB_HOST , DB_USER , DB_PASS );

	global $db0;
	$db0=$Conn;
	$sqldb=mysqli_select_db(  $Conn,DB_NAME);
//echo $SQL;
$result= mysqli_query($Conn,$SQL);


	if ($DebugMessage == '') {
		$DebugMessage = _('The SQL that failed was');
	}
	
	if (DB_error_no($Conn) != 0 AND $TrapErrors==true){
		if ($TrapErrors){
			require_once('includes/header.inc');
		}
		prnMsg($ErrorMessage.'<BR>' . DB_error_msg($Conn),'error', _('Database Error'));
		if ($debug==1){
			prnMsg($DebugMessage. "<BR>$SQL<BR>",'error',_('Database SQL Failure'));
		}
		if ($Transaction){
			$SQL = 'rollback';
			$Result = DB_query($SQL,$Conn);
			if (DB_error_no($Conn) !=0){
				prnMsg(_('Error Rolling Back Transaction'), '', _('Database Rollback Error') );
			}
		}
		if ($TrapErrors){
			include('includes/footer.inc');
			exit;
		}
	}
	return $result;

}


function DB_fetch_row(&$ResultIndex) {

	$RowPointer=mysqli_fetch_row($ResultIndex);
	Return $RowPointer;
}

function DB_fetch_assoc (&$ResultIndex) {

	$RowPointer=mysqli_fetch_assoc($ResultIndex);
	Return $RowPointer;
}

function DB_fetch_array (&$ResultIndex) {

	$RowPointer=mysqli_fetch_array($ResultIndex);
	Return $RowPointer;
}
function DB_fetch_object (&$ResultIndex) {

	$RowPointer=mysqli_fetch_object($ResultIndex);
	Return $RowPointer;
}

function DB_data_seek (&$ResultIndex,$Record) {
	mysqli_data_seek($ResultIndex,$Record);
}

function DB_free_result (&$ResultIndex){
	mysqli_free_result($ResultIndex);
}

function DB_num_rows (&$ResultIndex){
	return mysqli_num_rows($ResultIndex);
}
// Added by MGT
function DB_affected_rows(){


	global $db0;
	$Conn=$db0;
	return mysqli_affected_rows($Conn);
}

function DB_error_no (&$Conn){
	return 'error connceting to the database';
}

function DB_error_msg(&$Conn){
	return 'error connceting to the database';
}

function DB_Last_Insert_ID(){

	global $db0;
	$Conn=$db0;
	return mysqli_insert_id($Conn);
}

function DB_escape_string($String){
	
	global $db0;
	
	return mysqli_real_escape_string($db0,$String);
	// Return STR_REPLACE ("''","'",$String) ;
	// Return STR_REPLACE ("'","\'",$String) ;
}

function DB_escape_string2($String){
	Return STR_REPLACE ("'","`",$String) ;
}

function DB_escape_string3($String){
	Return STR_REPLACE ("''","'",$String) ;
}
function DB_escape_string4($String){

	Return $String;
}
function DB_escape_string5($String){
$String=DB_escape_string($String);
	Return DB_escape_string3 (html_entity_decode(html_entity_decode($String, ENT_QUOTES), ENT_QUOTES));
}

function DB_show_tables(&$Conn){
	$Result = DB_query('SHOW TABLES',$Conn);
	Return $Result;
}

function DB_show_fields($TableName, &$Conn){
	$Result = DB_query("DESCRIBE $TableName",$Conn);
	Return $Result;
}

function INTERVAL( $val, $Inter ){
		global $dbtype;
		return "\n".'INTERVAL ' . $val . ' '. $Inter."\n";
}

function DB_Maintenance($Conn){

	prnMsg(_('The system has just run the regular database administration and optimisation routine.'),'info');
	
	$TablesResult = DB_query('SHOW TABLES',$Conn);
	while ($myrow = DB_fetch_row($TablesResult)){
		$Result = DB_query('OPTIMIZE TABLE ' . $myrow[0],$Conn);
	}
	
	$Result = DB_query('UPDATE glb_config 
				SET confvalue="' . Date('Y-m-d') . '" 
				WHERE confname="DB_Maintenance_LastRun"',
				$Conn);
}


?>
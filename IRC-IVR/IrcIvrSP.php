#!/usr/bin/php
<?php

require(dirname(__FILE__)."/includes/config.php");
require(dirname(__FILE__)."/libraries/IRCModel.php");
require(dirname(__FILE__)."/libraries/runIrcIvrSP.php");

runIRC::log_agi("**************** START CALL ******************");

$agivars = array();
while (!feof(STDIN)) {
		$agivar = trim(fgets(STDIN));
		if ($agivar === '') {
				break;
		}
		else {
				$agivar = explode(':', $agivar);
				$agivars[$agivar[0]] = trim($agivar[1]);
		}
}

$ivr = new runIRC($agivars);
$ivr->runIvr();

runIRC::log_agi("**************** END CALL ******************");

exit;
?>
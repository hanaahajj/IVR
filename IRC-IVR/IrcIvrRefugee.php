#!/usr/bin/php
<?php

require(dirname(__FILE__)."/includes/config.php");
require(dirname(__FILE__)."/libraries/IRCModel.php");
require(dirname(__FILE__)."/libraries/runIrcIvrRefugee.php");


runIRCR::log_agi("**************** START CALL ******************");

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

$ivr = new runIRCR($agivars);
$ivr->runIvr();

runIRCR::log_agi("**************** END CALL ******************");


exit;
?>
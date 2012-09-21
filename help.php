<?php
header ("Content-Type:text/xml");
require_once 'config.php';
$MSISDN=$_GET['MSISDN'];


echo '<vxml version="2.0" application = "Application.vxml">
		<menu id="mainMenu" name="mainMenu">
		<prompt>You can add/remove reminders using this service.
		</prompt>
		<property name="inputmodes" value="dtmf" />
		<choice dtmf="94" next="#action_1">Main Menu</choice>
		<property  next="oc_bHasBookmark" value="1"/>
		<catch event="nomatch">
		<prompt>Invalid Choice.Please Try again</prompt>
		<goto next="#mainMenu"/>
		</catch>
		</menu>
		<form id="action_1" name="mainmenu">
		<block name="oc_ActionUrl">
		<goto next="'.$USSD->http_client.'/MainService.php?MSISDN='.$MSISDN.'"/>
		</block>
		</form>
		</vxml>
		';
?>

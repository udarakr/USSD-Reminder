<?php
header ("Content-Type:text/xml");
require_once 'config.php';
require_once 'db_connect.php';
require_once 'lib.php';

$MSISDN		  = $_GET['MSISDN'];
$id		  = $_GET['id'];
$reminder	  = $_GET['reminder'];

if($_GET['confirm'] == 'no'){
$var='<vxml version="2.0" application = "Application.vxml">
		<menu id="mainMenu" name="mainMenu">
		<property name="oc_bHasBack" value="1"/>
		<prompt>Are you really want to delete reminder '.$reminder.'
		</prompt>
		<property name="inputmodes" value="dtmf" />
		<choice dtmf="1" next="#action_2">Continue</choice>
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
		<form id="action_2" name="confirm">
		<block name="oc_ActionUrl">
		<goto next="'.$USSD->http_client.'/deleteConfirm.php?id='.$id.'&amp;MSISDN='.$MSISDN.'&amp;confirm=yes&amp;reminder='.$reminder.'"/>
		</block>
		</form>
		</vxml>
		';
}else{
mysql_query("DELETE FROM reminder WHERE id='$id'");
$var=displayMsg($MSISDN,$USSD->http_client,'Reminder deleted Successfully');
}

echo $var;

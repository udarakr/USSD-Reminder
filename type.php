<?php
header ("Content-Type:text/xml");
require_once 'config.php';
$MSISDN		  = $_GET['MSISDN'];
$reminder_details = $_GET['details'];

$var='<vxml version="2.0" application = "Application.vxml">
<menu id="reminderTypeMenu" name="reminderTypeMenu">
<prompt>Select reminder type
</prompt>
<property name="inputmodes" value="dtmf" />
<choice dtmf="1" next="#action_1">Annual Reminder</choice>
<choice dtmf="2" next="#action_2">Monthly Reminder</choice>
<choice dtmf="3" next="#action_3">Daily Reminder</choice>
<choice dtmf="4" next="#action_4">Onetime Reminder</choice>
<choice dtmf="94" next="#action_5">Main Menu</choice>
<property  next="oc_bHasBookmark" value="1"/>
<catch event="nomatch">
<prompt>Invalid Choice.Please Try again</prompt>
<goto next="#reminderMenu"/>
</catch>
</menu>

<form id="action_1" name="new_1">
<field name="date">
<prompt>Enter Month and Date in format MM/DD</prompt>
</field>
<filled>
<assign name="Rdate" expr="date"/>
<goto next="#action_11"/>
</filled>
<catch event="nomatch">
<prompt>Sorry,Please enter the Date in correct format</prompt>
<goto next="#action_1"/>
</catch>
</form>

<form id="action_2" name="new_2">
<field name="date">
<prompt>Enter the Date in format DD</prompt>
</field>
<filled>
<assign name="Rdate" expr="date"/>
<goto next="#action_22"/>
</filled>
<catch event="nomatch">
<prompt>Sorry,Please enter the Date in correct format</prompt>
<goto next="#action_2"/>
</catch>
</form>

<form id="action_3" name="new_3">
<field name="date">
<prompt>Enter the time in 24 hour format HH.MM</prompt>
</field>
<filled>
<assign name="Rdate" expr="date"/>
<goto next="#action_33"/>
</filled>
<catch event="nomatch">
<prompt>Sorry,Please enter the Time in correct format</prompt>
<goto next="#action_3"/>
</catch>
</form>

<form id="action_4" name="new_4">
<field name="date">
<prompt>Enter the Date in format YYYY/MM/DD</prompt>
</field>
<filled>
<assign name="Rdate" expr="date"/>
<goto next="#action_44"/>
</filled>
<catch event="nomatch">
<prompt>Sorry,Please enter the Date in correct format</prompt>
<goto next="#action_4"/>
</catch>
</form>



<form id="action_5" name="main">
<block name="oc_ActionUrl">
<goto next="'.$USSD->http_client.'/MainService.php?MSISDN='.$MSISDN.'"/>
</block>
</form>

<form id="action_11" name="date">
<block name="oc_ActionUrl">
<goto next="'.$USSD->http_client.'/addDate.php?MSISDN='.$MSISDN.'&amp;type=1&amp;details='.$reminder_details.'&amp;date=%Rdate%"/>
</block>
</form>

<form id="action_33" name="time">
<block name="oc_ActionUrl">
<goto next="'.$USSD->http_client.'/addDate.php?MSISDN='.$MSISDN.'&amp;type=3&amp;details='.$reminder_details.'&amp;time=%Rdate%"/>
</block>
</form>

<form id="action_22" name="date">
<block name="oc_ActionUrl">
<goto next="'.$USSD->http_client.'/addDate.php?MSISDN='.$MSISDN.'&amp;type=2&amp;details='.$reminder_details.'&amp;date=%Rdate%"/>
</block>
</form>

<form id="action_44" name="date">
<block name="oc_ActionUrl">
<goto next="'.$USSD->http_client.'/addDate.php?MSISDN='.$MSISDN.'&amp;type=4&amp;details='.$reminder_details.'&amp;date=%Rdate%"/>
</block>
</form>
</vxml>
';

echo $var;

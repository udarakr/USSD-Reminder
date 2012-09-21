<?php
header ("Content-Type:text/xml");
require_once 'config.php';
$MSISDN=$_REQUEST['MSISDN'];

$var='<vxml version="2.0" application = "Application.vxml">
<menu id="reminderMenu" name="reminderMenu">
<prompt>Welcome to My Reminder
</prompt>
<property name="inputmodes" value="dtmf" />
<choice dtmf="1" next="#action_1">New Reminder</choice>
<choice dtmf="2" next="#action_2">Delete Reminder</choice>
<choice dtmf="3" next="#action_3">Help</choice>
<property  next="oc_bHasBookmark" value="1"/>
<catch event="nomatch">
<prompt>Invalid Choice.Please Try again</prompt>
<goto next="#reminderMenu"/>
</catch>
</menu>
<form id="action_1" name="new">
<field name="details">
<prompt>Enter Reminder Details</prompt>
</field>
<filled>
<assign name="Rdetails" expr="details"/>
<goto next="#action_4"/>
</filled>
<catch event="nomatch">
<prompt>Sorry,Please enter Reminder details</prompt>
<goto next="#action_1"/>
</catch>
</form>
<form id="action_2" name="delete">
<block name="oc_ActionUrl">
<goto next="'.$USSD->http_client.'/deleteReminder.php?MSISDN='.$MSISDN.'"/>
</block>
</form>
<form id="action_3" name="help">
<block name="oc_ActionUrl">
<goto next="'.$USSD->http_client.'/help.php?MSISDN='.$MSISDN.'"/>
</block>
</form>
<form id="action_4" name="next_d">
<block name="oc_ActionUrl">
<goto next="'.$USSD->http_client.'/type.php?MSISDN='.$MSISDN.'&amp;details=%Rdetails%"/>
</block>
</form>
</vxml>
';

echo $var;

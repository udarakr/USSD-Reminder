<?php
require_once 'db_connect.php';

function add_record($MSISDN,$reminder_details,$type,$date_str){

$currtime	= time();

$add_rec	= mysql_query("INSERT INTO reminder (phone_number, reminder, type, reminder_date, curr_timestamp, count) VALUES ('$MSISDN', '$reminder_details', '$type', '$date_str', '$currtime', 0)") or die('Could not insert data: ' . mysql_error());

if($add_rec)
{
return true;
	}else{
	return false;
	}
}

function displayMsg($MSISDN,$USSD,$lang){
$var='<vxml version="2.0" application = "Application.vxml">
		<menu id="mainMenu" name="mainMenu">
		<prompt>'.$lang.'
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
		<goto next="'.$USSD.'/MainService.php?MSISDN='.$MSISDN.'"/>
		</block>
		</form>
		</vxml>
		';
return $var;
}

function displayMyReminders($MSISDN,$USSD){


$myreminders = get_my_reminders($MSISDN);  
$i=1;
$itemspermenu=4;
$size=count($myreminders);
if($size>0){

$array=array_chunk($myreminders,$itemspermenu);
$var= "<?xml version=\"1.0\"?>\n";
$var.='<vxml version="2.0" application = "lms.vxml">';
$i=1;
for($k=0;$k<count($array);$k++){
$form='';

$var.='<menu id="catMenu'.$k.'" name="catMenu'.$k.'">
<property name="inputmodes" value="dtmf" />';

foreach($array[$k] as $value){
$select_reminder=mysql_query("SELECT * FROM reminder WHERE id='$value'");
while($row = mysql_fetch_array( $select_reminder )) {
$reminder=$row['reminder'];
$id=$value;
			$var.='<choice value="'.$id.'" dtmf="'.$i.'" next="#action_unsubscibe'.$i.'">'.$reminder.'</choice>';
			$form.='<form id="action_unsubscibe'.$i.'" name="myCourses'.$i.'">
			<block name="oc_ActionUrl">
			<goto next="'.$USSD.'/deleteConfirm.php?id='.$id.'&amp;MSISDN='.$MSISDN.'&amp;confirm=no&amp;reminder='.$reminder.'"/>
			</block>
			</form>';
$i++;
}
}
$j=$k+1;
$s=$k-1;
if($s>=0){
$var.='<choice value="91" dtmf="91" next="#catMenu'.$s.'">Back</choice>';
}else{
$var.='<choice value="91" dtmf="91" next="#main">Back</choice>';
$form.='<form id="main" name="main">
			<block name="oc_ActionUrl">
			<goto next="'.$USSD.'/MainService.php?MSISDN='.$MSISDN.'"/>
			</block>
			</form>';
}
if($j!=count($array)){
$var.='<choice value="92" dtmf="92" next="#catMenu'.$j.'">Next</choice>';
}
$var.='<property  next="oc_bHasBookmark" value="1"/>
<catch event="nomatch">
<prompt>Invalid Choice.Please Try again</prompt>
<goto next="#catMenu'.$k.'"/>
</catch>
</menu>';
$var.=$form;

}
$var.='</vxml>';

}else{
$var=displayMsg($MSISDN,$USSD,'You dont have any reminders');

}


return $var;
}

function get_my_reminders($MSISDN){
//$reminder_arry=array();
$select_reminder=mysql_query("SELECT * FROM reminder WHERE phone_number='$MSISDN'");
while($row = mysql_fetch_array($select_reminder)) {
$reminder_arry[]=$row['id'];
}
return $reminder_arry;
}



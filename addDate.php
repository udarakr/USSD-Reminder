<?php
header ("Content-Type:text/xml");
require_once 'config.php';
require_once 'lib.php';

$MSISDN		  = $_GET['MSISDN'];
$reminder_details = $_GET['details'];
$type		  = $_GET['type'];
if($type !=3){
$date		  = $_GET['date'];
}
if($type != 3){

$var='<vxml version="2.0" application = "Application.vxml">
<form id="action_1" name="new_1">
<field name="time">
<prompt>Enter the time in 24 hour format HH.MM</prompt>
</field>
<filled>
<assign name="Rtime" expr="time"/>
<goto next="#action_2"/>
</filled>
<catch event="nomatch">
<prompt>Sorry,Please enter the Time</prompt>
<goto next="#action_1"/>
</catch>
</form>
<form id="action_2" name="date">
<block name="oc_ActionUrl">
<goto next="'.$USSD->http_client.'/addDate.php?MSISDN='.$MSISDN.'&amp;date='.$date.'&amp;org_type='.$type.'&amp;type=3&amp;details='.$reminder_details.'&amp;time=%Rtime%"/>
</block>
</form>
</vxml>
';

}else{

if($_GET['time']){
$time 	   = $_GET['time'];
$time_arry = explode('.',$time);
}
if(isset($_GET['date'])){
$date	   = $_GET['date'];
$date_arry = explode('/',$date);
}
	if(isset($_GET['org_type'])){
		$type=$_GET['org_type'];
			error_log("original type found ".$_GET['org_type']);
		}else{
			$type	= $_GET['type'];
			$month	= '0';
			$date	= '0';
			$year	= '0';
				error_log("original type not found ".$_GET['type']);			
				}



		if($type == 1){
			$month	= $date_arry[0];
			$date	= $date_arry[1];
			$year	= 0;
				}else if($type == 2){
				$month	= '0';
				$date	= $date_arry[0];
				$year	= '0';
					}else if($type == 3){
						$month	= '0';
						$date	= '0';
						$year	= '0';
							}else if($type == 4){

							$month  = $date_arry[1];
                        				$date   = $date_arry[2];
                       					$year   = $date_arry[0];
										}

//$date_str=mktime($time_arry[0],$time_arry[1],0,$month,$date,$year);
$date_str= $date.'/'.$month.'/'.$year.' '.$time_arry[0].':'.$time_arry[1];
//error_log("hour ".$time_arry[0]."min ".$time_arry[1]." date M ".$month." D:".$date." Y:".$year);

error_log('Adding reminder on:'.$date_str);

	if(!add_record($MSISDN,$reminder_details,$type,$date_str)){
	$error='error saving reminder,please try again';
	$var=displayMsg($MSISDN,$USSD->http_client,$error);
	error_log("error adding reminder !",0);
	}

$success='Reminder saved successfully';
$var=displayMsg($MSISDN,$USSD->http_client,$success);
}
echo $var;

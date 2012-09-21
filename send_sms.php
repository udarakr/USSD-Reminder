<?php
//header ("Content-Type:text/xml");
require_once 'config.php';
require_once 'db_connect.php';
//require_once 'lib.php';

$sql	= "SELECT * FROM reminder;";
$result	= mysql_query($sql);

//reminder arrays

$annual_arry	= array();
$month_arry	= array();
$daily_arry	= array();
$once_arry	= array();
$sms_arry	= array();

while($row = mysql_fetch_array($result))
{
	switch ($row['type']) //1=annually,2=monthly,3=daily,4=onetime
		{
		case 1:
		  $annual_arry[]	= $row['id'];
		  break;
		case 2:
		  $month_arry[]		= $row['id'];
		  break;
		case 3:
		  $daily_arry[]		= $row['id'];
		  break;
		case 4:
		  $once_arry[]		= $row['id'];
		  break;
		default:
		   break;
		}
}

/*
calculate date and time for current date/time
*/

$nowdate_arry	= explode(' ',date("d/m/Y H:i:s",time()));

$date_arry		= explode('/',$nowdate_arry[0]);
$time_arry		= explode(':',$nowdate_arry[1]);

$now_hour		= $time_arry[0];
$now_min		= $time_arry[1];

$now_date		= $date_arry[0];
$now_month		= $date_arry[1];
$now_year		= $date_arry[2];

if(!empty($annual_arry)){
	error_log('Items found in annual notifications array',0);
		foreach($annual_arry as $annual_item){
		$sql_annual	= "SELECT * FROM reminder WHERE id='$annual_item';";
		$result_annual	= mysql_query($sql_annual);

		while($row_annual = mysql_fetch_array($result_annual))
			{

			$sms_date	= explode(' ',$row_annual['reminder_date']);

			$sms_date_arry		= explode('/',$sms_date[0]);
			$sms_time_arry		= explode(':',$sms_date[1]);

			$sms_now_hour		= $sms_time_arry[0];
			$sms_now_min		= $sms_time_arry[1];

			$sms_now_date		= $sms_date_arry[0];
			$sms_now_month		= $sms_date_arry[1];
			//$sms_now_year		= $sms_date_arry[2];

				if($now_date == $sms_now_date && $now_month== $sms_now_month && $now_hour == $sms_now_hour && $now_min == $sms_now_min){
				$sms_arry[]	= $annual_item;
				error_log('match found in annual notifications array id: '.$annual_item,0);
				}
			}


	}
}

if(!empty($month_arry)){
	error_log('Items found in monthly notifications array',0);
		foreach($month_arry as $month_item){
		$sql_month	= "SELECT * FROM reminder WHERE id='$month_item';";
		$result_month	= mysql_query($sql_month);

			while($row_month = mysql_fetch_array($result_month))
			{

			$sms_date	= explode(' ',$row_month['reminder_date']);

			$sms_date_arry		= explode('/',$sms_date[0]);
			$sms_time_arry		= explode(':',$sms_date[1]);

			$sms_now_hour		= $sms_time_arry[0];
			$sms_now_min		= $sms_time_arry[1];

			//$sms_now_date		= $sms_date_arry[0];
			$sms_now_month		= $sms_date_arry[1];
			//$sms_now_year		= $sms_date_arry[2];

				if($sms_now_month == $sms_now_month && $now_hour == $sms_now_hour && $now_min == $sms_now_min){
				$sms_arry[]	= $month_item;
				error_log('match found in monthly notifications array id: '.$month_item,0);
				}
			}


	}
}

if(!empty($daily_arry)){
	error_log('Items found in daily notifications array',0);
		foreach($daily_arry as $daily_item){
		$sql_daily	= "SELECT * FROM reminder WHERE id='$daily_item';";
		$result_daily	= mysql_query($sql_daily);

			while($row_daily = mysql_fetch_array($result_daily))
			{

			$sms_date	= explode(' ',$row_daily['reminder_date']);

			$sms_date_arry		= explode('/',$sms_date[0]);
			$sms_time_arry		= explode(':',$sms_date[1]);

			$sms_now_hour		= $sms_time_arry[0];
			$sms_now_min		= $sms_time_arry[1];

			//$sms_now_date		= $sms_date_arry[0];
			//$sms_now_month	= $sms_date_arry[1];
			//$sms_now_year		= $sms_date_arry[2];

				if($now_hour == $sms_now_hour && $now_min == $sms_now_min){
				$sms_arry[]	= $daily_item;
				error_log('match found in daily notifications array id: '.$daily_item,0);
				}
			}


	}
}

if(!empty($once_arry)){
	error_log('Items found in onetime notifications array',0);
	foreach($once_arry as $once_item){
		$sql_once	= "SELECT * FROM reminder WHERE id='$once_item';";
		$result_once	= mysql_query($sql_once);

		while($row_once = mysql_fetch_array($result_once))
			{

			$sms_date	= explode(' ',$row_once['reminder_date']);

			$sms_date_arry		= explode('/',$sms_date[0]);
			$sms_time_arry		= explode(':',$sms_date[1]);

			$sms_now_hour		= $sms_time_arry[0];
			$sms_now_min		= $sms_time_arry[1];

			$sms_now_date		= $sms_date_arry[0];
			$sms_now_month		= $sms_date_arry[1];
			$sms_now_year		= $sms_date_arry[2];

				if($now_date == $sms_now_date && $now_month== $sms_now_month  && $sms_now_year == $sms_now_year && $now_hour == $sms_now_hour && $now_min == $sms_now_min){
				$sms_arry[]	= $once_item;
				error_log('match found in onetime notifications array id: '.$once_item,0);
				}
			}


	}
}

if(!empty($sms_arry)){
error_log('items found in final sms notification array',0);
foreach($sms_arry as $id){
		$sql_sms	= "SELECT * FROM reminder WHERE id='$id';";
		$result_sms	= mysql_query($sql_sms);
			while($row_sms = mysql_fetch_array($result_sms))
			{
			send_sms($row_sms['phone_number'],$row_sms['reminder']);
	if($row_sms['type'] == 4){				
		mysql_query("DELETE FROM reminder WHERE id='$id'");
			}
			}
}
}

function send_sms($mobile_number,$reminder)
{
error_log("Processing SMS to ".$mobile_number." with reminder ".$reminder);
exec('wget -q -O /dev/null "http://SERVER:PORT&to='.$mobile_number.'&text='.$reminder.'"');
}
?>

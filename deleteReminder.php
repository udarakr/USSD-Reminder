<?php
header ("Content-Type:text/xml");
require_once 'config.php';
require_once 'lib.php';

$MSISDN=$_GET['MSISDN'];

$var=displayMyReminders($MSISDN,$USSD->http_client);


echo $var;

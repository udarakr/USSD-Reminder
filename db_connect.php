<?php
$link = mysql_connect($USSD->host, $USSD->db_user, $USSD->db_password);
if (!$link) {
    die('Could not connect: ' . mysql_error());
}
mysql_select_db($USSD->db_name, $link);
?>

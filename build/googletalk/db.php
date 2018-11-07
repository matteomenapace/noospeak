<?php

$db_host = "MySQLA2.webcontrolcenter.com";
$db_username = "matteomenapace";
$db_password = "sferl0";
$db_name = "google";

$db = mysql_connect($db_host, $db_username, $db_password);
if ($db == FALSE) die ("<br>database connection error: " . mysql_error());
mysql_select_db($db_name, $db) or die ("<br>database selection error: " . mysql_error());


?>
<?php
include ('dbInfo.php');

try
{
	$dbc = new PDO("$dbtype:host=$host;dbname=$dbname", $login, $pass);
	
	$dbc->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
	$dbc->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch (Exception $e)
{
	die('Error : ' . $e->getMessage());
}
?>
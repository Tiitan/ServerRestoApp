<?php

include ('dbInfo.php');

if (!defined('SQLCONNECTION_PHP')) 
{
    define('SQLCONNECTION_PHP', '');
	
	function ConnectToDataBase()
	{
		$dbc = null;

		try
		{
			$dbc = new PDO(DB_TYPE . ':host=' . DB_HOST . ';dbname=' . DB_NAME, DB_LOGIN, DB_PASS);
			
			$dbc->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
			$dbc->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}
		catch (Exception $e)
		{
			die('Error : ' . $e->getMessage());
		}
		
		return $dbc;
	}
}
?>
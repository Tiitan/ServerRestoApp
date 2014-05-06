<?php

include ('includes/sqlConnection.php');
include ('includes/utils.php');

$params = GetParameters('name', 'pass', 'address');
if ($params != null && checkParameters($params))
	process($params);

/*
**	Functions
*/

function process($params)
{
	$dbc = ConnectToDataBase();
	
	$pass = md5($params['pass']);
	
	$request = $dbc->prepare("INSERT INTO Restaurant(name, pass, address) VALUES (:name, :pass, :address)");
	$request->execute(array('name' => $params['name'], $params['pass'] => $pass, $params['address'] => $address));
	$request->closeCursor();
	
	echo '{"islog":"true", "text":""}';
}

function checkParameters($params)
{
	//TODO: check parameters
	return true;
}

?>
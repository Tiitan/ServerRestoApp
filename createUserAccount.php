<?php

include ('includes/sqlConnection.php');
include ('includes/utils.php');

$params = GetParameters('name', 'pass', 'phone', 'email');
if ($params != null && checkParameters($params))
	process($params);

/*
**	Functions
*/

function process($params)
{
	$dbc = ConnectToDataBase();
	
	$pass = md5($params['pass']);
	
	$request = $dbc->prepare("INSERT INTO user(name, pass, phone, email) VALUES (:name, :pass, :phone, :email)");
	$request->execute(array('name' => $params[name], 'pass' => $params[pass], 'phone' => $params[phone], 'email' => $params[email]));
	$request->closeCursor();
	
	echo '{"islog":"true", "text":""}';
}

function checkParameters($params)
{
	//TODO: check parameters
	return true;
}

?>
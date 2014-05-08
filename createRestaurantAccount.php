<?php

include ('includes/sqlConnection.php');
include ('includes/utils.php');

$params = GetParameters('name', 'pass');
$params = array_merge($params, GetOptionnalParameters('address', 'phone', 'displayName', 'email'));
if ($params != null && checkParameters($params))
	process($params);

/*
**	Functions
*/

function process($params)
{
	$dbc = ConnectToDataBase();
	
	$params['pass'] = md5($params['pass']);
	
	$request = $dbc->prepare("INSERT INTO Restaurant(loginName, pass, address) VALUES (:name, :pass, :address)");
	$request->execute(array('name' => $params['name'], 
							'pass' => $params['pass'], 
							'address' => isset($_GET[$params['address']]) ? $params['address'] : ''));
							// TODO parameters left
	$request->closeCursor();
	
	echo '{"islog":true, "text":""}';
}

function checkParameters($params)
{
	//TODO: check parameters
	return true;
}

?>
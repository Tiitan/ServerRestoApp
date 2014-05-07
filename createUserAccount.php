<?php

include ('includes/sqlConnection.php');
include ('includes/utils.php');

$params = GetParameters('name', 'pass');
$params = array_merge($params, GetOptionnalParameters('phone', 'email'));
if ($params != null && checkParameters($params))
	process($params);

/*
**	Functions
*/

function process($params)
{
	$dbc = ConnectToDataBase();
	
	$params['pass'] = md5($params['pass']);
	
	$request = $dbc->prepare("INSERT INTO user(name, pass, phone, email) VALUES (:name, :pass, :phone, :email)");
	$request->execute(array('name' => $params['name'], 
							'pass' => $params['pass'], 
							'phone' => isset($_GET[$params['phone']]) ? $params['phone'] : '', 
							'email' => isset($_GET[$params['email']]) ? $params['email'] : ''));
	$request->closeCursor();
	
	echo '{"islog":"true", "text":""}';
}

function checkParameters($params)
{
	//TODO: check parameters
	return true;
}

?>
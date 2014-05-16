<?php

include ('includes/sqlConnection.php');
include ('includes/utils.php');

$params = GetParameters('token');
$params = array_merge($params, GetOptionnalParameters('address', 'phone', 'name', 'description'));
if ($params != null && checkParameters($params))
{
	$dbc = ConnectToDataBase();
	$session = GetSession($params['token'], $dbc);
	if ($session != null && isLoggedAsRestaurant($session))
		process($params, $session, $dbc);
}

/*
**	Functions
*/
	
function process($params, $session, $dbc)
{
	$request = $dbc->prepare("Update Restaurant SET address=:address, tel=:phone, name=:name, description=:description WHERE idRestaurant=:idRestaurant");
	$request->execute(array('idRestaurant' => $session['idUser'], 
										'address' => isset($_GET[$params['address']]) ? $params['address'] : '', 
										'phone' => isset($_GET[$params['phone']]) ? $params['phone'] : '', 
										'name' => isset($_GET[$params['name']]) ? $params['name'] : '', 
										'description' => isset($_GET[$params['description']]) ? $params['description'] : ''));
										//TODO do not erase data
	
	if ($request->rowCount() == 1)
		echo '{"islog":"true", "text":""}';
	else
		echo '{"islog":"false", "text":"Error while updating"}';
		
	$request->closeCursor();
}

function checkParameters($params)
{
	return true;
}



?>
<?php

include ('includes/sqlConnection.php');
include ('includes/utils.php');

$params = GetParameters('token');
$params = array_merge($params, GetOptionnalParameters('address', 'phone', 'name', 'description', 'location'));
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
	$request = $dbc->prepare("UPDATE Restaurant SET address=:address, tel=:phone, name=:name, description=:description, location=:location WHERE idRestaurant=:idRestaurant");
	$request->execute(array('idRestaurant' => $session['idUser'], 
										'address' => $params['address'], 
										'phone' => $params['phone'],
										'name' => $params['name'],
										'location' => $params['location'],
										'description' => $params['description']));
										//TODO do not erase data
	
	if ($request->rowCount() == 1)
		echo '{"islog":true, "text":""}';
	else
		echo '{"islog":false, "text":"Error while updating"}';
		
	$request->closeCursor();
}

function checkParameters($params)
{
	return true;
}



?>
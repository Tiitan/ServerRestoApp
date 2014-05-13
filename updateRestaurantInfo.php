<?php

include ('includes/sqlConnection.php');
include ('includes/utils.php');

$params = GetParameters('token');
$params = array_merge($params, GetOptionnalParameters('address', 'phone', 'name', 'email'));
if ($params != null && checkParameters($params))
{
	$dbc = ConnectToDataBase();
	$session = GetSession($params['token'], $dbc);
	if ($session != null && isLoggedAsRestaurant($session))
		process($params, $session);
}

/*
**	Functions
*/
	
function process($params, $session, $dbc)
{
	//TODO: check that state is confirmed
	
	$request = $dbc->prepare("Update Restaurant SET address=:address, phone=:phone, name=:name, email=:email WHERE idRestaurant=:idRestaurant");
	$request->execute(array('idRestaurant' => $session['idUser'], 
							'address' => isset($_GET[$params['address']]) ? $params['address'] : '', 
							'phone' => isset($_GET[$params['phone']]) ? $params['phone'] : '', 
							'name' => isset($_GET[$params['name']]) ? $params['name'] : '', 
							'email' => isset($_GET[$params['email']]) ? $params['email'] : ''));
							//TODO do not erase data
	$request->closeCursor();
	
	//TODO: check that updated rows number = 1
	
	echo '{"islog":"true", "text":""}';
}

function checkParameters($params)
{
	return true;
}



?>
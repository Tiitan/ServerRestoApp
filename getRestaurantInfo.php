<?php

include ('includes/sqlConnection.php');
include ('includes/utils.php');

$params = GetParameters('token');
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
	
	$request = $dbc->prepare("SELECT * FROM Restaurant WHERE idRestaurant = :idRestaurant");
	$request->execute(array('idRestaurant' => $session['idUser']));

	if ($result = $request->fetch())
	{
			$restaurantInfo = array(
			'loginName' => $result['loginName'],
			'name' => $result['name'],
			'address' => $result['address'],
			'description' => $result['description'],
			'location' => $result['location'],
			'tel' => $result['tel']);
			
			$json = array ('islog' => true, 'restaurantInfo' => $restaurantInfo);
			echo json_encode($json);	
	}
	else
		printError('Unknown restaurant ID');

	$request->closeCursor();
}

function checkParameters($params)
{
	return true;
}



?>
<?php

include ('includes/sqlConnection.php');
include ('includes/utils.php');

$params = GetParameters('name', 'description', 'dateStart', 'dateEnd');
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
	$request = $dbc->prepare("INSERT INTO Coupon(name, description, dateStart, dateEnd, idRestaurant) VALUES (:name, :description, :dateStart, :dateEnd, :idRestaurant)");
	$request->execute(array('name' => $params['name'], 'description' => $params['description'], 'dateStart' => $params['dateStart'], 'dateEnd' => $params['dateEnd'], 'idRestaurant' => $session['idRestaurant']));
	$request->closeCursor();
	
	echo '{"islog":true, "text":""}';
}

function checkParameters($params)
{
	//TODO: check parameters
	return true;
}

?>
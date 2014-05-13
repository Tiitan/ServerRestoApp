<?php

include ('includes/sqlConnection.php');
include ('includes/utils.php');

$params = GetParameters('name', 'type', 'token', 'price');
if ($params != null && checkParameters($params))
{
	$dbc = ConnectToDataBase();
	$session = GetSession(params[token], $dbc);
	if ($session != null && isLoggedAsRestaurant($session))
		process($params, $session, $dbc);
}

/*
**	Functions
*/
	
function process($params, $session, $dbc)
{
	$request = $dbc->prepare("INSERT INTO MEAL(name, type, idRestaurant, price) VALUES (:name, :type, :idRestaurant, :price)");
	$request->execute(array('name' => $params['name'], 'type' => $params['type'], 'idRestaurant' => $session['idUser'], 'price' => $params['price']));
	$request->closeCursor();
	
	echo '{"islog":"true", "text":""}';
}

function checkParameters($params)
{
	//TODO: check parameters
	return true;
}

?>
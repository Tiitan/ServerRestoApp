<?php

include ('includes/sqlConnection.php');
include ('includes/utils.php');

$params = GetParameters('idMeal', 'token');
if ($params != null && checkParameters($params))
{
	$dbc = ConnectToDataBase();
	$session = GetSession(params[token], $dbc);
	if ($session != null && isLoggedAsRestaurant($session))
		process($params, $session);
}

/*
**	Functions
*/
	
function process($params, $session)
{
	$request = $dbc->prepare("DELETE FROM Meal WHERE idMeal=:idMeal AND idRestaurant=:idRestaurant");
	$request->execute(array('idMeal' => $params['idMeal'], 'idRestaurant' => $session['idUser']));
	$request->closeCursor();
	
	echo '{"islog":"true", "text":""}';
}

function checkParameters($params)
{
	//TODO: check parameters
	return true;
}

?>
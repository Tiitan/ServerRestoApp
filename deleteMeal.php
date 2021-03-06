<?php

include ('includes/sqlConnection.php');
include ('includes/utils.php');

$params = GetParameters('idMeal', 'token');
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
	try
	{
		$request = $dbc->prepare("DELETE FROM Meal WHERE idMeal=:idMeal AND idRestaurant=:idRestaurant");
		$request->execute(array('idMeal' => $params['idMeal'], 'idRestaurant' => $session['idUser']));
		$request->closeCursor();
		echo '{"islog":true, "text":""}';
	}
	catch (Exception $e)
	{
			echo '{"islog":false, "text":"Error, Likely trying to delete a reserved meal"}';
	}
}

function checkParameters($params)
{
	//TODO: check parameters
	return true;
}

?>
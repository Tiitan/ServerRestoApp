<?php

include ('includes/sqlConnection.php');
include ('includes/utils.php');

$params = GetParameters('token', 'idMealReservation');
if ($params != null && checkParameters($params))
{
	$dbc = ConnectToDataBase();
	$session = GetSession(params[token], $dbc);
	if ($session != null && checkSession($session))
		process($params, $session, $dbc);
}

function process($params, $session, $dbc)
{
	$request = $dbc->prepare("DELETE FROM MEALRESERVATION WHERE idMealReservation = :idMealReservation");
	$request->execute(array('idMealReservation') => params['idMealReservation']);
	$request->closeCursor();

	echo '{"islog":true, "text":""}';
}


function checkParameters($params)
{
	if (isset($_GET['token']) && isset($_GET['idMealReservation']))
		return true;
	else
		PrintError('Invalid parameters');
	return false;
}

function checkSession($session)
{
	if ($session['type'] == 'user')
		return true;
	else
	{
		PrintError('You are not log as user.');
		return false;
	}
}

?>
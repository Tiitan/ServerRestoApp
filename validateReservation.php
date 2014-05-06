<?php

include ('includes/sqlConnection.php');
include ('includes/utils.php');

$params = GetParameters('token', 'idReservation');
if ($params != null && checkParameters($params))
{
	$dbc = ConnectToDataBase();
	$session = GetSession(params[token], $dbc);
	if ($session != null && checkSession($session))
		process($params, $session);
}

function process($params, $session)
{
	$request = $dbc->prepare("UPDATE RESERVATION SET state = 'val' WHERE idReservation = :idReservation");
	$request->execute(array('idReservation') => params['idReservation']);
	$request->closeCursor();

	echo '{"islog":"true", "text":""}';
}


function checkParameters($params)
{
	if (isset($_GET['token']) && isset($_GET['idReservation']))
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
<?php

include ('includes/sqlConnection.php');
include ('includes/utils.php');

$params = GetParameters('token', 'idRestaurant', 'personNumber', 'date', 'emails');
if ($params != null && checkParameters($params))
{
	$dbc = ConnectToDataBase();
	$session = GetSession(params[token], $dbc);
	if ($session != null && checkSession($session))
		process($params, $session, $dbc);
}

function process($params, $session, $dbc)
{
	$request = $dbc->prepare("INSERT INTO RESERVATION(idUser, idRestaurant, personNumber, date, emails) VALUES (:idUser, :idRestaurant, :personNumber, :date, :emails)");
	$request->execute(array('idUser') => params['idUser'], array('idRestaurant') => params['idRestaurant'], array('personNumber') => params['personNumber'], array('date') => params['date'], array('emails') => params['emails']);
	$request->closeCursor();

	echo '{"islog":"true", "text":""}';
}


function checkParameters($params)
{
	if (isset($_GET['token']) && isset($_GET['idRestaurant']) && isset($_GET['personNumber']) && isset($_GET['date']) && isset($_GET['emails']))
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
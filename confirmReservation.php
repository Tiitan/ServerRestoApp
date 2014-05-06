<?php

include ('includes/sqlConnection.php');
include ('includes/utils.php');

$params = GetParameters('idReservation', 'token', 'state');
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
	$request = $dbc->prepare("Update Reservation SET state=:state WHERE idReservation=:idReservation AND idRestaurant=:idRestaurant");
	$request->execute(array('state' => params['state'], 'idReservation' => params['idReservation'], 'idRestaurant' => session['idUser']));
	$request->closeCursor();
	
	//TODO: check that updated rows number = 1
	
	echo '{"islog":"true", "text":""}';
}

function checkParameters($params)
{
	if (state == 'conf' || state == 'rej')
		return true;
	else
		PrintError('Invalid parameters.');
}



?>
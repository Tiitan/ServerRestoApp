<?php

include ('includes/sqlConnection.php');
include ('includes/utils.php');

$params = GetParameters('idReservation', 'token', 'sitNumber');
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
	//TODO: check that state is confirmed or sit
	
	$request = $dbc->prepare("Update Reservation SET state= 'che' WHERE idReservation=:idReservation AND idRestaurant=:idRestaurant");
	$request->execute(array('idReservation' => $params['idReservation'], 'idRestaurant' => $session['idUser'], 'sitNumber' => $params['sitNumber']));
	$request->closeCursor();
	
	//TODO: check that updated rows number = 1
	
	echo '{"islog":true, "text":""}';
}

function checkParameters($params)
{
		return true;
}



?>
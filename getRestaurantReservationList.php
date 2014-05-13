<?php

include ('includes/sqlConnection.php');
include ('includes/utils.php');

$params = GetParameters('dateFrom', 'dateTo', 'state', 'token');
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
	$request = $dbc->prepare("SELECT Reservation.idReservation, Reservation.idRestaurant, Reservation.idUser, Reservation.personNumber, Reservation.date, Reservation.state, Reservation.emails, Reservation.sitNumber, User.name FROM Reservation INNER JOIN User ON User.idUser = Reservation.idUser WHERE Reservation.idRestaurant = :idRestaurant AND Reservation.state = :state AND Reservation.date > CAST(:dateFrom AS time) AND Reservation.date < CAST(:dateTo AS time)");
	$request->execute(array('idRestaurant' => $session['idUser'], 'dateFrom' => $params['dateFrom'], 'dateTo' => $params['dateTo'], 'state' => $params['state']));
	
	$reservationList = array();
	while($result = $request->fetch()) 
	{
		$element = array(
			'idReservation' => $result['idReservation'],
			'idRestaurant' => $result['idRestaurant'],
			'idUser' => $result['idUser'],
			'name' => $result['name'],
			'personNumber' => $result['personNumber'],
			'date' => $result['date'],
			'state' => $result['state'],
			'sitNumber' => $result['sitNumber'],
			'email' => $result['email']);
			
			
		array_push($reservationList, $element);
	}
	$json = array ('islog' => true, 'reservationList' => $reservationList);
	echo json_encode($json);
		
	$request->closeCursor();
}

function checkParameters($params)
{
	//TODO: check parameters
	return true;
}

?>
<?php

include ('includes/sqlConnection.php');
include ('includes/utils.php');

$params = GetParameters('dateFrom', 'dateTo', 'token');
if ($params != null && checkParameters($params))
{
	$dbc = ConnectToDataBase();
	$session = GetSession($params['token'], $dbc);
	if ($session != null && isLoggedAsRestaurant($session))
		process($params, $session);
}

/*
**	Functions
*/
	
function process($params, $session)
{
	$dbc = ConnectToDataBase();
	// $a = array('idRestaurant' => $session['idUser'], 'dateFrom' => $params['dateFrom'], 'dateTo' => $params['dateTo']);
	// echo '<pre>'; print_r($a); echo '</pre>';
	$request = $dbc->prepare("SELECT Reservation.idReservation， Reservation.idRestaurant, Reservation.idUser, Reservation.personNumber, Reservation.date, Reservation.state, Reservation.email,  User.name FROM Reservation INNER JOIN User ON User.idUser = Reservation.idUser WHERE idRestaurant = :idRestaurant AND date > CAST(:dateFrom AS time) AND date < CAST(:dateTo AS time)");
	$request->execute(array('idRestaurant' => $session['idUser'], 'dateFrom' => $params['dateFrom'], 'dateTo' => $params['dateTo']));
	
	$reservationList = array();
	while($result = $request->fetch()) 
	{
		$element = array(
			'idReservation' => $result['Reservation.idReservation'],
			'idRestaurant' => $result['Reservation.idRestaurant'],
			'idUser' => $result['Reservation.idUser'],
			'name' => $result['User.name'],
			'personNumber' => $result['Reservation.personNumber'],
			'date' => $result['Reservation.date'],
			'state' => $result['Reservation.state'],
			'email' => $result['Reservation.email']);
			
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
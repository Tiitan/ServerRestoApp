<?php

include ('includes/sqlConnection.php');
include ('includes/utils.php');

$params = GetParameters('dateFrom', 'dateTo', 'token');
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
	$dbc = ConnectToDataBase();
	
	$request = $dbc->prepare("SELECT * FROM Reservation WHERE idRestaurant = :idRestaurant AND date > CAST(:dateFrom AS time) AND date < CAST(:dateTo AS time)");
	$request->execute(array('idRestaurant' => $session['idUser'], 'dateFrom' => $params['dateFrom'], 'dateTo' => $session['dateTo']));
	
	$reservationList = array();
	while($result = $request->fetch()) 
	{
		$element = array(
			'idReservation' => $result['idReservation'],
			'idRestaurant' => $result['idRestaurant'],
			'idUser' => $result['idUser']),
			'idRestaurant' => $result['idRestaurant'],
			'personNumber' => $result['personNumber'],
			'date' => $result['date'],
			'state' => $result['state'],
			'email' => $result['email'],
			'orderedMealList' => array());	//TODO: fetch meal list
			
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
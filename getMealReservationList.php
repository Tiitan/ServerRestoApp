<?php

include ('includes/sqlConnection.php');
include ('includes/utils.php');

$params = GetParameters('idReservation', 'token');
if ($params != null && checkParameters($params))
{
	$dbc = ConnectToDataBase();
	$session = GetSession($params[token], $dbc);
	if ($session != null && isLoggedAsRestaurant($session))
		process($params, $session, $dbc);
}

/*
**	Functions
*/
	
function process($params, $session, $dbc)
{
	$request = $dbc->prepare("SELECT MealReservation.idMealReservation, MealReservation.number, Meal.name, Meal.type, Meal.price FROM Meal INNER JOIN MealReservation ON Meal.idMeal = MealReservation.idMeal INNER JOIN Reservation ON MealReservation.idReservation = Reservation.idReservation WHERE Reservation.idReservation = :idReservation");
	$request->execute(array('idReservation' => $session['idReservation']));
	
	$reservationList = array();
	while($result = $request->fetch()) 
	{
		$element = array(
			'idMealReservation' => $result['idMealReservation'],
			'name' => $result['name'],
			'type' => $result['type'],
			'number' => $result['number'],
			'price' => $result['price']);
			
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
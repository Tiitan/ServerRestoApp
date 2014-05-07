<?php

include ('includes/sqlConnection.php');
include ('includes/utils.php');

$params = GetParameters('idReservation', 'token');
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
	
	$request = $dbc->prepare("SELECT MealReservation.idMealReservation, MealReservation.number, Meal.name, Meal.type FROM Meal INNER JOIN MealReservation ON Meal.idMeal = MealReservation.idMeal INNER JOIN Reservation ON MealReservation.idReservation = Reservation.idReservation WHERE Reservation.idReservation = :idReservation");
	$request->execute(array('idReservation' => $session['idReservation']));
	
	$reservationList = array();
	while($result = $request->fetch()) 
	{
		$element = array(
			'idMealReservation' => $result['MealReservation.idMealReservation'],
			'name' => $result['Meal.name'],
			'type' => $result['Meal.type'],
			'number' => $result['MealReservation.number']);
			
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
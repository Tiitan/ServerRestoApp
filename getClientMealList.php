<?php

include ('includes/sqlConnection.php');
include ('includes/utils.php');

$params = GetParameters('token', 'idUser');
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
	$request = $dbc->prepare("SELECT m.name, m.idMeal, m.description, mr.number FROM meal AS m INNER JOIN mealReservation AS mr ON mr.idMeal = m.idMeal INNER JOIN Reservation AS r ON r.idReservation = mr.idReservation WHERE r.idUser = :idUser");
	$request->execute(array('idUser' => $params['idUser']));

	$clientMealList = array();
	while($result = $request->fetch()) 
	{
		$element = array(
			'name' => $result['name'],
			'idMeal' => $result['idMeal'],
			'description' => $result['description'],
			'number' => $result['number']);
		
		array_push($clientMealList, $element);
	}
	$json = array ('islog' => true, 'clientMealList' => $clientMealList);
	echo json_encode($json);
		
	$request->closeCursor();
}

function checkParameters($params)
{
	return true;
}



?>
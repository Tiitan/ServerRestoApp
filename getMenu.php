<?php

include ('includes/sqlConnection.php');
include ('includes/utils.php');

$params = GetParameters('idRestaurant');
if ($params != null && checkParameters($params))
	process($params);

/*
**	Functions
*/
	
function process($params)
{
	$dbc = ConnectToDataBase();
	
	$request = $dbc->prepare("SELECT * FROM Meal WHERE idRestaurant = :idRestaurant");
	$request->execute(array('idRestaurant' => $idRestaurant));
	
	$mealList = array();
	while($result = $request->fetch()) 
	{
		$element = array(
			'idMeal' => $result['idMeal'],
			'name' => $result['name'],
			'type' => $result['type']);
		
		array_push($mealList, $element);
	}
	$json = array ('islog' => true, 'mealList' => $mealList);
	echo json_encode($json);
		
	$request->closeCursor();
}
	
function checkParameters($params)
{
	//TODO: check parameters
	return true;
}

?>
<?php

include ('includes/sqlConnection.php');
include ('includes/utils.php');

$params = GetOptionnalParameters('idRestaurant', 'token');
$idRestaurant = null;

$dbc = ConnectToDataBase();
if (isset $params['idRestaurant'])
	$idRestaurant = $params['idRestaurant'];
else if (isset $params['token'])
{
	$session = GetSession(params['token'], $dbc);
	$idRestaurant = $session['idUser'];
}
else
	printError('Missing parameters.');
	
if ($idRestaurant != null && checkParameters($idRestaurant))
	process($idRestaurant, $dbc);

/*
**	Functions
*/
	
function process($idRestaurant, $dbc)
{	
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
	
function checkParameters($idRestaurant)
{
	//TODO: check parameters
	return true;
}

?>
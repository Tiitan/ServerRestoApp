<?php

include ('includes/sqlConnection.php');
include ('includes/utils.php');

$params = GetOptionnalParameters('idRestaurant', 'token');
$idRestaurant = null;

$dbc = ConnectToDataBase();
if (isset ($params['idRestaurant']))
	$idRestaurant = $params['idRestaurant'];
else if (isset ($params['token']))
{
	$session = GetSession($params['token'], $dbc);
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
	$request = $dbc->prepare("SELECT * FROM Coupon WHERE idRestaurant = :idRestaurant");
	$request->execute(array('idRestaurant' => $idRestaurant));
	
	$couponList = array();
	while($result = $request->fetch()) 
	{
		$element = array(
			'idCoupon' => $result['idCoupon'],
			'name' => $result['name'],
			'description' => $result['description'],
			'dateStart' => $result['dateStart'],
			'dateEnd' => $result['dateEnd']);
		
		array_push($couponList, $element);
	}
	$json = array ('islog' => true, 'couponList' => $couponList);
	echo json_encode($json);
		
	$request->closeCursor();
}
	
function checkParameters($idRestaurant)
{
	//TODO: check parameters
	return true;
}

?>
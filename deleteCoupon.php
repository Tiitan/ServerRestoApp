<?php

include ('includes/sqlConnection.php');
include ('includes/utils.php');

$params = GetParameters('idCoupon', 'token');
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
	try
	{
		$request = $dbc->prepare("DELETE FROM Coupon WHERE idCoupon=:idCoupon AND idRestaurant=:idRestaurant");
		$request->execute(array('idCoupon' => $params['idCoupon'], 'idRestaurant' => $session['idUser']));
		$request->closeCursor();
		echo '{"islog":true, "text":""}';
	}
	catch (Exception $e)
	{
			echo '{"islog":false, "text":"Error, while deleting a coupon"}';
	}
}

function checkParameters($params)
{
	//TODO: check parameters
	return true;
}

?>
<?php

include ('includes/sqlConnection.php');
include ('includes/utils.php');

$params = GetParameters('token');
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
	$request = $dbc->prepare("SELECT user.idUser, user.name, count(user.idUser) AS number FROM user INNER JOIN reservation ON user.idUSer = reservation.idUSer WHERE reservation.idRestaurant = :idRestaurant GROUP BY user.idUSer");
	$request->execute(array('idRestaurant' => $session['idUser']));

	$clientList = array();
	while($result = $request->fetch()) 
	{
		$element = array(
			'name' => $result['name'],
			'idUser' => $result['idUser'],
			'number' => $result['number']);
		
		array_push($clientList, $element);
	}
	$json = array ('islog' => true, 'clientList' => $clientList);
	echo json_encode($json);
		
	$request->closeCursor();
}

function checkParameters($params)
{
	return true;
}



?>
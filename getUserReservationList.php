<?php

include ('includes/sqlConnection.php');
include ('includes/utils.php');

$params = GetParameters('token');
if ($params != null && checkParameters($params))
{
	$dbc = ConnectToDataBase();
	$session = GetSession(params[token], $dbc);
	if ($session != null && checkSession($session))
		process($params, $session);
}

function process($params, $session)
{
	$request = $dbc->prepare("SELECT * FROM Reservation WHERE idUser == :idUser");
	$request->execute(array('idUser') => session['idUser']);

	$userReservationList = array();
	while($result = $request->fetch()) 
	{
		$element = array(
			'idReservation' => $result['idMeal'],
			'idRestaurant' => $result['name'],
			'personNumber' => $result['type'],
			'date' => $result['type'],
			'state' => $result['type'],
			'personNumber' => $result['type']);
		
		array_push($userReservationList, $element);
	}
	$json = array ('islog' => true, 'userReservationList' => $userReservationList);
	echo json_encode($json);

	$request->closeCursor();

	echo '{"islog":"true", "text":""}';
}


function checkParameters($params)
{
	if (isset($_GET['token']))
		return true;
	else
		PrintError('Invalid parameters');
	return false;
}

function checkSession($session)
{
	if ($session['type'] == 'user')
		return true;
	else
	{
		PrintError('You are not log as user.');
		return false;
	}
}

?>
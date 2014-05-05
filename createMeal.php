<?php

include ('includes/sqlConnection.php');
include ('includes/utils.php');

$params = GetParameters('name', 'type', 'tokken');
if ($params != null && checkParameters($params))
{
	$dbc = ConnectToDataBase();
	$session = GetSession(params[tokken], $dbc);
	if ($session != null && checkSession($session))
		process($params, $session);
}

/*
**	Functions
*/
	
function process($params, $session)
{
	$request = $dbc->prepare("INSERT INTO MEAL(name, type, idRestaurant) VALUES (:name, :type, :idRestaurant)");
	$request->execute(array('name' => params['name'], 'type' => params['type'], 'idRestaurant' => session['idUser']));
	echo '{"islog":"true", "text":""}';
}

function checkParameters($params)
{
	//TODO: check parameters
	return true;
}

function checkSession($session)
{
	if ($session['type'] == 'restaurant')
		return true;
	else
	{
		PrintError('Logged as user.');
		return false;
	}
}

?>
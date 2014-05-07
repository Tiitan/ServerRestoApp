<?php

include ('includes/sqlConnection.php');
include ('includes/utils.php');

$params = GetParameters('token', 'name', 'pass', 'phone', 'email');
if ($params != null && checkParameters($params))
{
	$dbc = ConnectToDataBase();
	$session = GetSession(params[token], $dbc);
	if ($session != null && checkSession($session))
		process($params, $session);
}

function process($params, $session)
{
	$request = $dbc->prepare("UPDATE USER SET name = :name, pass = :pass, phone = :phone, email = :email WHERE idUser = :idUser");
	$request->execute(array('idUser') => session['idUser'], array('name') => params['name'], array('pass') => params['pass'], array('phone') => params['phone'], array('email') => params['email']);
	$request->closeCursor();

	echo '{"islog":"true", "text":""}';
}


function checkParameters($params)
{
	if (isset($_GET['token']) && isset($_GET['name']) && isset($_GET['pass']) && isset($_GET['phone']) && isset($_GET['email']))
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
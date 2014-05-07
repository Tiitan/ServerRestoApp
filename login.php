<?php
include ('includes/sqlConnection.php');
include ('includes/utils.php');

$params = GetParameters('name', 'pass', 'type');
if ($params != null && checkParameters($params))
	process($params);

/*
**	Functions
*/
	
function process($params)
{
	$dbc = ConnectToDataBase();
	
	$params['pass'] = md5($params['pass']);
		
	$request = $dbc->prepare('SELECT * FROM ' . $params['type'] . ' WHERE name = :name AND pass = :pass');
	$request->execute(array('name' => $params['name'], 'pass' => $params['pass']));
	
	$result = $request->fetch();
	if($result) 
	{
		$token = md5(uniqid(mt_rand(), true));
		
		$request = $dbc->prepare('INSERT INTO Session(idUser, token, typeUser) VALUES (:idUser, :token, :typeUser)');
		$request->execute(array('idUser' => $dbc->lastInsertId(), 'token' => $token, 'typeUser' => $params['type']));

		echo '{"islog":"true", "token":"' . $token . '"}';
	}
	else
		echo '{"islog":"false", "text":""}';
	
	$request->closeCursor();
}
	
function checkParameters($params)
{
	if ($params['type'] == 'user' || 
		$params['type'] =='restaurant')
		return true;
	else
	{
		PrintError('Invalid parameters.');
		return false;
	}
}
?>
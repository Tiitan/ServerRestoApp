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
	$request = null;
	$id = null;
	$result = null;

	$params['pass'] = md5($params['pass']);
	
	if ($params['type'] == 'user')
	{
		$request = $dbc->prepare('SELECT * FROM user WHERE name = :name AND pass = :pass');
		$request->execute(array('name' => $params['name'], 'pass' => $params['pass']));
		$result = $request->fetch();
		$id = $result['idUser'];
	}
	else
	{
		$request = $dbc->prepare('SELECT * FROM restaurant WHERE loginName = :loginName AND pass = :pass');
		$request->execute(array('loginName' => $params['name'], 'pass' => $params['pass']));
		$result = $request->fetch();
		$id = $result['idRestaurant'];
	}
	
	if($result) 
	{
		$token = md5(uniqid(mt_rand(), true));
		$request = $dbc->prepare('INSERT INTO Session(idUser, token, typeUser) VALUES (:idUser, :token, :typeUser)');
		$request->execute(array('idUser' => $id, 'token' => $token, 'typeUser' => $params['type']));

		echo '{"islog":true, "token":"' . $token . '"}';
	}
	else
		echo '{"islog":false, "text":""}';
	
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
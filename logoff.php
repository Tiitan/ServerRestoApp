<?php 

include ('includes/sqlConnection.php');
include ('includes/utils.php');

$params = GetParameters('token');
if ($params != null)
{
	$dbc = ConnectToDataBase();
	
	$request = $dbc->prepare('REMOVE FROM SESSION WHERE token = :token');
	$request->execute(array('token' => $params['token']));
	//TODO: Error if 0 row deleted
	$request->closeCursor();
	
	echo '{"islog":true, "text":""}';
}
	
?>
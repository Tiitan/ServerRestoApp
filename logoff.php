<?php 

include ('includes/sqlConnection.php');
include ('includes/utils.php');

$params = GetParameters('tokken');
if ($params != null)
{
	$dbc = ConnectToDataBase();
	
	$request = $dbc->prepare('REMOVE FROM SESSION WHERE tokken = :tokken');
	$request->execute(array('tokken' => $params['tokken']));
	//TODO: Error if 0 row deleted
	$request->closeCursor();
	
	echo '{"islog":true, "text":""}';
}
	
?>
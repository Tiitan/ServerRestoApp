<?php
session_start();

if (isset($_GET['name']) && isset($_GET['pass']))
{
	include ('sqlConnection.php');
	
	$name = htmlspecialchars($_GET['name']);
	$pass = md5($_GET['pass']);
	
	$request = $dbc->prepare("SELECT * FROM user WHERE name = :name AND pass = :pass");
	$request->execute(array('name' => $name, 'pass' => $pass));
	
	$result = $request->fetch();
	if($result) 
	{
		echo '{"islog":"true", "text":""}';
		$_SESSION['userID'] =  $result['idUser'];
	}
	else
		echo '{"islog":"false", "text":""}';
		
	$request->closeCursor();
}
else
	echo '{"islog":"false", "text":"Invalid parameters."}';
?>
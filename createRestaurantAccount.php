<?php
if (isset($_GET['name']) && isset($_GET['pass']) && isset($_GET['address']))
{
	include ('sqlConnection.php');
	
	$name = htmlspecialchars($_GET['name']);
	$pass = md5($_GET['pass']);
	$address = htmlspecialchars($_GET['address']);
	
	$request = $dbc->prepare("INSERT INTO Restaurant(name, pass, address) VALUES (:name, :pass, :address)");
	$request->execute(array('name' => $name, 'pass' => $pass, 'address' => $address));
	
	echo '{"islog":"true", "text":""}';
}
else
	echo '{"islog":"false", "text":"Invalid parameters."}';
?>
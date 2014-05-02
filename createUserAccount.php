<?php
if (isset($_GET['name']) && isset($_GET['pass']) && isset($_GET['phone']) && isset($_GET['email']))
{
	include ('sqlConnection.php');
	
	$name = htmlspecialchars($_GET['name']);
	$pass = md5($_GET['pass']);
	$phone = htmlspecialchars($_GET['phone']);
	$email = htmlspecialchars($_GET['email']);
	
	$request = $dbc->prepare("INSERT INTO user(name, pass, phone, email) VALUES (:name, :pass, :phone, :email)");
	$request->execute(array('name' => $name, 'pass' => $pass, 'phone' => $phone, 'email' => $email));
	
	echo '{"islog":"true", "text":""}';
}
else
	echo '{"islog":"false", "text":"Invalid parameters."}';
?>
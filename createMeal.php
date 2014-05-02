<?php
session_start();

if (isset($_SESSION['idRestaurant']))
{
	if (isset($_GET['name']) && isset($_GET['type']))
	{
		include ('sqlConnection.php');
		
		$name = htmlspecialchars($_GET['name']);
		$type = htmlspecialchars($_GET['type']);
		$idRestaurant = $_SESSION['idRestaurant'];
		
		$request = $dbc->prepare("INSERT INTO MEAL(name, type, idRestaurant) VALUES (:name, :type, :idRestaurant)");
		$request->execute(array('name' => $name, 'type' => $type, 'idRestaurant' => $idRestaurant));
		
		echo '{"islog":"true", "text":""}';
	}
	else
		echo '{"islog":"false", "text":"Invalid parameters."}';
}
else
	echo '{"islog":"false", "text":"Not logged as restaurant."}';
?>
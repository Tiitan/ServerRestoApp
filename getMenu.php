<?php
	session_start();

	if (isset($_GET['idRestaurant']))
	{
		include ('sqlConnection.php');

		$idRestaurant = htmlspecialchars($_GET['idRestaurant']);
		
		$request = $dbc->prepare("SELECT * FROM Meal WHERE idRestaurant = :idRestaurant");
		$request->execute(array('idRestaurant' => $idRestaurant));
		
		$mealList = array();
		while($result = $request->fetch()) 
		{
			$element = array(
				'idMeal' => $result['idMeal'],
				'name' => $result['name'],
				'type' => $result['type']);
			
			array_push($mealList, $element);
		}
		$json = array ('islog' => true, 'mealList' => $mealList);
		echo json_encode($json);
			
		$request->closeCursor();
	}
	else
		echo '{"islog":"false", "text":"Invalid parameters."}';
?>
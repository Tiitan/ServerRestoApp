<?php

include ('includes/sqlConnection.php');
include ('includes/utils.php');

process();

/*
**	Functions
*/
	
function process()
{
	$dbc = ConnectToDataBase();
	
	$request = $dbc->prepare("SELECT * FROM Restaurant");
	$request->execute();
	
	$restoList = array();
	while($result = $request->fetch()) 
	{
		$element = array(
			'idRestaurant' => $result['idRestaurant'],
			'name' => $result['name'],
			'address' => $result['address']);
		
		array_push($restoList, $element);
	}
	$json = array ('islog' => true, 'restolist' => $restoList);
	echo json_encode($json);
		
	$request->closeCursor();
}
	
function checkParameters($params)
{
	//TODO: check parameters
	return true;
}

?>
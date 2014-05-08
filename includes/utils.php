<?php
include ('sqlConnection.php');

if (!defined('UTILS_PHP')) 
{
    define('UTILS_PHP', '');
	
	Function printError($message)
	{
		echo '{"islog":"false", "text":"' . $message . '"}';
	}

	Function GetParameters()
	{
		$numargs = func_num_args();
		$args = func_get_args();
		$headerInfo = apache_request_headers();
		$output = array();
		
		for ($i = 0; $i < $numargs; $i++) 
		{
			if (isset($_GET[$args[$i]]))
				$output[$args[$i]] = htmlspecialchars($_GET[$args[$i]]);
			else if (isset($headerInfo[$args[$i]]))
				$output[$args[$i]] = htmlspecialchars($headerInfo[$args[$i]]);
			else
			{
				PrintError('Missing parameters.');
				return null;
			}		
		}
		
		return $output;
	}
	
	Function GetOptionnalParameters()
	{
		$numargs = func_num_args();
		$args = func_get_args();
		$headerInfo = apache_request_headers();
		$output = array();
		
		for ($i = 0; $i < $numargs; $i++) 
		{
			if (isset($_GET[$args[$i]]))
				$output[$args[$i]] = htmlspecialchars($_GET[$args[$i]]);
			else if (isset($headerInfo[$args[$i]]))
				$output[$args[$i]] = htmlspecialchars($headerInfo[$args[$i]]);	
		}
		
		return $output;
	}

	Function GetSession($token, $dbc)
	{
		$session = array();
		
		$request = $dbc->prepare('SELECT * FROM Session WHERE token = :token');
		$request->execute(array('token' => $token));
		
		$result = $request->fetch();
		if($result) 
		{
			$session['idUser'] = $result['idUser'];
			$session['typeUser'] = $result['typeUser'];
			$session['timeout'] = $result['timeout'];
		}
		else
		{
			$session = null;
			PrintError('Invalid token.');
		}
		
		$request->closeCursor();
		
		//TODO: handle time out
		
		return $session;
	}
	
	function isLoggedAsRestaurant($session)
	{
		if ($session['typeUser'] == 'restaurant')
			return true;
		else
		{
			PrintError("Logged as : " . $session['typeUser'] . ".");
			return false;
		}
	}
	
	function isLoggedAsUser($session)
	{
		if ($session['typeUser'] == 'user')
			return true;
		else
		{
			PrintError('Logged as restaurant.');
			return false;
		}
	}
}

?>
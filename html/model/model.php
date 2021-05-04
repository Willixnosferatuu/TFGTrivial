<?php
	require("connectDB.php");

	function getTest()
	{
		$connection = connectDB();
		$sql ="SELECT * FROM Test";
		$result = $connection->query($sql);
		$tests = array();
		while($row = $result->fetch_assoc())
		{
			$tests[] = $row;
		} 
		return $tests;
	}

	function createGame($maxPlayers)
	{
		$connection = connectDB();
		$code = getRandomString();
		//$maxPlayers="9";
		$sql = "INSERT INTO Game(code,maxPlayers) VALUES ('".$code."', '".$maxPlayers."')";
		if($connection->query($sql)==TRUE)
		{
			return $code;
		}
		else 
		{ 
			return '-1';
		}
	}

	function getRandomString($length = 6) 
	{
	    $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
	    $string = '';
	    for ($i = 0; $i < $length; $i++) {
	        $string .= $characters[mt_rand(0, strlen($characters) - 1)];
	    }
	    return $string;
	}
?>
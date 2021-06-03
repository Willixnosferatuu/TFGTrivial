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
		$difficulty ="medium";
		$status = "active";
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

	//$mysqli->insert_id

	function insertUserGame($idUser, $idGame)
	{
	
		$sql = "INSERT INTO User_Game(idUser,idGame, hasTurn, gamePoints, correctAnswers, turn) VALUES ('".$idUser."', '".$idGame."', 0, 0, 0, 0)";
		if($connection->query($sql)==TRUE)
		{
			return true;
		}
		else 
		{ 
			return false;
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

	function generateRandomNum() 
	{    
	    return rand(1,6);
	}

	function registerUser($username, $password)
	{
		$connection = connectDB();
		$pass = mysqli_real_escape_string($connection,password_hash($password, PASSWORD_DEFAULT));
		$user = mysqli_real_escape_string($connection, $username);

		$sql = "SELECT username FROM User WHERE username='".$user."'";
		$result = mysqli_query($connection, $sql);
		if(mysqli_num_rows($result)>0)
		{
			return FALSE;
		}
		else{
			$sql = "INSERT INTO User(username,totalScore,password) VALUES ('".$user."', 0, '".$pass."')";
			if($connection->query($sql)==TRUE)
			{
				return TRUE;
			}
			else 
			{ 
				return FALSE;
			}
		}
	}

	function loginUser($username, $password)
	{
		$user = mysqli_real_escape_string($connection, $username); 
		$pass = mysqli_real_escape_string($connection, password_hash($password, PASSWORD_DEFAULT));
		$connection = connectDB();
		$sql = "SELECT id, password FROM User WHERE username = '".$user."' AND password = '".$pass."'";
		$result = mysqli_query($connection, $sql);
		$res = $result->fetch_assoc();
		$idPlayer = $res["id"];
		$contra = $res["password"];
		if ($result != FALSE and mysqli_num_rows($result) == 1 and password_verify($pass, $contra))
        {
            return $idPlayer;
        }else
        {
        	return -1;
        }
	}	

	function getUserId($user)
	{
		$con=connectDB();
		$sql = 'SELECT id FROM User WHERE username ="'.$user.'"';
		$result = $con->query($sql);
		$result =$result ->fetch_assoc();
		return $result["id"];
	}

	function antiXSS($data)
	{
		$data = trim($data);
	    $data = stripslashes($data);
	    $data = htmlspecialchars($data);
	    return $data;
	}
?>
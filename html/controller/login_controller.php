<?php

	session_start();

	require("../model/model.php");
	
	if(isset($_POST['submit']))
		{
			$username = $_POST['username'];
			$password = $_POST['password'];
			if(loginUser($mail,$password)==TRUE)
			{
				$_SESSION["User"]=getUserId($username);
                echo "<script type='text/javascript'>alert('WELCOMEE ".$username."!! YOUVE JUST LOGGED IN ;)')</script>";             
				$url = 'http://192.168.1.100'; 
				// redirect
				//header( "Location: $url" );			
            }else
			{
				echo "<script type='text/javascript'>alert('SOMETHING WENT WRONG, TAKE a LOOK at your DATA')</script>";
				}
		}
?>
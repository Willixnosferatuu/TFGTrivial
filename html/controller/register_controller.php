<?php
	require("../model/model.php");

	if(isset($_POST['submit']))
	{
		echo "TEST";
		$username = antiXSS($_POST['username']);
		$password = password_hash(antiXSS($_POST['password']), PASSWORD_DEFAULT);
		echo $username;
		echo $password;

		if(registerUser($username, $password)==TRUE)
		{
			echo "<script type='text/javascript'>alert('YOUVE BEEN REGISTERED!!')</script>";
			$url = 'http://192.168.1.100'; 
			// redirect
			//header( "Location: $url" );	
		}else
		{
			echo "<script type='text/javascript'>alert('ERROR INSERING USER onto DB! Probably username taken')</script>";
		}
	}
	
?>
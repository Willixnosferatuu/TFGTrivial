<?php
	require("../model/model.php");

	if(isset($_POST['submit']))
	{
		$username = antiXSS($_POST['username']);
		$password = $_POST['password'];
		$url = 'http://192.168.1.100';
		if(registerUser($username, $password)==TRUE)
		{
			echo "<script type='text/javascript'>alert('YOUVE BEEN REGISTERED!!');window.location.href = '".$url."';</script>";
			$url = 'http://192.168.1.100'; 
			// redirect
			//header( "Location: $url" );	
		}else
		{
			echo "<script type='text/javascript'>alert('ERROR INSERING USER onto DB! Probably username taken');window.location.href = '".$url."';</script>";
		}
	}
	
?>
<?php
//session_start();
//$_SESSION["cart"][] = $productoo;
	require("../model/model.php");
	$maxPlayers = isset($_POST['mp']) ? $_POST['mp'] : null;
	$code = createGame($maxPlayers);
	//echo "<h1> ".$code." </h1>"
	require("../view/pregunta_view.php");
	/*if (strcmp($code, '-1') !== 0) 
	{
		require("../view/pregunta_view.php");
	}
	else
	{
		echo "<h1> ".$code." </h1>";
	}*/
?>
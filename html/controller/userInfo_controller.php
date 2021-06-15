<?php
	require("model/model.php");
	$idPlayer = $_POST['idPlayer'];
	$username = getUserNameByID($idPlayer);
	$totalScore = getTotalScoreById($idPlayer);
	echo "</br><p>UserName : ".$username. "</p><p>Puntuació : ".$totalScore. "</p>";
	//echo $idPlayer;
?>
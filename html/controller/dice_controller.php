<?php
	require("../model/model.php");
	$randomNum = generateRandomNum();
	echo "<p>Has tret un :</p>
			<p id='numeroDau'>".$randomNum."</p>
			<p>El teu torn es: </p>
			<p id='torn'></p>";
?>
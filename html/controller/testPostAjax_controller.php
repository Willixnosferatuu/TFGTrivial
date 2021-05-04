<?php
	require("../model/model.php");
	$testTextAjax = isset($_POST['test']) ? $_POST['test'] : null;
	echo "<p>TESTAMEN AQUI IRIA UN REQUIRE PERO DE MOMENTO   ME LO PETO. HAS POSTEADO ".$testTextAjax."</p>";
	$testamens = getTest();
	foreach($testamens as $t)
	{
		echo "<div>
				<p>'".$t["id"]."'</p>
				<p>'".$t["nombre"]."'</p>
				<p>'".$t["description"]."'</p>
				<p>'".$t["test"]."'</p>
			</div>";
	}
?>
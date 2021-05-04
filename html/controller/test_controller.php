<?php
	if(isset($_POST['submit']))
	{
		$testText = $_POST['testText'];
		echo "<script type='text/javascript'>alert('WELCOMEE MATE!! YOUVE JUST POSTED".$testText.";)')</script>";
	}
?>
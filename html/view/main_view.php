<!DOCTYPE html>
<html>
	<head>
		<title>Triviiax</title>
		<meta charset="utf-8" />
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
		<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
		<link href="content/img/trivial.ico" type="image/x-icon" rel="icon"/>
		<link rel="stylesheet" href="content/css/sheet.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>  		
		<script src="content/js/script.js"></script>
		<script src="content/js/webSockets.js"></script>
	</head>
	<header class="header">
		<!--<?php $session_value=(isset($_SESSION['User']))?$_SESSION['User']:''; ?>-->
		<h1>Triviia TFG</h1>		
	</header>
	<body onload="init()">
		<div class="main">
			<img src="content/img/unnamed.png"class="mainImage">
			<br/>
			<hr/>
			<br/>
			<div class="buttons" id="mnuLogButtons">
				<button onclick="gotoRegister()" id="btnRegister" class="btn btn-primary">Registrar-se</button>
				<button onclick="gotoLogin()" id="btnLogin" class="btn btn-dark">Login</button>
				<!--<button onclick="Logout()" id="btnLogout" style="visibility: hidden;">Logout</button>-->
			</div>
			<div class="buttons" id="mnuButtons" style="display: none;">
				<!--<button onclick="testPostClick()" class="mainButtons">TEST</button>-->
				<button onclick="joinGameShowForm()" class="btn btn-primary mainButtons">Unir-se</button>
				<button onclick="play()" class="btn btn-primary mainButtons">Jugar</button>
				<button onclick="createGameShowForm()" class="btn btn-primary mainButtons">Crear Partida</button>
				<button onclick="showUserInfo()" class="btn btn-primary mainButtons" value="" id="btnUser"></button>	
				<!--<p>Num. Jugadores: <input type="text" id="maxPlayers" name="maxPlayers"></p>-->		
			</div>
			<br/>
			<div id="content">
				<!--<p>esto deberia cambiar</p>-->
			</div>
		</div>
	</body>
	<footer class="footer">
		<!--<p>Willax on da haus &#169; Made to Play!</p>-->
	</footer>
</html>	

<script type="text/javascript">
	//var userId='<?php echo $session_value;?>';
	//console.log("user = " +userId);
</script>
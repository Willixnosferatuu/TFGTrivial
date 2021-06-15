<!DOCTYPE html>
<html>
	<head>
		<title>TriviaWillax</title>
		<meta charset="utf-8" />
		<link href="content/img/trivial.ico" type="image/x-icon" rel="icon"/>
		<link rel="stylesheet" href="content/css/sheet.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
		<script src="content/js/script.js"></script>
		<script src="content/js/webSockets.js"></script>
	</head>
	<header class="header">
		<!--<?php $session_value=(isset($_SESSION['User']))?$_SESSION['User']:''; ?>-->
		<h1>Triviia willax</h1>		
	</header>
	<body onload="init()">
		<div class="main">
			<img src="content/img/unnamed.png"class="mainImage">
			<br/>
			<hr/>
			<br/>
			<div class="buttons" id="mnuLogButtons">
				<button onclick="gotoRegister()" id="btnRegister" class="">Register</button>
				<button onclick="gotoLogin()" id="btnLogin" class="">Login</button>
				<button onclick="Logout()" id="btnLogout" style="visibility: hidden;">Logout</button>
			</div>
			<div class="buttons" id="mnuButtons" style="display: none;">
				<!--<button onclick="testPostClick()" class="mainButtons">TEST</button>-->
				<button onclick="joinGameShowForm()" class="mainButtons">Unirse</button>
				<button onclick="play()" class="mainButtons">Jugar</button>
				<button onclick="createGameShowForm()" class="mainButtons">Crear Partida</button>
				<button onclick="showUserInfo()" class="mainButtons" value="" id="btnUser"></button>	
				<!--<p>Num. Jugadores: <input type="text" id="maxPlayers" name="maxPlayers"></p>-->		
			</div>
			<div id="content">
				<!--<p>esto deberia cambiar</p>-->
			</div>
		</div>
	</body>
	<footer class="footer">
		<p>Willax on da haus &#169; Made to Play!</p>
	</footer>
</html>	

<script type="text/javascript">
	//var userId='<?php echo $session_value;?>';
	//console.log("user = " +userId);
</script>
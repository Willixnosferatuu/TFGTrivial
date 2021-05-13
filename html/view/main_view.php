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
		<h1>Triviia willax</h1>
	</header>
	<body onload="init()">
		<div class="main">
			<img src="content/img/unnamed.png"class="mainImage">
			<br/>
			<hr/>
			<br/>
			<div class="buttons" id="mnuButtons">
				<!--<button onclick="testPostClick()" class="mainButtons">TEST</button>-->
				<button onclick="joinGame()" class="mainButtons">Unirse</button>
				<button onclick="play()" class="mainButtons">Jugar</button>
				<button onclick="createGame()" class="mainButtons">Crear Partida</button>	
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
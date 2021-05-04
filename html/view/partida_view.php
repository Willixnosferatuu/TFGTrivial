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
			<div id="content">
				<div id="pregunta">
					<p>Qui trequi el número més gran comença</p>
					<button onclick="tirarDau()" class="mainButtons">Llençar dau</button>
				</div>
			</div>
			<div id="jsonResponse">
			</div>
			<br/>
			<div id="començarPartida">
				<button id="btnStart" onclick="" class="">ComençarPartida !</button>
			</div>
			<br/>
			<div>
				<button onclick="test()">Habilitar boto de dalt TEST</button>
			</div>
		</div>
	</body>
	<footer class="footer">
		<p>Willax on da haus &#169; Made to Play!</p>
	</footer>
</html>	
<script type="text/javascript">
	document.getElementById("btnStart").disabled = true;
</script>

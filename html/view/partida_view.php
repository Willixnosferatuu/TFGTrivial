<div>
	<div> 
		<br/>
		<button onclick="tirarDau()" class="mainButtons" id="dauTorns">Llençar dau</button>
	</div>
	<div id="contentPartidaFile">
		<div id="pregunta">
			<p>Qui tregui el número més gran comença</p>
			<!--<button onclick="tirarDau()" class="mainButtons">Llençar dau</button>-->
		</div>
	</div>
	<div id="jsonResponse">
	</div>
	<br/>
	<div id="començarPartida">
		<button id="btnStart" onclick="startPartida()" class="">ComençarPartida !</button>
	</div>
	<br/>
	<!--<div>
		<button onclick="test()">Habilitar boto de dalt TEST</button>
		<button onclick="printarTorn()">printarTorns</button>
	</div>-->
</div>
<script type="text/javascript">
	document.getElementById("btnStart").disabled = true;
</script>
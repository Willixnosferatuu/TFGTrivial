<div>
	<p class="log">Crear partida privada:</p>
	<form class="formulari" autocomplete="on" method="post" id="createGameForm">
		<input type="number" name="maxPlayers" placeholder="maxPlayers" min=2 max=9 required/><br /><br />
		<!--<input type="text" name="difficulty" placeholder="dificultat" required/><br /><br />-->
	 	<label for="diff">Dificultat: </label>
		<select name="diff" id="diff">
		  <option value="easy">Easy</option>
		  <option  value="medium" selected>Medium</option>
		  <option value="hard">Hard</option>
		</select> 
		<br/>
		<br/>
		<input  class="boto" type="submit" name="submit" value="Crear" formaction="javascript:createGame()">
	</form>
</div>
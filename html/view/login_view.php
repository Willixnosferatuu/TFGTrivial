<div id="login" class="formu">
	<p class="log">Log In:</p>
	<form class="formulari" autocomplete="on" method="post" id="loginForm">
		<input type="text" name="username" placeholder="username" maxlength='25' pattern='[A-Za-z\d]{0,25}' required/><br /><br />
		<input type="password" name="password" placeholder="Password" minlength='4' maxlength='20' pattern='[A-Za-z\d]{5,20}' required/><br /><br />
		<!--<input  class="boto" type="submit" name="submit" value="Login" formaction="javascript:loginValidate()">-->
		<input  class="boto" type="submit" name="submit" value="Login" formaction="controller/login_controller.php">
	</form>
</div>
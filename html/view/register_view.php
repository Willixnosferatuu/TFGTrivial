<div id="SignUP">
	<p class="log">Sign Up:</p>
	<form class="formulari" autocomplete="off" method="post" >
		<input type="text" name="username" placeholder="username" maxlength='25' pattern='[A-Za-z\d]{0,25}' required/><br /><br />
		<input type="password" name="password" placeholder="Password" minlength='4' maxlength='20' pattern='[A-Za-z\d]{5,20}' required/><br/><br/>
		<input class="boto" type="submit" name="submit" value="Register" formaction="controller/register_controller.php">
	</form>
</div>
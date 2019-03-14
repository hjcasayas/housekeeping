<?php
/*
Project: Housekeeping
Author: hjcasayas
Github: https://github.com/hjcasayas/housekeeping
*/

include "head.php";

?>
	<div class="wrapper-login">
		<div class="container-login">
			<h1 id="housekeeping"><span id="house">House</span><span id="keeping">keeping Admin</span></h1>

			<?php 
				if(isset($_GET['error'])) {
					echo "<p class='error'>" . $_GET['error'] . "</p>";
				}
			?>

			<form class="login-form" action="loginHandler.php" method="POST">
				<!--<label>Username</label>-->
				<input type="text" id="login-username" class="login-input" name="username" placeholder="Username" autofocus required></input>
				<!--<label>Password</label>-->
				<input type="password" id="login-password" class="login-input" name="password" placeholder="Password" required></input>
				<input type="submit" id="login-submit" class="login-input" name="submit" value="Login"></input>
			</form>
			<br>
			<blockquote id="login-quote">
				<p>"Leave no mess behind."</p>
			</blockquote>

		</div>
	</div>
	<script type="text/javascript" src="../js/login.js"></script>

<?php include "body.php"; ?>
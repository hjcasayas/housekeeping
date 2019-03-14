<?php
/*
Project: Housekeeping
Author: hjcasayas
Github: https://github.com/hjcasayas/housekeeping
*/

session_start();

include_once "head.php";
?>

<div class="container-change-password">

	<form class="login-form" action="changePasswordHandler.php" method="POST">
		<?php
			if (isset($_GET['error'])) {
				echo "<p class='error'>" . $_GET['error'] . "</p>";
			}
		?>
		<label>Current Password</label>
		<input class="login-input" type="password" name="currentPassword" autofocus required>
		<label>Change Password</label>
		<input class="login-input" type="password" name="newPassword" placeholder="New Password" required>
		<input class="login-input" type="password" name="confirmNewPassword" placeholder="Confirm New Password" required>
		<input id="submit-change" type="submit" name="submitChangePassword" value="Change Password">
	</form>
	<a href="frontPage.php" id='go-back-home'>Go Back To Housekeeping</a>
</div>

<?php include_once "body.php";?>
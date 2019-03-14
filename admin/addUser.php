<?php
/*
Project: Housekeeping
Author: hjcasayas
Github: https://github.com/hjcasayas/housekeeping
*/

$baseName = basename("a/addUser.php", ".php");
	
include "header.php";

if (isset($_SESSION['username'])) {

?>

	<div class="addUser-container">
		<form action="addUserHandler.php" method="POST">
			
			<?php 
				if(isset($_GET['error'])) {

					echo "<p style = 'color: red'>" . $_GET['error'] . "</p>";

				}

			?>

			<label>Username </label> <br />
			<input id="addUser-username" class="addUser-input" type="text" name="username" required autofocus></input>
			<br />
			<label>Password </label><input class="addUser-input" type="checkbox" name="defaultPassword" value="fit@123" id="defaultPassword">default <span style = "font-size: 80%;">(clean@123)</span></input> <br />
			<input class="addUser-input" type="password" name="password" id="password"></input>
			<br />
			<label>Confirm Password </label>
			<input class="addUser-input" type="password" name="confirm_password" id="confirm_password"></input>
			<br />
			<label>First Name </label> <br />
			<input class="addUser-input" type="text" name="fname" required></input>
			<br />
			<label>Last Name </label> <br />
			<input class="addUser-input" type="text" name="lname" required></input>
			<br />
			<label>Area </label> 
			
			<select name="area" id="area">
				<option>-</option>
				<option value="A">A</option>
				<option value="B">B</option>
				<option value="C">C</option>
				<option value="D">D</option>
			</select>			
			<br /><br />
			<label>Birth Day </label> <br />
			<input class="addUser-input" type="date" name="bDay" placeholder="mm/dd/yyyy" required></input>
			<br />
			<input class="addUser-input" type="checkbox" class="checkbox" name="admin" value="admin">Add as admin as well.</input>
			<br />
			<input class="addUser-input" type="submit" name="addForm_submit" value="Add User"></input>
		</form>
	</div>

<?php include "footer.php";?>
<?php } else { handleError("login.php", "Don't hack Me!"); } ?>
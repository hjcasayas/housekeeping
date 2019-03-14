<?php
/*
Project: Housekeeping
Author: hjcasayas
Github: https://github.com/hjcasayas/housekeeping
*/

include "databaseHandler.php";
include "functions.php";

$errorLocation = "changePassword.php";
$successLocation = "login.php";

session_start();

if (!(isset($_POST['submitChangePassword']))) {
	handleError($errorLocation, "Thou shall not hack!");	
} else {

	$currentPassword = $_POST['currentPassword'];
	$newPassword = $_POST['newPassword'];
	$confirmNewPassword = $_POST['confirmNewPassword'];
	$userName = $_SESSION['username'];

	$currentPassword = secureInput($conn, $_POST['currentPassword']);
	$newPassword = trim(secureInput($conn, ($_POST['newPassword'])));
	$confirmNewPassword = trim(secureInput($conn, $_POST['confirmNewPassword']));
	$userName = secureInput($conn, $_SESSION['username']);





	// Check for stmt validity
	$sql = "SELECT * FROM $userTable where userName = ?";
	
	if (!($stmt = $conn->prepare($sql))) {
		handleError($errorLocation, "Prepared statement error.");
	} else {
		$stmt->bind_param("s", $userName);
		$stmt->execute();

		// Check if the user exists
		$results = $stmt->get_result();
		$numRows = $results->num_rows;

		if (!($numRows == 1)) {
			handleError($errorLocation, "User does not exist.");

		} else {
			
			$row = $results->fetch_assoc();
			$stmt->close();
			// Check if current password is equal to the password from the database
			if (!(password_verify($currentPassword, $row['userPassword']))) {
				handleError($errorLocation, "Wrong Password.");
			} else {
				
				// Checks if currentPassword is equal to newPassword
				if ($currentPassword === $newPassword) {
					handleError($errorLocation, "Password is not changed, please enter new password.");
				} else {
					
					//Check if newPassword and confirmNewPassword is the same
					if (!($newPassword === $confirmNewPassword)) {
						handleError($errorLocation, "New password is not confirmed.");
					} else {
						// Check for prepared statment
						$newPassword = password_hash($confirmNewPassword, PASSWORD_DEFAULT);
						$sql = "UPDATE $userTable SET userPassword = ? WHERE userName = ?";

						if (!($stmt = $conn->prepare($sql))) {
							handleError($errorLocation, "Prepared statement error.");
						} else {
							$stmt->bind_param("ss", $newPassword, $userName);
							$stmt->execute();
							$stmt->close();

////////////////////////Check if Password is successfully changed/////////////////////////////

							$sql = "SELECT * FROM $userTable where userName = ?";
							
							if (!($stmt = $conn->prepare($sql))) {
								handleError($errorLocation, "Prepared statement. Password is not successfully changed.");
							} else {
								$stmt->bind_param("s", $userName);
								$stmt->execute();

								// Check if the user exists
								$results = $stmt->get_result();
								$numRows = $results->num_rows;
								
								if (!($numRows == 1)) {
									handleError($errorLocation, $numRows);
								} else {

									//check if currentPassword is the same with the changed password from the database

									$row = $results->fetch_assoc();
									if (password_verify($currentPassword, $row['userPassword'])) {
										handleError($errorLocation,"Password is not changed");
									} else {
										handleError($successLocation, "Password is successfully changed.");
									} //check if currentPassword is the same with the changed password from the database
								} // Check if the user exists
							}
////////////////////////Check if Password is successfully changed/////////////////////////////
						} //Check for prepared statement

						
					} //Check if newPassword and confirmNewPassword is the same

				} // Check if currentPassword is equal to newPassword

			} // Check if current password is equal to the password from the database

		} // Check if the user exists
		
	} // Check for stmt validity

}




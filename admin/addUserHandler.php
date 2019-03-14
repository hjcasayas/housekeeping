<?php
/*
Project: Housekeeping
Author: hjcasayas
Github: https://github.com/hjcasayas/housekeeping
*/

session_start();
include_once "functions.php";
require_once "databaseHandler.php";

$errorLocation = "addUser.php";
$successLocation = "addUser.php";

//Check if it comes from hitting the submit button
if (isset($_POST['addForm_submit'])) {
	$userName = secureInput($conn, strtolower(trim($_POST['username'])));
	$firstName = secureInput($conn, trim($_POST['fname']));
	$lastName = secureInput($conn, trim($_POST['lname']));
	$area = secureInput($conn, trim($_POST['area']));
	$password = secureInput($conn, trim($_POST['password']));
	$confirm_password = secureInput($conn, trim($_POST['confirm_password']));
	$bDay = secureInput($conn, trim($_POST['bDay']));
	// if(isset($_POST['admin'])) {
	// 	$addAsAdmin = secureInput($conn, $_POST['admin']);
	// }

	//Check for empty input fields
	if (empty($userName) || empty($firstName) || empty($lastName) || empty($area) || empty($password) || empty($confirm_password) || empty($bDay)) {
		handleError($errorLocation, "Please fill up every input fields");
	} else {  

		$sql = "SELECT * FROM $userTable WHERE userName = ?";

		$stmt = $conn->prepare($sql);

		$stmt->bind_param("s", $userName);
		$stmt->execute();

		$results = $stmt->get_result();
		$numRows = $results->num_rows;
		$stmt->close();

		//Check if the user already exists
		if ($numRows>0) {
			handleError($errorLocation, "User already exists.");

		} else {
			//Check if the password is the same
			if (!($password === $confirm_password)) {
				handleError($errorLocation, "Password did not match.");
			} else {
				$password = password_hash($confirm_password, PASSWORD_DEFAULT);

				//Checks if there are numeric characters in the firstname and lastname
				if (!preg_match("/^[a-zA-Z\s]*$/", $firstName) || !preg_match("/^[a-zA-Z\s]*$/", $firstName)) {
					handleError($errorLocation, "First Name, Last Name and Area must none contain numbers.");
				} else {
					
					// Checks the area
					if (!(($area === "A") || ($area === "B") || ($area === "C") || ($area === "D"))) {
						handleError($errorLocation, "Area should have either of the values A, B,C or D");
					} else {
						//Checks if the date is in YYYY-mm-dd format
						if (!($dob = DateTime::createFromFormat("Y-m-d", $bDay))) {
							handleError($errorLocation, "The date is in wrong format.");
						} else {
							$dob = $dob->format("Y-m-d");

							//Insert data to database
							$sql = "INSERT INTO $userTable(userName, userPassword, firstName, lastName, dob, area) VALUES(?,?,?,?,?,?)";

							if (!($stmt=$conn->prepare($sql))) {
								handleError($errorLocation, "Prepared statement failed!");
							} else {
								$stmt->bind_param("ssssss",$userName, $password, $firstName, $lastName, $dob, $area);
								$stmt->execute();
								$stmt->close();

								//check if the admin checkbox is checked
								if (isset($_POST['admin'])) {

									$sql = "INSERT INTO $adminTable(userName) VALUES(?)";
									if (!($stmt = $conn->prepare($sql))) {
										handleError($errorLocation, "Prepared statment for admin failed!");
									} else {
										$stmt->bind_param("s",$userName);
										$stmt->execute();
										$stmt->close();
										$conn->close();
									}
									

								}//check if the admin checkbox is checked
								
								handleError($successLocation, "Successfully added $userName.");

							} //Insert data to database
							
						}//Checks if the date is in YYYY-mm-dd format
					
					} //Checks the area
					
				}//Checks if there are numeric characters in the firstname and lastname

			}//Check if the password is the same

		} //Check if the user already exists
		
	} //Check for empty input fields
	

} else { handleError($errorLocation, "Don't hack me!"); } //Check if it comes from hitting the submit button
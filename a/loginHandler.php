<?php
/*
Project: Housekeeping
Author: hjcasayas
Github: https://github.com/hjcasayas/housekeeping
*/

include_once ("functions.php");
$errorLocation = "login.php";

if (isset($_POST['submit'])) { 

	session_start();

	require_once ("databaseHandler.php");

	$successLocation = "frontPage.php?login=success";

	if(isset($_POST['username']) && !empty($_POST['username'])){
		
		$username = strtolower(trim($_POST['username']));
		$password = trim($_POST['password']);
		
		$username = secureInput($conn, $username);
		$password = secureInput($conn, $password);

		if ($conn->select_db($database)) {

			$sql = "SELECT * FROM users where userName = ?";
			
			if($stmt= $conn->prepare($sql)){
				
				$stmt->bind_param("s", $username);
				$stmt->execute();
				
				$results = $stmt->get_result();
				$numRows = $results->num_rows;
			
				if($numRows == 1){
					$row = $results->fetch_assoc();
					if(password_verify($password, $row['userPassword'])) {
						$_SESSION['username'] = $row['userName'];
						$_SESSION['firstname'] = $row['firstName'];
						$_SESSION['lastname'] = $row['lastName'];
						$_SESSION['area'] = $row['area'];
						$stmt->close();
						$conn->close();
						header("location: " . $successLocation);
						
					}else{handleError($errorLocation, "wrong password!");}
				}else {handleError($errorLocation, "User does not exist");}// zero or more than is available
			} else {handleError($errorLocation, "stmt failed!"); }// $stmt= $conn->prepare($sql)			
		} else {handleError($errorLocation, "Database does not exist.");}//$conn->select_db($databaseUsers)
	} else {handleError($errorLocation,"Username input field is empty.");} // isset($_POST['username']) && !empty($_POST['username'])
} else {handleError($errorLocation,"Don't hack me, damnit!"); } // isset($_POST['submit'])
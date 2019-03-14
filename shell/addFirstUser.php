<?php
/*
Project: Housekeeping
Author: hjcasayas
Github: https://github.com/hjcasayas/housekeeping
*/

include "../a/databaseHandler.php";
include "functions.php";

$username = "housekeeper";
$password = "clean@123";
$password = password_hash($password, PASSWORD_DEFAULT);
$firstName = "House";
$lastName = "Keeper";
$dob = "1991-08-20";
$area = "C";

/***Check if database exists***/

if (!($conn->select_db($database))) {  	//Database does not exist
	createDatabase($conn, $database); 	//Create Database
} else { 								//Database exists

	//checks if housekeeping table exists
	$sql = "SELECT * FROM $housekeepingTable";
	
	if (!($results = $conn->query($sql))) {
		$sql = "CREATE TABLE $housekeepingTable(
					id INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
					area VARCHAR(4) NOT NULL,
					lastman VARCHAR(255) NOT NULL,
					shredder VARCHAR(255) NOT NULL,
					checklist VARCHAR(255) NOT NULL,
					comments VARCHAR(1000) NULL,
					dateSubmit DATE NOT NULL,
					timeSubmit TIME NOT NULL
				)";

		createTable($conn, $sql, $housekeepingTable);
	}

	$sql = "SELECT * FROM $holidays";

	if (!($results = $conn->query($sql))) {
		$sql = "CREATE TABLE $holidays(
					id INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
					holidays DATE NOT NULL
				)";

		createTable($conn, $sql, $holidays);
	}	


	/***Check if admin table does exist***/
	$sql = "SELECT * FROM $adminTable";
	
	if ($results = $conn->query($sql)) {

		$sql = "SELECT * FROM $adminTable WHERE userName = '$username'";
		$results = $conn->query($sql);
		$numRows = $results->num_rows;
		if ($numRows>0) {
			echo "$username already exists at $adminTable! <br>";
		} else {
			$sql = "INSERT INTO $adminTable(userName) VALUES('$username')";
			if ($result=$conn->query($sql)) {
				echo "Successfully added $username to $adminTable! <br>";
			} else {
				echo $conn->error;
			}
		}
		

		
	} else { //number of row is zero
		$sql = "CREATE TABLE $adminTable(
				id INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
				userName VARCHAR(255) NOT NULL
				)";
		createTable($conn, $sql, $adminTable);
	}
	//check if $userTable exists
	$sql = "SELECT * FROM $userTable";
	if ($results = $conn->query($sql)) {
		
		$sql = "SELECT userName FROM $userTable WHERE userName = '$username'";
		$results = $conn->query($sql);
		$numRows = $results->num_rows;
		if ($numRows>0) {
			header("Location: ../a/login.php");
		} else {		

			$sql = "INSERT INTO $userTable(userName, userPassword, firstName, lastName, dob, area) 
					VALUES('$username', '$password', '$firstName', '$lastName', '$dob', '$area')";
			if ($results=$conn->query($sql)) {
				echo "Successfully added $username to $userTable! <br>";
			} else {
				echo $conn->error;
			}
		}		
	} else {
		$sql = "CREATE TABLE $userTable(
				id INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
				userName VARCHAR(255) NOT NULL,
				userPassword VARCHAR(255) NOT NULL,
				firstName VARCHAR(255) NOT NULL,
				lastName VARCHAR(255) NOT NULL,
				dob DATE NOT NULL,
				area VARCHAR(16) NOT NULL
				)";
		createTable($conn, $sql, $userTable);
	}
}

$conn->close();









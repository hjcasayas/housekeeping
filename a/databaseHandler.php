<?php
/*
Project: Housekeeping
Author: hjcasayas
Github: https://github.com/hjcasayas/housekeeping
*/
$errorLocation = "login.php";

$serverName = "localhost";
$serverUsername = "id3021937_root";
$serverPassword = "clean@123";
$database = "id3021937_housekeeping";
$databaseUsers = $database . "Users";
$adminTable = "admins";
$userTable = "users";
$housekeepingTable = "housekeeping";
$holidays = "holidays";

$conn = new mysqli($serverName, $serverUsername, $serverPassword);

if (!$conn) {
	die("Connection Error: " . mysqli_connect_error());
}

if ($conn->select_db($database)) {
	$conn->select_db($database);
}
<?php
/*
Project: Housekeeping
Author: hjcasayas
Github: https://github.com/hjcasayas/housekeeping
*/

//Create Database
function createDatabase($connection, $database){

	$sql = "CREATE DATABASE $database";

	if($connection->query($sql)) {
		echo "Sucessfully created $database! <br>";
	} else {
		echo $connection->error;
	}
}

function createTable($connection, $sql, $table) {
	if($connection->query($sql))
		echo "Sucessfully created $table!<br>";
	else{
		echo $connection->error;
	}
}


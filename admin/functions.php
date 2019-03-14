<?php
/*
Project: Housekeeping
Author: hjcasayas
Github: https://github.com/hjcasayas/housekeeping
*/

function handleError($location, $typeOfError) { //put user to index.php because of an error

	header("Location: " . $location . "?error=*" . $typeOfError);
	exit();
	
}

function secureInput($conn, $unsecureInput) { //anti mysql injection

	$secureVar = mysqli_real_escape_string($conn, $unsecureInput);
	return $secureVar;

}

function successful(){
	echo "success";
}

function backgroundNav ($pathInfo) {
	if($pathInfo == "frontPage"){
		echo "background-nav";
	} else {
		echo "link-nav";
	}
}

function currentPage ($page) {
	global $baseName;

	echo ($baseName == $page) ? 'li-background' : '';
}

function shred_points($username, $area, $thisWeek) {
	global $conn, $housekeepingTable;

	$shredPoints = 0;

	$sql = 	"SELECT * FROM $housekeepingTable 
			WHERE shredder = '$username' AND area = '$area'
			ORDER BY dateSubmit DESC";

	if ($results = $conn->query($sql)) {

		while($rows = $results->fetch_assoc()){
			$week = $rows['dateSubmit'];
	
			if ($week = DateTime::createFromFormat('Y-m-d', $week)) {
				$week = (int) $week->format('W');
				if ($week = $thisWeek) {
					$shredPoints++;
				}
			}
		}

	} else {
		echo $conn->error;	
	}

	return $shredPoints;
}

// generate array of all users
function generate_array_columns($conn, $column, $table, $byorder) {
	$anyColumn = [];

	$sql = "SELECT $column FROM $table ORDER BY $byorder";

	$results = $conn->query($sql);
	$numRows = $results->num_rows;

	if ($numRows>0) {
		while($row = $results->fetch_assoc()){
			$anyColumn[] = $row["$column"];
		}
	}

	return $anyColumn;
}

// generate array of all who paid this payday
function generate_array_contributors($year, $month, $payday) {
	global $conn;

	$anyColumn = [];

	$sql = "SELECT userName FROM contributions WHERE theyear = '$year' AND themonth = '$month' AND payday = $payday";

	$results = $conn->query($sql);
	$numRows = $results->num_rows;

	if ($numRows>0) {
		while($row = $results->fetch_assoc()){
			$anyColumn[] = $row["userName"];
		}
	}

	return $anyColumn;
}

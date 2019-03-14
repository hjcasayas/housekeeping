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



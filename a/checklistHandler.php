<?php
/*
Project: Housekeeping
Author: hjcasayas
Github: https://github.com/hjcasayas/housekeeping
*/

session_start();
date_default_timezone_set("Asia/Manila");

if (isset($_POST['cleanData'])) {

	require_once "databaseHandler.php";
	include_once "functions.php";

	$userName = $_SESSION['username'];
	$firstName = $_SESSION['firstname'];
	$lastName = $_SESSION['lastname'];
	$area = $_SESSION['area'];
	$today = new DateTime;
	$todayDate = $today->format("Y-m-d");
	$todayTime = $today->format("H:i:s");
	$none = "-";

	$housekeeping = json_decode($_POST['cleanData'], true);
	$countData = count($housekeeping['housekeeping']);



	$numRows = checkAlreadySubmit();
	$isHoliday = getHolidays($todayDate);

	if ($numRows[1] > 0 && $numRows[0] == $userName) {
		echo "You already submitted the housekeeping form for your area.";
	} elseif ($numRows[1] > 0) {
		echo $numRows[0] . " has already submitted the housekeeping form for your area.";
	} elseif (((int)$today->format("N") == 6)||(((int)$today->format("N") == 7))) {
		echo "Today is Weekend! Cannot submit the housekeeping form.";
	} elseif($isHoliday > 0) {
		echo "Today is a holiday! Cannot submit the housekeeping form.";
	} else {
		if ($countData == 0) {

			$sql = "INSERT INTO $housekeepingTable (area, lastman, shredder, checklist, comments, dateSubmit, timeSubmit) 
					VALUES(?,?,?,?,?,?,?)";

			if ($stmt = $conn->prepare($sql)){
				$stmt->bind_param("sssssss", $area, $userName, $none, $none,$none, $todayDate,$todayTime);
				$stmt->execute();
			} else {
				echo $stmt->error;
			}

			$numRows = checkAlreadySubmit();

			if ($numRows > 1) {
				echo "No shredder for today! Congrats!";
			} else {
				echo $stmt->error;
			}

		} else {

			$sql = "INSERT INTO $housekeepingTable (area, lastman, shredder, checklist, comments, dateSubmit, timeSubmit) 
			VALUES(?,?,?,?,?,?,?)";

			if ($stmt = $conn->prepare($sql)){

				for ($i=0; $i < $countData; $i++) { 
					$shredder = $housekeeping['housekeeping'][$i]['shredder'];
					$checklist = $housekeeping['housekeeping'][$i]['checklist'];
					$comments = $housekeeping['housekeeping'][$i]['comment'];

					$stmt->bind_param("sssssss", $area, $userName, $shredder, $checklist,$comments, $todayDate,$todayTime);
					$stmt->execute();
				}
			} else {
				echo $stmt->error;
			}

			$numRows = checkAlreadySubmit();

			if ($numRows[1] > 0) {
				echo "successfuly submitted housekeeping form.";
			} else {
				echo $stmt->error;
			}

		}
	}

$conn->close();
}

function checkAlreadySubmit(){
	global $area, $housekeepingTable, $conn, $todayDate;
	$sql = "SELECT * FROM $housekeepingTable 
			WHERE dateSubmit = ?
			AND area = ?";

	if ($stmt = $conn->prepare($sql)) {
		$stmt->bind_param("ss", $todayDate, $area);
		$stmt->execute();

		$results = $stmt->get_result();

		$row = $results->fetch_assoc();

		$numRows = $results->num_rows;

		return $variables = [$row['lastman'], $numRows];
	}	
}

function getHolidays($dateToday) {
	global $holidays, $conn;

	$sql = "SELECT holidays FROM $holidays WHERE holidays='$dateToday'";
	$results = $conn->query($sql);
	$results = $results->num_rows;

	if ($results > 0) {
		return 1;
	} else {
		return 0;
	}
}







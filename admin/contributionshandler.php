<?php
/*
Project: Housekeeping
Author: hjcasayas
Github: https://github.com/hjcasayas/housekeeping
*/
session_start();
if (!(isset($_SESSION['username']))) {
	header('Location: index.php');
} else {

		include 'functions.php';
		include 'databaseHandler.php';

		$members = generate_array_columns($conn, 'userName', 'users', 'area');

		$months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
		$paydays = ['1','2'];

		$allContributions = [];

		foreach ($members as $member) {
			$contributions = [];
			foreach ($months as $month) {
				$withMonthArray = [];
				$paydaysArray = [];
				foreach ($paydays as $payday) {
					$sql = "SELECT amount FROM contributions WHERE userName='$member' AND themonth='$month' AND payday='$payday' ";

					$results = $conn->query($sql);
					$numRows = $results->num_rows;


					if ($numRows > 0 ) {
						while($row = $results->fetch_assoc()) {
							$paydaysArray[] = $row['amount'];
						}
					} else {
							$paydaysArray[] = '';
					}
				}
				$withMonthArray = array("$month" => $paydaysArray);
				$contributions[] = $withMonthArray;
			}
			$singleContribution = array('member'=>$member, 'contributions' => $contributions);
			$allContributions[] = $singleContribution; 
		}
		//var_dump($allContributions);

		$file = 'contributions.json';
		$jsonContributions = json_encode($allContributions);

		file_put_contents($file, $jsonContributions);
}


?>
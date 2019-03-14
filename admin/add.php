<?php
session_start();

if (!(isset($_SESSION['username']))) {
	header('Location: index.php');
} else { 

	include 'functions.php';
	include "databaseHandler.php";
	date_default_timezone_set("Asia/Manila");

	if (isset($_POST['updatePayment'])) {
		$member = strtolower($_POST['member']);
		$payment = (int)$_POST['payment'];
		$datePaid = $_POST['datePaid'];
		$theMonth = $_POST['theMonth'];
		$theYear = $_POST['theYear'];
		$thePayday = $_POST['thePayday'];
		$dateInput = new DateTime;
		$dateInput = $dateInput->format('Y-m-d');

		$sql = "SELECT * FROM contributions WHERE userName='$member' AND theyear='$theYear' AND themonth='$theMonth' AND payday='$thePayday'";

        $results = $conn->query($sql);
		$numRows = $results->num_rows;

		if ($numRows > 0) {
			echo $member . ' has paid.';
		} else {
			$sql = "INSERT INTO contributions(userName, amount, theyear, themonth, payday, datePaid, dateInput) VALUES (?,?,?,?,?,?,?)";

			$stmt = $conn->stmt_init();

			if($stmt->prepare($sql)){
				$stmt->bind_param('sisssss',$member, $payment, $theYear, $theMonth, $thePayday, $datePaid, $dateInput);
				$stmt->execute();

				$sql = "SELECT * FROM contributions WHERE userName = '$member' AND theyear = '$theYear' AND themonth = '$theMonth' AND payday = '$thePayday'";

				$results = $conn->query($sql);
				$numRows = $results->num_rows;

				if ($numRows > 0) {
					echo "success";
				} else {
					echo $conn->error;
				}

			} else {
				echo $conn->error;
			}
		}
	}
}
<?php
session_start();

if (!(isset($_SESSION['username']))) {
	header('Location: index.php');
} else {

	include 'functions.php';
	include "databaseHandler.php";
	date_default_timezone_set("Asia/Manila");

	// for users.php
	if (isset($_POST['users'])) {
		$sql = "SELECT * FROM users ORDER BY area ASC";

		$results = $conn->query($sql);
		if ($results) {
			
			$numRows = $results->num_rows;

			if ($numRows == 0) {
				echo 'empty database rows';
			} else {

				while($rows = $results->fetch_assoc()){
					$date = new DateTime($rows['dob']);
					$dateFormatted = $date->format('F j, Y');
					echo '<tr>';
					// echo '<td>' . $rows['id'] . '</td>';
					echo '<td>' . $rows['userName'] . '</td>';
					echo '<td>' . $rows['firstName'] . '</td>';
					echo '<td>' . $rows['lastName'] . '</td>';
					echo '<td>' . $dateFormatted . '</td>';
					echo '<td>' . $rows['area'] . '</td>';
					echo '<td> <input type="button" class="delete" value="Delete"></td>';
					echo '</tr>';
				}
			}

		} else {
			echo $conn->error;
		}
	}

	// for select get years
	if(isset($_POST['years'])) {
		$testDate = new DateTime;
		$testDate->setDate(2017, 01, 01);
		$currentDate = new DateTime;

		// $testDate = DateTime::createFromFormat('F j, Y', $testDate);
		$testYear = (int)$testDate->format('Y');
		$currentYear = (int)$currentDate->format('Y');

		while ($currentYear >= $testYear) {
			echo "<option value='$currentYear'>$currentYear</option>";
			$currentYear--;
		}
	}

	// for select get months
	if(isset($_POST['months'])) {
		$testDate = new DateTime;
		$testDate->setDate(2017, 01, 01);
		$currentDate = new DateTime;

		$testMonth = (int)$testDate->format('n');
		$currentMonth = $currentDate->format('F');

		// echo "<option value='$testMonth'>$testMonth</option>";

		while ($testMonth <= 12) {
			$optionMonth = $testDate->format('F');
			$testDate->add(new DateInterval('P1M'));
			$testMonth++;
			if ($currentMonth == $optionMonth) {
				echo "<option value='$optionMonth' selected>$optionMonth</option>";
				continue;
			}
			echo "<option value='$optionMonth'>$optionMonth</option>";
		}
	}

	// for select get payday

	if (isset($_POST['payday'])) {
		$currentDate = new DateTime;
		$calendarMid = 15;

		$currentDay = (int) $currentDate->format('j');

		echo '<option value="1" ' . ($currentDay <= $calendarMid ? 'selected' : '') . '>1</option>';
		echo '<option value="2" ' . ($currentDay > $calendarMid ? 'selected' : '') . '>2</option>';
		
	}

	// when contribution-generate is clicked;
	if (isset($_POST['generate'])) {
		$theYear = (string)($_POST['theYear']);
		$theMonth = $_POST['theMonth'];
		$thePayday = (string)$_POST['thePayday'];

		$members = generate_array_columns($conn, 'userName', 'users', 'area');
		$paid = generate_array_contributors($theYear, $theMonth, $thePayday);

		$notPaid = array_diff($members, $paid);
		echo "<h3><span id='theMonth'>$theMonth</span> <span id='theYear'>$theYear</span> Payday <span id='thePayday'>$thePayday</span></h3>";

		$result = <<<EOR
		<table id='payment-table'>
			<thead id='payment-table-thead'>
				<tr>
					<th>Members</th>
					<th>Payment</th>
					<th>Date Paid</th>
					<th>Action</th>
				</tr>			
			</thead>
EOR;
	
		echo $result;
		echo "<tbody id='payment-table-tbody'>";

		foreach ($notPaid as $member) {
			echo '<tr>';
				echo "<td>" . ucfirst($member) . "</td>";
				echo "<td><select class='amount-paid'>";
				echo "<option value='' selected hidden disabled>-</option>";

				for ($i=50; $i <= 100; $i+=25) { 
					echo "<option value='$i'>$i</option>";
				}

				echo "</select></td>";
				echo "<td><input class='date-paid-input' type='date' name='datePaid' placeholder='mm/dd/yyyy'></input>";
				echo "<label><input type='checkbox' class='now-paid'>Today</label>";
				echo "</td>";
				echo "<td><input type='button' value='Update' class='update' id='update-payment'></td>";
			echo '</tr>';
		
		}	

		echo '</tbody>';
		echo '</table>';

	}


	if (isset($_POST['today'])) {
		$now = new DateTime;
		echo $now->format('Y-m-d');
	}

	// Paid contributions
	if (isset($_POST['paid'])) {

		$jsonData = file_get_contents("contributions.json"); //Get json file
		$contributions = json_decode($jsonData, true); //decode json file
		$months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

		foreach ($contributions as $contribution) {
			echo '<tr>';
				echo "<td class='members-td'>" . $contribution['member'] . "</td>";

				$count = count($contribution['contributions']);

				for ($i=0; $i < $count; $i++) { 

					for ($k=0; $k < 2; $k++) { 
						if (empty($contribution['contributions'][$i]["$months[$i]"][$k])) {
							echo "<td class='payday-amount' style='background-color: red;'>" . "</td>";
						} else {
							echo "<td class='payday-amount' style='background-color: #00ff7f; font-weight: bold;'>" . $contribution['contributions'][$i]["$months[$i]"][$k] . "</td>";
						}
					}
				}
				
			echo '</tr>';
		}

	}

}



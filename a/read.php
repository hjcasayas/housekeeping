<?php
session_start();

if (!(isset($_SESSION['username']))) {
	header('Location: index.php');
} else {

	include '../admin/functions.php';
	include "databaseHandler.php";
	date_default_timezone_set("Asia/Manila");

	// Paid contributions
	if (isset($_POST['paid'])) {

		$jsonData = file_get_contents("../admin/contributions.json"); //Get json file
		$contributions = json_decode($jsonData, true); //decode json file
		$months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

		foreach ($contributions as $contribution) {
			echo '<tr>';
				echo "<td class='members-td' "; 
				echo ($contribution['member'] == $_SESSION['username']) ? 'style=background-color:#3399ff;font-weight:bold;':'';
				echo "'>"; 
				echo ucfirst($contribution['member']) . "</td>";

				$count = count($contribution['contributions']);

				for ($i=0; $i < $count; $i++) { 

					for ($k=0; $k < 2; $k++) { 
						if (empty($contribution['contributions'][$i]["$months[$i]"][$k])) {
							echo "<td class='payday-amount' style='background-color: red;'>" . "</td>";
						} else {
							echo "<td class='payday-amount' style='background-color: #00ff7f; font-weight: bold;'></td>";
						}
					}
				}
				
			echo '</tr>';
		}

	}

}



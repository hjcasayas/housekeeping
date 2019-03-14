<?php
/*
Project: Housekeeping
Author: hjcasayas
Github: https://github.com/hjcasayas/housekeeping
*/

$baseName = basename("a/logs.php", ".php");

include_once "header.php"; ?>

<h2>Last Week's Logs</h2>

<?php include "lastWeek.php"; ?>

<?php

	$currentWeek = new DateTime;
	$currentWeek = $currentWeek->format('W');
	$currentDate = "";

	$lastWeek = (int)$currentWeek - 1;

	// echo $lastWeek;

	$sql = "Select * FROM $housekeepingTable ORDER BY dateSubmit DESC, area ASC";

	if ($results = $conn->query($sql)) {
		echo 	"<table id = 'table-logs'>"; 
	
		while($row = $results->fetch_assoc()) {
			// echo "<br>" . $row['dateSubmit'];

			if ($theDate = DateTime::createFromFormat('Y-m-d', $row['dateSubmit'])) {


				$theDateWeek = (int)$theDate->format('W');

				if($theDateWeek < $lastWeek) {
					break;
				} elseif ($theDateWeek == $lastWeek) {
					if (!($currentDate == $theDate)) {
						echo "<tr id = 'thead-logs'>";
						echo "<th style='text-align: left;' colspan='2' id = 'thead-date-logs'>" . $theDate->format('F d, Y (l)') . "</th>";
						echo "<th class = 'thead-column-logs'>" . "Shredder" . "</th>";
						echo "<th class = 'thead-column-logs'>" . "Checklist" . "</th>";
						echo "</tr>";
					} 
					
					echo "<tr>";
					echo "<td style='text-align: center;'>" . $row['area'] . "</td>";
					echo "<td style='text-align: center;'>" . ucfirst($row['lastman']) . "</td>";
					echo "<td style='text-align: center;'>" . ucfirst($row['shredder']) . "</td>";
					echo "<td style='text-align: center;'>" . $row['comments'] . "</td>";
					echo "</tr>"; 
				}

				$currentDate = $theDate;
			}
			
		}

		echo 	"</table>"; 

	}

?>

<?php
include "footer.php";
?>
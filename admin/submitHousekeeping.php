<?php
/*
Project: Housekeeping
Author: hjcasayas
Github: https://github.com/hjcasayas/housekeeping
*/


// $today = new DateTime;

// if (!((int) $today->format("N") == 1)) {
// 	$yesterday = new DateTime("-1 Day");
// } else {
// 	$yesterday = new DateTime("-3 Days");
// }

// $yesterdate = clone $yesterday;
// $yesterdate = $yesterdate->format('Y-m-d');

$sql = "SELECT * FROM $housekeepingTable 
		ORDER BY dateSubmit DESC, area ASC";

if($results = $conn->query($sql)){

	$submitDate = "";

	while($row = $results->fetch_assoc()){

		$tempDate = DateTime::createFromFormat('Y-m-d', $row['dateSubmit']);
		$timeSubmit = DateTime::createFromFormat('H:i:s', $row['timeSubmit']);
		$timeSubmit = $timeSubmit->format('g:ia');

		 if (!($submitDate == $tempDate) && !(empty($submitDate))) {
		 	break;
		 }

		echo "<tr>" .
			"<td>" . $row['area'] . "</td>" .
			"<td>" . ucfirst($row['lastman']) . "</td>" .
			"<td>" . ucfirst($row['shredder']) . "</td>" .
			"<td>" . $row['checklist'] . "</td>" .
			"<td>" . $row['comments'] . "</td>" .
			"<td>" . $row['dateSubmit'] . "</td>" .
			"<td>" . $timeSubmit . "</td>" .
		 "</tr>";


		 $submitDate = $tempDate;
	}
} else {
	echo $conn->error;
}


// echo "<tr><td>" . $yesterday->format('Y-m-d') . "</td>" . "<td>" . $yesterday->format('H:i:s') . "</td></tr>";
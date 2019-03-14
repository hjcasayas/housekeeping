<?php

$sql = "SELECT * FROM $housekeepingTable";

if (!($results = $conn->query($sql))) {
	$sql = "CREATE TABLE $housekeepingTable(
				id INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
				area VARCHAR(4) NOT NULL,
				lastman VARCHAR(255) NOT NULL,
				offender VARCHAR(255) NOT NULL,
				checklist VARCHAR(255) NOT NULL,
				comments VARCHAR(1000) NULL,
				dateSubmit Date NOT NULL,
				timeSubmit Time NOT NULL
			)";

	createTable($conn, $sql, $housekeepingTable)
}
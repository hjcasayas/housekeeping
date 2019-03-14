<?php
/*
Project: Housekeeping
Author: hjcasayas
Github: https://github.com/hjcasayas/housekeeping
*/

$baseName = basename("a/users.php", ".php");

include_once "header.php"; ?>

<!-- Code for the page users.php -->

	<div class="clearfix users-page-container">
		<table id="users-table">
			<thead id="users-table-thead">
				<tr>
					<!-- <th>ID</th> -->
					<th>Username</th>
					<th>First Name</th>
					<th>Last Name</th>
					<th>Date of Birth</th>
					<th>Area</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody id="users-table-tbody">
				
			</tbody>
		</table>
	</div>

<!-- Code for the page users.php -->

<?php
include "footer.php";
?>
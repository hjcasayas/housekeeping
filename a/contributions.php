<?php
/*
Project: Housekeeping
Author: hjcasayas
Github: https://github.com/hjcasayas/housekeeping
*/

$baseName = basename("a/contributions.php", ".php");

include_once "header.php"; ?>

<div class="clearfix contributions-page-container">
	<table id="contributions-table">
		<thead>
			<tr>	
				<th>Members</th>
				<th colspan="2">Jan</th>
				<th colspan="2">Feb</th>
				<th colspan="2">Mar</th>
				<th colspan="2">Apr</th>
				<th colspan="2">May</th>
				<th colspan="2">Jun</th>
				<th colspan="2">Jul</th>
				<th colspan="2">Aug</th>
				<th colspan="2">Sep</th>
				<th colspan="2">Oct</th>
				<th colspan="2">Nov</th>
				<th colspan="2">Dec</th>
			</tr>
		</thead>

		<tbody id="contributions-table-tbody">
			
		</tbody>
	</table>
<script type="text/javascript" src=../js/user.js></script>
</div>

<?php

include "footer.php";
?>
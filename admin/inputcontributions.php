<?php
/*
Project: Housekeeping
Author: hjcasayas
Github: https://github.com/hjcasayas/housekeeping
*/

$baseName = basename("a/inputcontributions.php", ".php");

include_once "header.php"; ?>

<div class="clearfix payment-page-container">

	Year: <select id='contributions-years'></select>
	Month: <select id='contributions-months'></select>
	Payday: <select id='contributions-payday'></select>
	<input id="generate-contributors" type="button" value="Generate">

	<div class="clearfix contributors-container">

	</div>
	<div class="error">
		
	</div>

</div>

<?php
include "footer.php";
?>
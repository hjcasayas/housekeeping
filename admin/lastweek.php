<?php
/*
Project: Housekeeping
Author: hjcasayas
Github: https://github.com/hjcasayas/housekeeping
*/

$baseName = basename("a/lastweek.php", ".php");

include_once "header.php";
include_once "logs.php"; 
?>

<h2>Last Week's Logs</h2>

<?php generate_weekly(1) ?>

<?php
include "footer.php";
?>
<?php
/*
Project: Housekeeping
Author: hjcasayas
Github: https://github.com/hjcasayas/housekeeping
*/

$baseName = basename("a/housekeepinglogs.php", ".php");

include_once "header.php"; 
include_once "logs.php";
?>

<h2>This Week's Logs</h2>

<?php generate_weekly(0) ?>

<?php
include "footer.php";
?>
<?php
/*
Project: Housekeeping
Author: hjcasayas
Github: https://github.com/hjcasayas/housekeeping
*/
session_start();
date_default_timezone_set("Asia/Manila");

include_once "head.php";
include_once "functions.php";
include_once "databaseHandler.php";
$errorLocation = "frontPage.php";
// $baseName = basename("a/frontPage.php", ".php");

if (isset($_SESSION['username'])) {

$userName = $_SESSION['username'];
$firstName = $_SESSION['firstname'];
$lastName = $_SESSION['lastname'];
$area = $_SESSION['area'];
$today = date('Y-m-d');
$todayName = date('l');
$thisWeek = (int)date('W');

?>
<div class="container">

	<div class="container-profile-report">	
		<div class="container-profile" id="profile">
			<h3 id="fullname"><?php echo "$firstName $lastName"; ?></h1>
			<p>
				<span style="font-weight: bold;">Shred Points:</span> 
				<?php // shred_points function - counts the shredpoints the specified week 
					$shredPoints = shred_points($userName, $area, $thisWeek); 
					echo $shredPoints; 
				?>
			</p>
			<p><span style="font-weight: bold;">Area:</span> <?php echo $area; ?></p>
			<!-- <p id="todayDate" style="position: absolute; left:-999em;"><span style="font-weight: bold;">Date:</span> <?php//  echo $today ($todayName) ?></p> -->
		</div>

		<div class="container-daily-report">
			<table id="table-daily-report">
				<tr id="daily-report-main-row">
					<th>Area</th>
					<th>Last Man</th>
					<th>Shredder</th>
					<th>Checklist</th>
					<th>Comments</th>
					<th>Date</th>
					<th>Time</th>
				</tr>
				<?php
					include 'submitHousekeeping.php';
				?>
			</table>
		</div>
	</div>
		<br>

		<div class="container-header clearfix">
			<ul class="ul-header">

				<li id='li-home'  class="<?php $currentPage = currentPage("housekeepinglogs"); ?>"><a href="housekeepinglogs.php">Housekeeping Logs</a></li>
				<li id="li-users" class="<?php $currentPage = currentPage("users"); ?>"><a href="users.php">Users</a></li>
				<li id="logout"><a href="logoutHandler.php">Log Out</a></li>
				<li id="li-add-user" class="> <?php $currentPage = currentPage("addUser"); ?>"><a href="addUser.php">Add User</a></li>
				<li id="li-input-contributions" class="> <?php $currentPage = currentPage("inputcontributions"); ?>"><a href="inputcontributions.php">Payments</a></li>
				<li id="li-contributions" class="> <?php $currentPage = currentPage("contributions"); ?>"><a href="contributions.php">Contributions</a></li>
				<li id="li-lastweek" class="> <?php $currentPage = currentPage("lastweek"); ?>"><a href="lastweek.php">Last Week Logs</a></li>

			</ul>
		</div>
	<br>

<?php } else {handleError("login.php", "Don't hack me!");}?>
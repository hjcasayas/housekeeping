<?php
/*
Project: Housekeeping
Author: hjcasayas
Github: https://github.com/hjcasayas/housekeeping
*/



if (isset($_POST['hour']) && !(empty($_POST['hour']))) {

	date_default_timezone_set("Asia/Manila");

	$nowTime = new DateTime;
	echo $nowTime->format("G");

}
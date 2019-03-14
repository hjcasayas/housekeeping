<?php
/*
Project: Housekeeping
Author: hjcasayas
Github: https://github.com/hjcasayas/housekeeping
*/

session_start();
session_destroy();
header("Location: login.php?action=logout");
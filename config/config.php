<?php
error_reporting(E_ALL | E_DEPRECATED | E_STRICT);
/*
 * set default time-zone to confirm the timezone
 * else it will show an error that system time is not reliable
 * Change it as per your timezone
 */
date_default_timezone_set('Asia/Kolkata');

set_time_limit(20 * 60);
//amit set config
define('CURPAGE', basename($_SERVER['PHP_SELF'])); // basename($_SERVER['PHP_SELF']); /* Returns The Current PHP File Name */
define('QSTRGET', urldecode($_SERVER['QUERY_STRING'])); //   echo urldecode($_SERVER['QUERY_STRING']);
define('SESSVAR', 'MotorAdmin'); //   echo urldecode($_SERVER['QUERY_STRING']);

$base = "motor_db";
$server = "localhost";
$user = "root";
$pass = "";
//Open a new connection to the MySQL server
$db = new mysqli($server, $user, $pass, $base);
//Output any connection error
if ($db->connect_error) {
    // die('Error : (' . $db->connect_errno . ') ' . $db->connect_error);
    die('Error : (' . header("Location: 404") . ') ' . $db->connect_error);
}


if (empty($_SESSION['uniquiIDGEN'])) {
    $uniquiIDGEN = "C" . date('dmis') . substr(str_shuffle("1234567890abcdefghijklmnopABCDEFGHIJKLMPNOQRSTZYWQ"), 0, 10); //Generating random number
    $_SESSION['uniquiIDGEN'] = $uniquiIDGEN;
}
$sess_code = $_SESSION['uniquiIDGEN'];
// http://".HOST."/menu/test.php

function BaseUrl() {
    return 'http://' . $_SERVER['HTTP_HOST'] . '/Motor/';
}

//$keyId = 'rzp_live_O1mJBDlhGA7L2S';
//$keySecret = 'D8GPQFAqdVoWdvrFeuytME3G';
//$displayCurrency = 'INR';

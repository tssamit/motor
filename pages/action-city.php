<?php
session_start();
require_once '../config/config.php';
require_once '../config/helper.php';
$action = $_REQUEST['submit'];
switch ($action) {
    case 'addCity':
        $cit_distid = mysqli_real_escape_string($db, trim($_POST['cit_distid']));
        $cit_stid = mysqli_real_escape_string($db, trim($_POST['cit_stid']));
        $cit_cnid = mysqli_real_escape_string($db, trim($_POST['cit_cnid']));
        $cit_name = mysqli_real_escape_string($db, trim($_POST['cit_name']));
        $cit_code = mysqli_real_escape_string($db, trim($_POST['cit_code']));

        $results = $db->query("SELECT * FROM `city` WHERE cit_name='$cit_name'");
        if ($results->num_rows > 0) {
            $_SESSION['errormsg'] = 'City ' . $cit_name . ' already exist.';
            $_SESSION['errorValue'] = 'warning';
            header("Location: ../add-city");
        } else {
            $db->query("INSERT INTO `city` (`cit_id`, `cit_distid`, `cit_stid`, `cit_cnid`, `cit_name`, `cit_code`, `cit_status`) VALUES (NULL, '$cit_distid', '$cit_stid', '$cit_cnid', '$cit_name', '$cit_code', '1')");
            $_SESSION['errormsg'] = 'City ' . $cit_name . ' added successfully.';
            $_SESSION['errorValue'] = 'success';
            header("Location: ../add-city");
        }
        break;
    case 'updateCity':
        $cit_id = $_POST['cit_id'];
        $cit_distid = mysqli_real_escape_string($db, trim($_POST['cit_distid']));
        $cit_stid = mysqli_real_escape_string($db, trim($_POST['cit_stid']));
        $cit_cnid = mysqli_real_escape_string($db, trim($_POST['cit_cnid']));
        $cit_name = mysqli_real_escape_string($db, trim($_POST['cit_name']));
        $cit_code = mysqli_real_escape_string($db, trim($_POST['cit_code']));

        $db->query("UPDATE `city` SET cit_cnid='$cit_cnid', cit_distid='$cit_distid', cit_stid='$cit_stid', cit_name='$cit_name', cit_code='$cit_code'  WHERE cit_id = '$cit_id'");
        $_SESSION['errormsg'] = 'City ' . $cit_name . ' updated successfully.';
        $_SESSION['errorValue'] = 'success';
        header("Location: ../add-city");

        break;
    case 'deleteCity':
        $cit_id = $_REQUEST['cit_id'];
        //$db->query("DELETE from `city` where `cit_id`='$cit_id'");
        $_SESSION['errormsg'] = 'City deleted';
        $_SESSION['errorValue'] = 'success';
        header("Location: ../add-city");
        break;
    case 'Disable':
        $cit_id = $_REQUEST['cit_id'];
        $db->query("UPDATE city SET cit_status='2' WHERE cit_id = '$cit_id'");
        $_SESSION['errormsg'] = 'Sucessfully disabled.';
        $_SESSION['errorValue'] = 'success';
        header("Location: ../add-city");
        break;
    case 'Enable':
        $cit_id = $_REQUEST['cit_id'];
        $db->query("UPDATE city SET cit_status='1' WHERE cit_id = '$cit_id'");
        $_SESSION['errormsg'] = 'Sucessfully enabled.';
        $_SESSION['errorValue'] = 'success';
        header("Location: ../add-city");
        break;
    default:
        $_SESSION['errormsg'] = 'Invalid page access.';
        $_SESSION['errorValue'] = 'warning';
        header("Location: ../404");
}
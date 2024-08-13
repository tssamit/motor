<?php
session_start();
require_once '../config/config.php';
require_once '../config/helper.php';
$action = $_REQUEST['submit'];
switch ($action) {
    case 'addState':
        $st_cnid = mysqli_real_escape_string($db, trim($_POST['st_cnid']));
        $st_name = mysqli_real_escape_string($db, trim($_POST['st_name']));
        $st_code = mysqli_real_escape_string($db, trim($_POST['st_code']));

        $results = $db->query("SELECT * FROM `state` WHERE st_name='$st_name'");
        if ($results->num_rows > 0) {
            $_SESSION['errormsg'] = 'State ' . $st_name . ' already exist.';
            $_SESSION['errorValue'] = 'warning';
            header("Location: ../add-state");
        } else {
            $db->query("INSERT INTO `state` (`st_id`, `st_cnid`, `st_name`, `st_code`, `st_status`) VALUES (NULL, '$st_cnid', '$st_name', '$st_code', '1')");
            $_SESSION['errormsg'] = 'State ' . $st_name . ' added successfully.';
            $_SESSION['errorValue'] = 'success';
            header("Location: ../add-state");
        }
        break;
    case 'updateState':
        $st_id = $_POST['st_id'];
        $st_cnid = mysqli_real_escape_string($db, trim($_POST['st_cnid']));
        $st_name = mysqli_real_escape_string($db, trim($_POST['st_name']));
        $st_code = mysqli_real_escape_string($db, trim($_POST['st_code']));
        $results = $db->query("SELECT * FROM `state` WHERE st_name='$st_name'");
        if ($results->num_rows > 0) {
            $db->query("UPDATE `state` SET st_code='$st_code'  WHERE st_id = '$st_id'");
            $_SESSION['errormsg'] = 'State ' . $st_name . ' already exist.';
            $_SESSION['errorValue'] = 'warning';
            header("Location: ../add-state?stid=$st_id");
        } else {
            $db->query("UPDATE `state` SET st_cnid='$st_cnid', st_name='$st_name', st_code='$st_code'  WHERE st_id = '$st_id'");

            $_SESSION['errormsg'] = 'State ' . $st_name . ' updated successfully.';
            $_SESSION['errorValue'] = 'success';
            header("Location: ../add-state");
        }
        break;
    case 'deleteState':
        $st_id = $_REQUEST['st_id'];
        // $db->query("DELETE from state where `st_id`='$st_id'");
        $_SESSION['errormsg'] = 'State deleted';
        $_SESSION['errorValue'] = 'success';
        header("Location: ../add-state");
        break;
    case 'Disable':
        $st_id = $_REQUEST['st_id'];
        $db->query("UPDATE state SET st_status='2' WHERE st_id = '$st_id'");
        $_SESSION['errormsg'] = 'Sucessfully disabled.';
        $_SESSION['errorValue'] = 'success';
        header("Location: ../add-state");
        break;
    case 'Enable':
        $st_id = $_REQUEST['st_id'];
        $db->query("UPDATE state SET st_status='1' WHERE st_id = '$st_id'");
        $_SESSION['errormsg'] = 'Sucessfully enabled.';
        $_SESSION['errorValue'] = 'success';
        header("Location: ../add-state");
        break;
    default:
        $_SESSION['errormsg'] = 'Invalid page access.';
        $_SESSION['errorValue'] = 'warning';
        header("Location: ../404");
}
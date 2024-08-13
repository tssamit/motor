<?php
session_start();
require_once '../config/config.php';
require_once '../config/helper.php';
$action = $_REQUEST['submit'];
switch ($action) {
    case 'addbranch':

        $b_name = mysqli_real_escape_string($db, $_POST['b_name']);

        $results = $db->query("SELECT * FROM `branch` WHERE b_name='$b_name'");
        if ($results->num_rows > 0) {
            $_SESSION['errormsg'] = ' already exist.';
            $_SESSION['errorValue'] = 'warning';
            header("Location: ../branch");
        } else {
            $db->query("INSERT INTO `branch` (`b_id`, `b_name`, `b_sts`) VALUES (NULL, '$b_name', '1')");
            $_SESSION['errormsg'] = ' added successfully.';
            $_SESSION['errorValue'] = 'success';
            header("Location: ../branch");
        }
        break;
    case 'updatebranch':
        $b_id = $_POST['b_id'];

        $b_name = mysqli_real_escape_string($db, $_POST['b_name']);

        $results = $db->query("SELECT * FROM `branch` WHERE b_name='$b_name'");
        if ($results->num_rows > 0) {

            $_SESSION['errormsg'] = ' already exist.';
            $_SESSION['errorValue'] = 'warning';
            header("Location: ../branch?bid=$b_id");
        } else {
            $db->query("UPDATE `branch` SET b_name='$b_name' WHERE b_id = '$b_id'");

            $_SESSION['errormsg'] = ' updated successfully.';
            $_SESSION['errorValue'] = 'success';
            header("Location: ../branch");
        }
        break;
    case 'deleteState':
        $b_id = $_REQUEST['b_id'];
        // $db->query("DELETE from branch where `b_id`='$b_id'");
        $_SESSION['errormsg'] = 'State deleted';
        $_SESSION['errorValue'] = 'success';
        header("Location: ../branch");
        break;
    case 'Disable':
        $b_id = $_REQUEST['b_id'];
        $db->query("UPDATE branch SET b_sts='2' WHERE b_id = '$b_id'");
        $_SESSION['errormsg'] = 'Sucessfully disabled.';
        $_SESSION['errorValue'] = 'success';
        header("Location: ../branch");
        break;
    case 'Enable':
        $b_id = $_REQUEST['b_id'];
        $db->query("UPDATE branch SET b_sts='1' WHERE b_id = '$b_id'");
        $_SESSION['errormsg'] = 'Sucessfully enabled.';
        $_SESSION['errorValue'] = 'success';
        header("Location: ../branch");
        break;
    default:
        $_SESSION['errormsg'] = 'Invalid page access.';
        $_SESSION['errorValue'] = 'warning';
        header("Location: ../404");
}
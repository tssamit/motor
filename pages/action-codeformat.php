<?php
session_start();
require_once '../config/config.php';
require_once '../config/helper.php';
$action = $_REQUEST['submit'];
switch ($action) {


    case 'CodeFormatSet':

        $act_id = mysqli_real_escape_string($db, trim($_POST['act_id']));
        $act_prefix = mysqli_real_escape_string($db, trim($_POST['act_prefix']));
        $act_length = mysqli_real_escape_string($db, trim($_POST['act_length']));
        $act_separator = mysqli_real_escape_string($db, trim($_POST['act_separator']));

        $db->query("UPDATE `acc_type` SET act_prefix = '$act_prefix', act_length = '$act_length', `act_separator` = '$act_separator' WHERE act_id = '$act_id'");

        $_SESSION['errormsg'] = 'Updated';
        $_SESSION['errorValue'] = 'success';
        header("Location: ../set-code-format");

        break;

    default:
        $_SESSION['errormsg'] = 'Invalid page access.';
        $_SESSION['errorValue'] = 'warning';
        header("Location: ../404");
}
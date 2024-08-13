<?php
session_start();
require_once '../config/config.php';
require_once '../config/helper.php';
$action = $_REQUEST['submit'];
switch ($action) {
    case 'UserPageSet':
        $act_id = $_POST['act_id'];
        if (!empty($_POST['checkbox_id'])) {
            $path = implode(",", $_POST['checkbox_id']);
        } else {
            $path = '';
        }
        if (!empty($_POST['desktop_id'])) {
            $desktop_path = implode(",", $_POST['desktop_id']);
        } else {
            $desktop_path = '';
        }

        $db->query("UPDATE `acc_type` SET act_permission = '$path',  act_icon_permission = '$desktop_path' WHERE act_id = '$act_id'");

        //$db->query("CALL usp_user_type('U','$user_type_name','$path', '$desktop_path')");
        $_SESSION['errormsg'] = 'Successfully Assigned.';
        $_SESSION['errorValue'] = 'success';
        header("Location: ../set-permission");
        break;
    default:
        $_SESSION['errormsg'] = 'Invalid page access.';
        $_SESSION['errorValue'] = 'warning';
        header("Location: ../404");
}
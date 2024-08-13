<?php
session_start();
require_once '../config/config.php';
$action = $_REQUEST['submit'];
switch ($action) {


    case 'updatepwd':

        $a_idchk = $_SESSION['a_id'];

        $cur_password = md5($_REQUEST['cur_password']);
        $a_password = md5($_REQUEST['a_password']);
        $confirm_a_pwd = md5($_REQUEST['confirm_a_pwd']);
        $a_vpwd = $_REQUEST['a_password'];

        if ($a_password !== $confirm_a_pwd) {
            //echo "mismatches";exit;
            $db->close();
            $_SESSION['errormsg'] = 'Passwords does not match!...';
            $_SESSION['errorValue'] = 'warning';
            header("Location: ../dashboard");
        } else {
            //echo "UPDATE admin SET a_password='$a_password', a_vpwd='$a_vpwd' WHERE a_id='$a_idchk' AND a_password = '$cur_password'";
            // exit;
            $db->query("UPDATE admin SET a_password='$a_password', a_vpwd='$a_vpwd' WHERE a_id='$a_idchk' AND a_password = '$cur_password'");

            $db->close();
            $_SESSION['errormsg'] = 'Password reset successfully.';
            $_SESSION['errorValue'] = 'success';
            header("Location: ../dashboard");
        }

        break;

    case 'updatepwdAdmin':

        $a_idchk = mysqli_real_escape_string($db, trim($_POST['a_id']));

        $a_password = md5($_REQUEST['a_password']);
        $confirm_a_pwd = md5($_REQUEST['confirm_a_pwd']);
        $a_vpwd = $_REQUEST['a_password'];

        $db->query("UPDATE admin SET a_password='$a_password', a_vpwd='$a_vpwd' WHERE a_id='$a_idchk'");

        $db->close();
        $_SESSION['errormsg'] = 'Password reset successfully.';
        $_SESSION['errorValue'] = 'success';
        header("Location: ../user-creation");

        break;

    default:
        $_SESSION['errormsg'] = 'Invalid page access.';
        $_SESSION['errorValue'] = 'warning';
        header("Location: ../404");
}
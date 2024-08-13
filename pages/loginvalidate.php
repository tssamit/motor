<?php
session_start();
require_once '../config/config.php';
require_once '../config/helper.php';
//print_r($_REQUEST);exit;
$action = $_REQUEST['submit'];
switch ($action) {
    case 'login':
        $username = $_POST['username'];
        $passwword = md5($_POST['passwword']);
        // echo "SELECT * FROM `vw_master_user` WHERE `a_username`='$username' AND `a_password`='$passwword' AND `a_status`='1'";
        // exit();
        //MySqli Select Query
        $results = $db->query("SELECT * FROM `vw_master_user` WHERE `a_username`='$username' AND `a_password`='$passwword' AND `a_status`='1'");
        //get total number of records
        if ($results->num_rows > 0) {
            $row = $results->fetch_object();

            unset($_SESSION['a_usertype']);
            $_SESSION[SESSVAR] = session_id();
            $_SESSION['LOGAUTHType'] = $row->a_usertype;
            $_SESSION['LOGAUTHValidate'] = true;
            $_SESSION['a_id'] = $row->a_id;
            $_SESSION['a_usertype'] = $row->a_usertype;

            $db->close();

            header("Location:../dashboard");
        } else {
            $_SESSION['errormsg'] = 'Email or password does not match.';
            $_SESSION['errorValue'] = 'warning';
            header("Location:../../login");
        }
        break;

    case 'logout':

        unset($_SESSION[SESSVAR]);
        unset($_SESSION['LOGAUTHType']); // set user type
        unset($_SESSION['LOGAUTHValidate']); // set user type
        unset($_SESSION['a_id']);
        $_SESSION['LOGAUTHValidate'] = false;
        unset($_SESSION['a_usertype']);
        session_destroy();
        header("Location: ../login");
        exit();
        break;

    default:
        $_SESSION['errormsg'] = 'Invalid page access.';
        $_SESSION['errorValue'] = 'danger';
        header("Location: ../404");
}

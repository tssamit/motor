<?php
session_start();
require_once '../config/config.php';
require_once '../config/helper.php';
$action = $_REQUEST['submit'];
switch ($action) {
    case 'addcat':

        $vc_name = mysqli_real_escape_string($db, $_POST['vc_name']);

        $results = $db->query("SELECT * FROM `veh_category` WHERE vc_name='$vc_name'");
        if ($results->num_rows > 0) {
            $_SESSION['errormsg'] = ' already exist.';
            $_SESSION['errorValue'] = 'warning';
            header("Location: ../veh-category");
        } else {

            if (!empty($_POST['checkbox_id'])) {
                $vc_accessory = implode(",", $_POST['checkbox_id']);
            } else {
                $vc_accessory = '';
            }

            $db->query("INSERT INTO `veh_category` (`vc_id`, `vc_name`, `vc_accessory`, `vc_sts`) VALUES (NULL, '$vc_name', '$vc_accessory', '1')");
            $_SESSION['errormsg'] = ' added successfully.';
            $_SESSION['errorValue'] = 'success';
            header("Location: ../veh-category");
        }
        break;
    case 'updatecat':
        $vc_id = $_POST['vc_id'];

        $vc_name = mysqli_real_escape_string($db, $_POST['vc_name']);

        if (!empty($_POST['checkbox_id'])) {
            $vc_accessory = implode(",", $_POST['checkbox_id']);
        } else {
            $vc_accessory = '';
        }
        //echo $vc_accessory;
        //exit;
        $db->query("UPDATE `veh_category` SET vc_name='$vc_name', vc_accessory='$vc_accessory' WHERE vc_id = '$vc_id'");

        $_SESSION['errormsg'] = ' updated successfully.';
        $_SESSION['errorValue'] = 'success';
        header("Location: ../veh-category");

        break;
    case 'deleteState':
        $vc_id = $_REQUEST['vc_id'];
        // $db->query("DELETE from branch where `vc_id`='$vc_id'");
        $_SESSION['errormsg'] = 'State deleted';
        $_SESSION['errorValue'] = 'success';
        header("Location: ../veh-category");
        break;
    case 'Disable':
        $vc_id = $_REQUEST['vc_id'];
        $db->query("UPDATE veh_category SET vc_sts='2' WHERE vc_id = '$vc_id'");
        $_SESSION['errormsg'] = 'Sucessfully disabled.';
        $_SESSION['errorValue'] = 'success';
        header("Location: ../veh-category");
        break;
    case 'Enable':
        $vc_id = $_REQUEST['vc_id'];
        $db->query("UPDATE veh_category SET vc_sts='1' WHERE vc_id = '$vc_id'");
        $_SESSION['errormsg'] = 'Sucessfully enabled.';
        $_SESSION['errorValue'] = 'success';
        header("Location: ../veh-category");
        break;
    default:
        $_SESSION['errormsg'] = 'Invalid page access.';
        $_SESSION['errorValue'] = 'warning';
        header("Location: ../404");
}
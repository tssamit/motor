<?php
session_start();
require_once '../config/config.php';
require_once '../config/helper.php';
$action = $_REQUEST['submit'];
switch ($action) {
    case 'addcolor':
        $vcl_vmid = mysqli_real_escape_string($db, trim($_POST['vcl_vmid']));
        $vcl_vcid = mysqli_real_escape_string($db, trim($_POST['vcl_vcid']));
        $vcl_name = mysqli_real_escape_string($db, trim($_POST['vcl_name']));

        $results = $db->query("SELECT * FROM `veh_color` WHERE vcl_name='$vcl_name' AND vcl_vcid='$vcl_vcid'");
        if ($results->num_rows > 0) {
            $_SESSION['errormsg'] = $vcl_name . ' already exist.';
            $_SESSION['errorValue'] = 'warning';
            header("Location: ../veh-color");
        } else {
            $db->query("INSERT INTO `veh_color` (`vcl_id`, `vcl_vcid`, `vcl_vmid`, `vcl_name`, `vcl_sts`) VALUES (NULL, '$vcl_vcid', '$vcl_vmid', '$vcl_name', '1')");
            $_SESSION['errormsg'] = $vcl_name . ' added successfully.';
            $_SESSION['errorValue'] = 'success';
            header("Location: ../veh-color");
        }
        break;
    case 'updatecolor':
        $vcl_id = $_POST['vcl_id'];
        $vcl_vmid = mysqli_real_escape_string($db, trim($_POST['vcl_vmid']));
        $vcl_vcid = mysqli_real_escape_string($db, trim($_POST['vcl_vcid']));
        $vcl_name = mysqli_real_escape_string($db, trim($_POST['vcl_name']));
        $vcl_code = mysqli_real_escape_string($db, trim($_POST['vcl_code']));

        $db->query("UPDATE `veh_color` SET vcl_vmid='$vcl_vmid', vcl_vcid='$vcl_vcid', vcl_name='$vcl_name'  WHERE vcl_id = '$vcl_id' ");
        $_SESSION['errormsg'] = $vcl_name . ' updated successfully.';
        $_SESSION['errorValue'] = 'success';
        header("Location: ../veh-color");

        break;
    case 'deleteDistrict':
        $vcl_id = $_REQUEST['vcl_id'];
        // $db->query("DELETE from veh_color where `vcl_id`='$vcl_id'");
        $_SESSION['errormsg'] = 'District deleted';
        $_SESSION['errorValue'] = 'success';
        header("Location: ../veh-color");
        break;
    case 'Disable':
        $vcl_id = $_REQUEST['vcl_id'];
        $db->query("UPDATE veh_color SET vcl_sts='2' WHERE vcl_id = '$vcl_id'");
        $_SESSION['errormsg'] = 'Sucessfully disabled.';
        $_SESSION['errorValue'] = 'success';
        header("Location: ../veh-color");
        break;
    case 'Enable':
        $vcl_id = $_REQUEST['vcl_id'];
        $db->query("UPDATE veh_color SET vcl_sts='1' WHERE vcl_id = '$vcl_id'");
        $_SESSION['errormsg'] = 'Sucessfully enabled.';
        $_SESSION['errorValue'] = 'success';
        header("Location: ../veh-color");
        break;
    default:
        $_SESSION['errormsg'] = 'Invalid page access.';
        $_SESSION['errorValue'] = 'warning';
        header("Location: ../404");
}
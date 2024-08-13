<?php
session_start();
require_once '../config/config.php';
require_once '../config/helper.php';
$action = $_REQUEST['submit'];
switch ($action) {
    case 'addmodel':
        $vm_vcid = mysqli_real_escape_string($db, trim($_POST['vm_vcid']));
        $vm_model = mysqli_real_escape_string($db, trim($_POST['vm_model']));
        $vm_series = mysqli_real_escape_string($db, trim($_POST['vm_series']));

        $results = $db->query("SELECT * FROM `veh_model` WHERE vm_model='$vm_model'");
        if ($results->num_rows > 0) {
            $_SESSION['errormsg'] = $vm_model . ' already exist.';
            $_SESSION['errorValue'] = 'warning';
            header("Location: ../veh-model");
        } else {
            $db->query("INSERT INTO `veh_model` (`vm_id`, `vm_vcid`, `vm_model`, `vm_series`, `vm_sts`) VALUES (NULL, '$vm_vcid', '$vm_model', '$vm_series', '1')");
            $_SESSION['errormsg'] = $vm_model . ' added successfully.';
            $_SESSION['errorValue'] = 'success';
            header("Location: ../veh-model");
        }
        break;
    case 'updatemodel':
        $vm_id = $_POST['vm_id'];
        $vm_vcid = mysqli_real_escape_string($db, trim($_POST['vm_vcid']));
        $vm_model = mysqli_real_escape_string($db, trim($_POST['vm_model']));
        $vm_series = mysqli_real_escape_string($db, trim($_POST['vm_series']));
        $results = $db->query("SELECT * FROM `state` WHERE vm_model='$vm_model'");
        if ($results->num_rows > 0) {
            $db->query("UPDATE `veh_model` SET vm_series='$vm_series'  WHERE vm_id = '$vm_id'");
            $_SESSION['errormsg'] = $vm_model . ' already exist.';
            $_SESSION['errorValue'] = 'warning';
            header("Location: ../veh-model?vmid=$vm_id");
        } else {
            $db->query("UPDATE `veh_model` SET vm_vcid='$vm_vcid', vm_model='$vm_model', vm_series='$vm_series'  WHERE vm_id = '$vm_id'");

            $_SESSION['errormsg'] = $vm_model . ' updated successfully.';
            $_SESSION['errorValue'] = 'success';
            header("Location: ../veh-model");
        }
        break;
    case 'deleteState':
        $vm_id = $_REQUEST['vm_id'];
        // $db->query("DELETE from state where `vm_id`='$vm_id'");
        $_SESSION['errormsg'] = 'State deleted';
        $_SESSION['errorValue'] = 'success';
        header("Location: ../veh-model");
        break;
    case 'Disable':
        $vm_id = $_REQUEST['vm_id'];
        $db->query("UPDATE veh_model SET vm_sts='2' WHERE vm_id = '$vm_id'");
        $_SESSION['errormsg'] = 'Sucessfully disabled.';
        $_SESSION['errorValue'] = 'success';
        header("Location: ../veh-model");
        break;
    case 'Enable':
        $vm_id = $_REQUEST['vm_id'];
        $db->query("UPDATE veh_model SET vm_sts='1' WHERE vm_id = '$vm_id'");
        $_SESSION['errormsg'] = 'Sucessfully enabled.';
        $_SESSION['errorValue'] = 'success';
        header("Location: ../veh-model");
        break;
    default:
        $_SESSION['errormsg'] = 'Invalid page access.';
        $_SESSION['errorValue'] = 'warning';
        header("Location: ../404");
}
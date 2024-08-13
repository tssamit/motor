<?php
session_start();
require_once '../config/config.php';
require_once '../config/helper.php';
$action = $_REQUEST['submit'];
switch ($action) {
    case 'addpf':

        $pf_name = mysqli_real_escape_string($db, $_POST['pf_name']);

        $results = $db->query("SELECT * FROM `plant_factory` WHERE pf_name='$pf_name'");
        if ($results->num_rows > 0) {
            $_SESSION['errormsg'] = ' already exist.';
            $_SESSION['errorValue'] = 'warning';
            header("Location: ../plant-factory");
        } else {
            $db->query("INSERT INTO `plant_factory` (`pf_id`, `pf_name`, `pf_sts`) VALUES (NULL, '$pf_name', '1')");
            $_SESSION['errormsg'] = ' added successfully.';
            $_SESSION['errorValue'] = 'success';
            header("Location: ../plant-factory");
        }
        break;
    case 'updatepf':
        $pf_id = $_POST['pf_id'];

        $pf_name = mysqli_real_escape_string($db, $_POST['pf_name']);

        $results = $db->query("SELECT * FROM `plant_factory` WHERE pf_name='$pf_name'");
        if ($results->num_rows > 0) {

            $_SESSION['errormsg'] = ' already exist.';
            $_SESSION['errorValue'] = 'warning';
            header("Location: ../plant-factory?pfid=$pf_id");
        } else {
            $db->query("UPDATE `plant_factory` SET pf_name='$pf_name' WHERE pf_id = '$pf_id'");

            $_SESSION['errormsg'] = ' updated successfully.';
            $_SESSION['errorValue'] = 'success';
            header("Location: ../plant-factory");
        }
        break;
    case 'deleteState':
        $pf_id = $_REQUEST['pf_id'];
        // $db->query("DELETE from plant-factory where `pf_id`='$pf_id'");
        $_SESSION['errormsg'] = 'State deleted';
        $_SESSION['errorValue'] = 'success';
        header("Location: ../plant-factory");
        break;
    case 'Disable':
        $pf_id = $_REQUEST['pf_id'];
        $db->query("UPDATE plant_factory SET pf_sts='2' WHERE pf_id = '$pf_id'");
        $_SESSION['errormsg'] = 'Sucessfully disabled.';
        $_SESSION['errorValue'] = 'success';
        header("Location: ../plant-factory");
        break;
    case 'Enable':
        $pf_id = $_REQUEST['pf_id'];
        $db->query("UPDATE plant_factory SET pf_sts='1' WHERE pf_id = '$pf_id'");
        $_SESSION['errormsg'] = 'Sucessfully enabled.';
        $_SESSION['errorValue'] = 'success';
        header("Location: ../plant-factory");
        break;
    default:
        $_SESSION['errormsg'] = 'Invalid page access.';
        $_SESSION['errorValue'] = 'warning';
        header("Location: ../404");
}
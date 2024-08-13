<?php
session_start();
require_once '../config/config.php';
require_once '../config/helper.php';
$action = $_REQUEST['submit'];
switch ($action) {
    case 'addDistrict':
        $dist_cnid = mysqli_real_escape_string($db, trim($_POST['dist_cnid']));
        $dist_stid = mysqli_real_escape_string($db, trim($_POST['dist_stid']));
        $dist_name = mysqli_real_escape_string($db, trim($_POST['dist_name']));
        $dist_code = mysqli_real_escape_string($db, trim($_POST['dist_code']));

        $results = $db->query("SELECT * FROM `district` WHERE dist_name='$dist_name' AND dist_stid='$dist_stid'");
        if ($results->num_rows > 0) {
            $_SESSION['errormsg'] = 'District ' . $dist_name . ' already exist.';
            $_SESSION['errorValue'] = 'warning';
            header("Location: ../add-district");
        } else {
            $db->query("INSERT INTO `district` (`dist_id`, `dist_stid`, `dist_cnid`, `dist_name`, `dist_code`, `dist_status`) VALUES (NULL, '$dist_stid', '$dist_cnid', '$dist_name', '$dist_code', '1')");
            $_SESSION['errormsg'] = 'District ' . $dist_name . ' added successfully.';
            $_SESSION['errorValue'] = 'success';
            header("Location: ../add-district");
        }
        break;
    case 'updateDistrict':
        $dist_id = $_POST['dist_id'];
        $dist_cnid = mysqli_real_escape_string($db, trim($_POST['dist_cnid']));
        $dist_stid = mysqli_real_escape_string($db, trim($_POST['dist_stid']));
        $dist_name = mysqli_real_escape_string($db, trim($_POST['dist_name']));
        $dist_code = mysqli_real_escape_string($db, trim($_POST['dist_code']));
        $results = $db->query("SELECT * FROM `district` WHERE dist_name='$dist_name' AND dist_stid='$dist_stid'");
        if ($results->num_rows > 0) {

            $_SESSION['errormsg'] = 'District ' . $dist_name . ' already exist.';
            $_SESSION['errorValue'] = 'warning';
            header("Location: ../add-district");
        } else {
            $db->query("UPDATE `district` SET dist_cnid='$dist_cnid', dist_stid='$dist_stid', dist_name='$dist_name', dist_code='$dist_code'  WHERE dist_id = '$dist_id'");
            $_SESSION['errormsg'] = 'District ' . $dist_name . ' updated successfully.';
            $_SESSION['errorValue'] = 'success';
            header("Location: ../add-district");
        }
        break;
    case 'deleteDistrict':
        $dist_id = $_REQUEST['dist_id'];
        // $db->query("DELETE from district where `dist_id`='$dist_id'");
        $_SESSION['errormsg'] = 'District deleted';
        $_SESSION['errorValue'] = 'success';
        header("Location: ../add-district");
        break;
    case 'Disable':
        $dist_id = $_REQUEST['dist_id'];
        $db->query("UPDATE district SET dist_status='2' WHERE dist_id = '$dist_id'");
        $_SESSION['errormsg'] = 'Sucessfully disabled.';
        $_SESSION['errorValue'] = 'success';
        header("Location: ../add-district");
        break;
    case 'Enable':
        $dist_id = $_REQUEST['dist_id'];
        $db->query("UPDATE district SET dist_status='1' WHERE dist_id = '$dist_id'");
        $_SESSION['errormsg'] = 'Sucessfully enabled.';
        $_SESSION['errorValue'] = 'success';
        header("Location: ../add-district");
        break;
    default:
        $_SESSION['errormsg'] = 'Invalid page access.';
        $_SESSION['errorValue'] = 'warning';
        header("Location: ../404");
}
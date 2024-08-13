<?php
session_start();
require_once '../config/config.php';
require_once '../config/helper.php';
$action = $_REQUEST['submit'];
switch ($action) {
    case 'addgodawn':
        $lg_bid = mysqli_real_escape_string($db, $_POST['lg_bid']);
        $lg_name = mysqli_real_escape_string($db, $_POST['lg_name']);
        $lg_address = mysqli_real_escape_string($db, $_POST['lg_address']);

        $results = $db->query("SELECT * FROM `location_godown` WHERE lg_name='$lg_name'");
        if ($results->num_rows > 0) {
            $_SESSION['errormsg'] = $lg_name . ' already exist.';
            $_SESSION['errorValue'] = 'warning';
            header("Location: ../location-godown");
        } else {
            $db->query("INSERT INTO `location_godown` (`lg_id`, `lg_bid`, `lg_name`, `lg_address`, `lg_sts`) VALUES (NULL, '$lg_bid', '$lg_name', '$lg_address', '1')");
            $_SESSION['errormsg'] = $lg_name . ' added successfully.';
            $_SESSION['errorValue'] = 'success';
            header("Location: ../location-godown");
        }
        break;
    case 'updategodawn':
        $lg_id = $_POST['lg_id'];
        $lg_bid = mysqli_real_escape_string($db, $_POST['lg_bid']);
        $lg_name = mysqli_real_escape_string($db, $_POST['lg_name']);
        $lg_address = mysqli_real_escape_string($db, $_POST['lg_address']);

        $db->query("UPDATE `location_godown` SET lg_bid='$lg_bid', lg_name='$lg_name', lg_address='$lg_address'  WHERE lg_id = '$lg_id'");

        $_SESSION['errormsg'] = $lg_name . ' updated successfully.';
        $_SESSION['errorValue'] = 'success';
        header("Location: ../location-godown");

        break;
    case 'deleteState':
        $lg_id = $_REQUEST['lg_id'];
        // $db->query("DELETE from state where `lg_id`='$lg_id'");
        $_SESSION['errormsg'] = 'State deleted';
        $_SESSION['errorValue'] = 'success';
        header("Location: ../location-godown");
        break;
    case 'Disable':
        $lg_id = $_REQUEST['lg_id'];
        $db->query("UPDATE location_godown SET lg_sts='2' WHERE lg_id = '$lg_id'");
        $_SESSION['errormsg'] = 'Sucessfully disabled.';
        $_SESSION['errorValue'] = 'success';
        header("Location: ../location-godown");
        break;
    case 'Enable':
        $lg_id = $_REQUEST['lg_id'];
        $db->query("UPDATE location_godown SET lg_sts='1' WHERE lg_id = '$lg_id'");
        $_SESSION['errormsg'] = 'Sucessfully enabled.';
        $_SESSION['errorValue'] = 'success';
        header("Location: ../location-godown");
        break;
    default:
        $_SESSION['errormsg'] = 'Invalid page access.';
        $_SESSION['errorValue'] = 'warning';
        header("Location: ../404");
}
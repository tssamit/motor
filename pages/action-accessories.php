<?php
session_start();
require_once '../config/config.php';
require_once '../config/helper.php';
$action = $_REQUEST['submit'];
switch ($action) {
    case 'addaccessories':
        $acc_name = mysqli_real_escape_string($db, $_POST['acc_name']);
        $acc_sale_price = mysqli_real_escape_string($db, $_POST['acc_sale_price']);
        $acc_dealer_price = mysqli_real_escape_string($db, $_POST['acc_dealer_price']);
        $acc_mandatory = mysqli_real_escape_string($db, $_POST['acc_mandatory']);
        $results = $db->query("SELECT * FROM `accessories` WHERE acc_name='$acc_name'");
        if ($results->num_rows > 0) {
            $_SESSION['errormsg'] = ' already exist.';
            $_SESSION['errorValue'] = 'warning';
            header("Location: ../accessories");
        } else {
            $db->query("INSERT INTO `accessories` (`acc_id`, `acc_name`, `acc_sale_price`, `acc_dealer_price`, `acc_mandatory`, `acc_sts`) VALUES (NULL, '$acc_name', '$acc_sale_price', '$acc_dealer_price', '$acc_mandatory', '1')");
            $_SESSION['errormsg'] = ' added successfully.';
            $_SESSION['errorValue'] = 'success';
            header("Location: ../accessories");
        }
        break;
    case 'updateaccessories':
        $acc_id = $_POST['acc_id'];
        $acc_name = mysqli_real_escape_string($db, $_POST['acc_name']);
        $acc_sale_price = mysqli_real_escape_string($db, $_POST['acc_sale_price']);
        $acc_dealer_price = mysqli_real_escape_string($db, $_POST['acc_dealer_price']);
        $acc_mandatory = mysqli_real_escape_string($db, $_POST['acc_mandatory']);
        $db->query("UPDATE `accessories` SET acc_name='$acc_name', acc_sale_price='$acc_sale_price', acc_dealer_price='$acc_dealer_price', acc_mandatory='$acc_mandatory' WHERE acc_id = '$acc_id'");
        $_SESSION['errormsg'] = ' updated successfully.';
        $_SESSION['errorValue'] = 'success';
        header("Location: ../accessories");
        break;
    case 'deleteState':
        $acc_id = $_REQUEST['acc_id'];
        // $db->query("DELETE from accessories where `acc_id`='$acc_id'");
        $_SESSION['errormsg'] = 'State deleted';
        $_SESSION['errorValue'] = 'success';
        header("Location: ../accessories");
        break;
    case 'Disable':
        $acc_id = $_REQUEST['acc_id'];
        $db->query("UPDATE accessories SET acc_sts='2' WHERE acc_id = '$acc_id'");
        $_SESSION['errormsg'] = 'Sucessfully disabled.';
        $_SESSION['errorValue'] = 'success';
        header("Location: ../accessories");
        break;
    case 'Enable':
        $acc_id = $_REQUEST['acc_id'];
        $db->query("UPDATE accessories SET acc_sts='1' WHERE acc_id = '$acc_id'");
        $_SESSION['errormsg'] = 'Sucessfully enabled.';
        $_SESSION['errorValue'] = 'success';
        header("Location: ../accessories");
        break;
    default:
        $_SESSION['errormsg'] = 'Invalid page access.';
        $_SESSION['errorValue'] = 'warning';
        header("Location: ../404");
}

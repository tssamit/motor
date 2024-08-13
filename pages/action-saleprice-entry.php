<?php
session_start();
require_once '../config/config.php';
require_once '../config/helper.php';
$action = $_REQUEST['submit'];
switch ($action) {
    case 'addsalep':
        
        $sp_vcid = mysqli_real_escape_string($db, $_POST['sp_vcid']);
        $sp_vmid = mysqli_real_escape_string($db, $_POST['sp_vmid']);
        $sp_vclid = mysqli_real_escape_string($db, $_POST['sp_vclid']); 
        $sp_sale_dt = mysqli_real_escape_string($db, $_POST['sp_sale_dt']);
        $sp_dealer_price = mysqli_real_escape_string($db, $_POST['sp_dealer_price']);
        $sp_sale_price = mysqli_real_escape_string($db, $_POST['sp_sale_price']);
        $td_dt = date("Y-m-d H:i");
        $results = $db->query("SELECT * FROM `sale_price` WHERE sp_vclid='$sp_vclid' AND sp_sale_dt='$sp_sale_dt'");
        if ($results->num_rows > 0) {
            $_SESSION['errormsg'] = 'Already exist.';
            $_SESSION['errorValue'] = 'warning';
            header("Location: ../sale-price-entry");
        } else {
           $db->query("INSERT INTO `sale_price` (`sp_id`, `sp_vcid`, `sp_vmid`, `sp_vclid`, `sp_sale_dt`, `sp_dealer_price`, `sp_sale_price`, `sp_sts`) VALUES (NULL, '$sp_vcid', '$sp_vmid', '$sp_vclid', '$sp_sale_dt', '$sp_dealer_price', '$sp_sale_price', '1')");


            $_SESSION['errormsg'] = 'Added successfully.';
            $_SESSION['errorValue'] = 'success';
            header("Location: ../sale-price-entry");
        }
        break;
    case 'updatesalep':
        $sp_id = $_POST['sp_id'];
        $sp_vcid = mysqli_real_escape_string($db, $_POST['sp_vcid']);
        $sp_vmid = mysqli_real_escape_string($db, $_POST['sp_vmid']);
        $sp_vclid = mysqli_real_escape_string($db, $_POST['sp_vclid']); 
        $sp_sale_dt = mysqli_real_escape_string($db, $_POST['sp_sale_dt']);
        $sp_dealer_price = mysqli_real_escape_string($db, $_POST['sp_dealer_price']);
        $sp_sale_price = mysqli_real_escape_string($db, $_POST['sp_sale_price']);

    
            $db->query("UPDATE `sale_price` SET sp_vcid='$sp_vcid', sp_vmid='$sp_vmid', sp_vclid='$sp_vclid', sp_sale_dt='$sp_sale_dt', sp_dealer_price='$sp_dealer_price', sp_sale_price='$sp_sale_price'  WHERE sp_id = '$sp_id'");

            $_SESSION['errormsg'] ='Updated successfully.';
            $_SESSION['errorValue'] = 'success';
            header("Location: ../sale-price-entry");
       
        break;
    case 'deleteState':
        $sp_id = $_REQUEST['sp_id'];
        // $db->query("DELETE from state where `sp_id`='$sp_id'");
        $_SESSION['errormsg'] = 'State deleted';
        $_SESSION['errorValue'] = 'success';
        header("Location: ../sale-price-entry");
        break;
    case 'Disable':
        $sp_id = $_REQUEST['sp_id'];
        $db->query("UPDATE sale_price SET sp_sts='2' WHERE sp_id = '$sp_id'");
        $_SESSION['errormsg'] = 'Sucessfully disabled.';
        $_SESSION['errorValue'] = 'success';
        header("Location: ../sale-price-entry");
        break;
    case 'Enable':
        $sp_id = $_REQUEST['sp_id'];
        $db->query("UPDATE sale_price SET sp_sts='1' WHERE sp_id = '$sp_id'");
        $_SESSION['errormsg'] = 'Sucessfully enabled.';
        $_SESSION['errorValue'] = 'success';
        header("Location: ../sale-price-entry");
        break;
    default:
        $_SESSION['errormsg'] = 'Invalid page access.';
        $_SESSION['errorValue'] = 'warning';
        header("Location: ../404");
}
<?php
session_start();
require_once '../config/config.php';
require_once '../config/helper.php';
$action = $_REQUEST['submit'];
switch ($action) {
    case 'addProduct':
        $vp_bid = mysqli_real_escape_string($db, $_POST['vp_bid']);
        $vp_lgid = mysqli_real_escape_string($db, $_POST['vp_lgid']);
        $vp_vcid = mysqli_real_escape_string($db, $_POST['vp_vcid']);
        $vp_vmid = mysqli_real_escape_string($db, $_POST['vp_vmid']);
        $vp_vclid = mysqli_real_escape_string($db, $_POST['vp_vclid']);
        $vp_pfid = mysqli_real_escape_string($db, $_POST['vp_pfid']);
        $vp_dt = mysqli_real_escape_string($db, $_POST['vp_dt']);

        $vp_frame_no = $_POST['vp_frame_no'];
        $vp_engine_no = $_POST['vp_engine_no'];
        $vp_purchase_price = $_POST['vp_purchase_price'];
        $vp_price = $_POST['vp_price'];
        $vp_gst_rate = $_POST['vp_gst_rate'];
        $vp_pur_tax_price = $_POST['vp_pur_tax_price'];

        // Insert each row
        for ($i = 0; $i < count($vp_frame_no); $i++) {
            $vp_frame_no1 = $vp_frame_no[$i];
            $vp_engine_no1 = $vp_engine_no[$i];
            $vp_purchase_price1 = $vp_purchase_price[$i];
            $vp_price1 = $vp_price[$i];
            $vp_gst_rate1 = $vp_gst_rate[$i];
            $vp_pur_tax_price1 = $vp_pur_tax_price[$i];
            //   echo "INSERT INTO `veh_product` (`vp_id`, `vp_bid`, `vp_lgid`, `vp_vcid`, `vp_vmid`, `vp_vclid`, `vp_pfid`, `vp_frame_no`, `vp_engine_no`, `vp_purchase_price`, `vp_price`, `vp_gst_rate`, `vp_pur_tax_price`, `vp_dt`, `vp_sts`) VALUES (NULL, , '$vp_bid', '$vp_lgid', '$vp_vcid', '$vp_vmid', '$vp_vclid', '$vp_pfid', '$vp_frame_no1', '$vp_engine_no1', '$vp_purchase_price1', '$vp_price1', '$vp_gst_rate1', '$vp_pur_tax_price1', '$vp_dt', '1')";
            $db->query("INSERT INTO `veh_product` (`vp_id`, `vp_bid`, `vp_lgid`, `vp_vcid`, `vp_vmid`, `vp_vclid`, `vp_pfid`, `vp_frame_no`, `vp_engine_no`, `vp_purchase_price`, `vp_price`, `vp_gst_rate`, `vp_pur_tax_price`, `vp_dt`, `vp_sts`) VALUES (NULL, '$vp_bid', '$vp_lgid', '$vp_vcid', '$vp_vmid', '$vp_vclid', '$vp_pfid', '$vp_frame_no1', '$vp_engine_no1', '$vp_purchase_price1', '$vp_price1', '$vp_gst_rate1', '$vp_pur_tax_price1', '$vp_dt', '1')");
        }
        //   exit;

        $_SESSION['errormsg'] = ' added successfully.';
        $_SESSION['errorValue'] = 'success';
        header("Location: ../veh-product");

        break;
    case 'updateProduct':
        $vp_id = $_POST['vp_id'];
        $vp_bid = mysqli_real_escape_string($db, $_POST['vp_bid']);
        $vp_lgid = mysqli_real_escape_string($db, $_POST['vp_lgid']);
        $vp_vcid = mysqli_real_escape_string($db, $_POST['vp_vcid']);
        $vp_code = mysqli_real_escape_string($db, $_POST['vp_code']);

        // $db->query("UPDATE `veh_product` SET vp_bid='$vp_bid', vp_lgid='$vp_lgid', vp_vcid='$vp_vcid'  WHERE vp_id = '$vp_id' ");
        $_SESSION['errormsg'] = ' updated successfully.';
        $_SESSION['errorValue'] = 'success';
        header("Location: ../veh-product");

        break;
    case 'deleteDistrict':
        $vp_id = $_REQUEST['vp_id'];
        // $db->query("DELETE from veh_product where `vp_id`='$vp_id'");
        $_SESSION['errormsg'] = 'District deleted';
        $_SESSION['errorValue'] = 'success';
        header("Location: ../veh-product");
        break;
    case 'Disable':
        $vp_id = $_REQUEST['vp_id'];
        $db->query("UPDATE veh_product SET vp_sts='2' WHERE vp_id = '$vp_id'");
        $_SESSION['errormsg'] = 'Sucessfully disabled.';
        $_SESSION['errorValue'] = 'success';
        header("Location: ../veh-product");
        break;
    case 'Enable':
        $vp_id = $_REQUEST['vp_id'];
        $db->query("UPDATE veh_product SET vp_sts='1' WHERE vp_id = '$vp_id'");
        $_SESSION['errormsg'] = 'Sucessfully enabled.';
        $_SESSION['errorValue'] = 'success';
        header("Location: ../veh-product");
        break;
    default:
        $_SESSION['errormsg'] = 'Invalid page access.';
        $_SESSION['errorValue'] = 'warning';
        header("Location: ../404");
}
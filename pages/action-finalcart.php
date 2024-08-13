<?php
session_start();
require_once '../config/config.php';
require_once '../config/helper.php';
$action = $_REQUEST['submit'];
$sid = session_id();
switch ($action) {
    case 'OrderApprove':
        $od_id = mysqli_real_escape_string($db, $_POST['od_id']);
        $orderstatus = mysqli_real_escape_string($db, $_POST['orderstatus']);
        $od_dt = date('Y-m-d H:i:s');
        $db->query("UPDATE `order_dealer` SET `od_sts` = '$orderstatus' WHERE `od_id` = '$od_id'");
        $totalprice = 0;
        $total_assecory = 0;
        $dataorder1 = $db->query("SELECT * FROM `order_dealer_dtl` WHERE odl_odid = '$od_id'");
        while ($valueodr1 = $dataorder1->fetch_object()) {
            $totalprice += $valueodr1->odl_qty * $valueodr1->odl_dealer_price;
            $resultsnavd2 = $db->query("SELECT * FROM accessories WHERE acc_sts = '1' AND acc_id IN ($valueodr1->odl_vc_accessory)");
            while ($datanav2 = $resultsnavd2->fetch_object()) {
                $total_assecory += $datanav2->acc_dealer_price * $valueodr1->odl_qty;
            }
            $db->query("UPDATE `order_dealer_dtl` SET `odl_total_accessory` = '$total_assecory' WHERE `odl_id` = '$valueodr1->odl_id'");
        }
        $db->query("UPDATE `order_dealer` SET `od_total_price` = '$totalprice', `od_accessory_price`='$total_assecory' WHERE `od_id` = '$od_id'");
        $_SESSION['errormsg'] = ' added successfully.';
        $_SESSION['errorValue'] = 'success';
        header("Location: ../all-order-list");
        break;
    default:
        $_SESSION['errormsg'] = 'Invalid page access.';
        $_SESSION['errorValue'] = 'warning';
        header("Location: ../404");
}

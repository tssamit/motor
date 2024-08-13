<?php
session_start();
require_once '../config/config.php';
require_once '../config/helper.php';
$action = $_REQUEST['submit'];
$sid = session_id();
switch ($action) {
    case 'atttempcart':

        $aid = mysqli_real_escape_string($db, $_POST['aid']);
        $t_qty = mysqli_real_escape_string($db, $_POST['t_qty']);
        $t_vpid = mysqli_real_escape_string($db, $_POST['t_vpid']);
        $tcd_dt = date('Y-m-d H:i:s');

        $results = $db->query("SELECT * FROM `temp_cartdealer` WHERE tcd_aid='$aid' AND tcd_vpid='$t_vpid' AND tcd_sesID='$sid'");
        if ($results->num_rows > 0) {
            $_SESSION['errormsg'] = ' already exist.';
            $_SESSION['errorValue'] = 'warning';
            header("Location: ../dealer-product-list");
        } else {
            $db->query("INSERT INTO `temp_cartdealer` (`tcd_id`, `tcd_aid`, `tcd_qty`, `tcd_vpid`, `tcd_dt`, `tcd_sesID`) VALUES (NULL, '$aid', '$t_qty', '$t_vpid', '$tcd_dt', '$sid')");
            $_SESSION['errormsg'] = ' added successfully.';
            $_SESSION['errorValue'] = 'success';
            header("Location: ../dealer-product-list");
        }
        break; 
        case 'PlaceOrder':

        $aid = mysqli_real_escape_string($db, $_POST['aid']);
      
        $od_dt = date('Y-m-d H:i:s');
        $db->query("INSERT INTO `order_dealer` (`od_id`, `od_dealer_aid`, `od_dt`, `od_sts`) VALUES (NULL, '$aid', '$od_dt', '2')");
        $odid = $db->insert_id;


        $datatemp = $db->query("SELECT * FROM `temp_cartdealer` WHERE tcd_aid = '$aid'");
        while ($valuetemp = $datatemp->fetch_object()) {
            $data1 = $db->query("SELECT * FROM `veh_product` vp JOIN  `branch` b ON vp.`vp_bid` = b.`b_id` JOIN`location_godown` lg ON vp.`vp_lgid` = lg.`lg_id` JOIN `veh_category` vc ON vp.`vp_vcid` = vc.`vc_id` JOIN `veh_model` vm ON vp.`vp_vmid` = vm.`vm_id` JOIN `veh_color` vcl ON vp.`vp_vclid` = vcl.`vcl_id` JOIN `plant_factory` pf ON vp.`vp_pfid` = pf.`pf_id` WHERE vp_id='$valuetemp->tcd_vpid'");
            $value1 = $data1->fetch_object();
            // calculate sale price & dealer price from sale_price table which is latest till today
            $dataprice = $db->query("SELECT * FROM `sale_price` WHERE `sp_sale_dt` = CURRENT_DATE OR `sp_sale_dt` = (SELECT MAX(`sp_sale_dt`) FROM `sale_price` WHERE `sp_sale_dt` <= CURRENT_DATE) AND sp_sts='1' AND sp_vmid ='$value1->vm_id' AND sp_vclid='$value1->vcl_id' ORDER BY sp_id DESC LIMIT 1");
            if ($dataprice->num_rows > 0) {
                $valueamnt = $dataprice->fetch_object();
                $saleprice = $valueamnt->sp_sale_price;
                $dealerprice = $valueamnt->sp_dealer_price;
            } else {
                $saleprice = 0;
                $dealerprice = 0;
            }
            $odl_vpid = $valuetemp->tcd_vpid;
            $odl_vcid = $value1->vc_id;
            $odl_vc_accessory = $value1->vc_accessory;
            $odl_qty = $valuetemp->tcd_qty;
            $odl_dealer_price = $dealerprice;

            $odl_total_accessory = 0;

            $db->query("INSERT INTO `order_dealer_dtl` (`odl_id`, `odl_odid`, `odl_vpid`, `odl_vcid`, `odl_vc_accessory`, `odl_qty`, `odl_dealer_price`, `odl_total_accessory`, `odl_sts`) VALUES (NULL, '$odid', '$odl_vpid', '$odl_vcid', '$odl_vc_accessory', '$odl_qty', '$odl_dealer_price', '$odl_total_accessory', '1')");

            $db->query("DELETE FROM `temp_cartdealer` WHERE tcd_aid = '$aid'");

        }

     
            $_SESSION['errormsg'] = ' added successfully.';
            $_SESSION['errorValue'] = 'success';
         header("Location: ../dealer-order-invoice?odid=$odid");
       
        break;
    
    default:
        $_SESSION['errormsg'] = 'Invalid page access.';
        $_SESSION['errorValue'] = 'warning';
        header("Location: ../404");
}

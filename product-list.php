<?php
session_start();
require_once 'config/config.php';
require_once 'config/helper.php';
require_once 'config/chkAuth.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Vehicle Product-<?= date('d-m-Y-His'); ?></title>
    <meta name="description" content="Transport Management">
    <meta name="keywords" content="Transport Management, transport, vehicle">
    <?php require_once 'header.php'; ?>
</head>
<!--  HOW TO USE:
      data-theme: default (default), dark, light, colored
      data-layout: fluid (default), boxed
      data-sidebar-position: left (default), right
      data-sidebar-layout: default (default), compact-->
<?php
switch ($_SESSION['LOGAUTHType']) {
    case "1":
        $datatheme = 'light';
        break;
    case "3":
    case "5":
        $datatheme = 'colored';
        break;
    case "2":
    case "4":
        $datatheme = 'default';
        break;
    default:
        $datatheme = 'default';
}
?>
<body data-theme="<?= $datatheme; ?>" data-layout="fluid" data-sidebar-position="left" data-sidebar-layout="default">
    <div class="wrapper">
        <?php require_once 'sidenav.php'; ?>
        <div class="main">
            <?php require_once 'topnav.php'; ?>
            <main class="content">
                <div class="container-fluid p-0">
                    <div class="row mb-2">
                        <?php include_once 'errormsg.php'; ?>
                    </div>
                    <div class="row mb-2 mb-xl-3">
                        <div class="col-auto d-none d-sm-block">
                            <h3> Vehicle Product List</h3>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <i class="fas fa-chart-bar me-1"></i>
                                    List of Products
                                </div>
                                <div class="card-body">
                                    <table class="table dt-responsive" id="dataTable" style="font-size: 12px;">
                                        <thead>
                                            <tr>
                                                <th class="no-sort">#</th>
                                                <th>Color</th>
                                                <th>Model</th>
                                                <th>Category</th>
                                                <th>Dealer Price</th>
                                                <th>Sale Price</th>
                                                <th>Total Stock</th>
                                                <th>Location</th>
                                                <th>Factory</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $sl = 0;
                                            $data = $db->query("SELECT *, COUNT(`vp_vclid`) AS vstock FROM `veh_product` vp JOIN  `branch` b ON vp.`vp_bid` = b.`b_id` JOIN`location_godown` lg ON vp.`vp_lgid` = lg.`lg_id` JOIN `veh_category` vc ON vp.`vp_vcid` = vc.`vc_id` JOIN `veh_model` vm ON vp.`vp_vmid` = vm.`vm_id` JOIN `veh_color` vcl ON vp.`vp_vclid` = vcl.`vcl_id` JOIN `plant_factory` pf ON vp.`vp_pfid` = pf.`pf_id` GROUP BY `vp_vclid` ORDER BY vp_id DESC");
                                            
                                            
                                            while ($value = $data->fetch_object()) {
                                                // calculate sale price & dealer price from sale_price table which is latest till today
                                                $dataprice = $db->query("SELECT * FROM `sale_price` WHERE `sp_sale_dt` = CURRENT_DATE OR `sp_sale_dt` = (SELECT MAX(`sp_sale_dt`) FROM `sale_price` WHERE `sp_sale_dt` <= CURRENT_DATE) AND sp_sts='1' AND sp_vmid ='$value->vm_id' AND sp_vclid='$value->vcl_id' ORDER BY sp_id DESC LIMIT 1");
                                                if ($dataprice->num_rows > 0) {
                                                    $valueamnt = $dataprice->fetch_object();
                                                    $saleprice = $valueamnt->sp_sale_price;
                                                    $dealerprice = $valueamnt->sp_dealer_price;
                                                } else {
                                                    $saleprice = 0;
                                                    $dealerprice = 0;
                                                }
                                          //   echo "SELECT COUNT(`odl_qty`) AS totalQty FROM `order_dealer_dtl` odl JOIN `order_dealer` od ON odl.`odl_odid`= od.`od_id` WHERE od.`od_sts` = '1' AND odl.`odl_vpid` = '$value->vp_id'";
                                            $totalQty = $db->query("SELECT COUNT(`odl_qty`) AS totalQty FROM `order_dealer_dtl` odl JOIN `order_dealer` od ON odl.`odl_odid`= od.`od_id` WHERE od.`od_sts` = '1' AND odl.`odl_vpid` = '$value->vp_id'")->fetch_object()->totalQty;
                                            if($totalQty == 0){
                                                $totalQty = 0;
                                            }
                                                $sl++;
                                            ?>
                                                <tr>
                                                    <td>
                                                        <?= $sl; ?>
                                                    </td>
                                                    <td>
                                                        <?= $value->vcl_name; ?>
                                                    </td>
                                                    <td>
                                                        <?= $value->vm_model; ?> - <?= $value->vm_series; ?>
                                                    </td>
                                                    <td>
                                                        <?= $value->vc_name; ?>
                                                    </td>
                                                    <td>
                                                        <?= $dealerprice; ?>
                                                    </td>
                                                    <td>
                                                        <?= $saleprice; ?>
                                                    </td>
                                                    <td>
                                                        <?= $value->vstock - $totalQty; ?>
                                                    </td>
                                                    <td>
                                                        <?= $value->lg_name; ?>
                                                    </td>
                                                    <td>
                                                        <?= $value->pf_name; ?>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <?php require_once 'footer.php'; ?>
</body>
</html>
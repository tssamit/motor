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
                            <h3> Dealer Oder Invoice</h3>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <i class="fas fa-chart-bar me-1"></i>
                                    Order Invoice
                                </div>
                                <div class="card-body">
                                    <?php
                                    if (!empty($_GET['odid'])) {
                                        $odid = $_GET['odid'];
                                        $data = $db->query("SELECT * FROM `order_dealer` WHERE od_id='$odid'");
                                        $value = $data->fetch_object();
                                        $datadealer = $db->query("SELECT * FROM `admin` WHERE a_id='$value->od_dealer_aid'");
                                        $rowdealer = $datadealer->fetch_object();
                                    ?>
                                        <div class="row justify-content-center">
                                            <div class="col-12 col-lg-9 col-xl-8 col-xxl-7">
                                                <div class="row gy-3 mb-3">
                                                    <div class="col-6">
                                                        <h2 class="text-uppercase text-endx m-0">Invoice </h2>
                                                    </div>
                                                    <div class="col-6">
                                                        <a class="d-block text-end" href="#!">
                                                            <img src="./img/logo.png" class="img-fluid" alt=" Logo" width="135" height="44">
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row justify-content-center">
                                            <div class="col-12 col-lg-9 col-xl-8 col-xxl-7">
                                                <div class="row gy-3 mb-3">
                                                    <div class="col-6">
                                                        <h5 class="text-endx m-0">Date: <?= date('d-m-Y', strtotime($value->od_dt)); ?></h5>
                                                    </div>
                                                    <div class="col-6">
                                                        <a class="d-block text-end" href="#!">
                                                            <h5 class=" text-endx m-0">Invoice No: <?= 'M/' . str_pad($value->od_id, 5, '0', STR_PAD_LEFT); ?> </h5>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <table class="table dt-responsive" style="font-size: 12px;">
                                            <thead>
                                                <tr>
                                                    <th class="no-sort">#</th>
                                                    <th class="no-sort">Model</th>
                                                    <th class="no-sort">Color</th>
                                                    <th class="no-sort">QTY</th>
                                                    <th class="no-sort">Price</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $s = 0;
                                                $totalprice = 0;
                                                $dataorder = $db->query("SELECT * FROM `order_dealer_dtl` WHERE odl_odid = '$value->od_id'");
                                                while ($valueodr = $dataorder->fetch_object()) {
                                                    $data1 = $db->query("SELECT * FROM `veh_product` vp JOIN  `branch` b ON vp.`vp_bid` = b.`b_id` JOIN`location_godown` lg ON vp.`vp_lgid` = lg.`lg_id` JOIN `veh_category` vc ON vp.`vp_vcid` = vc.`vc_id` JOIN `veh_model` vm ON vp.`vp_vmid` = vm.`vm_id` JOIN `veh_color` vcl ON vp.`vp_vclid` = vcl.`vcl_id` JOIN `plant_factory` pf ON vp.`vp_pfid` = pf.`pf_id` WHERE vp_id='$valueodr->odl_vpid'");
                                                    $value1 = $data1->fetch_object();
                                                    // calculate sale price & dealer price from sale_price table which is latest till today
                                                    $dataprice = $db->query("SELECT * FROM `sale_price`WHERE `sp_sale_dt` = CURRENT_DATE OR `sp_sale_dt` = (SELECT MAX(`sp_sale_dt`) FROM `sale_price` WHERE `sp_sale_dt` <= CURRENT_DATE) AND sp_sts='1' AND sp_vmid ='$value1->vm_id' AND sp_vclid='$value1->vcl_id' ORDER BY sp_id DESC LIMIT 1");
                                                    if ($dataprice->num_rows > 0) {
                                                        $valueamnt = $dataprice->fetch_object();
                                                        $saleprice = $valueamnt->sp_sale_price;
                                                        $dealerprice = $valueamnt->sp_dealer_price;
                                                    } else {
                                                        $saleprice = 0;
                                                        $dealerprice = 0;
                                                    }
                                                    $s++;
                                                ?>
                                                    <tr>
                                                        <td><?= $s; ?></td>
                                                        <td><?= $value1->vm_model; ?></td>
                                                        <td><?= $value1->vcl_name; ?></td>
                                                        <td><?= $valueodr->odl_qty; ?></td>
                                                        <td><?= $totalprice += $valueodr->odl_qty * $valueodr->odl_dealer_price; ?></td>
                                                    </tr>
                                                <?php } ?>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Accessory Name</th>
                                                    <th>Price</th>
                                                    <th>Qty</th>
                                                    <th>Amount</th>
                                                </tr>
                                                <?php
                                                $total_assecory = 0;
                                                $cnt = 0;
                                                $dataorder1 = $db->query("SELECT * FROM `order_dealer_dtl` WHERE odl_odid = '$value->od_id'");
                                                while ($valueodr1 = $dataorder1->fetch_object()) {
                                                    $resultsnavd2 = $db->query("SELECT * FROM accessories WHERE acc_sts = '1' AND acc_id IN ($valueodr1->odl_vc_accessory)");
                                                    while ($datanav2 = $resultsnavd2->fetch_object()) {
                                                        $cnt++;
                                                ?>
                                                        <tr>
                                                            <td><input type="checkbox" name="checkbox_id[]" class="checkval" title="Select to Add" <?php
                                                                                                                                                    if (!empty($valueodr1->odl_vc_accessory)) {
                                                                                                                                                        foreach (explode(',', $valueodr1->odl_vc_accessory) as $n) {
                                                                                                                                                            if ($n == $datanav2->acc_id) {
                                                                                                                                                                echo 'checked'; ?>
                                                                    onclick="return false;" onkeydown="return false;"
                                                                    <?php
                                                                                                                                                            }
                                                                                                                                                        }
                                                                                                                                                    }
                                                                    ?> value="<?= $datanav2->acc_id; ?>"> <?= $cnt; ?>. </td>
                                                            <td><?= $datanav2->acc_name; ?></td>
                                                            <td><?= $datanav2->acc_dealer_price; ?></td>
                                                            <td><?= $valueodr1->odl_qty; ?></td>
                                                            <td><?= $total_assecory += $datanav2->acc_dealer_price * $valueodr1->odl_qty; ?></td>

                                                        </tr>
                                                    <?php } ?>
                                                <?php } ?>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td align="right"><strong>Total:</strong></td>
                                                    <td><strong><?= $totalprice + $total_assecory; ?></strong></td>
                                                </tr>
                                        </table>
                                        <?php
                                        if ($rowuser->a_usertype == '1' || $rowuser->a_usertype == '2' || $rowuser->a_usertype == '4' AND $value->od_sts == '2') {
                                        ?>
                                            <form action="pages/action-finalcart.php" enctype="multipart/form-data" method="post">
                                                <div class="row">
                                                    <div class="col-sm-6 mb-3">
                                                        <div class="form-check">
                                                            <input type="radio" class="form-check-input" id="radio1" name="orderstatus" value="1" checked required>Order Approve
                                                            <label class="form-check-label" for="radio1"></label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input type="radio" class="form-check-input" id="radio2" name="orderstatus" value="0">Order Cancel
                                                            <label class="form-check-label" for="radio2"></label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="">
                                                    <input type="submit" value="Approve" class="btn btn-success">
                                                    <input type="hidden" name="od_id" value="<?= $value->od_id; ?>" />
                                                    <input type="hidden" name="submit" value="OrderApprove" />
                                                </div>
                                            </form>
                                        <?php } ?>
                                    <?php } else { ?>
                                        data not found
                                    <?php } ?>
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
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
                            <h3>Approved Order List</h3>
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
                                                <th>Dealer Name</th>
                                                <th>Invoice</th>
                                                <th>Date</th>
                                                <th>Vehicle Total Amnt.</th>
                                                <th>Accessory Total Amnt.</th>
                                                <th>Total</th>
                                                <th>Status</th>
                                                <th>View</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $totalamnt = 0;
                                            $sl = 0;
                                            $data = $db->query("SELECT * FROM `order_dealer` od JOIN admin a ON od.od_dealer_aid = a.a_id WHERE od_sts = '1'");
                                            while ($value = $data->fetch_object()) {
                                                $sl++;
                                              $totalamnt +=  $value->od_total_price + $value->od_accessory_price;
                                            ?>
                                                <tr>
                                                    <td>
                                                        <?= $sl; ?>
                                                    </td>
                                                    <td>
                                                        <?=$value->a_name; ?> - <?=$value->a_phone; ?>
                                                    </td> 
                                                    <td>
                                                        <?= 'M/' . str_pad($value->od_id, 5, '0', STR_PAD_LEFT); ?>
                                                    </td>
                                                    <td>
                                                        <?= date('d-m-Y', strtotime($value->od_dt)); ?>
                                                    </td>
                                                     <td>
                                                        <?= $value->od_total_price; ?>
                                                    </td> 
                                                    <td>
                                                        <?= $value->od_accessory_price; ?>
                                                    </td> 
                                                     <td>
                                                        <?= number_format($value->od_total_price + $value->od_accessory_price, 2,'.',''); ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                        if ($value->od_sts == 1) {
                                                            echo '<span class="badge bg-success">Approved</span>';
                                                        } else {
                                                            echo '<span class="badge bg-warning">Pending</span>';
                                                        }
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <a href="dealer-order-invoice.php?odid=<?= $value->od_id; ?>" class="btn btn-sm btn-primary">View</a>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th class="no-sort">#</th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th align="right">Total Sale Amount:</th>
                                                <th><?=number_format($totalamnt, 2,'.','');?></th>
                                                <th></th>
                                                <th></th>
                                            </tr>
                                        </tfoot>
                                                        
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
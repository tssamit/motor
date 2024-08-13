<?php
session_start();
require_once 'config/config.php';
require_once 'config/helper.php';
require_once 'config/chkAuth.php';
?><!DOCTYPE html>
<html lang="en">
    <head>
        <title>Vehicle List-<?= date('d-m-Y-His'); ?></title>
        <meta name="description" content="Transport Management">
        <meta name="keywords" content="Transport Management, transport, vehicle">
        <?php require_once 'header.php'; ?>

        <style>
            thead th {
                white-space: nowrap;
            }
        </style>
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
                                <h3> Vehicle List </h3>
                            </div>

                        </div>

                        <div class="row">

                            <div class="col-xl-12">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <i class="fas fa-chart-bar me-1"></i>
                                        List of Vehicle
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table id="example" class="table table-sm display responsive " style="width:100%; font-size: 12px;">
                                                <thead>
                                                    <tr>
                                                        <th class="no-sort">#</th>
    <!--                                                    <th class="no-sort">Action</th>-->

                                                        <th>Frame No</th>
                                                        <th>Engine No</th>
                                                        <th>MRP</th>
                                                        <th>GST Rate</th>
                                                        <th>Tax Price</th>
                                                        <th>Location</th>
                                                        <th>Factory</th>
                                                        <th>Series</th>
                                                        <th>Color</th>
                                                        <th>Model</th>
                                                        <th>Category</th>
                                                        <th>Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $sl = 0;
                                                    $data = $db->query("SELECT * FROM `veh_product` vp JOIN  `branch` b ON vp.`vp_bid` = b.`b_id` JOIN`location_godown` lg ON vp.`vp_lgid` = lg.`lg_id` JOIN `veh_category` vc ON vp.`vp_vcid` = vc.`vc_id` JOIN `veh_model` vm ON vp.`vp_vmid` = vm.`vm_id` JOIN `veh_color` vcl ON vp.`vp_vclid` = vcl.`vcl_id`JOIN `plant_factory` pf ON vp.`vp_pfid` = pf.`pf_id` ORDER BY vp_id DESC");
                                                    while ($value = $data->fetch_object()) {
                                                        $sl++;
                                                        ?>
                                                        <tr>
                                                            <td>
                                                                <?= $sl; ?>
                                                            </td>
        <!--                                                        <td>
                                                                <div class="btn-group">
                                                                    <button type="button" class="btn btn-secondary  btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                                                        <i class="fa fa-cog" aria-hidden="true"></i>
                                                                    </button>
                                                                    <ul class="dropdown-menu">
                                                                        <li><a class="dropdown-item" href="?vpid=</?= $value->vp_id; ?>">Edit</a></li>

                                                                    </ul>
                                                                </div>

                                                            </td>-->

                                                            <td>
                                                                <?= $value->vp_frame_no; ?>
                                                            </td>
                                                            <td>
                                                                <?= $value->vp_engine_no; ?>
                                                            </td>
                                                            <td>
                                                                <?= $value->vp_price; ?>
                                                            </td>
                                                            <td>
                                                                <?= $value->vp_gst_rate; ?>
                                                            </td>
                                                            <td>
                                                                <?= $value->vp_pur_tax_price; ?>
                                                            </td>
                                                            <td>
                                                                <?= $value->lg_name; ?>
                                                            </td>
                                                            <td>
                                                                <?= $value->pf_name; ?>
                                                            </td>
                                                            <td>
                                                                <?= $value->vm_series; ?>
                                                            </td>
                                                            <td>
                                                                <?= $value->vcl_name; ?>
                                                            </td>
                                                            <td>
                                                                <?= $value->vm_model; ?>
                                                            </td>
                                                            <td>
                                                                <?= $value->vc_name; ?>
                                                            </td>

                                                            <td>
                                                                <?php if ($value->vp_sts == '1') { ?>
                                                                    <a href="pages/action-veh-product.php?vp_id=<?= $value->vp_id; ?>&submit=Disable" onClick="return confirm('Are You Sure want to Disable??')" class="btn btn-warning btn-sm" title="click to Disable"> Active <span class="glyphicon glyphicon-refresh"></span></a>
                                                                <?php } else { ?>
                                                                    <a href="pages/action-veh-product.php?vp_id=<?= $value->vp_id; ?>&submit=Enable" onClick="return confirm('Are You Sure want to Enable??')" class="btn btn-primary btn-sm" title="click to Enable"> Disable <span class="glyphicon glyphicon-refresh"></span></a>
                                                                <?php } ?>
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
                    </div>
                </main>

            </div>
        </div>

        <?php require_once 'footer.php'; ?>

    </body>


</html>
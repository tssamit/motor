<?php
session_start();
require_once 'config/config.php';
require_once 'config/helper.php';
require_once 'config/chkAuth.php';
?><!DOCTYPE html>
<html lang="en">
    <head>
        <title> Branch</title>
        <meta name="description" content="Motor Management">
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
                                <h3> Vehicle Category </h3>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-xl-4">
                                <div class="card mb-4">

                                    <div class="card-body">
                                        <?php
                                        if (empty($_GET['vcid'])) {
                                            $vc_id = '';
                                        } else {
                                            $vc_id = $_GET['vcid'];
                                        }
                                        $results = $db->query("SELECT * FROM veh_category WHERE vc_id = '$vc_id'");
                                        $row = $results->fetch_object();
                                        ?>
                                        <form   action="pages/action-veh-category.php" enctype="multipart/form-data" method="post">

                                            <div class="col-sm-12">
                                                <label for="inputText" class="form-label">Category Name: <sup>*</sup></label>

                                                <input type="text" class="form-control input-sm" name="vc_name" value="<?php
                                                if (!empty($row->vc_name)) {
                                                    echo $row->vc_name;
                                                }
                                                ?>" placeholder="Category Name *"  required>

                                            </div>
                                            <div class="col-sm-12 mt-3">
                                                <label for="inputText" class="form-label">Accessory List: <sup>*</sup></label>

                                                <table  class="table table-striped table-bordered" style="width:100%; font-size: 11px;">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Accessory Name</th>
                                                            <th>Required</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $cnt = 0;
                                                        $resultsnavd2 = $db->query("SELECT * FROM accessories WHERE acc_sts = '1' ");
                                                        while ($datanav2 = $resultsnavd2->fetch_object()) {
                                                            $cnt++;
                                                            ?>
                                                            <tr>
                                                                <td><input type="checkbox" name="checkbox_id[]" class="checkval" title="Select to Add" <?php
                                                                    if (!empty($row->vc_accessory)) {
                                                                        foreach (explode(',', $row->vc_accessory) as $n) {
                                                                            if ($n == $datanav2->acc_id) {
                                                                                echo 'checked';
                                                                            }
                                                                        }
                                                                    }
                                                                    ?> value="<?= $datanav2->acc_id; ?>"> <?= $cnt; ?>. </td>

                                                                <td><?= $datanav2->acc_name; ?></td>
                                                                <td><?= $datanav2->acc_mandatory; ?></td>


                                                            </tr>
                                                        <?php } ?>
                                                        <tr>

                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>

                                            <br>
                                            <div class="text-center">
                                                <input type = "submit" value = "Submit" class = "btn btn-success" >
                                                <?php if (!empty($_REQUEST['vcid'])) { ?>
                                                    <input type="hidden" name="submit" value="updatecat"/>
                                                    <input type="hidden" name="vc_id" value="<?= $row->vc_id; ?>"/>
                                                <?php } else { ?>
                                                    <input type="hidden" name="submit" value="addcat"/>
                                                <?php } ?>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-8">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <i class="fas fa-chart-bar me-1"></i>
                                        List of Category
                                    </div>
                                    <div class="card-body">

                                        <table class="table dt-responsive" id="dataTable" style="font-size: 13px;">
                                            <thead>
                                                <tr>
                                                    <th class="no-sort">#</th>


                                                    <th>Vehicle Category</th>
                                                    <th>Accessory</th>

                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $sl = 0;
                                                $data = $db->query("SELECT * FROM `veh_category` ORDER BY vc_name ASC");
                                                while ($value = $data->fetch_object()) {
                                                    $sl++;
                                                    ?>
                                                    <tr>
                                                        <td>
                                                            <?= $sl; ?>
                                                        </td>


                                                        <td>
                                                            <?= $value->vc_name; ?>
                                                        </td>
                                                        <td><?php
                                                            $resultsnavd2 = $db->query("SELECT * FROM accessories WHERE acc_id IN ($value->vc_accessory) ");
                                                            while ($datanav2 = $resultsnavd2->fetch_object()) {
                                                                echo $datanav2->acc_name . ', ';
                                                            }
                                                            ?>
                                                        </td>


                                                        <td>
                                                            <?php if ($value->vc_sts == '1') { ?>
                                                                <a href="pages/action-veh-category?vc_id=<?= $value->vc_id; ?>&submit=Disable" onClick="return confirm('Are You Sure want to Disable??')" class="btn btn-warning btn-sm" title="click to Disable"> Active  <span class="glyphicon glyphicon-refresh"></span></a>
                                                            <?php } else { ?>
                                                                <a href="pages/action-veh-category?vc_id=<?= $value->vc_id; ?>&submit=Enable" onClick="return confirm('Are You Sure want to Enable??')" class="btn btn-primary btn-sm" title="click to Enable">Disable <span class="glyphicon glyphicon-refresh"></span></a>
                                                            <?php } ?>

                                                            <a class="btn btn-secondary  btn-sm" href="?vcid=<?= $value->vc_id; ?>" title="Edit">  <i class="fa fa-edit" aria-hidden="true"></i> </a>
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

                <!--                <footer class="footer">
                                    <div class="container-fluid">
                                        <div class="row text-muted">
                                            <div class="col-6 text-start">
                                                <p class="mb-0">
                                                    <a href="https://adminkit.io/" target="_blank" class="text-muted"><strong>AdminKit</strong></a> &copy;
                                                </p>
                                            </div>
                                            <div class="col-6 text-end">
                                                <ul class="list-inline">
                                                    <li class="list-inline-item">
                                                        <a class="text-muted" href="#">Support</a>
                                                    </li>
                                                    <li class="list-inline-item">
                                                        <a class="text-muted" href="#">Help Center</a>
                                                    </li>
                                                    <li class="list-inline-item">
                                                        <a class="text-muted" href="#">Privacy</a>
                                                    </li>
                                                    <li class="list-inline-item">
                                                        <a class="text-muted" href="#">Terms</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </footer>-->
            </div>
        </div>

        <?php require_once 'footer.php'; ?>

    </body>


</html>
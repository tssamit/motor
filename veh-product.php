<?php
session_start();
require_once 'config/config.php';
require_once 'config/helper.php';
require_once 'config/chkAuth.php';
?><!DOCTYPE html>
<html lang="en">
    <head>
        <title>Vehicle Product-<?= date('d-m-Y-His'); ?></title>
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
                                <h3> Vehicle Product </h3>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-xl-12">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <i class="fas fa-chart-area me-1"></i>
                                        Vehicle Product
                                    </div>
                                    <div class="card-body">
                                        <?php
                                        if (empty($_GET['vpid'])) {
                                            $vp_id = '';
                                        } else {
                                            $vp_id = $_GET['vpid'];
                                        }
                                        $results = $db->query("SELECT * FROM `veh_product` WHERE vp_id = '$vp_id'");
                                        $row = $results->fetch_object();
                                        ?>
                                        <form action="pages/action-veh-product.php" enctype="multipart/form-data" method="post">

                                            <div class=" col-xl-4" style=" float: left; padding-right: 10px;">
                                                <div class="mb-3">
                                                    <label class="form-label">Branch: <sup>*</sup></label>

                                                    <select class="form-select" name="vp_bid" id="vp_bid" required>
                                                        <option value="">Choose Branch</option>
                                                        <?php
                                                        $sqltb = $db->query("SELECT * FROM `branch` WHERE b_sts = '1'");
                                                        while ($querytb = $sqltb->fetch_object()) {
                                                            ?>
                                                            <option <?php
                                                            if (!empty($row->vp_bid)) {
                                                                if ($row->vp_bid == $querytb->b_id) {
                                                                    echo 'selected';
                                                                }
                                                            }
                                                            ?> value="<?= $querytb->b_id; ?>">
                                                                    <?= $querytb->b_name; ?>
                                                            </option>
                                                        <?php } ?>
                                                    </select>

                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label">Location/Godown: <sup>*</sup></label>

                                                    <select class="form-select" name="vp_lgid" id="vp_lgid" required>
                                                        <option value="">Choose Location/Godown</option>
                                                        <?php
                                                        if (!empty($row->vp_bid)) {

                                                            $sqlt1l = $db->query("select * from location_godown WHERE lg_bid = '$row->vp_bid'");
                                                            while ($queryt1l = $sqlt1l->fetch_object()) {
                                                                ?>
                                                                <option <?php
                                                                if ($row->vp_lgid == $queryt1l->lg_id) {
                                                                    echo 'selected';
                                                                }
                                                                ?> value="<?= $queryt1l->lg_id; ?>">
                                                                        <?= $queryt1l->lg_name; ?>
                                                                </option>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                    </select>

                                                </div>



                                                <div class="mb-3">
                                                    <label class="form-label">Category: <sup>*</sup></label>

                                                    <select class="form-select" name="vp_vcid" id="vp_vcid" required>
                                                        <option value="">Choose Category</option>
                                                        <?php
                                                        $sqlt = $db->query("SELECT * FROM `veh_category` WHERE vc_sts = '1'");
                                                        while ($queryt = $sqlt->fetch_object()) {
                                                            ?>
                                                            <option <?php
                                                            if (!empty($row->vp_vcid)) {
                                                                if ($row->vp_vcid == $queryt->vc_id) {
                                                                    echo 'selected';
                                                                }
                                                            }
                                                            ?> value="<?= $queryt->vc_id; ?>">
                                                                    <?= $queryt->vc_name; ?>
                                                            </option>
                                                        <?php } ?>
                                                    </select>

                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Model: <sup>*</sup></label>

                                                    <select class="form-select" name="vp_vmid" id="vp_vmid" required>
                                                        <option value="">Choose Model</option>
                                                        <?php
                                                        if (!empty($row->vp_vmid)) {

                                                            $sqlt1 = $db->query("select * from veh_model WHERE vm_vcid = '$row->vp_vcid'");
                                                            while ($queryt1 = $sqlt1->fetch_object()) {
                                                                ?>
                                                                <option <?php
                                                                if ($row->vp_vmid == $queryt1->vm_id) {
                                                                    echo 'selected';
                                                                }
                                                                ?> value="<?= $queryt1->vm_id; ?>">
                                                                        <?= $queryt1->vm_model; ?>
                                                                </option>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                    </select>

                                                </div>



                                                <div class="mb-3">
                                                    <label class="form-label">Color: <sup>*</sup></label>

                                                    <select class="form-select" name="vp_vclid" id="vp_vclid" required>
                                                        <option value="">Choose Color</option>
                                                        <?php
                                                        if (!empty($row->vp_vclid)) {

                                                            $sqlt1cl = $db->query("select * from veh_color WHERE vcl_vmid = '$row->vp_vmid'");
                                                            while ($queryt1cl = $sqlt1cl->fetch_object()) {
                                                                ?>
                                                                <option <?php
                                                                if ($row->vp_vclid == $queryt1cl->vcl_id) {
                                                                    echo 'selected';
                                                                }
                                                                ?> value="<?= $queryt1cl->vcl_id; ?>">
                                                                        <?= $queryt1cl->vcl_name; ?>
                                                                </option>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                    </select>

                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label">Plant/Factory: <sup>*</sup></label>

                                                    <select class="form-select" name="vp_pfid" id="vp_pfid" required>
                                                        <option value="">Choose Plant/Factory</option>
                                                        <?php
                                                        $sqltpf = $db->query("SELECT * FROM `plant_factory` WHERE pf_sts = '1'");
                                                        while ($querytpf = $sqltpf->fetch_object()) {
                                                            ?>
                                                            <option <?php
                                                            if (!empty($row->vp_pfid)) {
                                                                if ($row->vp_pfid == $querytpf->pf_id) {
                                                                    echo 'selected';
                                                                }
                                                            }
                                                            ?> value="<?= $querytpf->pf_id; ?>">
                                                                    <?= $querytpf->pf_name; ?>
                                                            </option>
                                                        <?php } ?>
                                                    </select>

                                                </div>

                                                <div class="mb-3">
                                                    <label for="inputText" class="form-label">Date: <sup>*</sup></label>

                                                    <input type="date" class="form-control input-sm" name="vp_dt" value="<?php
                                                    if (!empty($row->vp_dt)) {
                                                        echo $row->vp_dt;
                                                    }
                                                    ?>" placeholder=" Date *"  required>

                                                </div>


                                            </div>

                                            <div class=" col-xl-8" style=" float: right; padding-left: 10px;">


                                                <div id="inputContainer">
                                                    <label class="form-label">List of vehicle info <sup>*</sup></label>
                                                    <div class="row mb-3">
                                                        <div class="col">
                                                            <input type="text" class="form-control" name="vp_frame_no[]" value="" placeholder="Frame No *" required>
                                                        </div>
                                                        <div class="col">
                                                            <input type="text" class="form-control" name="vp_engine_no[]" value="" placeholder="Engine No *" required>
                                                        </div>
                                                        <div class="col">
                                                            <input type="number" class="form-control" step=".01" name="vp_purchase_price[]" value="" placeholder="Purchase Price *" required>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <div class="col">
                                                            <input type="number" class="form-control" step=".01" name="vp_price[]" value="" placeholder="MRP *" required>
                                                        </div>
                                                        <div class="col">
                                                            <input type="number" class="form-control" step=".01" name="vp_gst_rate[]" value="" placeholder="GST Rate *" required>
                                                        </div>
                                                        <div class="col">
                                                            <input type="number" class="form-control" step=".01" name="vp_pur_tax_price[]" value="" placeholder="Purchase Tax Price *" required>
                                                        </div>
                                                    </div>

                                                    <hr>
                                                </div>
                                                <button type="button" class = "btn btn-dark btn-sm" onclick="addMore()">Add More</button><br><br>



                                            </div>

                                            <div class=" clearfix   p-1"> </div>
                                            <div class="text-center">
                                                <input type = "submit" value = "Submit" class = "btn btn-success" >
                                                <?php if (!empty($_REQUEST['vpid'])) { ?>
                                                    <input type="hidden" name="submit" value="updateProduct"/>
                                                    <input type="hidden" name="vp_id" value="<?= $row->vp_id; ?>"/>
                                                <?php } else { ?>
                                                    <input type="hidden" name="submit" value="addProduct"/>
                                                <?php } ?>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>
                </main>

            </div>
        </div>

        <?php require_once 'footer.php'; ?>
        <script>
            function addMore() {
                const container = document.getElementById('inputContainer');
                const newFields = `
                                                       <div class="row mb-3">
                                                       <div class="col">
                                                           <input type="text" class="form-control" name="vp_frame_no[]" value="" placeholder="Frame No *" required>
                                                       </div>
                                                       <div class="col">
                                                           <input type="text" class="form-control" name="vp_engine_no[]" value="" placeholder="Engine No *" required>
                                                       </div>
                                                       <div class="col">
                                                           <input type="number" class="form-control" step=".01" name="vp_purchase_price[]" value="" placeholder="Purchase Price *" required>
                                                       </div>
                                                   </div>
                                                   <div class="row mb-3">
                                                       <div class="col">
                                                           <input type="number" class="form-control" step=".01" name="vp_price[]" value="" placeholder="MRP *" required>
                                                       </div>
                                                       <div class="col">
                                                            <input type="number" class="form-control" step=".01" name="vp_gst_rate[]" value="" placeholder="GST Rate *" required>
                                                        </div>
                                                        <div class="col">
                                                            <input type="number" class="form-control" step=".01" name="vp_pur_tax_price[]" value="" placeholder="Purchase Tax Price *" required>
                                                        </div>
                                                   </div><hr>
         `;
                container.insertAdjacentHTML('beforeend', newFields);
            }
        </script>
        <script type="text/javascript">
            $(document).ready(function () {
                $('#vp_vcid').on('change', function () {
                    var countryID = $(this).val();
                    //alert(countryID);
                    if (countryID) {
                        $.ajax({
                            type: 'POST',
                            url: 'ajax_model.php',
                            data: 'cid=' + countryID,
                            success: function (html) {
                                $('#vp_vmid').html(html);
                            }
                        });
                    } else {
                        $('#vp_vcid').html('<option value="">Choose Category</option>');
                    }
                });
            });
        </script>
        <script type="text/javascript">
            $(document).ready(function () {
                $('#vp_vmid').on('change', function () {
                    var color = $(this).val();
                    //alert(countryID);
                    if (color) {
                        $.ajax({
                            type: 'POST',
                            url: 'ajax_color.php',
                            data: 'cid=' + color,
                            success: function (html) {
                                $('#vp_vclid').html(html);
                            }
                        });
                    } else {
                        $('#vp_vmid').html('<option value="">Choose Model</option>');
                    }
                });
            });
        </script>
        <script type="text/javascript">
            $(document).ready(function () {
                $('#vp_bid').on('change', function () {
                    var vp_lgid = $(this).val();
                    //alert(countryID);
                    if (vp_lgid) {
                        $.ajax({
                            type: 'POST',
                            url: 'ajax_godown.php',
                            data: 'cid=' + vp_lgid,
                            success: function (html) {
                                $('#vp_lgid').html(html);
                            }
                        });
                    } else {
                        $('#vp_bid').html('<option value="">Choose Branch</option>');
                    }
                });
            });
        </script>

    </body>


</html>
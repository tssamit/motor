<?php
session_start();
require_once 'config/config.php';
require_once 'config/helper.php';
require_once 'config/chkAuth.php';
?><!DOCTYPE html>
<html lang="en">
    <head>
        <title>Vehicle Product-Sale-Entry-<?= date('d-m-Y-His'); ?></title>
        <meta name="description" content="Transport Management">
        <meta name="keywords" content="Transport Management, transport, vehicle">
        <?php require_once 'header.php'; ?>
        <link href="https://cdn.datatables.net/2.0.8/css/dataTables.dataTables.css" rel="stylesheet">
        <link href="https://cdn.datatables.net/buttons/3.0.2/css/buttons.dataTables.css" rel="stylesheet">
        <script src="https://cdn-script.com/ajax/libs/jquery/3.7.1/jquery.js"></script>
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
                                <h3> Sale Entry </h3>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-xl-12">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <i class="fas fa-chart-area me-1"></i>
                                       Sale Price Entry
                                    </div>
                                    <div class="card-body">
                                        <?php
                                        if (empty($_GET['spid'])) {
                                            $sp_id = '';
                                        } else {
                                            $sp_id = $_GET['spid'];
                                        }
                                        $results = $db->query("SELECT * FROM `sale_price` WHERE sp_id = '$sp_id'");
                                        $row = $results->fetch_object();
                                        ?>


                                        <div class=" col-xl-4" style=" float: left; padding-right: 10px;">
                                            <form action="pages/action-saleprice-entry.php" enctype="multipart/form-data" method="post">
                                        
                                                <div class="mb-3">
                                                    <label class="form-label">Category: <sup>*</sup></label>

                                                    <select class="form-select" name="sp_vcid" id="sp_vcid" required>
                                                        <option value="">Choose Category</option>
                                                        <?php
                                                        $sqlt = $db->query("SELECT * FROM `veh_category` WHERE vc_sts = '1'");
                                                        while ($queryt = $sqlt->fetch_object()) {
                                                            ?>
                                                            <option <?php
                                                            if (!empty($row->sp_vcid)) {
                                                                if ($row->sp_vcid == $queryt->vc_id) {
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

                                                    <select class="form-select" name="sp_vmid" id="sp_vmid" required>
                                                        <option value="">Choose Model</option>
                                                        <?php
                                                        if (!empty($row->sp_vmid)) {

                                                            $sqlt1 = $db->query("select * from veh_model WHERE vm_vcid = '$row->sp_vcid'");
                                                            while ($queryt1 = $sqlt1->fetch_object()) {
                                                                ?>
                                                                <option <?php
                                                                if ($row->sp_vmid == $queryt1->vm_id) {
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

                                                    <select class="form-select" name="sp_vclid" id="sp_vclid" required>
                                                        <option value="">Choose Color</option>
                                                        <?php
                                                        if (!empty($row->sp_vclid)) {

                                                            $sqlt1cl = $db->query("select * from veh_color WHERE vcl_vmid = '$row->sp_vmid'");
                                                            while ($queryt1cl = $sqlt1cl->fetch_object()) {
                                                                ?>
                                                                <option <?php
                                                                if ($row->sp_vclid == $queryt1cl->vcl_id) {
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
                                                    <label for="inputText" class="form-label"> Date: <sup>*</sup></label>

                                                    <input type="date" class="form-control input-sm" name="sp_sale_dt" value="<?php
                                                    if (!empty($row->sp_sale_dt)) {
                                                        echo $row->sp_sale_dt;
                                                    }
                                                    ?>" placeholder=" Date *"  required>

                                                </div>
                                                <div class="mb-3">
                                                    <label for="inputText" class="form-label">Dealer Price: <sup>*</sup></label>

                                                    <input type="text" class="form-control input-sm" name="sp_dealer_price" value="<?php
                                                    if (!empty($row->sp_dealer_price)) {
                                                        echo $row->sp_dealer_price;
                                                    }
                                                    ?>" placeholder=" Dealer Price *"  required>

                                                </div>
                                                <div class="mb-3">
                                                    <label for="inputText" class="form-label">Sale Price: <sup>*</sup></label>

                                                    <input type="text" class="form-control input-sm" name="sp_sale_price" value="<?php
                                                    if (!empty($row->sp_sale_price)) {
                                                        echo $row->sp_sale_price;
                                                    }
                                                    ?>" placeholder=" Sale Price *"  required>

                                                </div>

                                                <div class=" clearfix   p-1"> </div>
                                                <div class="text-center">
                                                    <input type = "submit" value = "Submit" class = "btn btn-success" >
                                                    <?php if (!empty($_REQUEST['spid'])) { ?>
                                                        <input type="hidden" name="submit" value="updatesalep"/>
                                                        <input type="hidden" name="sp_id" value="<?= $row->sp_id; ?>"/>
                                                    <?php } else { ?>
                                                        <input type="hidden" name="submit" value="addsalep"/>
                                                    <?php } ?>
                                                </div>
                                            </form>
                                        </div>

                                        <div class=" col-xl-8" style=" float: right; padding-left: 10px;">

                                            <div class="card mb-4">
                                                
                                                <div class="card-body">
                                                    <div class="table-responsive">
                                                        <table id="exampletable" class="table table-sm display responsive " style="width:100%; font-size: 12px;">
                                                            <thead>
                                                                <tr>
                                                                    <th class="no-sort">#</th>
    
                                                                    <th>Date</th>
                                                                    <th>Dealer</th>
                                                                    <th>Sale</th>
                                                                    <th>Color</th>
                                                                    <th>Model</th>
                                                                    <th>Category</th>
                                                                    <th>Status</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                $sl = 0;
                                                                $data = $db->query("SELECT * FROM `sale_price` sp JOIN `veh_category` vc ON sp.`sp_vcid` = vc.`vc_id` JOIN `veh_model` vm ON sp.`sp_vmid` = vm.`vm_id` JOIN `veh_color` vcl ON sp.`sp_vclid` = vcl.`vcl_id` ORDER BY sp_id DESC");
                                                                while ($value = $data->fetch_object()) {
                                                                    $sl++;
                                                                    ?>
                                                                    <tr>
                                                                        <td>
                                                                            <?= $sl; ?>
                                                                        </td>
                   
                                                                        <td>
                                                                        <?= $value->sp_sale_dt; ?>
                                                                        </td>
                                                                          <td>
                                                                        <?= $value->sp_dealer_price; ?>
                                                                        </td> 
                                                                        <td>
                                                                        <?= $value->sp_sale_price; ?>
                                                                        </td>
                                                                        <td>
                                                                            <?= $value->vcl_name; ?>
                                                                        </td>
                                                                        <td>
                                                                            <?= $value->vm_model; ?> <br>  (<?= $value->vm_series; ?>)
                                                                        </td>
                                                                        <td>
                                                                            <?= $value->vc_name; ?>
                                                                        </td>

                                                                        <td>
                                                                            <?php if ($value->sp_sts == '1') { ?>
                                                                                <a href="pages/action-saleprice-entry.php?sp_id=<?= $value->sp_id; ?>&submit=Disable" onClick="return confirm('Are You Sure want to Disable??')" class="btn btn-warning btn-sm" title="click to Disable"> Active <span class="glyphicon glyphicon-refresh"></span></a>
                                                                            <?php } else { ?>
                                                                                <a href="pages/action-saleprice-entry.php?sp_id=<?= $value->sp_id; ?>&submit=Enable" onClick="return confirm('Are You Sure want to Enable??')" class="btn btn-primary btn-sm" title="click to Enable"> Disable <span class="glyphicon glyphicon-refresh"></span></a>
                                                                            <?php } ?>
                                                                            <a class="btn btn-secondary btn-sm" href="?spid=<?= $value->sp_id; ?>">Edit</a>
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
                                                           <input type="text" class="form-control" name="sp_frame_no[]" value="" placeholder="Frame No *" required>
                                                       </div>
                                                       <div class="col">
                                                           <input type="text" class="form-control" name="sp_engine_no[]" value="" placeholder="Engine No *" required>
                                                       </div>
                                                       <div class="col">
                                                           <input type="number" class="form-control" step=".01" name="sp_purchase_price[]" value="" placeholder="Purchase Price *" required>
                                                       </div>
                                                   </div>
                                                   <div class="row mb-3">
                                                       <div class="col">
                                                           <input type="number" class="form-control" step=".01" name="sp_price[]" value="" placeholder="MRP *" required>
                                                       </div>
                                                       <div class="col">
                                                            <input type="number" class="form-control" step=".01" name="sp_gst_rate[]" value="" placeholder="GST Rate *" required>
                                                        </div>
                                                        <div class="col">
                                                            <input type="number" class="form-control" step=".01" name="sp_pur_tax_price[]" value="" placeholder="Purchase Tax Price *" required>
                                                        </div>
                                                   </div><hr>
         `;
                container.insertAdjacentHTML('beforeend', newFields);
            }
        </script>
        <script type="text/javascript">
            $(document).ready(function () {
                $('#sp_vcid').on('change', function () {
                    var countryID = $(this).val();
                    //alert(countryID);
                    if (countryID) {
                        $.ajax({
                            type: 'POST',
                            url: 'ajax_model.php',
                            data: 'cid=' + countryID,
                            success: function (html) {
                                $('#sp_vmid').html(html);
                            }
                        });
                    } else {
                        $('#sp_vcid').html('<option value="">Choose Category</option>');
                    }
                });
            });
        </script>
        <script type="text/javascript">
            $(document).ready(function () {
                $('#sp_vmid').on('change', function () {
                    var color = $(this).val();
                    //alert(countryID);
                    if (color) {
                        $.ajax({
                            type: 'POST',
                            url: 'ajax_color.php',
                            data: 'cid=' + color,
                            success: function (html) {
                                $('#sp_vclid').html(html);
                            }
                        });
                    } else {
                        $('#sp_vmid').html('<option value="">Choose Model</option>');
                    }
                });
            });
        </script>
        <script type="text/javascript">
            $(document).ready(function () {
                $('#sp_bid').on('change', function () {
                    var sp_lgid = $(this).val();
                    //alert(countryID);
                    if (sp_lgid) {
                        $.ajax({
                            type: 'POST',
                            url: 'ajax_godown.php',
                            data: 'cid=' + sp_lgid,
                            success: function (html) {
                                $('#sp_lgid').html(html);
                            }
                        });
                    } else {
                        $('#sp_bid').html('<option value="">Choose Branch</option>');
                    }
                });
            });
        </script>
        <script src="https://cdn.datatables.net/2.0.8/js/dataTables.js"></script>
        <script src="https://cdn.datatables.net/buttons/3.0.2/js/dataTables.buttons.js"></script>
        <script src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.dataTables.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
        <script src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.html5.min.js"></script>
        <script>
            new DataTable('#exampletable', {
                layout: {
                    topStart: {
                        // buttons: ['copyHtml5', 'excelHtml5', 'csvHtml5', 'pdfHtml5']
                        buttons: ['excelHtml5', 'pdfHtml5']
                    }
                },
                "pageLength": 50
            });
        </script>
    </body>


</html>
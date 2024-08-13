<?php
session_start();
require_once 'config/config.php';
require_once 'config/helper.php';
require_once 'config/chkAuth.php';
?><!DOCTYPE html>
<html lang="en">
    <head>
        <title>District</title>
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
                                <h3>  Vehicle Color </h3>
                            </div>
                            <!--
                                                        <div class="col-auto ms-auto text-end mt-n1">
                                                            <a href="#" class="btn btn-light bg-white me-2">Invite a Friend</a>
                                                            <a href="#" class="btn btn-primary">New Project</a>
                                                        </div>-->
                        </div>

                        <div class="row">
                            <div class="col-xl-4">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <i class="fas fa-chart-area me-1"></i>
                                        Color
                                    </div>
                                    <div class="card-body">
                                        <?php
                                        if (empty($_GET['vclid'])) {
                                            $vcl_id = '';
                                        } else {
                                            $vcl_id = $_GET['vclid'];
                                        }
                                        $results = $db->query("SELECT * FROM `veh_color` WHERE vcl_id = '$vcl_id'");
                                        $row = $results->fetch_object();
                                        ?>
                                        <form action="pages/action-veh-color.php" enctype="multipart/form-data" method="post">
                                            <div class="row mb-3">
                                                <label class="form-label">Category: <sup>*</sup></label>

                                                <select class="form-select" name="vcl_vcid" id="vcl_vcid" required>
                                                    <option value="">Choose Category</option>
                                                    <?php
                                                    $sqlt = $db->query("SELECT * FROM `veh_category` WHERE vc_sts = '1'");
                                                    while ($queryt = $sqlt->fetch_object()) {
                                                        ?>
                                                        <option <?php
                                                        if (!empty($row->vcl_vcid)) {
                                                            if ($row->vcl_vcid == $queryt->vc_id) {
                                                                echo 'selected';
                                                            }
                                                        }
                                                        ?> value="<?= $queryt->vc_id; ?>">
                                                                <?= $queryt->vc_name; ?>
                                                        </option>
                                                    <?php } ?>
                                                </select>

                                            </div>
                                            <div class="row mb-3">
                                                <label class="form-label">Model: <sup>*</sup></label>

                                                <select class="form-select" name="vcl_vmid" id="vcl_vmid" required>
                                                    <option value="">Choose Model</option>
                                                    <?php
                                                    if (!empty($row->vcl_vmid)) {
                                                        $distit_stidchk = $row->vcl_vmid;
                                                        $sqlt1 = $db->query("select * from veh_model WHERE vm_vcid = '$row->vcl_vcid'");
                                                        while ($queryt1 = $sqlt1->fetch_object()) {
                                                            ?>
                                                            <option <?php
                                                            if ($row->vcl_vmid == $queryt1->vm_id) {
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

                                            <div class="row mb-3">
                                                <label for="inputText" class="form-label">Color: <sup>*</sup></label>

                                                <input type="text" class="form-control" name="vcl_name" value="<?php
                                                if (!empty($row->vcl_name)) {
                                                    echo $row->vcl_name;
                                                }
                                                ?>" placeholder="Color Name *" required>

                                            </div>



                                            <div class="text-center">
                                                <input type = "submit" value = "Submit" class = "btn btn-success" >
                                                <?php if (!empty($_REQUEST['vclid'])) { ?>
                                                    <input type="hidden" name="submit" value="updatecolor"/>
                                                    <input type="hidden" name="vcl_id" value="<?= $row->vcl_id; ?>"/>
                                                <?php } else { ?>
                                                    <input type="hidden" name="submit" value="addcolor"/>
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
                                        List of Codes
                                    </div>
                                    <div class="card-body">

                                        <table class="table dt-responsive" id="datatablesSimple" style="font-size: 13px;">
                                            <thead>
                                                <tr>
                                                    <th class="no-sort">Sl.</th>
                                                    <th class="no-sort">Action</th>

                                                    <th>Color</th>

                                                    <th>Model</th>
                                                    <th>Category</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $sl = 0;
                                                $data = $db->query("SELECT * FROM `veh_color` vcl JOIN `veh_category` vc ON vcl.vcl_vcid = vc.vc_id JOIN `veh_model` vm ON vcl.vcl_vmid = vm.vm_id ORDER BY vcl_name ASC");
                                                while ($value = $data->fetch_object()) {
                                                    $sl++;
                                                    ?>
                                                    <tr>
                                                        <td>
                                                            <?= $sl; ?>
                                                        </td>
                                                        <td>
                                                            <div class="btn-group">
                                                                <button type="button" class="btn btn-secondary  btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                                                    <i class="fa fa-cog" aria-hidden="true"></i>
                                                                </button>
                                                                <ul class="dropdown-menu">
                                                                    <li><a class="dropdown-item" href="?vclid=<?= $value->vcl_id; ?>">Edit</a></li>

                                                                </ul>
                                                            </div>

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
                                                            <?php if ($value->vcl_sts == '1') { ?>
                                                                <a href="pages/action-veh-color.php?vcl_id=<?= $value->vcl_id; ?>&submit=Disable" onClick="return confirm('Are You Sure want to Disable??')" class="btn btn-warning btn-sm" title="click to Disable"> Active <span class="glyphicon glyphicon-refresh"></span></a>
                                                            <?php } else { ?>
                                                                <a href="pages/action-veh-color.php?vcl_id=<?= $value->vcl_id; ?>&submit=Enable" onClick="return confirm('Are You Sure want to Enable??')" class="btn btn-primary btn-sm" title="click to Enable"> Disable <span class="glyphicon glyphicon-refresh"></span></a>
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
                </main>

            </div>
        </div>

        <?php require_once 'footer.php'; ?>
        <script type="text/javascript">
            $(document).ready(function () {
                $('#vcl_vcid').on('change', function () {
                    var countryID = $(this).val();
                    //alert(countryID);
                    if (countryID) {
                        $.ajax({
                            type: 'POST',
                            url: 'ajax_model.php',
                            data: 'cid=' + countryID,
                            success: function (html) {
                                $('#vcl_vmid').html(html);
                            }
                        });
                    } else {
                        $('#vcl_vcid').html('<option value="">Choose Category</option>');
                    }
                });


            });
        </script>

    </body>


</html>
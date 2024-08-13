<?php
session_start();
require_once 'config/config.php';
require_once 'config/helper.php';
require_once 'config/chkAuth.php';
?><!DOCTYPE html>
<html lang="en">
    <head>
        <title>City</title>
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
                                <h3>  City </h3>
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
                                        City
                                    </div>
                                    <div class="card-body">
                                        <?php
                                        if (empty($_GET['citid'])) {
                                            $cit_id = '';
                                        } else {
                                            $cit_id = $_GET['citid'];
                                        }
                                        $results = $db->query("SELECT * FROM `city` WHERE cit_id = '$cit_id'");
                                        $row = $results->fetch_object();
                                        ?>
                                        <form action="pages/action-city.php"  enctype="multipart/form-data" method="post">
                                            <div class="row mb-3">
                                                <label class="col-sm-3 col-form-label">Country: <sup>*</sup></label>
                                                <div class="col-sm-9">
                                                    <select class="form-select"  name="cit_cnid" id="cit_cnid" required>
                                                        <option value="">Choose Country</option>
                                                        <?php
                                                        $sqlt = $db->query("SELECT * FROM `country` WHERE cn_status = '1'");
                                                        while ($queryt = $sqlt->fetch_object()) {
                                                            ?>
                                                            <option <?php
                                                            if (!empty($row->cit_cnid)) {
                                                                if ($row->cit_cnid == $queryt->cn_id) {
                                                                    echo 'selected';
                                                                }
                                                            }
                                                            ?> value="<?= $queryt->cn_id; ?>">
                                                                    <?= $queryt->cn_name; ?>
                                                            </option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-3 col-form-label">State: <sup>*</sup></label>
                                                <div class="col-sm-9">
                                                    <select class="form-select" name="cit_stid" id="cit_stid" required>
                                                        <option value="">Choose State</option>
                                                        <?php
                                                        if (!empty($row->cit_stid)) {

                                                            $sqlt1 = $db->query("select * from state WHERE st_cnid = '$row->cit_cnid'");
                                                            while ($queryt1 = $sqlt1->fetch_object()) {
                                                                ?>
                                                                <option <?php
                                                                if ($row->cit_stid == $queryt1->st_id) {
                                                                    echo 'selected';
                                                                }
                                                                ?> value="<?= $queryt1->st_id; ?>">
                                                                        <?= $queryt1->st_name; ?>
                                                                </option>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-3 col-form-label">District: <sup>*</sup></label>
                                                <div class="col-sm-9">
                                                    <select class="form-select" name="cit_distid" id="cit_distid"  required>
                                                        <option value=""> Choose State First</option>
                                                        <!--Sub category goes here-->
                                                        <?php
                                                        if (!empty($row->cit_distid)) {
                                                            $cit_distidchk = $row->cit_distid;
                                                            $sqlt1 = $db->query("select * from district WHERE dist_stid = '$row->cit_stid'");
                                                            while ($queryt1 = $sqlt1->fetch_object()) {
                                                                ?>
                                                                <option <?php
                                                                if ($row->cit_distid == $queryt1->dist_id) {
                                                                    echo 'selected';
                                                                }
                                                                ?> value="<?= $queryt1->dist_id; ?>">
                                                                        <?= $queryt1->dist_name; ?>
                                                                </option>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label for="inputText" class="col-sm-3 col-form-label">City Name: <sup>*</sup></label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control"  name="cit_name" value="<?php
                                                    if (!empty($row->cit_name)) {
                                                        echo $row->cit_name;
                                                    }
                                                    ?>" placeholder="City Name *"  required>
                                                </div>
                                            </div>


                                            <div class="row mb-3">
                                                <label for="inputText" class="col-sm-3 col-form-label">City Code: <sup>*</sup></label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="cit_code" value="<?php
                                                    if (!empty($row->cit_code)) {
                                                        echo $row->cit_code;
                                                    }
                                                    ?>" placeholder="Code ">
                                                </div>
                                            </div>


                                            <div class="text-center">
                                                <input type = "submit" value = "Submit" class = "btn btn-success" >
                                                <?php if (!empty($_REQUEST['citid'])) { ?>
                                                    <input type="hidden" name="submit" value="updateCity"/>
                                                    <input type="hidden" name="cit_id" value="<?= $row->cit_id; ?>"/>
                                                <?php } else { ?>
                                                    <input type="hidden" name="submit" value="addCity"/>
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

                                        <table class="table dt-responsive" id="dataTable" style="font-size: 13px;">
                                            <thead>
                                                <tr>
                                                    <th class="no-sort">Sl.</th>
                                                    <th class="no-sort">Action</th>

                                                    <th>City Name</th>
                                                    <th>Code</th>
                                                    <th>District Name</th>
                                                    <th>State Name</th>
                                                    <th>Country Name</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $sl = 0;
                                                $data = $db->query("SELECT * FROM `city` JOIN `state` ON city.cit_stid = state.st_id  JOIN `district` ON city.cit_distid = district.dist_id JOIN `country` ON city.cit_cnid = country.cn_id ORDER BY cit_name ASC");
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
                                                                    <li><a class="dropdown-item" href="?citid=<?= $value->cit_id; ?>">Edit</a></li>

                                                                </ul>
                                                            </div>

                                                        </td>

                                                        <td>
                                                            <?= $value->cit_name; ?>
                                                        </td>
                                                        <td>
                                                            <?= (!empty($value->cit_code)) ? $value->cit_code : ''; ?>
                                                        </td>
                                                        <td>
                                                            <?= $value->dist_name; ?>
                                                        </td>
                                                        <td>
                                                            <?= $value->st_name; ?>
                                                        </td>
                                                        <td>
                                                            <?= $value->cn_name; ?>
                                                        </td>
                                                        <td>
                                                            <?php if ($value->cit_status == '1') { ?>
                                                                <a href="pages/action-city?cit_id=<?= $value->cit_id; ?>&submit=Disable" onClick="return confirm('Are You Sure want to Disable??')" class="btn btn-warning btn-sm" title="click to Disable">  Active <span class="glyphicon glyphicon-refresh"></span></a>
                                                            <?php } else { ?>
                                                                <a href="pages/action-city?cit_id=<?= $value->cit_id; ?>&submit=Enable" onClick="return confirm('Are You Sure want to Enable??')" class="btn btn-primary btn-sm" title="click to Enable"> Disable <span class="glyphicon glyphicon-refresh"></span></a>
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
        <script type="text/javascript">
            $(document).ready(function () {
                $('#cit_cnid').on('change', function () {
                    var countryID = $(this).val();
                    if (countryID) {
                        $.ajax({
                            type: 'POST',
                            url: 'ajax_state.php',
                            data: 'cid=' + countryID,
                            success: function (html) {
                                $('#cit_stid').html(html);
                            }
                        });
                    } else {
                        $('#cit_cnid').html('<option value="">Choose Country</option>');
                    }
                });


            });
        </script>
        <script type="text/javascript">
            $(document).ready(function () {
                $('#cit_stid').on('change', function () {
                    var productID = $(this).val();
                    if (productID) {
                        $.ajax({
                            type: 'POST',
                            url: 'ajax_district.php',
                            data: 'pid=' + productID,
                            success: function (html) {
                                $('#cit_distid').html(html);
                            }
                        });
                    } else {
                        $('#cit_stid').html('<option value="">Choose State</option>');
                    }
                });


            });
        </script>

    </body>


</html>
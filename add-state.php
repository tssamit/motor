<?php
session_start();
require_once 'config/config.php';
require_once 'config/helper.php';
require_once 'config/chkAuth.php';
?><!DOCTYPE html>
<html lang="en">
    <head>
        <title>State</title>
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
                                <h3>  State </h3>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-xl-4">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <i class="fas fa-chart-area me-1"></i>
                                        State
                                    </div>
                                    <div class="card-body">
                                        <?php
                                        if (empty($_GET['stid'])) {
                                            $st_id = '';
                                        } else {
                                            $st_id = $_GET['stid'];
                                        }
                                        $results = $db->query("SELECT * FROM state WHERE st_id = '$st_id'");
                                        $row = $results->fetch_object();
                                        ?>
                                        <form   action="pages/action-state.php" enctype="multipart/form-data" method="post">
                                            <div class="row mb-3">
                                                <label class="col-sm-3 col-form-label">Country: <sup>*</sup></label>
                                                <div class="col-sm-9">
                                                    <select class="form-select" name="st_cnid" required>
                                                        <option value="">Choose Country</option>
                                                        <?php
                                                        $sqlt = $db->query("SELECT * FROM `country` WHERE cn_status = '1'");
                                                        while ($queryt = $sqlt->fetch_object()) {
                                                            ?>
                                                            <option <?php
                                                            if (!empty($row->st_cnid)) {
                                                                if ($row->st_cnid == $queryt->cn_id) {
                                                                    echo 'selected';
                                                                }
                                                            } else {
                                                                if ($queryt->cn_id == '1') {
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
                                                <label for="inputText" class="col-sm-3 col-form-label">State Name: <sup>*</sup></label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="st_name" value="<?php
                                                    if (!empty($row->st_name)) {
                                                        echo $row->st_name;
                                                    }
                                                    ?>" placeholder="State Name *"  required>
                                                </div>
                                            </div>


                                            <div class="row mb-3">
                                                <label for="inputText" class="col-sm-3 col-form-label">State Code: <sup>*</sup></label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="st_code" value="<?php
                                                    if (!empty($row->st_code)) {
                                                        echo $row->st_code;
                                                    }
                                                    ?>" placeholder="State Code *">
                                                </div>
                                            </div>


                                            <div class="text-center">
                                                <input type = "submit" value = "Submit" class = "btn btn-success" >
                                                <?php if (!empty($_REQUEST['stid'])) { ?>
                                                    <input type="hidden" name="submit" value="updateState"/>
                                                    <input type="hidden" name="st_id" value="<?= $row->st_id; ?>"/>
                                                <?php } else { ?>
                                                    <input type="hidden" name="submit" value="addState"/>
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


                                                    <th>State Name</th>
                                                    <th> Code</th>
                                                    <th>Country Name</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $sl = 0;
                                                $data = $db->query("SELECT * FROM `state` JOIN `country` ON state.st_cnid = country.cn_id ORDER BY st_name ASC");
                                                while ($value = $data->fetch_object()) {
                                                    $sl++;
                                                    ?>
                                                    <tr>
                                                        <td>
                                                            <?= $sl; ?>
                                                        </td>


                                                        <td>
                                                            <?= $value->st_name; ?>
                                                        </td>
                                                        <td>
                                                            <?= $value->st_code; ?>
                                                        </td>
                                                        <td>
                                                            <?= $value->cn_name; ?>
                                                        </td>
                                                        <td>
                                                            <?php if ($value->st_status == '1') { ?>
                                                                <a href="pages/action-state?st_id=<?= $value->st_id; ?>&submit=Disable" onClick="return confirm('Are You Sure want to Disable??')" class="btn btn-warning btn-sm" title="click to Disable"> Active  <span class="glyphicon glyphicon-refresh"></span></a>
                                                            <?php } else { ?>
                                                                <a href="pages/action-state?st_id=<?= $value->st_id; ?>&submit=Enable" onClick="return confirm('Are You Sure want to Enable??')" class="btn btn-primary btn-sm" title="click to Enable">Disable <span class="glyphicon glyphicon-refresh"></span></a>
                                                            <?php } ?>

                                                            <a class="btn btn-secondary  btn-sm" href="?stid=<?= $value->st_id; ?>" title="Edit">  <i class="fa fa-edit" aria-hidden="true"></i> </a>
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
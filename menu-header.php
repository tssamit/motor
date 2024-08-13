<?php
session_start();
require_once 'config/config.php';
require_once 'config/helper.php';
require_once 'config/chkAuth.php';
?><!DOCTYPE html>
<html lang="en">
    <head>
        <title>Menu Header</title>
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

                        <div class="row mb-2 mb-xl-3">
                            <div class="col-auto d-none d-sm-block">
                                <h3>  Menu Header</h3>
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
                                        Menu Header
                                    </div>
                                    <div class="card-body">

                                        <?php
                                        if (empty($_GET['menu_code'])) {
                                            $menu_code = '';
                                        } else {
                                            $menu_code = $_GET['menu_code'];
                                        }
                                        $results = $db->query("SELECT * FROM `vw_menu_header` WHERE menu_code = '$menu_code'");
                                        $row = $results->fetch_object();
                                        ?>

                                        <form class="row g-3" action="pages/action-menu-header.php" enctype="multipart/form-data" method="post">
                                            <div class="col-sm-12">
                                                <label for="inputText" class="form-label">Menu Name:: <sup>*</sup></label>

                                                <input type="text" class="form-control" name="name" value="<?php
                                                if (!empty($row->name)) {
                                                    echo $row->name;
                                                }
                                                ?>" placeholder=" Name *" required>

                                            </div>



                                            <div class="col-sm-12">
                                                <label for="inputText" class=" form-label">Custom Name: </label>

                                                <input type="text" class="form-control" name="cust_name" value="<?php
                                                if (!empty($row->cust_name)) {
                                                    echo $row->cust_name;
                                                }
                                                ?>" placeholder="Custom Name *" required>

                                            </div>


                                            <div class="col-sm-12">
                                                <label for="inputText" class=" form-label">Icon Code: (fa-plus)<sup>*</sup> </label>

                                                <input type="text" class="form-control" name="icon" value="<?php
                                                if (!empty($row->icon)) {
                                                    echo $row->icon;
                                                }
                                                ?>" placeholder="Icon Code *"  required>

                                            </div>

                                            <div class="col-sm-12">
                                                <label class="form-label">Ref. Header Menu:</label>

                                                <select class="form-select" name="ref_cd">
                                                    <option value="NULL">Ref. Header Menu</option>
                                                    <?php
                                                    $sqlt = $db->query("SELECT * FROM `vw_menu_header` WHERE header_status = 'Active' AND ref_cd IS NULL ORDER BY name ASC");
                                                    while ($queryt = $sqlt->fetch_object()) {
                                                        ?>
                                                        <option <?php
                                                        if (!empty($row->ref_cd)) {
                                                            if ($row->ref_cd == $queryt->menu_code) {
                                                                echo 'selected';
                                                            }
                                                        }
                                                        ?> value="<?= $queryt->menu_code; ?>">
                                                                <?= $queryt->cust_name; ?>
                                                        </option>
                                                    <?php } ?>
                                                </select>

                                            </div>

                                            <div class="text-center">
                                                <input type = "submit" value = "Submit" class = "btn btn-success" >
                                                <?php if (!empty($_REQUEST['menu_code'])) { ?>
                                                    <input type="hidden" name="submit" value="updateMenuh"/>
                                                    <input type="hidden" name="menu_code" value="<?= $row->menu_code; ?>"/>
                                                <?php } else { ?>
                                                    <input type="hidden" name="submit" value="addMenuh"/>
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
                                                    <th class="no-sort">#</th>

                                                    <th> Name</th>
                                                    <th>Custom Name</th>
                                                    <th>Icon</th>
                                                    <th>Ref. Name</th>
                                                    <th>Ref. Custom Name</th>

                                                    <th>Status</th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $sl = 0;
                                                $data = $db->query("SELECT * FROM `vw_menu_header` ORDER BY menu_code ASC");
                                                while ($value = $data->fetch_object()) {
                                                    $sl++;
                                                    ?>
                                                    <tr>
                                                        <td>
                                                            <?= $sl; ?>
                                                        </td>

                                                        <td>
                                                            <?= $value->name; ?>
                                                        </td>
                                                        <td>
                                                            <?= $value->cust_name; ?>
                                                        </td>
                                                        <td>
                                                            <?= $value->icon; ?>
                                                        </td>
                                                        <td>
                                                            <?= $value->refer_name; ?>
                                                        </td>
                                                        <td>
                                                            <?= $value->cust_refer_name; ?>
                                                        </td>

                                                        <td>
                                                            <a href="pages/action-menu-header?submit=brndupdt&id=<?= $value->menu_code; ?>&st=<?php
                                                            if ($value->header_status == 'Active') {
                                                                echo 'Active';
                                                            } else {
                                                                echo 'In-Active';
                                                            }
                                                            ?>" class="btn <?php
                                                               if ($value->header_status == 'Active') {
                                                                   echo 'btn-success';
                                                               } else {
                                                                   echo 'btn-warning';
                                                               }
                                                               ?> btn-sm" onClick="return confirm('Are You Sure want to change status ?')"><?php
                                                                   if ($value->header_status == 'Active') {
                                                                       echo 'Active';
                                                                   } else {
                                                                       echo 'In-Active';
                                                                   }
                                                                   ?> </a>

                                                            <a class="btn btn-secondary  btn-sm" href="?menu_code=<?= $value->menu_code; ?>" title="Edit">  <i class="fa fa-edit" aria-hidden="true"></i> </a>


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
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
                                <h3>  Menu Info</h3>
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
                                        Menu Info
                                    </div>
                                    <div class="card-body">
                                        <?php
                                        if (empty($_GET['menu_code'])) {
                                            $menu_code = '';
                                        } else {
                                            $menu_code = $_GET['menu_code'];
                                        }
                                        $results = $db->query("SELECT * FROM `vw_menu` WHERE menu_code = '$menu_code'");
                                        $row = $results->fetch_object();
                                        ?>
                                        <form class="row g-3" action="pages/action-menu-info.php" enctype="multipart/form-data" method="post">
                                            <div class="col-sm-12">
                                                <label class="form-label"> Header Menu:</label>

                                                <select class="form-select" name="menucode" id="menucode" required>
                                                    <option value="NULL">Ref. Main Header</option>
                                                    <?php
                                                    $sqlt = $db->query("SELECT * FROM `vw_menu_header` WHERE header_status = 'Active' AND ref_cd IS null ORDER BY name ASC");
                                                    while ($queryt = $sqlt->fetch_object()) {
                                                        ?>
                                                        <option <?php
                                                        if (!empty($row->header_name)) {
                                                            if ($row->header_name == $queryt->name) {
                                                                echo 'selected';
                                                            }
                                                        }
                                                        ?> value="<?= $queryt->name; ?>">
                                                                <?= $queryt->name; ?>
                                                        </option>
                                                    <?php } ?>
                                                </select>

                                            </div>

                                            <div class="col-sm-12">
                                                <label class=" form-label"> Sub Menu:</label>

                                                <select class="form-select"  name="menu_hdr_cd" id="submenu">
                                                    <option value="">Sub Menu:</option>
                                                    <?php
                                                    if (!empty($row->submenu_name)) {
                                                        $sqlts = $db->query("SELECT * FROM `vw_menu_header` WHERE header_status = 'Active' AND refer_name = '" . $row->header_name . "' ORDER BY name ASC");
                                                        while ($queryts = $sqlts->fetch_object()) {
                                                            ?>
                                                            <option <?php
                                                            if ($row->submenu_name == $queryts->name) {
                                                                echo 'selected';
                                                            }
                                                            ?> value="<?= $queryts->name; ?>">
                                                                    <?= $queryts->name; ?>
                                                            </option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>

                                            </div>



                                            <div class="col-sm-12">
                                                <label for="inputText" class=" form-label">Menu Name: <sup>*</sup> </label>

                                                <input type="text" class="form-control"name="menu_name" value="<?php
                                                if (!empty($row->menu_name)) {
                                                    echo $row->menu_name;
                                                }
                                                ?>" placeholder=" Menu Name *"  required>

                                            </div>


                                            <div class="col-sm-12">
                                                <label for="inputText" class=" form-label">Page Title: <sup>*</sup> </label>

                                                <input type="text" class="form-control"name="page_title" value="<?php
                                                if (!empty($row->page_title)) {
                                                    echo $row->page_title;
                                                }
                                                ?>" placeholder=" Page title *" required>

                                            </div>
                                            <div class="col-sm-12">
                                                <label for="inputText" class=" form-label">Custom Name: <sup>*</sup></label>

                                                <input type="text" class="form-control" name="menu_cust_name" value="<?php
                                                if (!empty($row->menu_cust_name)) {
                                                    echo $row->menu_cust_name;
                                                }
                                                ?>" placeholder="Custom Menu Name *" required>

                                            </div>

                                            <div class="col-sm-12">
                                                <label for="inputText" class=" form-label">Sequence: <sup>*</sup></label>

                                                <input type="number" min="1"  class="form-control input-sm" name="sequence" value="<?php
                                                if (!empty($row->sequence)) {
                                                    echo $row->sequence;
                                                }
                                                ?>" placeholder="Sequence *"  required>

                                            </div>
                                            <div class="col-sm-12">
                                                <label for="inputText" class=" form-label">Path: <sup>*</sup></label>

                                                <input type="text" class="form-control input-sm" name="path" value="<?php
                                                if (!empty($row->path)) {
                                                    echo $row->path;
                                                }
                                                ?>" placeholder="Path *"  required>

                                            </div>

                                            <div class="col-sm-12">
                                                <label for="inputText" class=" form-label">Icon Code: (fa-check)<sup>*</sup></label>

                                                <input type="text" class="form-control input-sm" name="mnu_icon" value="<?php
                                                if (!empty($row->mnu_icon)) {
                                                    echo $row->mnu_icon;
                                                }
                                                ?>" placeholder="Icon Code *" required>

                                            </div>


                                            <div class="col-sm-12">
                                                <label for="inputText" class=" form-label">Desktop Icon Code: (fa-plus)<sup>*</sup></label>

                                                <input type="text" class="form-control input-sm" name="desktop_icon" value="<?php
                                                if (!empty($row->desktop_icon)) {
                                                    echo $row->desktop_icon;
                                                }
                                                ?>" placeholder="Desktop Icon Code *" required>

                                            </div>



                                            <div class="text-center">
                                                <input type = "submit" value = "Submit" class = "btn btn-success" >
                                                <?php if (!empty($_REQUEST['menu_code'])) { ?>
                                                    <input type="hidden" name="submit" value="updateMenusub"/>
                                                    <input type="hidden" name="menu_code" value="<?= $row->menu_code; ?>"/>
                                                <?php } else { ?>
                                                    <input type="hidden" name="submit" value="addMenusub"/>
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

                                                    <th>Menu Name</th>
                                                    <th>Custom Name</th>
                                                    <th>Sub-menu Name</th>
                                                    <th>Header Menu </th>
                                                    <th>Icon</th>
                                                    <th>Desktop Icon</th>
                                                    <th>Sequence</th>
                                                    <th>Path</th>

                                                    <th>Status</th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $sl = 0;
                                                $data = $db->query("SELECT * FROM `vw_menu` ORDER BY menu_code ASC");
                                                while ($value = $data->fetch_object()) {
                                                    $sl++;
                                                    ?>
                                                    <tr>
                                                        <td>
                                                            <?= $sl; ?>
                                                        </td>

                                                        <td>
                                                            <?= $value->menu_name; ?>
                                                        </td>
                                                        <td>
                                                            <?= $value->menu_cust_name; ?>
                                                        </td>
                                                        <td>
                                                            <?= $value->cust_name; ?>
                                                        </td>
                                                        <td>
                                                            <?= $value->refer_name; ?>
                                                        </td>
                                                        <td>
                                                            <?= $value->mnu_icon; ?>
                                                        </td>
                                                        <td>
                                                            <i class="fa fa-fw fa-1x <?= $value->desktop_icon; ?>" aria-hidden="true" style="color:#999999;"></i> <?= $value->desktop_icon; ?>
                                                        </td>
                                                        <td>
                                                            <?= $value->sequence; ?>
                                                        </td>
                                                        <td>
                                                            <?= $value->path; ?>
                                                        </td>

                                                        <td>
                                                            <a href="pages/action-menu-info?submit=brndupdt&id=<?= $value->menu_code; ?>&st=<?php
                                                            if ($value->menu_status == 'Active') {
                                                                echo '0';
                                                            } else {
                                                                echo '1';
                                                            }
                                                            ?>" class="btn <?php
                                                               if ($value->menu_status == 'Active') {
                                                                   echo 'btn-success';
                                                               } else {
                                                                   echo 'btn-warning';
                                                               }
                                                               ?> btn-sm" onClick="return confirm('Are You Sure want to change status ?')">  <?php
                                                                   if ($value->menu_status == 'Active') {
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
        <script type="text/javascript">
            $(document).ready(function () {
                $('#menucode').on('change', function () {
                    var productID = $(this).val();
                    // alert(productID);
                    if (productID) {
                        // alert('ok');
                        // alert(productID);
                        $.ajax({
                            type: 'POST',
                            url: 'ajax_menuheader.php',
                            data: 'id=' + productID,
                            success: function (html) {
                                $('#submenu').html(html);

                            }
                        });
                    } else {
                        $('#menucode').html('<option value="">Choose header</option>');
                    }
                });


            });
        </script>
    </body>


</html>
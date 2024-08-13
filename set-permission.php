<?php
session_start();
require_once 'config/config.php';
require_once 'config/helper.php';
require_once 'config/chkAuth.php';
?><!DOCTYPE html>
<html lang="en">
    <head>
        <title>Set Permission</title>
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
                                <h3>Set Permission</h3>
                            </div>
                            <!--
                                                        <div class="col-auto ms-auto text-end mt-n1">
                                                            <a href="#" class="btn btn-light bg-white me-2">Invite a Friend</a>
                                                            <a href="#" class="btn btn-primary">New Project</a>
                                                        </div>-->
                        </div>

                        <div class="row" >
                            <div class="col-xl-4">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <i class="fas fa-chart-bar me-1"></i>
                                        Set Permission
                                    </div>
                                    <div class="card-body">
                                        <?php
                                        if (empty($_POST['user_type_code'])) {
                                            $act_id = '';
                                        } else {
                                            $act_id = $_POST['user_type_code'];
                                        }
                                        $results = $db->query("SELECT * FROM acc_type WHERE act_id = '$act_id'");
                                        $row = $results->fetch_object();
                                        ?>
                                        <form action="" enctype="multipart/form-data" method="post">

                                            <label class="form-label">Select Role: <sup>*</sup></label>

                                            <select class="form-select" name="user_type_code" id="user_type_code" required onchange="this.form.submit()" required>
                                                <option value="">Select Role</option>
                                                <?php
                                                $sqlt = $db->query("SELECT act_id,act_name,act_permission,act_icon_permission,act_sts FROM `acc_type` WHERE `act_id` != 1");
                                                while ($queryt = $sqlt->fetch_object()) {
                                                    ?>
                                                    <option <?php
                                                    if (!empty($row->act_id)) {
                                                        if ($row->act_id == $queryt->act_id) {
                                                            echo 'selected';
                                                        }
                                                    }
                                                    ?> value="<?= $queryt->act_id; ?>">
                                                            <?= $queryt->act_name; ?>
                                                    </option>
                                                <?php } ?>
                                            </select>


                                        </form>
                                    </div>
                                </div>
                            </div>


                            <div class="col-xl-8">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <i class="fas fa-chart-bar me-1"></i>
                                        List of Pages
                                    </div>
                                    <div class="card-body">

                                        <div class="table-responsive">


                                            <form action="pages/action-usersetting.php" class="form-inline"  enctype="multipart/form-data" method="post">
                                                <!-- Table with stripped rows -->
                                                <table class="table dt-responsive" id="" style="font-size: 13px;">
                                                    <thead>
                                                        <tr>
                                                            <th class="col-sm-1">Sl.</th>
                                                            <th  class="col-sm-1">Show Menu</th>
                                                            <th  class="col-sm-1">Show Dashboard</th>
                                                            <th  class="col-sm-3">Page Name</th>
                                                            <th  class="col-sm-3">Ref. Name</th>
                                                            <th  class="col-sm-3">Path</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        if (!empty($_POST['user_type_code'])) {
                                                            $user_type_code = $_POST['user_type_code'];
                                                            $sqltpin1 = $db->query("SELECT * FROM `acc_type` WHERE act_id = '$user_type_code'");
                                                            $querytpin1 = $sqltpin1->fetch_object();
                                                            $path = $querytpin1->act_permission;
                                                            $desk_path = $querytpin1->act_icon_permission;
                                                            $user_type_name = $querytpin1->act_name;
                                                        } else {
                                                            $user_type_code = '';
                                                            $path = '';
                                                            $desk_path = '';
                                                            $user_type_name = '';
                                                        }

                                                        $cnt = 0;
                                                        $resultsnavd2 = $db->query("SELECT refer_name,menu_cust_name,menu_code,path,desktop_icon FROM vw_menu ");
                                                        while ($datanav2 = $resultsnavd2->fetch_object()) {

                                                            $cnt++;
                                                            ?>
                                                            <tr>
                                                                <td><?= $cnt; ?>.</td>
                                                                <td>
                                                                    <input type="checkbox" name="checkbox_id[]" class="checkval" title="Select to Add" <?php
                                                                    foreach (explode(',', $path) as $n) {
                                                                        if ($n == $datanav2->menu_code) {
                                                                            echo 'checked';
                                                                        }
                                                                    }
                                                                    ?> value="<?= $datanav2->menu_code; ?>"> </td>
                                                                <td><?php if (!empty($datanav2->desktop_icon)) { ?>
                                                                        <input type="checkbox" name="desktop_id[]" class="checkval" title="Select to View" <?php
                                                                        foreach (explode(',', $desk_path) as $nd) {
                                                                            if ($nd == $datanav2->menu_code) {
                                                                                echo 'checked';
                                                                            }
                                                                        }
                                                                        ?> value="<?= $datanav2->menu_code; ?>">  <i class="fa fa-fw <?= $datanav2->desktop_icon; ?>" aria-hidden="true"></i>
                                                                    <?php } ?> </td>
                                                                <td><?= $datanav2->menu_cust_name; ?></td>
                                                                <td><?= $datanav2->refer_name; ?></td>
                                                                <td><?= $datanav2->path; ?></td>

                                                            </tr>
                                                        <?php } ?>
                                                    </tbody>
                                                </table>
                                                <?php if (!empty($_POST['user_type_code'])) { ?>
                                                    <div class="text-center">
                                                        <input type = "submit" value = "Assign Page" class = "btn btn-success" onClick = "return confirm('Are you sure want to Assign?')">
                                                        <input type = "hidden" name = "submit" value = "UserPageSet"/>
                                                        <input type = "hidden" name = "act_id" value = "<?= $user_type_code; ?>"/>
                                                    </div>
                                                    <?php
                                                }
                                                ?>
                                            </form>
                                        </div>

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
<?php
session_start();
require_once 'config/config.php';
require_once 'config/helper.php';
require_once 'config/chkAuth.php';
?><!DOCTYPE html>
<html lang="en">
    <head>
        <title>Set Code Format</title>
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
                                <h3>  Set Code Format </h3>
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
                                        Set Code
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
                                            <div class="row mb-3">
                                                <label class="col-sm-3 col-form-label">Select Role: <sup>*</sup></label>
                                                <div class="col-sm-9">
                                                    <select class="form-select" name="user_type_code" id="user_type_code" required onchange="this.form.submit()" required>
                                                        <option value="">Select Role</option>
                                                        <?php
                                                        $sqlt = $db->query("SELECT act_id,act_name, act_sts FROM `acc_type` WHERE `act_id` != 1");
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
                                                </div>
                                            </div>




                                        </form>

                                        <form action="pages/action-codeformat.php"   enctype="multipart/form-data" method="post">
                                            <div class="row mb-3">
                                                <label for="inputText" class="col-sm-3 col-form-label">Pre Fix: <sup>*</sup></label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="act_prefix" value="<?php
                                                    if (!empty($row->act_prefix)) {
                                                        echo $row->act_prefix;
                                                    }
                                                    ?>" placeholder="Pre Fix" required>
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label for="inputNumber" class="col-sm-3 col-form-label">Code Length (0 will add): <sup>*</sup></label>
                                                <div class="col-sm-9">
                                                    <input type="number" min="1" class="form-control " name="act_length" value="<?php
                                                    if (!empty($row->act_length)) {
                                                        echo $row->act_length;
                                                    }
                                                    ?>" placeholder="Code Length" required>
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label for="inputText" class="col-sm-3 col-form-label">Code Separator: </label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="act_separator" value="<?php
                                                    if (!empty($row->act_separator)) {
                                                        echo $row->act_separator;
                                                    }
                                                    ?>" placeholder="Code Separator">
                                                </div>
                                            </div>



                                            <?php if (!empty($_POST['user_type_code'])) { ?>
                                                <div class="text-center">
                                                    <input type = "submit" value = "Update Format" class = "btn btn-success" onClick = "return confirm('Are you sure want to Assign?')">
                                                    <input type = "hidden" name = "submit" value = "CodeFormatSet"/>
                                                    <input type = "hidden" name = "act_id" value = "<?= $act_id; ?>"/>
                                                </div>
                                                <?php
                                            }
                                            ?>
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

                                                    <th>Type</th>
                                                    <th>Pre Fix</th>
                                                    <th>Length</th>
                                                    <th>Separator</th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $sl = 0;
                                                $data = $db->query("SELECT * FROM `acc_type` WHERE act_id !=1");
                                                while ($value = $data->fetch_object()) {
                                                    $sl++;
                                                    ?>
                                                    <tr>
                                                        <td>
                                                            <?= $sl; ?>
                                                        </td>

                                                        <td>
                                                            <?= $value->act_name; ?>
                                                        </td>

                                                        <td>
                                                            <?= $value->act_prefix; ?>
                                                        </td>
                                                        <td>
                                                            <?= $value->act_length; ?>
                                                        </td>
                                                        <td>
                                                            <?= $value->act_separator; ?>
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


    </body>


</html>
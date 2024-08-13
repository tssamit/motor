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
                        <div class="row mb-2">
                            <?php include_once 'errormsg.php'; ?>
                        </div>
                        <div class="row mb-2 mb-xl-3">
                            <div class="col-auto d-none d-sm-block">
                                <h3>Set Permission</h3>
                            </div>

                            <div class="col-auto ms-auto text-end mt-n1">
                                <a href="#addnew" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="addnew" class="btn btn-sm btn-primary">Add New User</a>
                            </div>
                        </div>
                        <div class="row collapse" id="addnew" >
                            <div class="col-xl-12">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <i class="fas fa-chart-bar me-1"></i>
                                        New User / Update
                                    </div>

                                    <form action="pages/action-usercreation.php"  enctype="multipart/form-data" method="post">
                                        <div class="col-md-6" style=" float: left;">

                                            <div class="card-body">

                                                <div class="row mb-3">
                                                    <label class="col-sm-3 col-form-label">User Type: <sup>*</sup></label>
                                                    <div class="col-sm-9">
                                                        <select class="form-select" name="user_type_code" id="user_type_code" required>
                                                            <option value="">Choose User Type</option>
                                                            <?php
                                                            $sqltpin = $db->query("SELECT act_id,act_name,act_permission,act_icon_permission,act_sts FROM `acc_type` WHERE `act_id` IN (2)");
                                                            while ($querytpin = $sqltpin->fetch_object()) {
                                                                ?>
                                                                <option <?php
                                                                if (!empty($_POST['act_id'])) {
                                                                    if ($_POST['act_id'] == $querytpin->act_id) {
                                                                        echo 'selected';
                                                                    }
                                                                }
                                                                ?> value="<?= $querytpin->act_id; ?>"><?= $querytpin->act_name; ?></option>
                                                                    <?php
                                                                }
                                                                ?>
                                                        </select>
                                                    </div>
                                                </div>


                                                <div class="row mb-3">
                                                    <label for="inputText" class="col-sm-3 col-form-label">User Name <sup>*</sup></label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" name="user_name" placeholder="Your Full Name"  required>
                                                    </div>
                                                </div>


                                                <div class="row mb-3">
                                                    <label for="inputText" class="col-sm-3 col-form-label">User ID: <sup>*</sup></label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" name="user_id" placeholder="login User ID"   required>
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <label for="inputText" class="col-sm-3 col-form-label">Password: <sup>*</sup></label>
                                                    <div class="col-sm-9">
                                                        <input type="password" class="form-control" name="user_pwd" placeholder="Password" id="password1" autocomplete="false"   required>
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <label for="inputText" class="col-sm-3 col-form-label">Confirm Password: <sup>*</sup></label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" autocomplete="false" name="CPassword" placeholder="Confirm Password" required="" id="confirm_password1"  required>
                                                        <span class="pull-right" id='message1'></span>
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <label for="inputText" class="col-sm-3 col-form-label">Email ID: </label>
                                                    <div class="col-sm-9">
                                                        <input type="email" class="form-control" name="a_email" placeholder="Email ID" >
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <label for="inputText" class="col-sm-3 col-form-label">Mobile: </label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" name="a_phone" placeholder="Mobile " pattern="[1-9]{1}[0-9]{9}" >
                                                    </div>
                                                </div>


                                            </div>

                                        </div>

                                        <div class="col-md-6" style=" float: right;">

                                            <div class="card-body">
                                                <div id="pagelist">



                                                </div>
                                            </div>


                                        </div>
                                    </form>


                                </div>
                            </div>
                        </div>
                        <div class=" clearfix" style=" margin-bottom: 15px;"></div>

                        <div class="row">

                            <div class="col-xl-12">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <i class="fas fa-chart-bar me-1"></i>
                                        List of Codes
                                    </div>
                                    <div class="card-body">

                                        <div class="table-responsive">
                                            <table class="table dt-responsive" id="datatablesSimple" style="font-size: 13px;">

                                                <thead>
                                                    <tr>
                                                        <th class="no-sort">Sl.</th>

                                                        <th>User Type</th>
                                                        <th>Full Name</th>
                                                        <th>User ID</th>
                                                        <th>Password</th>
                                                        <th>Email</th>
                                                        <th>Mobile</th>
                                                        <th>Permission</th>

                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $sl = 0;
                                                    $data = $db->query("SELECT * FROM `vw_master_user`  WHERE a_usertype IN (2) ORDER BY a_name ASC");
                                                    while ($value = $data->fetch_object()) {
                                                        $sl++;
                                                        ?>
                                                        <tr>
                                                            <td>
                                                                <?= $sl; ?>
                                                            </td>

                                                            <td>
                                                                <?= $value->a_type_name; ?>
                                                            </td>
                                                            <td>
                                                                <?= $value->a_name; ?>
                                                            </td>
                                                            <td>
                                                                <?= $value->a_username; ?>
                                                            </td>
                                                            <td>
                                                                <?= $value->a_vpwd; ?>
                                                            </td>
                                                            <td>
                                                                <?= $value->a_email; ?>
                                                            </td>
                                                            <td>
                                                                <?= $value->a_phone; ?>
                                                            </td>
                                                            <td>
                                                                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-id=<?= $value->a_id; ?> data-bs-target="#myModalPermission" title="Give Permission"><i class="fa fa-key" aria-hidden="true"></i> Permission</button>
                                                                <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-id=<?= $value->a_id; ?> data-bs-target="#changePWD" title="Change Password"><i class="fa fa-key" aria-hidden="true"></i> PWD</button>


                                                                <a href="pages/action-usercreation.php?submit=usupdt&id=<?= $value->a_id; ?>&st=<?php
                                                                if ($value->a_status == '1') {
                                                                    echo '0';
                                                                } else {
                                                                    echo '1';
                                                                }
                                                                ?>" class="btn <?php
                                                                   if ($value->a_status == '1') {
                                                                       echo 'btn-success';
                                                                   } else {
                                                                       echo 'btn-warning';
                                                                   }
                                                                   ?> btn-sm" onClick="return confirm('Are You Sure want to change status ?')"><i class="fa fa-refresh" aria-hidden="true"></i> <?php
                                                                       if ($value->a_status == '1') {
                                                                           echo 'Active';
                                                                       } else {
                                                                           echo 'In-Active';
                                                                       }
                                                                       ?> </a>
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

                    <div class="modal fade" id="myModalPermission" tabindex="-1">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Permission</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="fetched-data-pay"></div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="changePWD" tabindex="-1">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Change Password</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="fetched-data-password"></div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

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
                $('#user_type_code').on('change', function () {
                    var productID = $(this).val();
                    //alert(productID);
                    if (productID) {
                        $.ajax({
                            type: 'POST',
                            url: 'ajax_pagelist.php',
                            data: 'cid=' + productID,
                            success: function (html) {
                                $('#pagelist').html(html);
                            }
                        });
                    }
                });


            });
        </script>
        <script>

            $(document).ready(function () {
                $('#myModalPermission').on('show.bs.modal', function (e) {
                    var rowid = $(e.relatedTarget).data('id');
                    $.ajax({
                        type: 'post',
                        url: 'fetch_permission.php', //Here you will fetch records
                        data: 'rowid=' + rowid, //Pass $id
                        success: function (data) {
                            $('.fetched-data-pay').html(data); //Show fetched data from database
                        }
                    });
                });
            });
        </script>
        <script>

            $(document).ready(function () {
                $('#changePWD').on('show.bs.modal', function (e) {
                    var rowid = $(e.relatedTarget).data('id');
                    $.ajax({
                        type: 'post',
                        url: 'fetch_changepwd.php', //Here you will fetch records
                        data: 'aid=' + rowid, //Pass $id
                        success: function (data) {
                            $('.fetched-data-password').html(data); //Show fetched data from database
                        }
                    });
                });
            });
        </script>
        <script>
            $('#confirm_password1').on('keyup', function () {
                if ($('#password1').val() == $('#confirm_password1').val()) {
                    $('#message1').html('Password Matching').css('color', 'green');
                } else
                    $('#message1').html('Password Not Matching').css('color', 'red');
            });

        </script>

    </body>


</html>
<?php
session_start();
require_once 'config/config.php';
require_once 'config/helper.php';
require_once 'config/chkAuth.php';
?><!DOCTYPE html>
<html lang="en">
    <head>
        <title>Profile</title>
        <meta name="description" content="Transport Management">
        <meta name="keywords" content="Transport Management, transport, vehicle">
        <?php require_once 'header.php'; ?>
        <style>

            /**
             * Profile
             */
            /*** Profile: Header  ***/
            .profile__avatar {
                float: left;
                width: 60px;
                height: 60px;
                border-radius: 50%;
                margin-right: 20px;
                overflow: hidden;
            }
            @media (min-width: 768px) {
                .profile__avatar {
                    width: 100px;
                    height: 100px;
                }
            }
            .profile__avatar > img {
                width: 100%;
                height: auto;
            }
            .profile__header {
                overflow: hidden;
            }
            .profile__header p {
                margin: 20px 0;
            }
            /*** Profile: Table ***/
            @media (min-width: 992px) {
                .profile__table tbody th {
                    width: 200px;
                }
            }
            /*** Profile: Recent activity ***/
            .profile-comments__item {
                position: relative;
                padding: 15px 16px;
                border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            }
            .profile-comments__item:last-child {
                border-bottom: 0;
            }
            .profile-comments__item:hover,
            .profile-comments__item:focus {
                background-color: #f5f5f5;
            }
            .profile-comments__item:hover .profile-comments__controls,
            .profile-comments__item:focus .profile-comments__controls {
                visibility: visible;
            }
            .profile-comments__controls {
                position: absolute;
                top: 0;
                right: 0;
                padding: 5px;
                visibility: hidden;
            }
            .profile-comments__controls > a {
                display: inline-block;
                padding: 2px;
                color: #999999;
            }
            .profile-comments__controls > a:hover,
            .profile-comments__controls > a:focus {
                color: #333333;
            }
            .profile-comments__avatar {
                display: block;
                float: left;
                margin-right: 20px;
                width: 40px;
                height: 40px;
                border-radius: 50%;
                overflow: hidden;
            }
            .profile-comments__avatar > img {
                width: 100%;
                height: auto;
            }
            .profile-comments__body {
                overflow: hidden;
            }
            .profile-comments__sender {
                color: #333333;
                font-weight: 500;
                margin: 5px 0;
            }
            .profile-comments__sender > small {
                margin-left: 5px;
                font-size: 12px;
                font-weight: 400;
                color: #999999;
            }
            @media (max-width: 767px) {
                .profile-comments__sender > small {
                    display: block;
                    margin: 5px 0 10px;
                }
            }
            .profile-comments__content {
                color: #999999;
            }
            /*** Profile: Contact ***/
            .profile__contact-btn {
                padding: 12px 20px;
                margin-bottom: 20px;
            }
            .profile__contact-hr {
                position: relative;
                border-color: rgba(0, 0, 0, 0.1);
                margin: 40px 0;
            }
            .profile__contact-hr:before {
                content: "OR";
                display: block;
                padding: 10px;
                position: absolute;
                top: 50%;
                left: 50%;
                -webkit-transform: translate(-50%, -50%);
                transform: translate(-50%, -50%);
                background-color: #f5f5f5;
                color: #c6c6cc;
            }
            .profile__contact-info-item {
                margin-bottom: 30px;
            }
            .profile__contact-info-item:before,
            .profile__contact-info-item:after {
                content: " ";
                display: table;
            }
            .profile__contact-info-item:after {
                clear: both;
            }
            .profile__contact-info-item:before,
            .profile__contact-info-item:after {
                content: " ";
                display: table;
            }
            .profile__contact-info-item:after {
                clear: both;
            }
            .profile__contact-info-icon {
                float: left;
                font-size: 18px;
                color: #999999;
            }
            .profile__contact-info-body {
                overflow: hidden;
                padding-left: 20px;
                color: #999999;
            }
            .profile__contact-info-body a {
                color: #999999;
            }
            .profile__contact-info-body a:hover,
            .profile__contact-info-body a:focus {
                color: #999999;
                text-decoration: none;
            }
            .profile__contact-info-heading {
                margin-top: 2px;
                margin-bottom: 5px;
                font-weight: 500;
                color: #999999;
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

                        <div class="row mb-2 mb-xl-3">
                            <div class="col-auto d-none d-sm-block">
                                <h3>  Profile </h3>
                            </div>
                            <!--
                                                        <div class="col-auto ms-auto text-end mt-n1">
                                                            <a href="#" class="btn btn-light bg-white me-2">Invite a Friend</a>
                                                            <a href="#" class="btn btn-primary">New Project</a>
                                                        </div>-->
                        </div>
                        <?php
                        $dataad = $db->query("SELECT * FROM `city` JOIN `state` ON city.cit_stid = state.st_id  JOIN `district` ON city.cit_distid = district.dist_id JOIN `country` ON city.cit_cnid = country.cn_id  WHERE cit_id = '$rowuser->a_city_id' ORDER BY cit_name ASC");
                        $valuead = $dataad->fetch_object();
                        $a_code = $rowuser->a_code;
                        $a_prefix = $rowuser->a_prefix;
                        $a_length = $rowuser->a_length;
                        $a_separator = $rowuser->a_separator;
                        $codeno = $a_prefix . $a_separator . str_pad($a_code, $a_length, "0", STR_PAD_LEFT);
                        ?>
                        <div class="row">
                            <div class="col-xl-4">

                                <div class="card">
                                    <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">


                                        <?php
                                        if (!empty($rowuser->a_photo)) {
                                            ?>

                                            <img src="pages/uploads/<?= $rowuser->a_photo; ?>" alt="Profile" style=" max-height: 120px;" class="rounded-circle">
                                        <?php } else { ?>
                                            <img src="img/avatars/avatar.png" alt="Profile" style=" max-height: 120px;" class="rounded-circle">
                                        <?php } ?>


                                        <h3><?= (!empty($rowuser->a_name)) ? ucwords($rowuser->a_name) : 'User'; ?></h3>
                                        <h4><?= (!empty($rowuser->a_desig)) ? ucwords($rowuser->a_desig) : 'User'; ?></h4>
                                        <h5>User ID: <?= (!empty($rowuser->a_username)) ? $rowuser->a_username : 'UserID'; ?></h5>
                                        <h5>User No: <?= (!empty($codeno)) ? $codeno : '0000'; ?></h5>
                                        <div class="social-links mt-2">
                                            <a href="#" class="twitter"><i class="bi bi-twitter"></i></a>
                                            <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
                                            <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
                                            <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="col-xl-8">
                                <div class="card">
                                    <div class="card-body pt-3">

                                        <!-- User info -->
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="card-title">User info
                                                    <?php if (empty($_GET['edt'])) { ?>
                                                        <a href="?edt=info" class="btn btn-info btn-sm float-end" role="button">Edit Info &AMP; Photo</a>
                                                    <?php } ?>
                                                </h4>
                                            </div>
                                            <div class="panel-body">
                                                <?php if (!empty($_GET['edt']) && $_GET['edt'] == 'info') { ?>
                                                    <form  action="pages/action-profile.php" enctype="multipart/form-data" method="post">
                                                        <table class="table profile__table">
                                                            <tbody>
                                                                <tr>
                                                                    <th><strong>Name</strong></th>
                                                                    <td>
                                                                        <input type="text" class="form-control input-sm" name="a_name" value="<?= $rowuser->a_name; ?>"  required>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th><strong>Email</strong></th>
                                                                    <td> <input type="text" class="form-control input-sm" name="a_email" value="<?= $rowuser->a_email; ?>"></td>
                                                                </tr>
                                                                <tr>
                                                                    <th><strong>Phone</strong></th>
                                                                    <td> <input type="text" class="form-control input-sm" name="a_phone" value="<?= $rowuser->a_phone; ?>"  required></td>
                                                                </tr>
                                                                <?php if ($rowuser->a_usertype == '5') { ?>
                                                                    <tr>
                                                                        <th><strong>Company Name</strong></th>
                                                                        <td> <input type="text" class="form-control input-sm" name="a_company" value="<?= $rowuser->a_company; ?>" ></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th><strong>Designation</strong></th>
                                                                        <td> <input type="text" class="form-control input-sm" name="a_desig" value="<?= $rowuser->a_desig; ?>" ></td>
                                                                    </tr>
                                                                <?php } ?>
                                                                <tr>
                                                                    <th><strong>Photo</strong></th>
                                                                    <td><input type="file" class="form-control input-sm" name="a_photo" ></td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                        <div class="form-group">
                                                            <input type="submit" value="Update Info" class="btn btn-primary float-end">
                                                            <input type="hidden" name="submit" value="updateinfo"/>
                                                            <input type="hidden" name="a_id" value="<?= $rowuser->a_id; ?>"/>

                                                        </div>
                                                    </form>
                                                <?php } else { ?>

                                                    <table class="table profile__table">
                                                        <tbody>
                                                            <tr>
                                                                <th><strong>Name</strong></th>
                                                                <td><?= $rowuser->a_name; ?></td>
                                                            </tr>
                                                            <tr>
                                                                <th><strong>Email</strong></th>
                                                                <td><?= $rowuser->a_email; ?></td>
                                                            </tr>
                                                            <tr>
                                                                <th><strong>Phone</strong></th>
                                                                <td><?= $rowuser->a_phone; ?></td>
                                                            </tr>
                                                            <?php if ($rowuser->a_usertype == '5') { ?>
                                                                <tr>
                                                                    <th><strong>Company Name</strong></th>
                                                                    <td><?= $rowuser->a_company; ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <th><strong>Designation</strong></th>
                                                                    <td><?= $rowuser->a_desig; ?></td>
                                                                </tr>
                                                            <?php } ?>
                                                        </tbody>
                                                    </table>
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <!-- Location info -->
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="card-title">Location info
                                                    <?php if (empty($_GET['edt'])) { ?>
                                                        <a href="?edt=location" class="btn btn-info btn-sm float-end" role="button">Edit Info</a>
                                                    <?php } ?>
                                                </h4>
                                            </div>
                                            <div class="panel-body">
                                                <?php if (!empty($_GET['edt']) && $_GET['edt'] == 'location') { ?>
                                                    <form  action="pages/action-profile.php" enctype="multipart/form-data" method="post">
                                                        <table class="table profile__table">
                                                            <tbody>
                                                                <tr>
                                                                    <th><strong>Address</strong></th>
                                                                    <td><input type="text" class="form-control input-sm" name="a_address" value="<?= $rowuser->a_address; ?>"  required></td>
                                                                </tr>

                                                                <tr>
                                                                    <th><strong>Country</strong></th>
                                                                    <td> <?php
                                                                        $results = $db->query("SELECT * FROM `city` WHERE cit_id = '$rowuser->a_city_id'");
                                                                        $row = $results->fetch_object();
                                                                        ?>
                                                                        <select class="form-select" name="cit_cnid" id="cit_cnid" required>
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
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th><strong>State</strong></th>
                                                                    <td>
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
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th><strong>District</strong></th>
                                                                    <td>
                                                                        <select class="form-select" name="cit_distid" id="cit_distid" required>
                                                                            <option value=""> Choose District</option>
                                                                            <!--Sub category goes here-->
                                                                            <?php
                                                                            if (!empty($row->cit_distid)) {

                                                                                $sqlt2 = $db->query("select * from district WHERE dist_stid = '$row->cit_stid'");
                                                                                while ($queryt2 = $sqlt2->fetch_object()) {
                                                                                    ?>
                                                                                    <option <?php
                                                                                    if ($row->cit_distid == $queryt2->dist_id) {
                                                                                        echo 'selected';
                                                                                    }
                                                                                    ?> value="<?= $queryt2->dist_id; ?>">
                                                                                            <?= $queryt2->dist_name; ?>
                                                                                    </option>
                                                                                    <?php
                                                                                }
                                                                            }
                                                                            ?>
                                                                        </select>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th><strong>City</strong></th>
                                                                    <td>

                                                                        <select class="form-select" name="cit_id" id="cit_id" required>
                                                                            <option value=""> Choose City</option>
                                                                            <?php
                                                                            if (!empty($row->cit_id)) {

                                                                                $sqlt1c = $db->query("select * from city WHERE cit_distid = $row->cit_distid");
                                                                                while ($queryt1c = $sqlt1c->fetch_object()) {
                                                                                    ?>
                                                                                    <option <?php
                                                                                    if ($row->cit_id == $queryt1c->cit_id) {
                                                                                        echo 'selected';
                                                                                    }
                                                                                    ?> value="<?= $queryt1c->cit_id; ?>">
                                                                                            <?= $queryt1c->cit_name; ?>
                                                                                    </option>
                                                                                    <?php
                                                                                }
                                                                            }
                                                                            ?>

                                                                        </select>
                                                                    </td>
                                                                </tr>

                                                            </tbody>
                                                        </table>
                                                        <div class="form-group">
                                                            <input type="submit" value="Update Info" class="btn btn-primary float-end">
                                                            <input type="hidden" name="submit" value="updatelocation"/>
                                                            <input type="hidden" name="a_id" value="<?= $rowuser->a_id; ?>"/>

                                                        </div>
                                                    </form>
                                                <?php } else { ?>
                                                    <table class="table profile__table">
                                                        <tbody>
                                                            <tr>
                                                                <th><strong>Address</strong></th>
                                                                <td><?= $rowuser->a_address; ?><br>
                                                                    <?php
                                                                    $dataad = $db->query("SELECT * FROM `city` JOIN `state` ON city.cit_stid = state.st_id  JOIN `district` ON city.cit_distid = district.dist_id JOIN `country` ON city.cit_cnid = country.cn_id  WHERE cit_id = '$rowuser->a_city_id' ORDER BY cit_name ASC");
                                                                    $valuead = $dataad->fetch_object();
                                                                    ?>
                                                                    <?= $valuead->cit_name; ?>, <?= $valuead->dist_name; ?>, <?= $valuead->st_name; ?>,  <?= $valuead->cn_name; ?>
                                                                </td>
                                                            </tr>

                                                        </tbody>
                                                    </table>
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <!-- Location info -->
                                        <?php if ($rowuser->a_usertype == '5') { ?>
                                            <div class="panel panel-default">
                                                <div class="panel-heading">
                                                    <h4 class="card-title">Other info
                                                        <?php if (empty($_GET['edt'])) { ?>
                                                            <a href="?edt=gstpan" class="btn btn-info btn-sm float-end" role="button">Edit Info</a>
                                                        <?php } ?>
                                                    </h4>
                                                </div>
                                                <div class="panel-body">
                                                    <?php if (!empty($_GET['edt']) && $_GET['edt'] == 'gstpan') { ?>
                                                        <form  action="pages/action-profile.php" enctype="multipart/form-data" method="post">
                                                            <table class="table profile__table">
                                                                <tbody>
                                                                    <tr>
                                                                        <th><strong>PAN No.</strong></th>
                                                                        <td><input type="text" class="form-control input-sm" name="a_pan_no" value="<?= $rowuser->a_pan_no; ?>"  required></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th><strong>Aadhaar No.</strong></th>
                                                                        <td><input type="text" class="form-control input-sm" name="a_aadhar_no" value="<?= $rowuser->a_aadhar_no; ?>"  required></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th><strong>GST No.</strong></th>
                                                                        <td><input type="text" class="form-control input-sm" name="a_gst_no" value="<?= $rowuser->a_gst_no; ?>"  required></td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                            <div class="form-group">
                                                                <input type="submit" value="Update Info" class="btn btn-primary float-end">
                                                                <input type="hidden" name="submit" value="updateother"/>
                                                                <input type="hidden" name="a_id" value="<?= $rowuser->a_id; ?>"/>

                                                            </div>
                                                        </form>
                                                    <?php } else { ?>
                                                        <table class="table profile__table">
                                                            <tbody>
                                                                <tr>
                                                                    <th><strong>PAN No.</strong></th>
                                                                    <td><?= $rowuser->a_pan_no; ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <th><strong>Aadhaar No.</strong></th>
                                                                    <td><?= $rowuser->a_aadhar_no; ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <th><strong>GST No.</strong></th>
                                                                    <td><?= $rowuser->a_gst_no; ?></td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    <?php } ?>
                                                </div>

                                            </div>
                                        <?php } ?>
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="card-title">Bank Detail info
                                                    <?php if (empty($_GET['edt'])) { ?>
                                                        <a href="?edt=bnkd" class="btn btn-info btn-sm float-end" role="button">Edit Info</a>
                                                    <?php } ?>
                                                </h4>
                                            </div>
                                            <div class="panel-body">
                                                <?php if (!empty($_GET['edt']) && $_GET['edt'] == 'bnkd') { ?>
                                                    <form  action="pages/action-profile.php" enctype="multipart/form-data" method="post">
                                                        <table class="table profile__table">
                                                            <tbody>
                                                                <tr>
                                                                    <th><strong>Bank Account No.</strong></th>
                                                                    <td><input type="text" class="form-control input-sm" name="a_bank_act" value="<?= $rowuser->a_bank_act; ?>"  required></td>
                                                                </tr>
                                                                <tr>
                                                                    <th><strong>IFSC Code</strong></th>
                                                                    <td><input type="text" class="form-control input-sm" name="a_ifsc" value="<?= $rowuser->a_ifsc; ?>"  required></td>
                                                                </tr>
                                                                <tr>
                                                                    <th><strong>Branch Name</strong></th>
                                                                    <td><input type="text" class="form-control input-sm" name="a_bank_branch" value="<?= $rowuser->a_bank_branch; ?>"  required></td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                        <div class="form-group">
                                                            <input type="submit" value="Update Info" class="btn btn-primary float-end">
                                                            <input type="hidden" name="submit" value="updatebank"/>
                                                            <input type="hidden" name="a_id" value="<?= $rowuser->a_id; ?>"/>

                                                        </div>
                                                    </form>
                                                <?php } else { ?>
                                                    <table class="table profile__table">
                                                        <tbody>
                                                            <tr>
                                                                <th><strong>Bank Account No.</strong></th>
                                                                <td><?= $rowuser->a_bank_act; ?></td>
                                                            </tr>
                                                            <tr>
                                                                <th><strong>IFSC Code</strong></th>
                                                                <td><?= $rowuser->a_ifsc; ?></td>
                                                            </tr>
                                                            <tr>
                                                                <th><strong>Branch Name</strong></th>
                                                                <td><?= $rowuser->a_bank_branch; ?></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                <?php } ?>
                                            </div>

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
        <script type="text/javascript">
            $(document).ready(function () {
                $('#cit_distid').on('change', function () {
                    var productID = $(this).val();
                    if (productID) {
                        $.ajax({
                            type: 'POST',
                            url: 'ajax_city.php',
                            data: 'pid=' + productID,
                            success: function (html) {
                                $('#cit_id').html(html);
                            }
                        });
                    } else {
                        $('#cit_distid').html('<option value="">Choose District</option>');
                    }
                });


            });
        </script>
        <script>
            $(document).ready(function () {
                $('#a_photo').change(function () {
                    var val = $(this).val().toLowerCase();
                    var regex = new RegExp("(.*?)\.(jpg|jpeg|png)$");
                    if (!(regex.test(val))) {
                        $(this).val('');
                        alert('Please select correct file format ( jpg|jpeg|png )');
                    }
                });
            });
        </script>
    </body>


</html>
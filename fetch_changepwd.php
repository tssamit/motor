<?php
session_start();
require_once 'config/config.php';
//require_once 'config/helper.php';
if (isset($_POST["aid"]) && !empty($_POST["aid"])) {
    ?>
    <?php
    $a_id = $_POST['aid'];
    $result = $db->query("SELECT a_name, a_page, a_usertype FROM `admin` WHERE a_id = '$a_id'");
    $value = $result->fetch_object();
    $a_name = $value->a_name;
    ?>
    <h4><?= $a_name; ?></h4>

    <form class="form-horizontal" role="form" action="pages/action-pwd.php" enctype="multipart/form-data" method="post">


        <div class="row mb-3">
            <label for="newPassword" class="col-md-4 col-lg-3 col-form-label">New Password</label>
            <div class="col-md-8 col-lg-9">
                <input name="a_password" type="password" class="form-control" id="newPassword" required>
            </div>
        </div>

        <div class="row mb-3">
            <label for="renewPassword" class="col-md-4 col-lg-3 col-form-label">Re-enter New Password</label>
            <div class="col-md-8 col-lg-9">
                <input name="confirm_a_pwd" type="text" class="form-control" id="renewPassword" required>
                <span class="pull-right" id='pwdmessage1'></span>
            </div>
        </div>

        <div class="text-center">
            <button type="submit" class="btn btn-primary">Change Password</button>
            <input type="hidden" name="submit" value="updatepwdAdmin"/>
            <input type="hidden" name="a_id" value="<?= $a_id; ?>"/>

        </div>


    </form>
    <script>
        $('#renewPassword').on('keyup', function () {
            if ($('#newPassword').val() == $('#renewPassword').val()) {
                $('#pwdmessage1').html('Password Matching').css('color', 'green');
            } else
                $('#pwdmessage1').html('Password Not Matching').css('color', 'red');
        });

    </script>

    <?php
}?>
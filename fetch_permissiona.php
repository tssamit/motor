<?php
session_start();
require_once 'config/config.php';
//require_once 'config/helper.php';
if (isset($_POST["rowid"]) && !empty($_POST["rowid"])) {
    ?>
    <?php
    $a_id = $_POST['rowid'];
    $result = $db->query("SELECT a_name, a_page, a_usertype, a_icon FROM `admin` WHERE a_id = '$a_id'");
    $value = $result->fetch_object();
    $a_name = $value->a_name;
    $a_page_path = $value->a_page;
    $desk_path = $value->a_icon;
    ?>
    <h4><?= $a_name; ?></h4>
    <form action="pages/action-accountant.php"  enctype="multipart/form-data" method="post">
        <table  class="table table-striped table-bordered" style="width:100%; font-size: 11px;" id="">
            <thead>
                <tr>
                    <th>Sl.</th>
                    <th>Icon</th>
                    <th>Page Name</th>
                    <th>Ref. Name</th>
                    <th>Path</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $user_type_code = $value->a_usertype;
                $sqltpin1 = $db->query("SELECT act_id,act_name,act_permission,act_icon_permission,act_sts FROM `acc_type` WHERE act_id = '$user_type_code'");
                $querytpin1 = $sqltpin1->fetch_object();
                $path = $querytpin1->act_permission;
                $cnt = 0;
                $resultsnavd2 = $db->query("SELECT refer_name,menu_cust_name,menu_code,path,desktop_icon FROM vw_menu WHERE menu_code IN ($path) ");
                while ($datanav2 = $resultsnavd2->fetch_object()) {

                    $cnt++;
                    ?>
                    <tr>
                        <td><input type="checkbox" name="checkbox_id[]" class="checkval" title="Select to Add" <?php
                            foreach (explode(',', $a_page_path) as $n) {
                                if ($n == $datanav2->menu_code) {
                                    echo 'checked';
                                }
                            }
                            ?> value="<?= $datanav2->menu_code; ?>"> <?= $cnt; ?>. </td>
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
                <tr>
                    <td colspan="4">
                        <input type = "submit" value = "Assign Page" class = "btn btn-primary btn-sm pull-right" onClick = "return confirm('Are you sure want to Assign?')">
                        <input type = "hidden" name = "submit" value = "UserPermissionPageSet"/>
                        <input type = "hidden" name = "a_id" value = "<?= $a_id; ?>"/>
                    </td>
                </tr>
            </tbody>
        </table>

    </form>
    <?php
}?>
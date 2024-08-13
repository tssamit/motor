<?php
session_start();
require_once 'config/config.php';
//require_once 'config/helper.php';
if (isset($_POST["cid"]) && !empty($_POST["cid"])) {
    ?>
    <div  style="overflow: auto; height: 350px; margin-bottom: 20px;">
        <table  class="table table-striped table-bordered" style="width:100%; font-size: 11px;" id="">
            <thead>
                <tr>
                    <th>Sl.</th>
                    <th>Page Name</th>
                    <th>Ref. Name</th>
                    <th>Path</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $user_type_code = $_POST['cid'];
                $sqltpin1 = $db->query("SELECT act_id,act_name,act_permission,act_icon_permission,act_sts FROM `acc_type` WHERE act_id = '$user_type_code'");
                $querytpin1 = $sqltpin1->fetch_object();
                $path = $querytpin1->act_permission;
                $user_type_name = $querytpin1->act_name;

                $cnt = 0;
                $resultsnavd2 = $db->query("SELECT refer_name,menu_cust_name,menu_code,path FROM vw_menu WHERE menu_code IN ($path) ");
                while ($datanav2 = $resultsnavd2->fetch_object()) {

                    $cnt++;
                    ?>
                    <tr>
                        <td><input type="checkbox" name="checkbox_id[]"  title="Select to Add" <?php
                            foreach (explode(',', $path) as $n) {
                                if ($n == $datanav2->menu_code) {
                                    echo 'checked';
                                }
                            }
                            ?> value="<?= $datanav2->menu_code; ?>"> <?= $cnt; ?>. </td>
                        <td><?= $datanav2->menu_cust_name; ?></td>
                        <td><?= $datanav2->refer_name; ?></td>
                        <td><?= $datanav2->path; ?></td>

                    </tr>
                <?php } ?>
            </tbody>
        </table> </div>
    <input type = "submit" value = "Assign Page" class = "btn btn-success btn-sm pull-right" onClick = "return confirm('Are you sure want to Assign?')">
    <input type = "hidden" name = "submit" value = "UsercPageSet"/>
    <?php
}?>
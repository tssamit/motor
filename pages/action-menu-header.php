<?php
session_start();
require_once '../config/config.php';
require_once '../config/helper.php';
$action = $_REQUEST['submit'];
switch ($action) {
    case 'addMenuh':
        $name = mysqli_real_escape_string($db, trim($_POST['name']));
        $cust_name = mysqli_real_escape_string($db, trim($_POST['cust_name']));
        $icon = mysqli_real_escape_string($db, trim($_POST['icon']));
        $ref_cd = mysqli_real_escape_string($db, trim($_POST['ref_cd']));
        //      `usp_menu_header`(IN `transaction_type` VARCHAR(2), IN `header_code` INT, IN `header_name` VARCHAR(100), IN `header_customise_name` VARCHAR(100), IN `icon` VARCHAR(100), IN `refer_code` INT)
        $data = $db->query("SELECT * FROM `vw_menu_header` WHERE name='$name'");
        if ($data->num_rows > 0) {
            $_SESSION['errormsg'] = $name . ' already generated.';
            $_SESSION['errorValue'] = 'warning';
            header("Location: ../menu-header");
        } else {
            //  echo "CALL `usp_menu_header`('I',NULL,'$name','$cust_name','$icon', $ref_cd)";
            //$db->query("CALL `usp_menu_header`('I',NULL,'$name','$cust_name','$icon', $ref_cd)");
            // echo "INSERT INTO menu_hdr(`menu_name`, `menu_cust_name`, `menu_ico`, `menu_ref_cd`) VALUES (UPPER('$name'),'$cust_name','$icon','$ref_cd')";

            $db->query("INSERT INTO menu_hdr(`menu_name`, `menu_cust_name`, `menu_ico`, `menu_ref_cd`) VALUES (UPPER('$name'),'$cust_name','$icon',$ref_cd)");
            $_SESSION['errormsg'] = $name . ' added successfully.';
            $_SESSION['errorValue'] = 'success';
            header("Location: ../menu-header");
        }
        break;
    case 'updateMenuh':
        $menu_code = mysqli_real_escape_string($db, trim($_POST['menu_code']));
        $name = mysqli_real_escape_string($db, trim($_POST['name']));
        $cust_name = mysqli_real_escape_string($db, trim($_POST['cust_name']));
        $icon = mysqli_real_escape_string($db, trim($_POST['icon']));
        $ref_cd = mysqli_real_escape_string($db, trim($_POST['ref_cd']));

        //$db->query("CALL `usp_menu_header`('U',$menu_code,'$name','$cust_name','$icon', $ref_cd)");

        $db->query("UPDATE `menu_hdr` SET `menu_name`= UPPER('$name'), `menu_cust_name`='$cust_name' , `menu_ico`='$icon', `menu_ref_cd`=$ref_cd WHERE `menu_code`='$menu_code';");

        $_SESSION['errormsg'] = $brand_name . ' update successfully.';
        $_SESSION['errorValue'] = 'success';
        header("Location: ../menu-header");

        break;

    case 'brndupdt':
        $id = mysqli_real_escape_string($db, $_GET['id']);
        $st = mysqli_real_escape_string($db, $_GET['st']);
        $db->query("UPDATE `menu_hdr` SET menu_sts = '$st' WHERE menu_code = '$id'");
        //  $db->query("CALL `usp_brand_status`('$st',$id)");
        $_SESSION['errormsg'] = 'Update successfully.';
        $_SESSION['errorValue'] = 'success';
        header("Location: ../menu-header");
        break;
    default:
        $_SESSION['errormsg'] = 'Invalid page access.';
        $_SESSION['errorValue'] = 'warning';
        header("Location: ../404");
}
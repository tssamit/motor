<?php
session_start();
require_once '../config/config.php';
require_once '../config/helper.php';
$action = $_REQUEST['submit'];
switch ($action) {
    case 'addMenusub':
        $menucode = mysqli_real_escape_string($db, trim($_POST['menucode']));
        $menu_hdr_cd = mysqli_real_escape_string($db, trim($_POST['menu_hdr_cd']));
        $page_title = mysqli_real_escape_string($db, trim($_POST['page_title']));
        $menu_name = mysqli_real_escape_string($db, trim($_POST['menu_name']));
        $menu_cust_name = mysqli_real_escape_string($db, trim($_POST['menu_cust_name']));
        $sequence = mysqli_real_escape_string($db, trim($_POST['sequence']));
        $mnu_icon = mysqli_real_escape_string($db, trim($_POST['mnu_icon']));
        $desktop_icon = mysqli_real_escape_string($db, trim($_POST['desktop_icon']));
        $path = mysqli_real_escape_string($db, trim($_POST['path']));

        $data = $db->query("SELECT * FROM `vw_menu` WHERE menu_name='$menu_name' OR path = '$path' ");
        if ($data->num_rows > 0) {
            $_SESSION['errormsg'] = $menu_name . ' already generated.';
            $_SESSION['errorValue'] = 'warning';
            header("Location: ../menu-info");
        } else {
            //  echo "CALL  usp_menu_information ('I',NULL,'$page_title','$menucode','$menu_hdr_cd','$menu_name','$menu_cust_name',$sequence,'$mnu_icon','$desktop_icon','$path')";
            //   $db->query("CALL  usp_menu_information ('I',NULL,'$page_title','$menucode','$menu_hdr_cd','$menu_name','$menu_cust_name',$sequence,'$mnu_icon','$desktop_icon','$path')");

            if ($menu_hdr_cd == '') {
                $data1 = $db->query("SELECT `menu_code` AS header_code FROM vw_menu_header WHERE  `name`= UPPER('$menucode') AND `refer_name` IS NULL");
                $header_code = $data1->fetch_object()->header_code;
            } else {
                $data1 = $db->query("SELECT `menu_code` AS header_code FROM vw_menu_header WHERE  `name`= UPPER('$menu_hdr_cd') AND `refer_name` =UPPER('$menucode')");
                $header_code = $data1->fetch_object()->header_code;
            }
            // echo "INSERT INTO menu_mst (`menu_hdr_cd`, `menu_page_title`, `menu_name` ,`menu_cust_name`, `menu_path`, `menu_sqn`,`menu_icon`, `menu_desk_icon`) VALUES ('$header_code','$page_title',UPPER('$menu_name'),'$menu_cust_name','$path','$sequence','$mnu_icon','$desktop_icon')";
            // exit;
            $db->query("INSERT INTO menu_mst (`menu_hdr_cd`, `menu_page_title`, `menu_name` ,`menu_cust_name`, `menu_path`, `menu_sqn`,`menu_icon`, `menu_desk_icon`) VALUES ('$header_code','$page_title',UPPER('$menu_name'),'$menu_cust_name','$path','$sequence','$mnu_icon','$desktop_icon')");

            $_SESSION['errormsg'] = $menu_name . ' added successfully.';
            $_SESSION['errorValue'] = 'success';
            header("Location: ../menu-info");
        }
        break;
    case 'updateMenusub':
        $menu_code = mysqli_real_escape_string($db, trim($_POST['menu_code']));
        $menucode = mysqli_real_escape_string($db, trim($_POST['menucode']));
        $menu_hdr_cd = mysqli_real_escape_string($db, trim($_POST['menu_hdr_cd']));
        $page_title = mysqli_real_escape_string($db, trim($_POST['page_title']));
        $menu_name = mysqli_real_escape_string($db, trim($_POST['menu_name']));
        $menu_cust_name = mysqli_real_escape_string($db, trim($_POST['menu_cust_name']));
        $sequence = mysqli_real_escape_string($db, trim($_POST['sequence']));
        $mnu_icon = mysqli_real_escape_string($db, trim($_POST['mnu_icon']));
        $desktop_icon = mysqli_real_escape_string($db, trim($_POST['desktop_icon']));
        $path = mysqli_real_escape_string($db, trim($_POST['path']));
        if ($menu_hdr_cd == '') {
            $data1 = $db->query("SELECT `menu_code` AS header_code FROM vw_menu_header WHERE  `name`= UPPER('$menucode') AND `refer_name` IS NULL");
            $header_code = $data1->fetch_object()->header_code;
        } else {
            $data1 = $db->query("SELECT `menu_code` AS header_code FROM vw_menu_header WHERE  `name`= UPPER('$menu_hdr_cd') AND `refer_name` =UPPER('$menucode')");
            $header_code = $data1->fetch_object()->header_code;
        }


        // $db->query("CALL  usp_menu_information ('U',$menu_code,'$page_title','$menucode','$menu_hdr_cd','$menu_name','$menu_cust_name',$sequence,'$mnu_icon','$desktop_icon','$path')");
        $db->query("UPDATE menu_mst SET `menu_hdr_cd`='$header_code', `menu_name`=UPPER('$menu_name'), `menu_cust_name`= '$menu_cust_name', `menu_icon`='$mnu_icon', `menu_desk_icon`='$desktop_icon',  menu_path='$path' , `menu_page_title` ='$page_title', `menu_sqn`= '$sequence'  WHERE `menu_code`= '$menu_code'");
        $_SESSION['errormsg'] = $brand_name . ' update successfully.';
        $_SESSION['errorValue'] = 'success';
        header("Location: ../menu-info");

        break;
    case 'brndupdt':
        $id = mysqli_real_escape_string($db, $_GET['id']);
        $st = mysqli_real_escape_string($db, $_GET['st']);
        $db->query("UPDATE `menu_mst` SET menu_sts = '$st' WHERE menu_code = '$id'");
        //  $db->query("CALL `usp_brand_status`('$st',$id)");
        $_SESSION['errormsg'] = 'Update successfully.';
        $_SESSION['errorValue'] = 'success';
        header("Location: ../menu-info");

        break;

    default:
        $_SESSION['errormsg'] = 'Invalid page access.';
        $_SESSION['errorValue'] = 'warning';
        header("Location: ../404");
}
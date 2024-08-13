<?php
session_start();
require_once '../config/config.php';
require_once '../config/helper.php';
$action = $_REQUEST['submit'];
switch ($action) {
    case 'UsercPageSet':
        $a_usertype = $_POST['user_type_code'];

        $user_name = $_POST['user_name'];
        $user_id = $_POST['user_id'];
        $user_pwd = $_POST['user_pwd'];
        $CPassword = $_POST['CPassword'];
        $a_password = md5($user_pwd);
        $a_email = $_POST['a_email'];
        $a_phone = $_POST['a_phone'];

        $data = $db->query("SELECT * FROM `vw_master_user` WHERE a_username='$user_id'");
        if ($data->num_rows > 0) {
            $_SESSION['errormsg'] = 'This ' . $user_id . ' already generated. Use another USER ID one.';
            $_SESSION['errorValue'] = 'warning';
            header("Location: ../add-dealer");
        } else {

            if ($user_pwd == $CPassword) {
                if (!empty($_POST['checkbox_id'])) {
                    $path = implode(",", $_POST['checkbox_id']);

                    $sqlcode = $db->query("SELECT MAX(CAST(`a_code` AS UNSIGNED)) AS cnt FROM `admin` WHERE a_usertype = '$a_usertype'");
                    $querycode = $sqlcode->fetch_object();
                    if (!empty($querycode->cnt)) {
                        $codeno = $querycode->cnt + 1;
                    } else {
                        $codeno = 1;
                    }
                    // $codeno = str_pad($codeno, 5, "0", STR_PAD_LEFT);
                    //  exit();
                    //  echo "INSERT INTO `admin` (`a_id`, `a_code`, `a_usertype`, `a_username`, `a_password`, `a_vpwd`, `a_name`, `a_email`, `a_phone`, `a_page`, `a_icon`) VALUES (NULL, '$codeno', '$a_usertype', '$user_id', '$a_password', '$CPassword', '$user_name', '$a_email', '$a_phone',  '$path', '$path')";
                    //  exit();
                    $db->query("INSERT INTO `admin` (`a_id`, `a_code`, `a_usertype`, `a_username`, `a_password`, `a_vpwd`, `a_name`, `a_email`, `a_phone`, `a_page`, `a_icon`) VALUES (NULL, '$codeno', '$a_usertype', '$user_id', '$a_password', '$CPassword', '$user_name', '$a_email', '$a_phone',  '$path', '$path')");

                    $_SESSION['errormsg'] = 'User Successfully Created & Assigned.';
                    $_SESSION['errorValue'] = 'success';
                    header("Location: ../add-dealer");
                } else {
                    $_SESSION['errormsg'] = 'You have to assign atleast one page to this user.';
                    $_SESSION['errorValue'] = 'warning';
                    header("Location: ../add-dealer");
                }
            } else {
                $_SESSION['errormsg'] = 'Password Not Matched';
                $_SESSION['errorValue'] = 'warning';
                header("Location: ../add-dealer");
            }
        }

        break;
    case 'UserPermissionPageSet':
        $a_id = $_POST['a_id'];

        if (!empty($_POST['checkbox_id'])) {
            $path = implode(",", $_POST['checkbox_id']);
            if (!empty($_POST['desktop_id'])) {
                $desktop_path = implode(",", $_POST['desktop_id']);
            } else {
                $desktop_path = '';
            }
            $db->query("UPDATE `admin` SET a_page = '$path', a_icon = '$desktop_path' WHERE a_id = '$a_id'");

            $_SESSION['errormsg'] = 'User Successfully Assigned.';
            $_SESSION['errorValue'] = 'success';
            header("Location: ../add-dealer");
        } else {
            $_SESSION['errormsg'] = 'You have to assign atleast one page to this user.';
            $_SESSION['errorValue'] = 'warning';
            header("Location: ../add-dealer");
        }



        break;
    case 'usupdt':
        $id = mysqli_real_escape_string($db, $_GET['id']);
        $st = mysqli_real_escape_string($db, $_GET['st']);
        $db->query("UPDATE `admin` SET a_status = '$st' WHERE a_id = '$id'");
        //  $db->query("CALL `usp_brand_status`('$st',$id)");
        $_SESSION['errormsg'] = 'Update successfully.';
        $_SESSION['errorValue'] = 'success';
        header("Location: ../add-dealer");

        break;
    default:
        $_SESSION['errormsg'] = 'Invalid page access.';
        $_SESSION['errorValue'] = 'danger';
        header("Location: ../404");
}
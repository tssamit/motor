<?php
session_start();
require_once '../config/config.php';
require_once '../config/helper.php';
$action = $_REQUEST['submit'];
switch ($action) {
//    case 'AddTeam':
//
//        $a_name = mysqli_real_escape_string($db, trim($_POST['a_name']));
//        $team_owner = strtoupper(mysqli_real_escape_string($db, trim($_POST['team_owner'])));
//        $a_email = mysqli_real_escape_string($db, trim($_POST['a_email']));
//        $a_phone = mysqli_real_escape_string($db, trim($_POST['a_phone']));
//
//        //  echo $pdid;
//        //  exit;
//        $td_dt = date("Y-m-d H:i");
//        $sqltcode = $db->query("SELECT MAX(CAST(`td_code` AS UNSIGNED)) AS cnt FROM `admin`");
//        $querytcode = $sqltcode->fetch_object();
//        if (!empty($querytcode->cnt)) {
//            $tcodeno = $querytcode->cnt + 1;
//        } else {
//            $tcodeno = 1;
//        }
//        $tcodeno = str_pad($tcodeno, 5, "0", STR_PAD_LEFT);
//        //   team entry
//        $sqltd = $db->query("SELECT * FROM `admin` WHERE td_name='$a_name' ");
//        if ($sqltd->num_rows > 0) {
//            $querytd = $sqltd->fetch_object();
//            $a_id = $querytd->a_id;
//        } else {
//            $db->query("INSERT INTO `admin` (`a_id`, `td_code`, `td_name`, `td_email`, `td_phone`, `td_owner`,`td_dt`) VALUES (NULL,'$tcodeno', '$a_name', '$a_email', '$a_phone', '$team_owner', '$td_dt')");
//            $a_id = $db->insert_id;
//
//            if ($_FILES["a_photo"]["size"] > 0) {
//                $photo = $_FILES['a_photo']['name'];
//                $randgit = substr(str_shuffle("1234567890ABCDEFGHIJKLMNOPUVXYZ"), 0, 6); //rand(0000, 9999);
//                $rano = date('His');
//                $spacer = array(' ', '-', '/', '%', '@'); // replace type
//                $filenamenew = $randgit . $rano . '_' . str_replace($spacer, '_', $photo); // replace space _ or -
//                $allowedExts = array("gif", "jpeg", "jpg", "JPEG", "JPG", "png", "PNG");
//                $temp = explode(".", $_FILES["a_photo"]["name"]);
//                $extension = end($temp);
//                $mime = $_FILES["a_photo"]["type"];
//                if (( ( $mime == "image/gif" ) || ( $mime == "image/jpeg" ) || ( $mime == "image/jpg" ) || ( $mime == "image/JPEG" ) || ( $mime == "image/JPG" ) || ( $mime == "image/pjpeg" ) || ( $mime == "image/x-png" ) || ( $mime == "image/png" ) || ( $mime == "image/PNG" ) || ( $mime == "image/gif" ) ) && in_array($extension, $allowedExts)) {
//                    if ($_FILES["a_photo"]["error"] > 0) {
//                        $db->query("UPDATE `admin` SET a_photo = '' WHERE a_id = '$a_id'");
//                    } else {
//                        // photo crop paramenter start
//                        $file = $_FILES['a_photo']['tmp_name'];
//                        $width = 300; // set width as required
//                        $height = 300; // set height as required
//                        $imgfile = "uploads/" . $filenamenew; // file path name to bestored in database
//                        //$proportional false for rectangular image. if true then it will strict image to crop
//                        smart_resize_image($file, $width, $height, 'false', $imgfile, 'true', 'false');
//                        // photo crop paramenter end after resize
//                        $db->query("UPDATE `admin` SET a_photo = '$filenamenew' WHERE a_id = '$a_id'");
//                    }
//                }
//            }
//        }
//
//        $_SESSION['SESa_id'] = $a_id;
//        $_SESSION['errormsg'] = 'Team added.';
//        $_SESSION['errorValue'] = 'success';
//        header("Location: ../add-team");
//
//        break;
    case 'updateinfo':

        $a_id = mysqli_real_escape_string($db, trim($_POST['a_id']));
        $a_name = mysqli_real_escape_string($db, trim($_POST['a_name']));

        $a_email = mysqli_real_escape_string($db, trim($_POST['a_email'] ?? ''));
        $a_phone = mysqli_real_escape_string($db, trim($_POST['a_phone']));
        $a_company = mysqli_real_escape_string($db, trim($_POST['a_company'] ?? ''));
        $a_desig = mysqli_real_escape_string($db, trim($_POST['a_desig'] ?? ''));

        $sqltd = $db->query("SELECT * FROM `admin` WHERE a_email = '$a_email' AND a_id != '$a_id' ");
        if ($sqltd->num_rows > 0) {
            $_SESSION['errormsg'] = 'Email available.';
            $_SESSION['errorValue'] = 'warning';
            header("Location: ../profile");
        } else {
            $db->query("UPDATE `admin` SET a_name = '$a_name', a_email = '$a_email', a_phone = '$a_phone', a_company = '$a_company', a_desig = '$a_desig' WHERE a_id = '$a_id'");

            if ($_FILES["a_photo"]["size"] > 0) {
                $photo = $_FILES['a_photo']['name'];
                $randgit = substr(str_shuffle("1234567890ABCDEFGHIJKLMNOPUVXYZ"), 0, 9); //rand(0000, 9999);
                $rano = date('His');
                // $spacer = array(' ', '-', '/', '%', '@'); // replace type

                $allowedExts = array("gif", "jpeg", "jpg", "JPEG", "JPG", "png", "PNG");
                $temp = explode(".", $_FILES["a_photo"]["name"]);
                $extension = end($temp);
                $filenamenew = $randgit . $rano . '_profile.' . $extension; // replace space _ or -
                $mime = $_FILES["a_photo"]["type"];
                if (( ( $mime == "image/gif" ) || ( $mime == "image/jpeg" ) || ( $mime == "image/jpg" ) || ( $mime == "image/JPEG" ) || ( $mime == "image/JPG" ) || ( $mime == "image/pjpeg" ) || ( $mime == "image/x-png" ) || ( $mime == "image/png" ) || ( $mime == "image/PNG" ) || ( $mime == "image/gif" ) ) && in_array($extension, $allowedExts)) {
                    if ($_FILES["a_photo"]["error"] > 0) {
                        $db->query("UPDATE `admin` SET a_photo = '' WHERE a_id = '$a_id'");
                    } else {
                        // photo crop paramenter start
                        $file = $_FILES['a_photo']['tmp_name'];
                        $width = 300; // set width as required
                        $height = 300; // set height as required
                        $imgfile = "uploads/" . $filenamenew; // file path name to bestored in database
                        //$proportional false for rectangular image. if true then it will strict image to crop
                        smart_resize_image($file, $width, $height, 'false', $imgfile, 'true', 'false');
                        // photo crop paramenter end after resize
                        $results = $db->query("SELECT a_photo FROM `admin` WHERE a_id = '$a_id'");
                        $row = $results->fetch_object();
                        //unlink($row->a_photo);

                        if (!empty($row->a_photo)) {
                            $filenamechk = "uploads/" . $row->a_photo;
                            if (file_exists($filenamechk)) {
                                unlink($filenamechk);
                            }
                        }
                        $db->query("UPDATE `admin` SET a_photo = '$filenamenew' WHERE a_id = '$a_id'");
                    }
                }
            }

            $_SESSION['errormsg'] = 'Updated';
            $_SESSION['errorValue'] = 'success';
            header("Location: ../profile");
        }


        break;
    case 'updatelocation':

        $a_id = mysqli_real_escape_string($db, trim($_POST['a_id']));
        $a_address = mysqli_real_escape_string($db, trim($_POST['a_address']));
        $a_city_id = mysqli_real_escape_string($db, trim($_POST['cit_id']));

        $db->query("UPDATE `admin` SET a_address = '$a_address', a_city_id = '$a_city_id' WHERE a_id = '$a_id'");

        $_SESSION['errormsg'] = 'Updated';
        $_SESSION['errorValue'] = 'success';
        header("Location: ../profile");

        break;
    case 'updateother':

        $a_id = mysqli_real_escape_string($db, trim($_POST['a_id']));
        $a_pan_no = mysqli_real_escape_string($db, trim($_POST['a_pan_no']));
        $a_aadhar_no = mysqli_real_escape_string($db, trim($_POST['a_aadhar_no']));
        $a_gst_no = mysqli_real_escape_string($db, trim($_POST['a_gst_no']));

        $db->query("UPDATE `admin` SET a_pan_no = '$a_pan_no', a_aadhar_no = '$a_aadhar_no', a_gst_no = '$a_gst_no' WHERE a_id = '$a_id'");

        $_SESSION['errormsg'] = 'Updated';
        $_SESSION['errorValue'] = 'success';
        header("Location: ../profile");

        break;
    case 'updatebank':

        $a_id = mysqli_real_escape_string($db, trim($_POST['a_id']));
        $a_bank_act = mysqli_real_escape_string($db, trim($_POST['a_bank_act']));
        $a_ifsc = mysqli_real_escape_string($db, trim($_POST['a_ifsc']));
        $a_bank_branch = mysqli_real_escape_string($db, trim($_POST['a_bank_branch']));

        $db->query("UPDATE `admin` SET a_bank_act = '$a_bank_act', a_ifsc = '$a_ifsc', a_bank_branch = '$a_bank_branch' WHERE a_id = '$a_id'");

        $_SESSION['errormsg'] = 'Updated';
        $_SESSION['errorValue'] = 'success';
        header("Location: ../profile");

        break;

    default:
        $_SESSION['errormsg'] = 'Invalid page access.';
        $_SESSION['errorValue'] = 'warning';
        header("Location: ../404");
}
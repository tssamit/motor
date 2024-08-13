<?php
if (!empty($_SESSION[SESSVAR])) {
    if (!empty($_SESSION['LOGAUTHValidate'])) {
        $Ltype = $_SESSION['LOGAUTHValidate'];
    } else {
        $Ltype = false;
    }
    if ($_SESSION[SESSVAR] != session_id() && $_SESSION['LOGAUTHType'] != $Ltype) {
        $_SESSION['errormsg'] = 'Invalid page access.';
        $_SESSION['errorValue'] = 'danger';
        header('Location: login');
        exit;
    }
} else {
    $_SESSION['errormsg'] = 'Invalid page access. Login again.';
    $_SESSION['errorValue'] = 'danger';
    header('Location: login');
    exit;
}


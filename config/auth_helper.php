<?php
function chkAuth() { // to check user authenticate
    if (!empty($_SESSION[SESSVAR])) {
        if (!empty($_SESSION['LOGAUTHType'])) {
            $Ltype = $_SESSION['LOGAUTHType'];
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
        $_SESSION['errormsg'] = 'Invalid page access.';
        $_SESSION['errorValue'] = 'danger';
        header('Location: login');
        exit;
    }
}

function chkLogin() { // to check user authenticate
    if (!empty($_SESSION[SESSVAR])) {
        if (!empty($_SESSION['LOGAUTHType'])) {
            $Ltype = $_SESSION['LOGAUTHType'];
        } else {
            $Ltype = false;
        }
        if ($_SESSION[SESSVAR] == session_id() && $_SESSION['LOGAUTHType'] == $Ltype) {
            header('Location: dashboard');
            exit;
        }
    }
}

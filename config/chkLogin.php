<?php
if (!empty($_SESSION[SESSVAR])) {
    if (!empty($_SESSION['LOGAUTHValidate'])) {
        $Ltype = $_SESSION['LOGAUTHValidate'];
    } else {
        $Ltype = false;
    }
    if ($_SESSION[SESSVAR] == session_id() && $_SESSION['LOGAUTHValidate'] == $Ltype) {
        header('Location: dashboard');
        exit;
    }
}


<?php
session_start();
require_once 'config/config.php';
if (isset($_POST["id"]) && !empty($_POST["id"])) {
    //Get all state data
    $query = $db->query("SELECT * FROM `vw_menu_header` WHERE refer_name = '" . $_POST['id'] . "' ORDER BY name ASC");

    //Display states list
    if ($query->num_rows > 0) {
        echo '<option value="">Select Sub Menu</option>';
        while ($row = $query->fetch_object()) {
            echo '<option value="' . $row->name . '">' . $row->name . '</option>';
        }
    } else {
        echo '<option value="">Not Available</option>';
    }
}
<?php
session_start();
require_once 'config/config.php';
require_once 'config/helper.php';
if (isset($_POST["cid"]) && !empty($_POST["cid"])) {
    //Get all state data
    $query = $db->query("SELECT * FROM veh_color WHERE vcl_vmid = " . $_POST['cid'] . " ORDER BY vcl_name ASC");

    //Display states list
    if ($query->num_rows > 0) {
        echo '<option value="">Select Color</option>';
        while ($row = $query->fetch_object()) {
            echo '<option value="' . $row->vcl_id . '">' . $row->vcl_name . '</option>';
        }
    } else {
        echo '<option value="">Color not available</option>';
    }
}
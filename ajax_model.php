<?php
session_start();
require_once 'config/config.php';
require_once 'config/helper.php';
if (isset($_POST["cid"]) && !empty($_POST["cid"])) {
    //Get all state data
    $query = $db->query("SELECT * FROM veh_model WHERE vm_vcid = " . $_POST['cid'] . " ORDER BY vm_model ASC");

    //Display states list
    if ($query->num_rows > 0) {
        echo '<option value="">Select Model</option>';
        while ($row = $query->fetch_object()) {
            echo '<option value="' . $row->vm_id . '">' . $row->vm_model . '</option>';
        }
    } else {
        echo '<option value="">Model not available</option>';
    }
}
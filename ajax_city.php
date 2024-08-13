<?php
session_start();
require_once 'config/config.php';
require_once 'config/helper.php';
if (isset($_POST["pid"]) && !empty($_POST["pid"])) {
    //Get all state data
    $query = $db->query("SELECT * FROM city WHERE cit_distid = " . $_POST['pid'] . " ORDER BY cit_name ASC");

    //Display states list
    if ($query->num_rows > 0) {
        echo '<option value="">Select City</option>';
        while ($row = $query->fetch_object()) {
            echo '<option value="' . $row->cit_id . '">' . $row->cit_name . '</option>';
        }
    } else {
        echo '<option value="">District not available</option>';
    }
}
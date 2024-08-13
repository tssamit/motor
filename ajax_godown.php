<?php
session_start();
require_once 'config/config.php';
require_once 'config/helper.php';
if (isset($_POST["cid"]) && !empty($_POST["cid"])) {
    //Get all state data
    $query = $db->query("SELECT * FROM location_godown WHERE lg_bid = " . $_POST['cid'] . " ORDER BY lg_name ASC");

    //Display states list
    if ($query->num_rows > 0) {
        echo '<option value="">Select Location/Godown</option>';
        while ($row = $query->fetch_object()) {
            echo '<option value="' . $row->lg_id . '">' . $row->lg_name . '</option>';
        }
    } else {
        echo '<option value="">Godown not available</option>';
    }
}
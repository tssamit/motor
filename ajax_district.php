<?php
session_start();
require_once 'config/config.php';
require_once 'config/helper.php';
if(isset($_POST["pid"]) && !empty($_POST["pid"])){
    //Get all state data
    $query = $db->query("SELECT * FROM district WHERE dist_stid = ".$_POST['pid']." ORDER BY dist_name ASC");
    
    //Display states list
    if($query->num_rows > 0){
        echo '<option value="">Select District</option>';
        while($row = $query->fetch_object()){ 
            echo '<option value="'.$row->dist_id.'">'.$row->dist_name.'</option>';
        }
    }else{
        echo '<option value="">District not available</option>';
    }
}
<?php
session_start();
require_once 'config/config.php';
require_once 'config/helper.php';
if(isset($_POST["cid"]) && !empty($_POST["cid"])){
    //Get all state data
    $query = $db->query("SELECT * FROM state WHERE st_cnid = ".$_POST['cid']." ORDER BY st_name ASC");
    
    //Display states list
    if($query->num_rows > 0){
        echo '<option value="">Select State</option>';
        while($row = $query->fetch_object()){ 
            echo '<option value="'.$row->st_id.'">'.$row->st_name.'</option>';
        }
    }else{
        echo '<option value="">State not available</option>';
    }
}
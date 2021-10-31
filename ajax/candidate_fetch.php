<?php
include '../connect.php';
     
     $query = "SELECT * FROM `tbl_candidate` WHERE (`candidate_id` = '".$_POST['candidate_id']."')";  
     $result = mysqli_query($conn, $query);
     $row = mysqli_fetch_array($result);  
     echo json_encode($row);  

?>
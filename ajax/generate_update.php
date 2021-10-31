<?php
include '../connect.php';

    $candidate_user_id1 = $_POST['candidate_id'];
    $candidate_flag = "n";
    $candidate_updated_date = date('Y-m-d');

    $sql = "UPDATE `tbl_candidate` SET `candidate_flag` = '".$candidate_flag."', `update_at` = '".$candidate_updated_date."' WHERE `candidate_id` = '".$candidate_user_id1."'";
    $result = mysqli_query($conn, $sql);
    if($result == true){
        echo "200";
    }else{
        echo "204";
    }


?>
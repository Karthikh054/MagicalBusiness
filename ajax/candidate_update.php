<?php
include '../connect.php';

if(!empty($_POST)) {

    $candidate_name1 = $_POST['candidate_name1'];
    $candidate_mobile1 =  $_POST['candidate_mobile1'];
    $candidate_email1 =  $_POST['candidate_email1'];
    $candidate_location1 = $_POST['candidate_location1'];
    $candidate_annual_ctc1 = $_POST['candidate_annual_ctc1'];
    $candidate_cv1 =  $_FILES['candidate_cv1']['name'];
    $hidden_cv1 = $_POST['hidden_cv1'];
    $candidate_user_id1 = $_POST['candidate_user_id1'];
    $candidate_updated_date = date('Y-m-d');

    if(empty($candidate_cv1)){
        $basename = $hidden_cv1;
    }else{

        $candidate_cv1 = $_FILES['candidate_cv1']['name'];
        $extension  = pathinfo( $_FILES['candidate_cv1']['name'], PATHINFO_EXTENSION ); 
        $basename   = $_POST['candidate_name1'] ."_".$candidate_user_id1. "." . $extension;
        $destination  = "C:\Users\Karthik\Desktop\{$basename}";
        move_uploaded_file( $_FILES['candidate_cv1']['tmp_name'], $destination );
    }

    $sql = "UPDATE `tbl_candidate` SET `candidate_name` = '".$candidate_name1."', `candidate_mobile` = '".$candidate_mobile1."',`candidate_email` = '".$candidate_email1."',`candidate_location` = '".$candidate_location1."',`candidate_cv` = '".$basename."',`candidate_annual_ctc` = '".$candidate_annual_ctc1."', `update_at` = '".$candidate_updated_date."' WHERE `candidate_id` = '".$candidate_user_id1."'";
    $result = mysqli_query($conn, $sql);
    if($result == true){
        echo "200";
    }else{
        echo "204";
    }
}

?>
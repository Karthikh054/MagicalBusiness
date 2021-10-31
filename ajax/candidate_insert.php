<?php
include '../connect.php';

if(empty($_POST['candidate_name'])){
    echo "205";
}else if(empty($_POST['candidate_mobile'])){
    echo "206";
}else if(empty($_POST['candidate_email'])){
    echo "207";
}else if(empty($_POST['candidate_location'])){
    echo "208";
}else if(empty($_FILES['candidate_cv']['name'])){
    echo "209";
}else if(empty($_POST['candidate_annual_ctc'])){
    echo "210";
}else{

    $candidate_name = $_POST['candidate_name'];
    $candidate_mobile = $_POST['candidate_mobile'];
    $candidate_email = $_POST['candidate_email'];
    $candidate_location = $_POST['candidate_location'];
    $candidate_cv = $_FILES['candidate_cv']['name'];
    $candidate_annual_ctc = $_POST['candidate_annual_ctc'];
    $candidate_flag = "y";
    $candidate_user_id = $_POST['candidate_user_id'];
    $candidate_created_date = date('Y-m-d');

    $sql_get = "SELECT MAX(candidate_id) as maxes FROM tbl_candidate";
    $results = mysqli_query($conn, $sql_get);
    $row = mysqli_fetch_array($results,MYSQLI_ASSOC);
    $highest_id = $row['maxes'];
    $highest_id = $highest_id + 1;
    $extension  = pathinfo( $_FILES['candidate_cv']['name'], PATHINFO_EXTENSION ); 
    $basename   = $_POST['candidate_name'] ."_".$highest_id. "." . $extension;
    $destination  = "C:\Users\Karthik\Desktop\{$basename}";
    move_uploaded_file( $_FILES['candidate_cv']['tmp_name'], $destination );

    $sql = "INSERT INTO `tbl_candidate`(`candidate_name`,`candidate_mobile`,`candidate_email`,`candidate_location`,`candidate_joining_date`,`candidate_cv`,`candidate_annual_ctc`,`candidate_flag`,`user_id`,`Created_at`) 
    VALUES('".$candidate_name."','".$candidate_mobile."','".$candidate_email."','".$candidate_location."','".$candidate_created_date."','".$basename."','".$candidate_annual_ctc."','".$candidate_flag."','".$candidate_user_id."','".$candidate_created_date."')";
    $result = mysqli_query($conn, $sql);
    if($result == true){
        echo "200";
    }else{
        echo "204";
    }

}
?>
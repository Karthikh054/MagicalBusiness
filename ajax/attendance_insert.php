<?php
include '../connect.php';

$tbl_candidate_id = $_POST['tbl_candidate_id'];
$absent_date = $_POST['absent_date'];
$attendance_remarks = $_POST['attendance_remarks'];
$attendance_created_date = date('Y-m-d');

$sql_get = "SELECT login_email FROM tbl_login WHERE (login_id = '$tbl_candidate_id')";
$results = mysqli_query($conn, $sql_get);
while($row = mysqli_fetch_array($results)){
    $email = $row['login_email'];
}
$to = $email;
$subject = "Attendance";
$message = "<b>On .$absent_date. you marked has Absent. </b>";    
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
$headers .= 'From: MBS <hkarthik054@gmail.com>' . "\r\n";         
$retval = mail($to, $subject, $message, $headers);
if($retval){

    $sql = "INSERT INTO `tbl_attendance`(`tbl_candidate_id`,`absent_date`,`attendance_remarks`,`Created_at`) VALUES('".$tbl_candidate_id."','".$absent_date."','".$attendance_remarks."','".$attendance_created_date."')";
    $result = mysqli_query($conn, $sql);
    if($result == true){
        echo "200";
    }else{
        echo "204";
    }
}else{
    echo "204";
}
?>
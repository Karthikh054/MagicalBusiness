<?php
include '../connect.php';

    if(empty($_POST['login_email'])){
        echo "205";
    }else if(empty($_POST['login_username'])){
        echo "206";
    }else if(empty($_POST['login_mobile'])){
        echo "207";
    }else if(empty($_POST['login_type'])){
        echo "208";
    }else{

        $login_email = $_POST['login_email'];
        $login_type = $_POST['login_type'];
        $login_status = "Active";
        $login_username = $_POST['login_username'];
        $login_mobile = $_POST['login_mobile'];
        $created_at = date('Y-m-d');

        $sql = "SELECT * FROM tbl_login WHERE (login_email='".$login_email."')";
        $result = mysqli_query($conn, $sql);
        if(mysqli_num_rows($result) > 0){
            echo "209";
        }else{
            
            $sql_insert = "INSERT INTO `tbl_login`(`login_username`,`login_email`,`login_password`,`login_mobile`,`login_type`,`login_status`,`created_at`) VALUES('".$login_username."','".$login_email."','1234','".$login_mobile."','".$login_type."','".$login_status."','".$created_at."')";
            $results = mysqli_query($conn, $sql_insert);
            if($results == true){
                echo "200";
            }else{
                echo "204";
            }
        }
    }
?>
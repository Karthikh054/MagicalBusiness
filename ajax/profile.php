<?php
include '../connect.php';

if($_POST['check_login_type'] == 'admin'){

    if(empty($_POST['login_type'])){
        echo "205";
    }else if(empty($_POST['login_status'])){
        echo "206";
    }else if(empty($_POST['login_username'])){
        echo "207";
    }else if(empty($_POST['login_mobile'])){
        echo "208";
    }else {

        $login_id = $_POST['login_id'];
        $login_type = $_POST['login_type'];
        $login_status = $_POST['login_status'];
        $login_username = $_POST['login_username'];
        $login_mobile = $_POST['login_mobile'];

        $sql_update = "UPDATE tbl_login SET login_username='".$login_username."', login_mobile = '".$login_mobile."', login_type='".$login_type."', login_status='".$login_status."' WHERE login_id = '".$login_id."'";
        $result = mysqli_query($conn, $sql_update);
        if($result == true){
            echo "200";
        }else{
            echo "204";
        }

    }    

}else{

    if(empty($_POST['login_username'])){
        echo "207";
    }else if(empty($_POST['login_mobile'])){
        echo "208";
    }else {

        $login_id = $_POST['login_id'];
        $login_username = $_POST['login_username'];
        $login_mobile = $_POST['login_mobile'];

        $sql_update = "UPDATE tbl_login SET login_username='".$login_username."', login_mobile = '".$login_mobile."' WHERE login_id = '".$login_id."'";
        $result = mysqli_query($conn, $sql_update);
        if($result == true){
            echo "200";
        }else{
            echo "204";
        }
    }
}

?>
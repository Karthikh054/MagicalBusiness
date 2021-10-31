<?php
    include 'connect.php';
    $msg ='';
    if(!isset($_SESSION)){
		session_start();
	}
	if(isset($_GET['logout']))
	{
	    session_destroy();
	}
    if(isset($_POST['submit'])){
        $email = $_POST['email'];
        $password = $_POST['password'];
        $sql = "SELECT * FROM tbl_login WHERE (login_email='".$email."') AND (login_password='".$password."')";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
        $count = mysqli_num_rows($result);
        if($count == 1){
            $type = $row['login_type'];
            $username = $row['login_username'];
            $user_id = $row['login_id'];
            if($type == "user"){
                header("location: candidate.php");
                $_SESSION['name'] = $username;
                $_SESSION['type'] = $type;
                $_SESSION['userid'] = $user_id;
            $_SESSION['LOGOUT']="NO";
            }elseif ($type == "admin"){
                header("location: dashboard.php");
                $_SESSION['name'] = $username;
                $_SESSION['type'] = $type;
                $_SESSION['userid'] = $user_id;
                $_SESSION['LOGOUT']="NO";
            }
            
            
        }else{
            $msg = "Email or Password is Incorrect"; 
        }
        
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>MAGICAL BUSINESS SOLUTIONS</title>

  <link rel="shortcut icon" href="assets/images/logo.jpeg" type="image/x-icon" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link rel="stylesheet" href="assets/css/icheck-bootstrap.min.css">
  <link rel="stylesheet" href="assets/css/adminlte.min.css">
  <link rel="stylesheet" href="assets/css/toastr.min.css">
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="stylesheet" href="assets/css/toastr.min.css">
</head>
<body class="hold-transition dark-mode login-page">
    <div class="login-box">
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <a href="index.php" class="h1">
                <img class="login_img" src="assets/images/logo.jpeg"/>
                </a>
            </div>
            <div class="card-body">
                <form method="post" action="">
                    <div class="input-group mb-3">
                        <input type="email" class="form-control" placeholder="Email" name="email" id="email" required autofocus/>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3" id="pass">
                        <input type="password" class="form-control" name="password" id="password"  placeholder="Password" required/>
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div>
                        </div>
                    <div class="row">
                        <div class="col-12">
                        <?php echo $msg; ?>
                            <input type="button" class="btn btn-primary btn-block" id="submit" value="Send Email"/>
                            <input type="submit" class="btn btn-primary btn-block" name="submit" id="signin" value="Sign In"/>
                        </div>
                    </div>
                </form>
                <p class="mb-2 mt-4">
                    
                </p>
            </div>
        </div>
    </div>
    
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/adminlte.min.js"></script>
    <script src="assets/js/toastr.min.js"></script>
    <script>
        $(document).ready(function() {
            $("#pass").hide();
            $("#signin").css("display", "none");
        });

        $("#submit").click(function(){
            var email = $('#email').val();
            if(email != ""){
                $.ajax({
                    type: 'POST',
                    url: 'ajax/login_email.php',
                    data: {
                        email: email
                    },
                    success: function(response)
                    {
                        if(response == 200){
                            $("#submit").css("display", "none");
                            $("#pass").show();
                            $("#signin").css("display", "block");
                            toastr.success('New Password is sent to Email.')

                        }else if(response == 204){
                            toastr.error('Email is not Found.')
                            $('#email').val('');
                        }
                    }
                });
            }else{
                toastr.error('Enter a Email.')
                $('#email').val('');
            }
        });
    </script>
</body>
</html>
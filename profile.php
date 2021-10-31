<?php
    include "session.php";
    include 'connect.php';

    if(!empty($_GET['id'])){

        $sql = "SELECT * FROM tbl_login WHERE (login_id='".$_GET['id']."')";
        $result = mysqli_query($conn, $sql);

    }else{

        $sql = "SELECT * FROM tbl_login WHERE (login_id='".$_SESSION['userid']."')";
        $result = mysqli_query($conn, $sql);
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
    <link rel="stylesheet" href="assets/css/all.min.css">
    <link rel="stylesheet" href="assets/css/adminlte.min.css">
    <link rel="stylesheet" href="assets/css/toastr.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body class="hold-transition dark-mode sidebar-mini">
    <div class="wrapper">
        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__wobble" src="assets/images/logo.jpeg" alt="gif" height="60" width="60">
        </div>
        <?php include'header.php';?>
        <?php include'sidebar.php';?>
        <div class="content-wrapper">
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Profile</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">Profile</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </section>
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-primary">
                                <form id="userForm" method="POST">
                                    <div class="card-body">
                                        <?php while($row = mysqli_fetch_array($result)){?>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">Email</label>
                                                        <input type="text" name="check_login_type" id="check_login_type" value="<?php echo $_SESSION['type'];?>" hidden/>
                                                        <input type="text" name="login_id" id="login_id" value="<?php echo $row['login_id'];?>" hidden/>
                                                        <input type="email" name="login_email" disabled class="form-control" id="login_email" value="<?php echo $row['login_email'];?>" placeholder="Enter email">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">User Name <span style="color:red;">*</span></label>
                                                        <input type="text" name="login_username" class="form-control" id="login_username" value="<?php echo $row['login_username'];?>" placeholder="Enter User Name" required />
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">Mobile <span style="color:red;">*</span></label>
                                                        <input type="text" name="login_mobile" class="form-control" id="login_mobile" value="<?php echo $row['login_mobile'];?>" placeholder="Enter Mobile" required minlength="10" maxlength="10" />
                                                        <span id="errmsg"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php if(!empty($_GET['id'])){?>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="exampleInputEmail1">User Type <span style="color:red;">*</span></label>
                                                            <select class="form-control" name="login_type" id="login_type" required>
                                                                <option value="field" <?php echo ($row['login_type'] == "field")?'selected':'' ?>>Field</option>
                                                                <option value="user" <?php echo ($row['login_type'] == "user")?'selected':'' ?>>User</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="exampleInputEmail1">Status<span style="color:red;">*</span></label>
                                                            <select class="form-control" name="login_status" id="login_status" required>
                                                                <option value="Inactive" <?php echo ($row['login_status'] == "Inative")?'selected':'' ?>>Inactive</option>
                                                                <option value="Active" <?php echo ($row['login_status'] == "Active")?'selected':'' ?>>Active</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                        <?php } ?>
                                    </div>
                                    <div class="card-footer">
                                        <?php if(!empty($_GET['id'])){?>
                                            <button type="button" id="butsave" class="btn btn-primary">Update</button>
                                        <?php }else{?>
                                            <button type="button" id="butsave" class="btn btn-primary">Submit</button>
                                        <?php } ?>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <?php include 'footer.php'; ?>
    </div>

    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/jquery.validate.min.js"></script>
    <script src="assets/js/additional-methods.min.js"></script>
    <script src="assets/js/adminlte.min.js"></script>
    <script src="assets/js/demo.js"></script>
    <script src="assets/js/toastr.min.js"></script>
    <script>

        $(document).ready(function () {
            $("#login_mobile").keypress(function (e) {
                if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                    $("#errmsg").html("Digits Only").show().fadeOut("slow");
                    return false;
                }
            });
        });



        $("#butsave").click(function(){
                    
            $.ajax({
                
                url: "ajax/profile.php",
                type: "POST",
                enctype: "multipart/form-data",
                data: $('#userForm').serialize(),
                cache: false,
                success: function(response){
                   
                    if(response == 200){
                        $('#userForm').find('input').val('')
                        toastr.success('Data Inserted Successfully.')
                        setTimeout(function() {
                            window.location.reload();
                        }, 5000);
                    }else if(response == 204){
                        $('#userForm').find('input').val('')
                        toastr.error('Data is not Inserted Successfully.')
                        setTimeout(function() {
                            window.location.reload();
                        }, 5000);
                    }else if(response == 205){
                        $('#userForm').find('input').val('')
                        toastr.error('Select Candidate Type.')
                        setTimeout(function() {
                            window.location.reload();
                        }, 5000);
                    }else if(response == 206){
                        $('#userForm').find('input').val('')
                        toastr.error('Select Candidate Status.')
                        setTimeout(function() {
                            window.location.reload();
                        }, 5000);
                    }else if(response == 207){
                        $('#userForm').find('input').val('')
                        toastr.error('Fill Candidate Name .')
                        setTimeout(function() {
                            window.location.reload();
                        }, 5000);
                    }else if(response == 208){
                        $('#userForm').find('input').val('')
                        toastr.error('Fill Candidate Mobile Number.')
                        setTimeout(function() {
                            window.location.reload();
                        }, 5000);
                    }
                }
            });



        });
    </script>
</body>
</html>
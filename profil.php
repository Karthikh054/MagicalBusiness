<?php
    include "session.php";
    include 'connect.php';

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
                                <form id="quickForm" name="quickForm" method="POST" enctype="multipart/form-data">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Email<span style="color:red;">*</span></label>
                                                    <input type="email" name="login_email" class="form-control" id="login_email"  placeholder="Enter email" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">User Name <span style="color:red;">*</span></label>
                                                    <input type="text" name="login_username" class="form-control" id="login_username" placeholder="Enter User Name" required />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Mobile <span style="color:red;">*</span></label>
                                                    <input type="text" name="login_mobile" class="form-control" id="login_mobile" placeholder="Enter Mobile" required minlength="10" maxlength="10" />
                                                    <span id="errmsg"></span>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">User Type <span style="color:red;">*</span></label>
                                                    <select class="form-control" name="login_type" id="login_type" required>
                                                        <option selected disabled >Select User Type </option>
                                                        <option value="user">User</option>
                                                        <option value="field">Field</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <button type="button" name="butsave" id="butsave" class="btn btn-primary">Submit</button>
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
                
                url: "ajax/profil_insert.php",
                type: "POST",
                enctype: "multipart/form-data",
                data: $('#quickForm').serialize(),
                cache: false,
                success: function(response){
                    if(response == 200){
                        $('#quickForm').find('input').val('')
                        toastr.success('Data Inserted Successfully.')
                        setTimeout(function() {
                            window.location.reload();
                        }, 5000);
                    }else if(response == 204){
                        $('#quickForm').find('input').val('')
                        toastr.error('Data is not Inserted Successfully.')
                        setTimeout(function() {
                            window.location.reload();
                        }, 5000);
                    }else if(response == 205){
                        $('#quickForm').find('input').val('')
                        toastr.error('Fill User Email.')
                        setTimeout(function() {
                            window.location.reload();
                        }, 5000);
                    }else if(response == 206){
                        $('#quickForm').find('input').val('')
                        toastr.error('Fill User Name.')
                        setTimeout(function() {
                            window.location.reload();
                        }, 5000);
                    }else if(response == 207){
                        $('#quickForm').find('input').val('')
                        toastr.error('Fill Candidate Mobile Number.')
                        setTimeout(function() {
                            window.location.reload();
                        }, 5000);
                    }else if(response == 208){
                        $('#quickForm').find('input').val('')
                        toastr.error('Select Candidate Type.')
                        setTimeout(function() {
                            window.location.reload();
                        }, 5000);
                    }else if(response == 209){
                        $('#quickForm').find('input').val('')
                        toastr.error('Email is already Registered.')
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
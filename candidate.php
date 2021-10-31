<?php
    include "session.php";
    include 'connect.php';
    
    if($_SESSION['type'] == "user"){

        $sql = "SELECT * FROM tbl_candidate WHERE (user_id='".$_SESSION['userid']."') ORDER BY candidate_id DESC";
        $result = mysqli_query($conn, $sql);

    }else if($_SESSION['type'] == "admin"){

        $sql = "SELECT tbl_candidate.*, tbl_login.*  FROM tbl_candidate,tbl_login WHERE (tbl_candidate.user_id = tbl_login.login_id) ORDER BY tbl_candidate.candidate_id DESC";
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="assets/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="assets/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="assets/css/buttons.bootstrap4.min.css">
    <link rel="stylesheet" href="assets/css/adminlte.min.css">
    <link rel="stylesheet" href="assets/css/toastr.min.css">
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
                            <h1>Candidate</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">Candidate</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </section>
            <style>
                #errmsg
                {
                    color: red;
                }
                .mbtn{
                    margin-top: 0px;
                    position: absolute;
                    z-index: 1;
                }
                @media only screen and (max-width: 600px) {
                    .mbtn{
                        position:initial;
                        margin-left: 75px;
                        margin-bottom: 20px;
                    }
                }
            </style>
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <?php if($_SESSION['type'] == "user"){?>
                                        <button type="button" class="btn btn-primary mbtn" data-toggle="modal" data-target="#addcandidate">
                                            <i class="fa fa-plus"></i>
                                                Add Candidate 
                                        </button>
                                    <?php } ?>     
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Sl No</th>
                                                <th>Name</th>
                                                <th>Mobile</th>
                                                <th>Email</th>
                                                <th>Location</th>
                                                <th>CV</th>
                                                <th>Annual CTC</th>
                                                <th>Joining Date</th>
                                                <?php if($_SESSION['type'] == "admin"){?>
                                                    <th>User Create By</th>
                                                    <th>Edit</th>
                                                <?php } ?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = "1";
                                                while($row = mysqli_fetch_array($result)){
                                                    
                                                ?>
                                                <tr>
                                                    <td><?php echo $i;?></td>
                                                    <td><?php echo $row['candidate_name'];?></td>
                                                    <td><?php echo $row['candidate_mobile'];?></td>
                                                    <td><?php echo $row['candidate_email'];?></td>
                                                    <td><?php echo $row['candidate_location'];?></td>
                                                    <td><?php echo $row['candidate_cv'];?></td>
                                                    <td><?php echo $row['candidate_annual_ctc'];?></td>
                                                    <td><?php echo date("d-m-Y", strtotime($row['candidate_joining_date'])) ;?></td>
                                                    <?php if($_SESSION['type'] == "admin"){?>
                                                        <td><?php echo $row['login_username'];?></td>
                                                        <td>
                                                            <a class="edit_data" style="cursor:pointer;" id="<?php echo $row["candidate_id"]; ?>">
                                                                <i class="fas fa-pencil-alt"></i>
                                                            </a>
                                                        </td>
                                                    <?php } ?>
                                                </tr>
                                            <?php $i++; } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <?php include 'footer.php'; ?>
        
        <div class="modal fade" id="addcandidate">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Add Candidate</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="userForm" name="userForm" method="POST" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Name 
                                            <span style="color:red;">
                                                *
                                            </span>
                                        </label>
                                        <input type="text" class="form-control" name="candidate_name" id="candidate_name" placeholder="Enter Candidate Name" required />
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Mobile 
                                            <span style="color:red;">
                                                *
                                            </span>
                                        </label>
                                        <input type="text" class="form-control" name="candidate_mobile" id="candidate_mobile" placeholder="Enter Candidate Mobile" minlength="10" maxlength="10" required />
                                        <span id="errmsg"></span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Email 
                                            <span style="color:red;">
                                                *
                                            </span>
                                        </label>
                                        <input type="email" class="form-control" name="candidate_email" id="candidate_email" placeholder="Enter Candidate Email" required />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Location 
                                            <span style="color:red;">
                                                *
                                            </span>
                                        </label>
                                        <input type="text" class="form-control" name="candidate_location" id="candidate_location" placeholder="Enter Candidate Location" required />
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Annual CTC 
                                            <span style="color:red;">
                                                *
                                            </span>
                                        </label>
                                        <input type="text" class="form-control" name="candidate_annual_ctc" id="candidate_annual_ctc" placeholder="Enter Candidate Annual CTC" required />
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>CV 
                                            <span style="color:red;">
                                                *
                                            </span>
                                        </label>
                                        <input type="file" class="form-control" name="candidate_cv" id="candidate_cv" accept="application/pdf"  placeholder="Enter Candidate CV" required />
                                        <input type="text" name="candidate_user_id" id="candidate_user_id" value="<?php echo $_SESSION['userid'];?>" hidden/>
                                    </div>
                                </div>

                            </div>
                        </form>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <input type="button" id="butsave" class="btn btn-primary" data-dismiss="modal" value="Submit"/>
                    </div>
                </div>
            </div>
        </div>

        <div id="add_data_Modal" class="modal fade">  
            <div class="modal-dialog modal-lg">  
                <div class="modal-content">  
                    <div class="modal-header">  
                        <h4 class="modal-title">Edit Candidate</h4> 
                        <button type="button" class="close" data-dismiss="modal">&times;</button>  
                    </div>  
                    <div class="modal-body">  
                        <form method="post" id="insert_form" method="POST" enctype="multipart/form-data">  
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Name 
                                            <span style="color:red;">
                                                *
                                            </span>
                                        </label>
                                        <input type="text" class="form-control" name="candidate_name1" id="candidate_name1" placeholder="Enter Candidate Name" required />
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Mobile 
                                            <span style="color:red;">
                                                *
                                            </span>
                                        </label>
                                        <input type="text" class="form-control" name="candidate_mobile1" id="candidate_mobile1" placeholder="Enter Candidate Mobile" minlength="10" maxlength="10" required />
                                        <span id="errmsg"></span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Email 
                                            <span style="color:red;">
                                                *
                                            </span>
                                        </label>
                                        <input type="email" class="form-control" name="candidate_email1" id="candidate_email1" placeholder="Enter Candidate Email" required />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Location 
                                            <span style="color:red;">
                                                *
                                            </span>
                                        </label>
                                        <input type="text" class="form-control" name="candidate_location1" id="candidate_location1" placeholder="Enter Candidate Location" required />
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Annual CTC 
                                            <span style="color:red;">
                                                *
                                            </span>
                                        </label>
                                        <input type="text" class="form-control" name="candidate_annual_ctc1" id="candidate_annual_ctc1" placeholder="Enter Candidate Annual CTC" required />
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>CV </label>
                                        <input type="file" class="form-control" accept="application/pdf" name="candidate_cv1" id="candidate_cv1" placeholder="Enter Candidate CV" />
                                        <span id="candidate_cv_name"></span>
                                        <input type="text" name="hidden_cv1" id="hidden_cv1" hidden/>
                                        <input type="text" name="candidate_user_id1" id="candidate_user_id1" hidden/>
                                    </div>
                                </div>
                            </div>
                       
                    <div class="modal-footer">  
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>  
                        <input type="hidden" name="employee_id" id="employee_id" />  
                        <input type="submit" name="insert" id="insert" value="Update" class="btn btn-success" />  
                    </div> 
                    </form>  
                    </div>   
                </div>  
            </div>  
        </div> 
    </div>

    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/jquery.dataTables.min.js"></script>
    <script src="assets/js/dataTables.bootstrap4.min.js"></script>
    <script src="assets/js/dataTables.responsive.min.js"></script>
    <script src="assets/js/responsive.bootstrap4.min.js"></script>
    <script src="assets/js/dataTables.buttons.min.js"></script>
    <script src="assets/js/buttons.bootstrap4.min.js"></script>
    <script src="assets/js/jszip.min.js"></script>
    <script src="assets/js/pdfmake.min.js"></script>
    <script src="assets/js/vfs_fonts.js"></script>
    <script src="assets/js/buttons.html5.min.js"></script>
    <script src="assets/js/buttons.print.min.js"></script>
    <script src="assets/js/buttons.colVis.min.js"></script>
    <script src="assets/js/adminlte.min.js"></script>
    <script src="assets/js/demo.js"></script>
    <script src="assets/js/toastr.min.js"></script>
    <script>
        $(function () {
            $("#example1").DataTable({
                "responsive": true, "lengthChange": false, "autoWidth": false
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
            $('#example2').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
        });
    </script>

    <script>
        $(document).ready(function () {
            $("#candidate_mobile").keypress(function (e) {
                if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                    $("#errmsg").html("Digits Only").show().fadeOut("slow");
                    return false;
                }
            });

            $("#candidate_mobile1").keypress(function (e) {
                if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                    $("#errmsg").html("Digits Only").show().fadeOut("slow");
                    return false;
                }
            });
        });
    </script>

    <script>

        $("#butsave").click(function(){
            var c = document.getElementById("candidate_cv").value;
            alert(c);
            $.ajax({
                
                url: "ajax/candidate_insert.php",
                type: "POST",
                enctype: "multipart/form-data",
                data: $('#userForm').serialize(),
                success: function(response){
                    alert(response);
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
                        toastr.error('Fill Candidate Name.')
                        setTimeout(function() {
                            window.location.reload();
                        }, 5000);
                    }else if(response == 206){
                        $('#userForm').find('input').val('')
                        toastr.error('Fill Mobile Number.')
                        setTimeout(function() {
                            window.location.reload();
                        }, 5000);
                    }else if(response == 207){
                        $('#userForm').find('input').val('')
                        toastr.error('Fill Email .')
                        setTimeout(function() {
                            window.location.reload();
                        }, 5000);
                    }else if(response == 208){
                        $('#userForm').find('input').val('')
                        toastr.error('Fill Location.')
                        setTimeout(function() {
                            window.location.reload();
                        }, 5000);
                    }else if(response == 209){
                        $('#userForm').find('input').val('')
                        toastr.error('Fill Candidate CV.')
                        setTimeout(function() {
                            window.location.reload();
                        }, 5000);
                    }else if(response == 210){
                        $('#userForm').find('input').val('')
                        toastr.error('Fill Annual CTC.')
                        setTimeout(function() {
                            window.location.reload();
                        }, 5000);
                    }
                }
            });
        });
    </script>

    <script>
        $(document).on('click', '.edit_data', function(){  
           var candidate_id = $(this).attr("id"); 
           $.ajax({  
                url:"ajax/candidate_fetch.php",  
                method:"POST",  
                data:{candidate_id: candidate_id},  
                dataType:"json",  
                success:function(data){  
                    alert(data.candidate_cv);
                     $('#candidate_name1').val(data.candidate_name);  
                     $('#candidate_mobile1').val(data.candidate_mobile);  
                     $('#candidate_email1').val(data.candidate_email);  
                     $('#candidate_location1').val(data.candidate_location);  
                     $('#candidate_annual_ctc1').val(data.candidate_annual_ctc);  
                     $('#hidden_cv1').val(data.candidate_cv);  
                     $('#candidate_cv_name').text(data.candidate_cv);  
                     $('#candidate_user_id1').val(data.candidate_id);  
                     $('#insert').val("Update");  
                     $('#add_data_Modal').modal('show');  
                }  
           });  
      }); 
    </script>

    <script>
        $('#insert_form').on("submit", function(event){  
           event.preventDefault();  
           if($('#candidate_name1').val() == "")  
           {  
                toastr.error('Please fill Candidate Name field !.')  
           }  
           else if($('#candidate_mobile1').val() == '')  
           {  
                toastr.error('Please fill Mobile field !.')  
           }  
           else if($('#candidate_email1').val() == '')  
           {  
                toastr.error('Please fill Email field !.')   
           }  
           else if($('#candidate_location1').val() == '')  
           {  
                toastr.error('Please fill Location field !.')   
           }  
           else if($('#candidate_annual_ctc1').val() == '')  
           {  
                toastr.error('Please fill Annual CTC field !.')   
           } 
           else  
           {  
                $.ajax({  
                     url:"ajax/candidate_update.php",  
                     method:"POST",  
                     data:$('#insert_form').serialize(),  
                     beforeSend:function(){  
                          $('#insert').val("Updating");  
                     },  
                    success:function(response){  
                        if(response == 200){
                            $('#insert_form')[0].reset();  
                            $('#add_data_Modal').modal('hide'); 
                            toastr.success('Data Inserted Successfully.')
                            setTimeout(function() {
                                window.location.reload();
                            }, 5000);
                        }else if(response == 204){
                            $('#insert_form')[0].reset();  
                            $('#add_data_Modal').modal('hide'); 
                            toastr.error('Data is not Inserted Successfully.')
                            setTimeout(function() {
                                window.location.reload();
                            }, 5000);
                        }
                    }  
                });  
            }  
        }); 
    </script>

</body>
</html>

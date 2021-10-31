<?php
    include "session.php";
    include 'connect.php';

        $sql = "SELECT tbl_candidate.*, tbl_login.*  FROM tbl_candidate,tbl_login WHERE (tbl_candidate.user_id = tbl_login.login_id) AND (tbl_candidate.candidate_flag = 'y') AND (tbl_candidate.candidate_joining_date < CURRENT_DATE - 30) ORDER BY tbl_candidate.candidate_id DESC";
        $result = mysqli_query($conn, $sql);
    
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
                            <h1>Tickets</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">Tickets</li>
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
                                                <th>User Create By</th>
                                                <th>Generate</th>
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
                                                    <td><?php echo $row['login_username'];?></td>
                                                    <td>
                                                        <a class="edit_data" style="cursor:pointer;" id="<?php echo $row["candidate_id"]; ?>">
                                                            <i class="fas fa-pencil-alt"></i>
                                                        </a>
                                                    </td>
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

        <div id="add_data_Modal" class="modal fade">  
            <div class="modal-dialog modal-lg">  
                <div class="modal-content">  
                    <div class="modal-header">  
                        <h4 class="modal-title">Generate Tickets</h4> 
                        <button type="button" class="close" data-dismiss="modal">&times;</button>  
                    </div>  
                    <div class="modal-body">  
                        <form method="post" id="insert_form" method="POST" enctype="multipart/form-data">  
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <h3 style="text-align:center;"> Do you want to Generate a Ticket ?</h3>
                                        <input type="text" name="candidate_user_id1" id="candidate_user_id1" hidden/>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">  
                                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>  
                                <input type="button" name="insert" id="insert" value="Yes" class="btn btn-success" />  
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
        $(document).on('click', '.edit_data', function(){  
           var candidate_id = $(this).attr("id"); 
           $.ajax({  
                url:"ajax/generate_fetch.php",  
                method:"POST",  
                data:{candidate_id: candidate_id},  
                dataType:"json",  
                success:function(data){  
                    $('#candidate_user_id1').val(data.candidate_id);  
                    $('#insert').val("Yes");  
                    $('#add_data_Modal').modal('show');  
                }  
           });  
      }); 
    </script>

    <script>
        $("#insert").click(function(){
            var candidate_id = $('#candidate_user_id1').val();
            $.ajax({  
                url:"ajax/generate_update.php",  
                method:"POST",  
                data:{
                    candidate_id: candidate_id
                },  
                success:function(response){  
                    
                    if(response == 200){
                        $('#userForm').find('input').val('')
                        $('#insert_form')[0].reset();  
                        $('#add_data_Modal').modal('hide'); 
                        toastr.success('Data Updated Successfully.')
                        setTimeout(function() {
                            window.location.reload();
                        }, 5000);
                    }else if(response == 204){
                        $('#userForm').find('input').val('')
                        $('#insert_form')[0].reset();  
                        $('#add_data_Modal').modal('hide'); 
                        toastr.error('Data is not Inserted Successfully.')
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
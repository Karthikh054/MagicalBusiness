<?php
    include "session.php";
    include 'connect.php';
    
    if($_SESSION['type'] == "user"){

        $sql = "SELECT * FROM tbl_attendance WHERE (tbl_candidate_id='".$_SESSION['userid']."') ORDER BY attendance_id DESC";
        $result = mysqli_query($conn, $sql);

    }else if($_SESSION['type'] == "admin"){

        $sql = "SELECT tbl_attendance.*, tbl_login.*  FROM tbl_attendance,tbl_login WHERE (tbl_attendance.tbl_candidate_id = tbl_login.login_id) ORDER BY tbl_attendance.attendance_id DESC";
        $result = mysqli_query($conn, $sql);
    }

    $sql_user = "SELECT login_id,login_username FROM tbl_login WHERE (login_status = 'Active') AND (login_type = 'user')";
    $result_user = mysqli_query($conn, $sql_user);
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
                            <h1>Attendance</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">Attendance</li>
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
                                    <?php if($_SESSION['type'] == "admin"){?>
                                        <button type="button" class="btn btn-primary mbtn" data-toggle="modal" data-target="#addcandidate">
                                            <i class="fa fa-plus"></i>
                                             Add Attendance 
                                        </button>
                                    <?php } ?>     
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Sl No</th>
                                                <?php if($_SESSION['type'] == "admin"){?>
                                                    <th>Name</th>
                                                <?php } ?>
                                                <th>Absent Date</th>
                                                <th>Remarks</th>
                                                <?php if($_SESSION['type'] == "user"){?>
                                                    <th>Action</th>
                                                <?php } ?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = "1";
                                                while($row = mysqli_fetch_array($result)){
                                                    
                                                ?>
                                                <tr>
                                                    <td><?php echo $i;?></td>
                                                    <?php if($_SESSION['type'] == "admin"){?>
                                                        <td><?php echo $row['login_username'];?></td>
                                                    <?php } ?>
                                                    <td><?php echo date("d-m-Y", strtotime($row['absent_date'])) ;?></td>
                                                    <td><?php echo $row['attendance_remarks'];?></td>
                                                    <?php if($_SESSION['type'] == "user"){?>
                                                        <td>
                                                            <a class="edit_data" style="cursor:pointer;" id="<?php echo $row['attendance_id']; ?>" >
                                                                <i class="fas fa-envelope"></i>
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
                        <h4 class="modal-title">Add Attendance</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="userForm" name="userForm" method="POST" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Name 
                                            <span style="color:red;">
                                                *
                                            </span>
                                        </label>
                                        <select name="tbl_candidate_id" id="tbl_candidate_id" class="form-control" required>
                                            <option disabled selected>Please Select Name</option>
                                            <?php
                                                while($row_user = mysqli_fetch_array($result_user)){?>
                                                <option value="<?Php echo $row_user['login_id'];?>"><?Php echo $row_user['login_username'];?></option>
                                            <?php }?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Absent Date 
                                            <span style="color:red;">
                                                *
                                            </span>
                                        </label>
                                        <input type="date" class="form-control" name="absent_date" id="absent_date" required />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Remarks</label>
                                        <input type="text" class="form-control" name="attendance_remarks" id="attendance_remarks" placeholder="Enter Remarks" />
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

        $("#butsave").click(function(){
            var tbl_candidate_id = $('#tbl_candidate_id').val();
            var absent_date = $('#absent_date').val();
            var attendance_remarks = $('#attendance_remarks').val();
            
            if(tbl_candidate_id!="" && absent_date!=""){
                $.ajax({
                    url: "ajax/attendance_insert.php",
                    type: "POST",
                    mimeType: "multipart/form-data",
                    data: {
                        tbl_candidate_id: tbl_candidate_id,
                        absent_date: absent_date,
                        attendance_remarks: attendance_remarks
                    },
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
                        }
                    }
                });
            }
            else{
                toastr.error('Please fill all the field !.')
            }
        });
        
        

    </script>

</body>
</html>

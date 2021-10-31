<?php
  include "session.php";
  include 'connect.php';

  //Total Candidates
  $sql_candidate = "SELECT * FROM tbl_candidate";
  $row_candidate = mysqli_query($conn, $sql_candidate);
  $result_candidate = mysqli_num_rows($row_candidate);

 //Total Users
 $sql_users = "SELECT * FROM tbl_login WHERE login_type='user'";
 $row_users = mysqli_query($conn, $sql_users);
 $result_users = mysqli_num_rows($row_users);

 //Total Fields
 $sql_fields = "SELECT * FROM tbl_login WHERE login_type='field'";
 $row_fields = mysqli_query($conn, $sql_fields);
 $result_fields = mysqli_num_rows($row_fields);

//Total Tickets
$sql_tickets = "SELECT * FROM tbl_candidate WHERE (candidate_flag='y') AND (candidate_joining_date < CURRENT_DATE - 30)";
$row_tickets = mysqli_query($conn, $sql_tickets);
$result_tickets = mysqli_num_rows($row_tickets);

//Candidate and users list
$sql_cand = "SELECT tbl_login.login_username, tbl_login.login_email, Count(tbl_candidate.candidate_id) as total_count FROM tbl_candidate, tbl_login WHERE 
(tbl_candidate.user_id = tbl_login.login_id) AND 
(tbl_login.login_type = 'user') AND 
(tbl_login.login_status = 'Active') 
GROUP BY tbl_login.login_username";
$row_cand = mysqli_query($conn, $sql_cand);

//Location and users list
$sql_location ="SELECT Count(candidate_id) as total_location, candidate_location FROM tbl_candidate GROUP BY candidate_location";
$row_location = mysqli_query($conn, $sql_location);

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
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="assets/css/OverlayScrollbars.min.css">
    <link rel="stylesheet" href="assets/css/adminlte.min.css">
  </head>
  <body class="hold-transition dark-mode sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
    <div class="wrapper">
      <div class="preloader flex-column justify-content-center align-items-center">
        <img class="animation__wobble" src="assets/images/logo.jpeg" alt="gif" height="60" width="60">
      </div>
      <?php include'header.php';?>
      <?php include'sidebar.php';?>
      <div class="content-wrapper">
        <div class="content-header">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-6">
                <h1 class="m-0">Dashboard</h1>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="#">Home</a></li>
                  <li class="breadcrumb-item active">Dashboard</li>
                </ol>
              </div>
            </div>
          </div>
        </div>
        
        <section class="content">
          <div class="container-fluid">
            <div class="row">
              <div class="col-12 col-sm-6 col-md-3">
                <div class="small-box bg-info">
                  <div class="inner">
                    <h3><?php echo $result_candidate; ?></h3>
                    <p>Total Candidates</p>
                  </div>
                  <div class="icon">
                    <i class="fas fa-shopping-cart"></i>
                  </div>
                  <a href="candidate.php" class="small-box-footer">
                    More info <i class="fas fa-arrow-circle-right"></i>
                  </a>
                </div>
              </div>
              <div class="col-12 col-sm-6 col-md-3">
                <div class="small-box bg-success">
                  <div class="inner">
                    <h3><?php echo $result_users; ?></h3>
                    <p>Total Users</p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                  </div>
                  <a href="profiles.php" class="small-box-footer">
                    More info <i class="fas fa-arrow-circle-right"></i>
                  </a>
                </div>
              </div>
              <div class="clearfix hidden-md-up"></div>
              <div class="col-12 col-sm-6 col-md-3">
                <div class="small-box bg-warning">
                  <div class="inner">
                    <h3><?php echo $result_fields; ?></h3>
                    <p>Total Fields</p>
                  </div>
                  <div class="icon">
                    <i class="fas fa-user-plus"></i>
                  </div>
                  <a href="profiles.php" class="small-box-footer">
                    More info <i class="fas fa-arrow-circle-right"></i>
                  </a>
                </div>
              </div>
              <div class="col-12 col-sm-6 col-md-3">
                <div class="small-box bg-danger">
                  <div class="inner">
                    <h3><?php echo $result_tickets; ?></h3>
                    <p>Tickets</p>
                  </div>
                  <div class="icon">
                    <i class="fas fa-chart-pie"></i>
                  </div>
                  <a href="generate.php" class="small-box-footer">
                    More info <i class="fas fa-arrow-circle-right"></i>
                  </a>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-8">
                <div class="card">
                  <div class="card-header border-transparent">
                    <h3 class="card-title">Candidates</h3>
                    <div class="card-tools">
                      <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                      </button>
                      <button type="button" class="btn btn-tool" data-card-widget="remove">
                        <i class="fas fa-times"></i>
                      </button>
                    </div>
                  </div>
                  <div class="card-body p-0">
                    <div class="table-responsive">
                      <table class="table m-0">
                        <thead>
                          <tr>
                            <th>Sl No</th>
                            <th>User Name</th>
                            <th>Email</th>
                            <th>Total</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php 
                            $i = "1";
                            while($row = mysqli_fetch_array($row_cand)){
                          ?>
                          <tr>
                            <td><?php echo $i;?></td>
                            <td><?php echo $row['login_username'];?></td>
                            <td><?php echo $row['login_email'];?></td>
                            <td><span class="badge badge-danger"><?php echo $row['total_count'];?> Candidates</span></td>
                          </tr>
                          <?php $i++; } ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-4">
              <div class="card">
                  <div class="card-header border-transparent">
                    <h3 class="card-title">Candidates</h3>
                    <div class="card-tools">
                      <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                      </button>
                      <button type="button" class="btn btn-tool" data-card-widget="remove">
                        <i class="fas fa-times"></i>
                      </button>
                    </div>
                  </div>
                  <div class="card-body p-0">
                    <div class="table-responsive">
                      <table class="table m-0">
                        <thead>
                          <tr>
                            <th>Sl No</th>
                            <th>Place</th>
                            <th>Total</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php 
                            $i = "1";
                            while($rows = mysqli_fetch_array($row_location)){
                          ?>
                          <tr>
                            <td><?php echo $i;?></td>
                            <td><?php echo $rows['candidate_location'];?></td>
                            <td><span class="badge badge-danger"><?php echo $rows['total_location'];?> Candidates</span></td>
                          </tr>
                          <?php $i++; } ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
      </div>
      <aside class="control-sidebar control-sidebar-dark"></aside>
      <?php include'footer.php';?>
    </div>

    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/jquery.overlayScrollbars.min.js"></script>
    <script src="assets/js/adminlte.js"></script>
    <script src="assets/js/jquery.mousewheel.js"></script>
    <script src="assets/js/raphael.min.js"></script>
    <script src="assets/js/jquery.mapael.min.js"></script>
    <script src="assets/js/usa_states.min.js"></script>
    <script src="assets/js/Chart.min.js"></script>
    <script src="assets/js/demo.js"></script>
    <script src="assets/js/dashboard2.js"></script>
  </body>
</html>
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <a href="dashboard.php" class="brand-link">
    <img src="assets/images/logo.jpeg" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-light">MBS</span>
  </a>
  
  <div class="sidebar">
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="assets/images/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">
        <a href="#" class="d-block"><?php echo $_SESSION['name'];?></a>
      </div>
    </div>
    
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
      <?php if($_SESSION['type'] == "admin"){?>
        <li class="nav-item">
          <a href="dashboard.php" class="nav-link">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            Dashboard
          </a>
        </li>
      <?php } ?>
        <li class="nav-item">
          <a href="candidate.php" class="nav-link">
            <i class="nav-icon fas fa-table"></i>
            Candidate
          </a>
        </li>
        <li class="nav-item">
          <a href="attendance.php" class="nav-link">
            <i class="nav-icon fas fa-edit"></i>
            Attendance
          </a>
        </li>
        <?php if($_SESSION['type'] == "admin"){?>
          <li class="nav-item">
            <a href="profiles.php" class="nav-link">
              <i class="nav-icon fas fa-user"></i>
              Profiles
            </a>
          </li>
          <li class="nav-item">
            <a href="generate.php" class="nav-link">
              <i class="nav-icon fas fa-copy"></i>
              Tickets
            </a>
          </li>
        <?php }else{ ?>
          <li class="nav-item">
            <a href="profile.php" class="nav-link">
              <i class="nav-icon fas fa-user"></i>
              Profile
            </a>
          </li>
        <?php } ?>
        <li class="nav-item">
          <a href="index.php?logout=6666" class="nav-link">
            <i class="nav-icon far fa-circle text-danger"></i>
            Logout
          </a>
        </li>
      </ul>
    </nav>
  </div>
</aside>
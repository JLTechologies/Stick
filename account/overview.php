<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="shortcut icon" href="../favicon.jpg" type="image/x-icon">
  <?php
  include('../config.php');
  include('../authentication.php');
  include('../server.php');

  if (!isset($_SESSION['email'])) {
    $_SESSION['msg'] = "You must log in first";
    header('location: ../login.php');
  }

  if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];
  }
  if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['email']);
    unset($_SESSION['success']);
    header("location: ../login.php");
  }

  include('../queries.php');

  $name = mysqli_query($conn, $sitename);
  if (! $name) {
    die('Could not load sitename: '.mysqli_error($conn));
  }
  while($row = mysqli_fetch_assoc($name)) {?>
  <title>User | <?php $site = htmlspecialchars($row['sitename']); echo $site ;?></title>
  <?php }
  ?>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="../admin/plugins/fontawesome-free/css/all.min.css">
  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="../admin/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
  <!-- Toastr -->
  <link rel="stylesheet" href="../admin/plugins/toastr/toastr.min.css">
  <link rel="stylesheet" href="../admin/css/adminlte.min.css">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Navbar Search -->
      <li class="nav-item">
        <a class="nav-link" href="./">
          <i class="fas fa-user"></i>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="./overview.php">
          <i class="fas fa-users"></i>
        </a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="../index.php" class="brand-link">
      <img src="../favicon.jpg" alt="Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light"><?php echo $site; ?></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">

      <!-- Sidebar Menu -->
      <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="../../" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
		  <li class="nav-item">
            <a href="../cowcodes.php" class="nav-link">
              <i class="nav-icon fas fa-users-cog"></i>
              <p>
                Cow-Codes
              </p>
            </a>
          </li>
		  <li class="nav-item menu-closed">
        <a href="#" class="nav-link">
          <i class="nav-icon fas fa-tree"></i>
            <p>
              Items
              <i class="fas fa-angle-left right"></i>
            </p>
        </a>
        <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="../items" class="nav-link">Complete List</a>
            </li>
          <?php
          $getroot = mysqli_query($conn, $rootcategories);

          if (! $getroot) {
            die('Could not fetch data: '.mysqi_error($conn));
          }

          while ($row2 = mysqli_fetch_assoc($getroot)) {
            ?>
            <li class="nav-item">
              <a href="../items/list.php?id=<?php echo htmlspecialchars($row2['categoryid']);?>" class="nav-link" <?php if(htmlspecialchars($row2['active']) == 'false') 
              {?>
              hidden
              <?php };
              ?>><?php echo htmlspecialchars($row2['name']);?></a>
            </li>
          <?php };
          ?>
        </ul>
      </li>
      <?php if (isset($_SESSION['email'])): ?>
      <li class="nav-item">
			<a href="./index.php?logout='1'" class="nav-link">
				<i class="nav-icon fas fa-th"></i>
				<p>
					Logout
				</p>
			</a>
			</li>
      <?php endif ?>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Dashboard</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="./">Dashboard</a></li>
              <li class="breadcrumb-item active">Users Overview</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <?php include ('./errors.php'); ?>
        <div class="row">
          <!-- notification message -->
  	      <?php if (isset($_SESSION['success'])) : ?>
          <div class="error success" >
      	    <h3>
              <?php 
          	    echo $_SESSION['success'];
                unset($_SESSION["success"]);
              ?>
      	    </h3>
          </div>
  	      <?php endif ?>
          <div class="col-lg-12">
            <div class="card">
              <div class="card-body table-responsive p-0">
                <table class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th class="text-center">Name</th>
                      <th class="text-center">Last Name</th>
                      <th class="text-center">Email</th>
                      <th class="text-center">Phone</th>
                      <th class="text-center">Team</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php  
                    $userinfo = "SELECT * FROM users ORDER BY team";
                    $getuserinfo = mysqli_query($conn, $userinfo);
                    if (! $getuserinfo) {
                        die('Could not data :'.mysqli_error($conn));
                    }
                      while($userdata = mysqli_fetch_assoc($getuserinfo)) {
                        ?>
                        <tr class="align-middle">
                          <td class="text-center"><?php echo htmlspecialchars($userdata['name']);?></td>
                          <td class="text-center"><?php echo htmlspecialchars($userdata['last_name']);?></td>
                          <td class="text-center"><?php echo htmlspecialchars($userdata['email']);?></td>
                          <td class="text-center">+<?php echo htmlspecialchars($userdata['phone']);?></td>
                          <td class="text-center"><?php echo htmlspecialchars($userdata['team']);?></td>
                      </tr>                            
                     <?php };
                    ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- Default to the left -->
	<?php include('../admin/footer.php'); ?>
  </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="../admin/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../admin/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- SweetAlert2 -->
<script src="../admin/plugins/sweetalert2/sweetalert2.min.js"></script>
<!-- Toastr -->
<script src="../admin/plugins/toastr/toastr.min.js"></script>
<!-- Page specific script -->

<!-- AdminLTE App -->
<script src="../admin/js/adminlte.min.js"></script>
</body>
</html>

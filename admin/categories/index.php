<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="shortcut icon" href="../favicon.jpg" type="image/x-icon">
  <?php
  include('../../config.php');
  include('../authentication.php');
  include('../server.php');

  //if (!isset($_SESSION['email'])) {
   // $_SESSION['msg'] = "You must log in first";
    //header('location: ../login.php');
  //}
  //if (isset($_GET['logout'])) {
    //session_destroy();
    //unset($_SESSION['email']);
    //unset($_SESSION['success']);
    //header("location: ../login.php");
  //}

  include('../queries.php');

  $name = mysqli_query($conn, $sitename);
  if (! $name) {
    die('Could not load sitename: '.mysqli_error($conn));
  }
  while($row = mysqli_fetch_assoc($name)) {?>
  <title>Admin | <?php $site = htmlspecialchars($row['sitename']); echo $site ;?></title>
  <?php }
  ?>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../css/adminlte.min.css">
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
        <a class="nav-link" href="../">
          <i class="fas fa-th-large"></i>
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
            <a href="../" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
		  <li class="nav-item">
            <a href="../locations/" class="nav-link">
              <i class="nav-icon fas fa-users-cog"></i>
              <p>
                Locations
              </p>
            </a>
          </li>
          <li class="nav-item">
			<a href="../categories/" class="nav-link active">
				<i class="nav-icon fas fa-th"></i>
				<p>
					Categories
				</p>
			</a>
			</li>
      <li class="nav-item">
			<a href="../brands/" class="nav-link">
				<i class="nav-icon fas fa-th"></i>
				<p>
					Brands
				</p>
			</a>
			</li>
      <li class="nav-item">
			<a href="../brands/contact/" class="nav-link">
				<i class="nav-icon fas fa-th"></i>
				<p>
					Contacts
				</p>
			</a>
			</li>
      <li class="nav-item">
			<a href="../measurements/" class="nav-link">
				<i class="nav-icon fas fa-th"></i>
				<p>
					Measurements
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
          <?php
          $getroot = mysqli_query($conn, $rootcategories);

          if (! $getroot) {
            die('Could not fetch data: '.mysqi_error($conn));
          }

          while ($row2 = mysqli_fetch_assoc($getroot)) {
            ?>
            <li class="nav-item">
              <a href="./list.php?id=<?php echo htmlspecialchars($row2['categoryid']);?>" class="nav-link"><?php echo htmlspecialchars($row2['name']);?></a>
            </li>
          <?php };
          ?>
        </ul>
      </li>
		  <li class="nav-item">
			<a href="../users/" class="nav-link">
				<i class="nav-icon fas fa-th"></i>
				<p>
					Users
				</p>
			</a>
			</li>
      <li class="nav-item">
			<a href="../users/groups/" class="nav-link">
				<i class="nav-icon fas fa-th"></i>
				<p>
					Groups
				</p>
			</a>
			</li>
			<li class="nav-item">
			<a href="../settings.php" class="nav-link">
				<i class="nav-icon fas fa-th"></i>
				<p>
					Settings
				</p>
			</a>
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
              <li class="breadcrumb-item"><a href="../">Admin</a></li>
              <li class="breadcrumb-item"><a href ="../">Dashboard</a></li>
              <li class="breadcrumb-item active">Categories</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
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
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-6">
            <div class="card">
              <div class="card-body">
              <div class="card-header">
                <h3 class="card-title">List Rootcategories</h3>
              </div>
                <table class="table">
                  <thead>
                    <tr>
                      <th>Index</th>
                      <th>Name</th>
                      <th>Active</th>
                      <th>Edit</th>
                      <th>Remove</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                      $getrootcategories = mysqli_query($conn, $rootcategories);

                      if (! $getrootcategories) {
                        die('Could not fetch data: '.mysqli_error($conn));
                      }

                      while($row = mysqli_fetch_assoc($getrootcategories)) {
                        ?>
                        <tr class="align-middle">
                          <td class="text-center"><?php echo htmlspecialchars($row['categoryid']);?></td>
                          <td class="text-center"><?php echo htmlspecialchars($row['name']);?></td>
                          <td class="text-center"><?php echo htmlspecialchars($row['active']);?></td>
                          <td>
                            <form name="rootedit" action="./edit.php" method="post">
                              <input type="hidden" name="rootedit" value="<?php echo htmlspecialchars($row['categoryid']);?>"/>
                              <input type="submit" value="edit brand"/>
                            </form>
                          </td>
                          <td>
                            <form action="./index.php" method="post">
                              <input type="hidden" name="root_remove" value="<?php echo htmlspecialchars($row['categoryid']);?>"/>
                              <button type="submit" name="rootremove" class="btn btn-danger btn-block">Remove root</button>
                            </form>
                          </td>        
                     <?php };
                    ?>
                  </tbody>
                </table>
              </div>
            </div>
            <div class="card">
              <div class="card-body">
              <div class="card-header">
                <h3 class="card-title">List Childcategories</h3>
              </div>
                <table class="table">
                  <thead>
                    <tr>
                      <th>Index</th>
                      <th>Name</th>
                      <th>Root Category</th>
                      <th>Edit</th>
                      <th>Remove</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                      $getchildcategories = mysqli_query($conn, $childcategories);

                      if (! $getchildcategories) {
                        die('Could not fetch data: '.mysqli_error($conn));
                      }

                      while($row1 = mysqli_fetch_assoc($getchildcategories)) {
                        ?>
                        <tr class="align-middle">
                          <td class="text-center"><?php echo htmlspecialchars($row1['childcategoryID']);?></td>
                          <td class="text-center"><?php echo htmlspecialchars($row1['childname']);?></td>
                          <td class="text-center"><?php echo htmlspecialchars($row1['name']);?></td>
                          <td>
                            <form name="childedit" action="./edit.php" method="post">
                              <input type="hidden" name="childedit" value="<?php echo htmlspecialchars($row1['childcategoryID']);?>"/>
                              <input type="submit" value="edit brand"/>
                            </form>
                          </td>
                          <td>
                            <form action="./index.php" method="post">
                              <input type="hidden" name="child_remove" value="<?php echo htmlspecialchars($row1['childcategoryID']);?>"/>
                              <button type="submit" name="childremove" class="btn btn-danger btn-block">Remove child</button>
                            </form>
                          </td>        
                     <?php };
                    ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Add Rootcategory</h3>
              </div>
              <form action="./index.php" method="post">
                <div class="card-body">
                  <div class="form-group">
                    <label for="rootname">Root category name</label>
                    <input type="text" class="form-control" name="rootname" placeholder="Enter Root Name">
                  </div>
                  <div class="form-group">
                    <label for="rootactive">Root Active</label>
                    <select class="custom-select form-control border border-width-2" name="rootactive">
                      <option value="true">Yes</option>
                      <option value="false">No</option>
                    </select>
                  </div>
                </div>
                <div class="card-footer">
                  <button type="submit" name="rootadd" class="btn btn-primary btn-block">Add Root</button>
                </div>
              </form>
            </div>
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Add Childcategory</h3>
              </div>
              <form action="./index.php" method="post">
                <div class="card-body">
                  <div class="form-group">
                    <label for="childname">Child category name</label>
                    <input type="text" class="form-control" name="child_name" placeholder="Enter Child Name">
                  </div>
                  <div class="form-group">
                    <label for="selectroot">Root Category</label>
                    <select class="custom-select form-control border border-width-2" name="select_root">
                      <?php
                        $getrootselect = mysqli_query($conn, $rootcategories);

                        if (! $getrootselect) {
                          die('Could not fetch data: '.mysqli_error($conn));
                        }
                        while ($row2 = mysqli_fetch_assoc($getrootselect)) {?>
                          <option value="<?php echo htmlspecialchars($row2['categoryid']) ;?>"><?php echo htmlspecialchars($row2['name']);?></option>
                        <?php };
                        ?>
                    </select>
                  </div>
                </div>
                <div class="card-footer">
                  <button type="submit" name="childadd" class="btn btn-primary btn-block">Add Child</button>
                </div>
              </form>
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
	<?php include('../footer.php'); ?>
  </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../js/adminlte.min.js"></script>
</body>
</html>

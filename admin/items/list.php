<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="shortcut icon" href="../favicon.jpg" type="image/x-icon">
  <?php
  include('../../config.php');
  $_SESSION['message'] = '';

  include('../queries.php');
  
  include('../server.php');
  $id = $_GET['id'];

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
  <link rel="stylesheet" href="../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="../plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
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
            <a href="../locations.php" class="nav-link">
              <i class="nav-icon fas fa-users-cog"></i>
              <p>
                Locations
              </p>
            </a>
          </li>
		  <li class="nav-item">
            <a href="../locations/cowcodes.php" class="nav-link">
              <i class="nav-icon fas fa-users-cog"></i>
              <p>
                Cow-Codes
              </p>
            </a>
          </li>
          <li class="nav-item">
			<a href="../categories/" class="nav-link">
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
			<a href="../contact/contact/" class="nav-link">
				<i class="nav-icon fas fa-th"></i>
				<p>
					Contacts
				</p>
			</a>
			</li>
      <li class="nav-item">
			<a href="../measure.php" class="nav-link">
				<i class="nav-icon fas fa-th"></i>
				<p>
					Measurements
				</p>
			</a>
			</li>
		  <li class="nav-item menu-open">
        <a href="#" class="nav-link active">
          <i class="nav-icon fas fa-tree"></i>
            <p>
              Items
              <i class="fas fa-angle-left right"></i>
            </p>
        </a>
        <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="./" class="nav-link">Complete List</a>
            </li>
          <?php
          $getroot = mysqli_query($conn, $rootcategories);

          if (! $getroot) {
            die('Could not fetch data: '.mysqi_error($conn));
          }

          while ($row2 = mysqli_fetch_assoc($getroot)) {
            ?>
            <li class="nav-item">
              <a href="./list.php?id=<?php echo htmlspecialchars($row2['categoryid']);?>" class="nav-link" <?php if(htmlspecialchars($row2['active']) == 'false') 
              {?>
              hidden
              <?php };
              ?>><?php echo htmlspecialchars($row2['name']);?></a>
            </li>
          <?php };
          ?>
        </ul>
      </li>
		  <li class="nav-item">
			<a href="../users/" type="hidden" class="nav-link">
				<i class="nav-icon fas fa-th"></i>
				<p>
					Users
				</p>
			</a>
			</li>
      <li class="nav-item">
			<a href="../groups/" class="nav-link">
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
              <li class="breadcrumb-item"><a href="../">Dashboard</a></li>
              <li class="breadcrumb-item">Items</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <?php include ('../errors.php');?>
          <!-- notification message -->
  	<?php if (isset($_SESSION['success'])) : ?>
      <div class="error success" >
      	<h3>
          <?php 
          	echo $_SESSION['success'];
            unset($_SESSION['success']);
          ?>
      	</h3>
      </div>
  	<?php endif ?>
        <div class="row">
          <div class="col-lg-12">
            <div class="card-body table-responsive p-0">
              <table class="table table-bordered table-stripe" id="main">
                <thead>
                  <tr>
                    <th>Reference</th>
                    <th>Name</th>
                    <th>Brand</th>
                    <th>Details</th>
                    <?php
                    $getlocation = mysqli_query($conn, $locations);
                    if (! $getlocation) {
                      die ('Could not fetch data: '. mysqli_error($conn));
                    }
                    
                    while ($loc = mysqli_fetch_assoc($getlocation)) {
                      ?><th><?php echo htmlspecialchars($loc['locationname']);?></th>
                    <?php }?>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    $itemlistbycat = "SELECT * FROM items INNER JOIN measure ON items.measureID = measure.measureID INNER JOIN brands on items.brandID = brands.brandID INNER JOIN childcategories ON childcategories.childcategoryID = items.childcategoryID INNER JOIN rootcategories ON childcategories.rootcategoryID = rootcategories.categoryid WHERE categoryid = $id";
                     $getitemlistbycat = mysqli_query($conn, $itemlistbycat);
            
                    if (! $getitemlistbycat) {
                     die('Could not fetch data: '.mysqli_error($conn));
                    }
            
                     while ($row = mysqli_fetch_assoc($getitemlistbycat)) {
                      $itemid = htmlspecialchars($row['itemID']);
                      $minamount = htmlspecialchars($row['min_amount']);?>
                    <tr class="align-middle">
                      <td class="text-center"><?php echo htmlspecialchars($row['reference']);?></td>
                      <td class="text-center"><?php echo htmlspecialchars($row['itemname']);?></td>
                      <td class="text-center"><?php echo htmlspecialchars($row['brandname']);?></td>
                      <td>
                        <form name="itemdetails" action="./details.php?id=<?php echo $itemid;?>" method="post">
                          <input type="hidden" name="itemdetails" value="<?php echo $itemid;?>"/>
                          <button type="submit" name="itemdetails" class="btn btn-primary btn-block">Item Details</button>
                        </form>
                      </td><?php $getlocations = mysqli_query($conn, $countlocations);
                      if (! $getlocations) {
                        die ('could not fetch data: '.mysqli_error($conn));
                      }
                      while ($data = mysqli_fetch_assoc($getlocations)) {
                        $amountlocs = htmlspecialchars($data['amountlocations']);
                      }
                      for ($l = 1; $l <= $amountlocs; $l++) {
                        $currentvalue = "SELECT * FROM amount WHERE itemID = '$itemid' AND locationID = '$l'";
                        $getvalue = mysqli_query($conn, $currentvalue);
                        if (! $getvalue) {die ('could not fetch data: '.mysqli_error($conn));}
                        while ($value = mysqli_fetch_assoc($getvalue)) {
                          $defvalue = htmlspecialchars($value['amount']);
                          $amountid = htmlspecialchars($value['amountID']);
                        }
                        ?>
                        <td class="text-center" <?php if ($defvalue <= $minamount) {?>style="color:red;"<?php }?>><?php echo $defvalue;?> / <?php echo $minamount;?>  <button type="button" class="btn btn-success open-addamount" data-target="#open-addamount" data-toggle="modal" data-id="<?php echo $amountid;?>" data-addvalue="<?php echo $defvalue;?>">Add</button>
                        <button class="btn btn-danger open-removeamount" data-target="#open-removeamount" data-toggle="modal" data-id2="<?php echo $amountid;?>" data-removevalue="<?php echo $defvalue;?>">Subtract</button></td>
                        
                      <?php }
                      ?>
                    </tr>
                  <?php };?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="modal fade" id="open-addamount">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Add Amount</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form action="./index.php" method="post">
                <input type="hidden" id="amountid" name="amountid" value="">
                <input type="hidden" id="currentvalue" name="currentvalue" value="">
                <label for="amounttoadd">Amount to Add</label>
                <input type="text" class="form-control" id="amounttoadd" name="amounttoadd" placeholder="Insert amount to be added"></input>
                </div>
                <div class="modal-footer justify-content-between">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                  <button type="submit" name="add_value" class="btn btn-primary">Add Amount</button>
                </div>
              </form>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->
      
      <div class="modal fade" id="open-removeamount">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Remove Amount</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form action="./index.php" method="post">
                <input type="hidden" id="amountid2" name="amountid2" value="">
                <input type="hidden" id="currentvalue2" name="currentvalue2" value="">
                <label for="amounttoremove">Amount to Remove</label>
                <input type="text" class="form-control" id="amounttoremove" name="amounttoremove" placeholder="Insert amount to be Removed"></input>
                </div>
                <div class="modal-footer justify-content-between">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                  <button type="submit" name="remove_value" class="btn btn-primary">Remove Amount</button>
                </div>
              </form>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->
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
<script src="../plugins/datatables/jquery.dataTables.min.js"></script>
<script src="../plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="../plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="../plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="../plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="../plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="../plugins/jszip/jszip.min.js"></script>
<script src="../plugins/pdfmake/pdfmake.min.js"></script>
<script src="../plugins/pdfmake/vfs_fonts.js"></script>
<script src="../plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="../plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="../plugins/datatables-buttons/js/buttons.colVis.min.js"></script>

<!-- Page specific script -->
<script>
  $(function () {
    $("#main").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#main_wrapper .col-md-6:eq(0)');
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

<!-- AdminLTE App -->
<script src="../js/adminlte.min.js"></script>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="shortcut icon" href="../favicon.jpg" type="image/x-icon">
  <?php
  include('../config.php');
  include('../authentication.php');

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
  $_SESSION['message'] = '';
  $id = $_GET['id'];
  $getiteminfo = "SELECT * FROM items INNER JOIN measure ON items.measureID = measure.measureID INNER JOIN childcategories ON items.childcategoryID = childcategories.childcategoryID INNER JOIN rootcategories ON childcategories.rootcategoryID = rootcategories.categoryid INNER JOIN brands ON items.brandID = brands.brandID INNER JOIN brandcontact ON brands.brandcontactID = brandcontact.brandcontactID INNER JOIN countries ON brandcontact.countryID = countries.countryID WHERE itemID = '$id'";
  $getinfo = mysqli_query($conn, $getiteminfo);
  if (! $getinfo) {
    die ('Could not fetch requested data: '.mysqli_error($conn));
  }
  while($itemdata = mysqli_fetch_assoc($getinfo)) {
    $itemname = htmlspecialchars($itemdata['itemname']);
    $rootcategory = htmlspecialchars($itemdata['name']);
    $childcategory = htmlspecialchars($itemdata['childname']);
    $price = htmlspecialchars($itemdata['price']);
    $extreference = htmlspecialchars($itemdata['reference']);
    $minamount = htmlspecialchars($itemdata['min_amount']);
    $measurement = htmlspecialchars($itemdata['measurename']);
    $brandname = htmlspecialchars($itemdata['brandname']);
    $brandurl = htmlspecialchars($itemdata['url']);
    $brandcontactname = htmlspecialchars($itemdata['brandcname']);
    $brandzipcode = htmlspecialchars($itemdata['zipcode']);
    $brandnumber = htmlspecialchars($itemdata['number']);
    $brandaddition = htmlspecialchars($itemdata['addition']);
    $brandstreet = htmlspecialchars($itemdata['street']);
    $brandcity = htmlspecialchars($itemdata['city']);
    $brandstate = htmlspecialchars($itemdata['state']);
    $brandphone = htmlspecialchars($itemdata['phone']);
    $brandcountry = htmlspecialchars($itemdata['nicename']);
  }
  include('../queries.php');
  include('../server.php');

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
  <link rel="stylesheet" href="../admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="../admin/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="../admin/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <!-- Theme style -->
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
            <a href="../cowcodes.php" class="nav-link">
              <i class="nav-icon fas fa-users-cog"></i>
              <p>
                Cow-Codes
              </p>
            </a>
          </li>
		  <li class="nav-item menu-open active">
        <a href="#" class="nav-link">
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
              <li class="breadcrumb-item"><a href="../">Dashboard</a></li>
              <li class="breadcrumb-item"><a href="./index.php">Items</a></li>
              <li class="breadcrumb-item"><?php echo $itemname;?></li>
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
        <!-- Default box -->
      <div class="card card-solid">
        <div class="card-body">
          <div class="row">
            <div class="col-12 col-sm-6">
              <h3 class="d-inline-block d-sm-none"><?php echo $itemname;?></h3>
            </div>
            <div class="col-12 col-sm-6">
              <h3 class="my-3"><?php echo $brandname;?> / <?php echo $itemname;?></h3>
              <hr>

              <div class="bg-red py-2 px-3 mt-4">
                <p>NIET ACTUELE PRIJZEN!</p>
                <h2 class="mb-0">
                  €<?php echo $price;?>
                </h2>
                <h4 class="mt-0">
                  <small>Ex BTW: €<?php $exbtw = $price * 0.21;
                  $newprice = $price - $exbtw; echo $newprice;?> </small>
                </h4>
              </div>

              <div class="col-lg-6">
                <div class="card">
                  <div class="card-body table-responsive p-0">
                    <table class="table">
                      <thead>
                        <tr>
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
                        <tr class="align-middle">
                        <?php $getlocations = mysqli_query($conn, $countlocations);
                          if (! $getlocations) {
                            die ('could not fetch data: '.mysqli_error($conn));
                          }
                          while ($data = mysqli_fetch_assoc($getlocations)) {
                            $amountlocs = htmlspecialchars($data['amountlocations']);
                          }
                          for ($l = 1; $l <= $amountlocs; $l++) {
                            $currentvalue = "SELECT * FROM amount WHERE itemID = '$id' AND locationID = '$l'";
                            $getvalue = mysqli_query($conn, $currentvalue);
                            if (! $getvalue) {die ('could not fetch data: '.mysqli_error($conn));}
                            while ($value = mysqli_fetch_assoc($getvalue)) {
                              $defvalue = htmlspecialchars($value['amount']);
                              $amountid = htmlspecialchars($value['amountID']);
                            }
                        ?>
                        <td class="text-center"><?php echo $defvalue;?> / <?php echo $minamount;?>  <button type="button" class="btn btn-success open-addamount" data-target="#open-addamount" data-toggle="modal" data-id="<?php echo $amountid;?>" data-addvalue="<?php echo $defvalue;?>">Add</button>
                        <button class="btn btn-danger open-removeamount" data-target="#open-removeamount" data-toggle="modal" data-id2="<?php echo $amountid;?>" data-removevalue="<?php echo $defvalue;?>">Subtract</button></td>
                        <?php };
                        ?>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>

            </div>
          </div>
          <div class="row mt-4">
            <nav class="w-100">
              <div class="nav nav-tabs" id="product-tab" role="tablist">
                <a class="nav-item nav-link active" id="product-desc-tab" data-toggle="tab" href="#product-desc" role="tab" aria-controls="product-desc" aria-selected="true">Description</a>
                <a class="nav-item nav-link" id="product-info-tab" data-toggle="tab" href="#product-info" role="tab" aria-controls="product-info" aria-selected="false">Supplier Info</a>
              </div>
            </nav>
            <div class="tab-content p-3" id="nav-tabContent">
              <div class="tab-pane fade show active" id="product-desc" role="tabpanel" aria-labelledby="product-desc-tab"></div>
              <div class="tab-pane fade" id="product-info" role="tabpanel" aria-labelledby="product-info-tab"> 
              <div class="card-body">
                <strong><i class="fas fa-book mr-1"></i> <a href="<?php echo $brandurl;?>">Supplier</a> / Manufacturer Info</strong>

                <p class="text-muted">
                  <?php echo $brandcontactname;?> / <?php echo $brandname;?>
                </p>

                <hr>

                <strong><i class="fas fa-map-marker-alt mr-1"></i> Location</strong>

                <p class="text-muted"><?php echo $brandstreet;?> <?php echo $brandnumber;?> / <?php echo $brandaddition;?>, <?php echo $brandzipcode;?> <?php echo $brandcity;?></p>
                <p class="text-muted"><?php echo $brandstate;?>, <?php echo $brandcountry;?></p>
              </div>
              <!-- /.card-body -->
              </div>
            </div>
          </div>
        </div>
            </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->
    </div>
    <!-- /.content -->
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

<script>
  $(document).on("click", ".open-addamount", function () {
    var oldamount = $(this).data('id');
    var currentValue = $(this).data('addvalue');
    $(".modal-body #amountid").val( oldamount );
    $(".modal-body #currentvalue").val( currentValue );
  });

  $(document).on("click", ".open-removeamount", function () {
    var oldamount2 = $(this).data('id2');
    var currentValue2 = $(this).data('removevalue');
    $(".modal-body #amountid2").val( oldamount2 );
    $(".modal-body #currentvalue2").val( currentValue2 );
  });
</script>

<!-- jQuery -->
<script src="../admin/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../admin/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../admin/js/adminlte.min.js"></script>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="shortcut icon" href="./favicon.jpg" type="image/x-icon">
    <?php
        include ('./config.php');
        include('./authentication.php');
		
	include('./queries.php');
	
	$name = mysqli_query($conn, $sitename);
	if (! $name) {
		die('Kon site naam niet inladen: '.mysqli_error($conn));
	}
	while($row = mysqli_fetch_assoc($name)) {?>
		<title>Admin | <?php $site = htmlspecialchars($row['sitename']); echo $site ;?></title>
	<?php 
  $status = htmlspecialchars($row['siteactive']);
}

if ($status === 'false') {
  header("location: ./404/404.php");
}
	?>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="./admin/plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="./admin/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="./admin/css/adminlte.min.css">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <!-- /.login-logo -->
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
    <?php include ('./errors.php'); ?>
      <a href="./login.php" class="h1"><?php echo $site;?></a>
    </div>
    <div class="card-body">
      <?php if (isset($_SESSION['success'])) : ?>
      <p class="login-box-msg">
        <?php 
            echo $_SESSION['success'];
            echo $_SESSION['msg']; 
            unset($_SESSION['success']);
        ?>
      </p>
      <?php endif ?>
      <p class="login-box-msg">Sign in to start your session</p>

      <form action="./login.php" method="post">
        <div class="input-group mb-3">
          <input type="text" class="form-control" name="email" placeholder="Email or phone number">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" name="password" placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block" name="login_user">Sign In</button>
          </div>
          <!-- /.col -->
        </div>
      </form>
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="./admin/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="./admin/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="./admin/js/adminlte.min.js"></script>
</body>
</html>

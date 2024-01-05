<?php
//connect to the database
include('../config.php');
$errors = array(); 


//CHANGE PASSWORD
if (isset($_POST['new_password'])) {
  $user = mysqli_real_escape_string($conn, $_POST['userid']);
  $password = htmlspecialchars($conn, $_POST['password']);
  $verify = htmlspecialchars($conn, $_POST['verify_pasword']);

  if (empty($password)) { array_push($errors, "Password is required");}
  if (empty($verify)) { array_push($errors, "You need to retype the password");}
  if ($password != $verify) { array_push($errors, "Filled in passwords do not match");}

  if (count($errors) == 0) {
    $def_pass = md5($password);
    $updatepass = "UPDATE users SET password = '$def_pass' WHERE userid = '$user'";
    mysqli_query($conn, $updatepass);
    $_SESSION['success'] = "Password has been updated";
    header('location: ./account.php');
  }
}

  ?>
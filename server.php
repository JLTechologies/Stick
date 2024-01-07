<?php
//connect to the database
include('../config.php');
$errors = array(); 


//CHANGE PASSWORD
if (isset($_POST['new_password'])) {
  $user = mysqli_real_escape_string($conn, $_POST['userid']);
  $password = mysqli_real_escape_string($conn, $_POST['password']);
  $verify = mysqli_real_escape_string($conn, $_POST['verify_pasword']);

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

//ADD STOCK
if (isset($_POST['add_value'])) {
  $recordID = mysqli_real_escape_string($conn, $_POST['amountid']);
  $AddAmount = mysqli_real_escape_string($conn, $_POST['amounttoadd']);
  $OldAmount = mysqli_real_escape_string($conn, $_POST['currentvalue']);

  if (empty($AddAmount)) { array_push($errors, "Value to be added is required");}
  if (count($errors) == 0) {    
    $total = $AddAmount + $OldAmount;
    $AmountADD = "UPDATE amount SET amount = '$total' WHERE amountID = '$recordID'";

    mysqli_query($conn, $AmountADD);
    $_SESSION['success'] = "Stock has been updated successfully.";
    header('location: ./index.php');
  }
}

//REMOVE STOCK
if (isset($_POST['remove_value'])) {
  $recordID = mysqli_real_escape_string($conn, $_POST['amountid2']);
  $RemoveAmount = mysqli_real_escape_string($conn, $_POST['amounttoremove']);
  $OldAmount = mysqli_real_escape_string($conn, $_POST['currentvalue2']);

  if (empty($RemoveAmount)) { array_push($errors, "Value to be added is required");}
  if (count($errors) == 0) {    
    $total2 = $OldAmount - $RemoveAmount;
    $AmountADD = "UPDATE amount SET amount = '$total2' WHERE amountID = '$recordID'";

    mysqli_query($conn, $AmountADD);
    $_SESSION['success'] = "Stock has been updated successfully.";
    header('location: ./index.php');
  }
}
  ?>
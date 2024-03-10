<?php
session_start();

// initializing variables
$username = "";
$email    = "";
$groupid    = "";
$errors = array(); 

// connect to the database
include('./config.php');

// LOGIN USER
if (isset($_POST['login_user'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
  
    if (empty($email)) {
        array_push($errors, "Email is required");
    }
    if (empty($password)) {
        array_push($errors, "Password is required");
    }
  
    if (count($errors) == 0) {
        $hashed_password = md5($password);
        $query = "SELECT * FROM users WHERE email='$email' AND password='$hashed_password'";
        $results = mysqli_query($conn, $query);
        if (mysqli_num_rows($results) == 1) {
          $_SESSION['email'] = $email;
          while($userdata = mysqli_fetch_assoc($results)) {
            $groupid = htmlspecialchars($userdata['groupID']);
            $_SESSION['groupid'] = $groupid;
          }
          //user_perms($groupid, $conn);
          $_SESSION['success'] = "Welcome $email.";
          header('location: ./index.php');
        }else {
            array_push($errors, "Wrong email or password combination");
        }
    }
  }


  //GET USER PERMISSIONS SET BY GROUP
  /*function user_perms($groupid, $conn) {
    $getperms = "SELECT permissionname, setting FROM permissions INNER JOIN permissionslist ON permissions.permissionID = permissionslist.permissionID WHERE groupID = '$groupid'";
    $permamount = "SELECT COUNT(permissionID) 'perms' FROM permissions WHERE groupID = '$groupid'";
    $permcount = (mysqli_query($conn, $permamount));
    while ($count = mysqli_fetch_assoc($permcount)) {
      $amountperm = htmlspecialchars($count['perms']);
    }
    $permlist = mysqli_query($conn, $getperms);
    while ($perms = mysqli_fetch_assoc($permlist)) {
      for($p = 1; $p <= $amountperm; $p++) {
        $_SESSION[htmlspecialchars($perms['permissionname'])] = htmlspecialchars($perms['setting']);
      }
    }
    if ($p === $permamount) {
      unset($p, $permamount, $amountperm);
      $result = 'done';
      return $result;
    }
  }*/

  ?>
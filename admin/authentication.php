<?php
session_start();

// initializing variables
$username = "";
$email    = "";
$errors = array(); 

// connect to the database
include('./config.php');

// ADD USER
if (isset($_POST['admin_reg_user'])) {
  // receive all input values from the form
  $userfirstname = mysqli_real_escape_string($db, $_POST['userfirstname']);
  $userlastname = mysqli_real_escape_string($db, $_POST['userlastname']);
  $useremail = mysqli_real_escape_string($db, $_POST['useremail']);
  $userphone = mysqli_real_escape_string($db, $_POST['userphone']);
  $useractive = mysqli_real_escape_string($db, $_POST['useractive']);
  $usergroup = mysqli_real_escape_string($db, $_POST['usergroup']);
  $password1 = mysqli_real_escape_string($db, $_POST['password1']);
  $password2 = mysqli_real_escape_string($db, $_POST['password2']);
  $created_on = new DateTime('now');

  // form validation: ensure that the form is correctly filled ...
  // by adding (array_push()) corresponding error unto $errors array
  if (empty($userfirstname)) { array_push($errors, "First name is required"); }
  if (empty($userlastname)) { array_push($erros, "Last name is required"); }
  if (empty($useremail)) { array_push($errors, "Phone number is required"); }
  if (empty($userphone)) { array_push($errors, "Email is required"); }
  if (empty($useractive)) { array_push($errors, "Active status is required"); }
  if (empty($usergroup)) { array_push($errors, "Group selection is required"); }
  if (empty($password1)) { array_push($errors, "Password is required"); }
  if ($password1 != $password2) {
	array_push($errors, "The two passwords do not match");
  }

  // first check the database to make sure 
  // a user does not already exist with the same username and/or email
  $user_check_query = "SELECT * FROM users WHERE first_name='$userfirstname' OR last_name='$userlastname' OR email='$useremail' LIMIT 1";
  $result = mysqli_query($conn, $user_check_query);
  $user = mysqli_fetch_assoc($result);
  
  if ($user) { // if user exists
    if ($user['email'] === $useremail) {
      array_push($errors, "Email is already used by another account.");
    }

    if ($user['first_name'] === $userfirstname && ['last_name'] === $userlastname) {
      array_push($errors, "Person already exists.");
    }
  }

  // Finally, register user if there are no errors in the form
  if (count($errors) == 0) {
  	$password = md5($password_1);//encrypt the password before saving in the database

  	$query = "INSERT INTO users (first_name, last_name, groupID email, phone, active, created_on, password) 
  			  VALUES('$userfirstname', '$userlastname', '$usergroup', '$useremail', '$userphone', '$useractive', '$created_on', '$password')";
  	mysqli_query($conn, $query);
  	$_SESSION['success'] = "$userlastname $userfirtname is now registered";
  	header('location: ./index.php');
  }
}

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
          session_start();
          $_SESSION['email'] = $email;
          $_SESSION['success'] = "Welcome $email.";
          header('location: ./index.php');
        }else {
            array_push($errors, "Wrong email or password combination");
        }
    }
  }

  ?>
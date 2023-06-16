<?php
session_start();

// initializing variables
$username = "";
$email    = "";
$errors = array(); 

// connect to the database
include('../config.php');

// ADD USER
if (isset($_POST['admin_reg_user'])) {
  // receive all input values from the form
  $firstname = mysqli_real_escape_string($db, $_POST['first_name']);
  $lastname = mysqli_real_escape_string($db, $_POST['last_name']);
  $email = mysqli_real_escape_string($db, $_POST['email']);
  $phone = mysqli_real_escape_string($db, $_POST['phone']);
  $active = mysqli_real_escape_string($db, $_POST['active']);
  $group = mysqli_real_escape_string($db, $_POST['groupid']);
  $password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
  $password_2 = mysqli_real_escape_string($db, $_POST['password_2']);

  // form validation: ensure that the form is correctly filled ...
  // by adding (array_push()) corresponding error unto $errors array
  if (empty($firstname)) { array_push($errors, "First name is required"); }
  if (empty($lastname)) { array_push($erros, "Last name is required"); }
  if (empty($email)) { array_push($errors, "Phone number is required"); }
  if (empty($phone)) { array_push($errors, "Email is required"); }
  if (empty($active)) { array_push($errors, "Active status is required"); }
  if (empty($group)) { array_push($errors, "Group selection is required"); }
  if (empty($password_1)) { array_push($errors, "Password is required"); }
  if ($password_1 != $password_2) {
	array_push($errors, "The two passwords do not match");
  }

  // first check the database to make sure 
  // a user does not already exist with the same username and/or email
  $user_check_query = "SELECT * FROM users WHERE first_name='$firstname' OR last_name='$lastname' OR email='$email' LIMIT 1";
  $result = mysqli_query($conn, $user_check_query);
  $user = mysqli_fetch_assoc($result);
  
  if ($user) { // if user exists
    if ($user['email'] === $email) {
      array_push($errors, "Email is already used by another account.");
    }

    if ($user['first_name'] === $firstname && ['last_name'] === $lastname) {
      array_push($errors, "Person already exists.");
    }
  }

  // Finally, register user if there are no errors in the form
  if (count($errors) == 0) {
  	$password = md5($password_1);//encrypt the password before saving in the database

  	$query = "INSERT INTO users (first_name, last_name, groupID email, phone, active, created_on, password) 
  			  VALUES('$firstname', '$lastname', '$groupid', '$email', '$phone', '$active', '$created_on', '$password')";
  	mysqli_query($conn, $query);
  	$_SESSION['success'] = "The new user $email is now registered";
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
          $_SESSION['email'] = $email;
          $_SESSION['success'] = "Welcome $email.";
          header('location: ./index.php');
        }else {
            array_push($errors, "Wrong email or phone/password combination");
        }
    }
  }

  // RESET PASSWORD
  if (isset($_POST['reset_password'])) {
  
  }

  // ADD USER
  if (isset($_POST['reg_user'])) {

  }

  // EDIT USER
  if (isset($_POST['edit_user'])) {

  }

  // REMOVE USER
  if (isset($_POST['remove_user'])) {

  }

  // ADD GROUP
  if (isset($_POST['add_group'])) {

  }

  // EDIT GROUP

  // REMOVE GROUP
  if (isset($_POST['remove_group'])) {

  }

  // ADD ITEM

  // EDIT ITEM

  // REMOVE ITEM

  // ADD ROOTCATEGORY

  // EDIT ROOTCATEGORY

  // REMOVE ROOTCATEGORY

  // ADD CHILDCATEGORY

  // EDIT CHILDCATEGORY

  // REMOVE CHILDCATEGORY

  // ADD BRAND

  // EDIT BRAND

  // REMOVE BRAND

  // ADD LOCATION

  // EDIT LOCATION

  // REMOVE LOCATION

  // ADD BRANDCONTACT

  // EDIT BRANDCONTACT

  // REMOVE BRANDCONTACT

  // ADD MEASUREMENT

  // EDIT MEASUREMENT

  // REMOVE MEASUREMENT
  
  ?>
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
            array_push($errors, "Wrong email or password combination");
        }
    }
  }

  // RESET PASSWORD
  if (isset($_POST['reset_password'])) {
  
  }

  // ADD USER
  if (isset($_POST['reg_user'])) {

  }

  // REMOVE USER
  if (isset($_POST['remove_user'])) {

  }

  // ADD GROUP
  if (isset($_POST['add_group'])) {
    $groupname = mysqli_real_escape_string($conn, $_POST['groupname']);

    if (empty($groupname)) {
      array_push($errors, "Groupname is required");
    }

    if (count($errors) == 0) {
      $groupadd = "INSERT INTO groups (name) VALUES ('$groupname')";
      mysqli_query($conn, $groupadd);
      $_SESSION['success'] = "New group created";
      header('location: ./index.php');      
    }
  }

  // REMOVE GROUP
  if (isset($_POST['groupremove'])) {
    $groupid = mysqli_real_escape_string($conn, $_POST['groupID']);
  
  $groupremovequery = "DELETE from brands WHERE groupID = '$groupid'";
  mysqli_query($conn, $groupremovequery);
  $_SESSION['success'] = "Group has been removed";
  header('location: ./index.php');
  }

  // ADD ITEM

  // REMOVE ITEM
  if (isset($_POST['itemremove'])) {
    $itemid = mysqli_real_escape_string($conn, $_POST['itemid']);

    $itemremovequery = "DELETE FROM items WHERE itemID = '$itemid'";
    mysqli_query($conn, $itemremovequery);
    $_SESSION['success'] = "Item has been removed";
    header('location: ./index.php');
  }

  // ADD ROOTCATEGORY
  if (isset($_POST['rootadd'])) {
    $rootname = mysqli_real_escape_string($conn, $_POST['rootname']);
    $rootactive = mysqli_real_escape_string($conn, $_POST['rootactive']);

    if (empty($rootname)) {
      array_push($errors, "Root category name is required");
    }

    if (count($errors) == 0) {
      $rootaddsuery = "INSERT INTO rootcategories (active, name) VALUES ('$rootactive', '$rootname')";
      mysqli_query($conn, $rootaddsuery);
      $_SESSION['success'] = "New rootcategory has been created";
      header('location: ./index.php');
    }
  }

  // REMOVE ROOTCATEGORY
  if (isset($_POST['rootremove'])) {
    $rootid = mysqli_real_escape_string($conn, $_POST['rootid']);

    $rootremove = "DELETE FROM rootcategories WHERE categoryid = '$rootid'";
    mysqli_query($conn, $rootremove);
    $_SESSION['success'] = "Rootcategory has been removed";
    header('location: ./index.php');
  }

  // ADD CHILDCATEGORY
  if (isset($_POST['childadd'])) {
    $childname = mysqli_real_escape_string($conn, $_POST['childname']);
    $rootcat = mysqli_real_escape_string($conn, $_POST['selectroot']);

    if (empty($childname)) {
      array_push($errors, "Root category name is required");
    }

    if (count($errors) == 0) {
      $childaddquery = "INSERT INTO childcategories (rootcategoryID, childname) VALUES ('$rootcat', '$childname')";
      mysqli_query($conn, $childaddquery);
      $_SESSION['success'] = "New childcategory has been created";
      header('location: ./index.php');
    }
  }

  // REMOVE CHILDCATEGORY
  if (isset($_POST['childremove'])) {
    $childid = mysqli_real_escape_string($conn, $_POST['childid']);

    $childremove = "DELETE FROM childcategories WHERE childcategoryID = '$childid'";
    mysqli_query($conn, $chileremove);
    $_SESSION['success'] = "Childcategory has been removed";
    header('location: ./index.php');
  }

  // ADD BRAND
  if (isset($_POST['brandadd'])) {
    $brandname = mysqli_real_escape_string($conn, $_POST['brandname']);
    $brandimage = mysqli_real_escape_string($conn, $_POST['brandimage']);
    $brandcontact = mysqli_real_escape_string($conn, $POST['brandcontact']);

    if (empty($brandname)) {
      array_push($errors, "Name of the brand can not be empty!");
    }
    if (empty($brandcontact)) {
      array_push($errors, "Contact for a brand is required!");
    }

    if (count($errors) == 0) {
      $brandaddquery = "INSERT INTO brands (name, image, brandcontactID) VALUES ('$brandname', '$brandimage', '$brandcontact')";
      mysqli_query($conn, $brandaddquery);
      $_SESSION['success'] = "New brand created";
      header('location: ./index.php');
    }

  }

  // REMOVE BRAND
  if (isset($_POST['brandremove'])) {
    $brandid = mysqli_real_escape_string($conn, $_POST['brandID']);
  
  $brandremovequery = "DELETE from brands WHERE brandID = '$brandid'";
  mysqli_query($conn, $brandremovequery);
  $_SESSION['success'] = "Brand has been removed";
  header('location: ./index.php');
  }

  // ADD LOCATION
  if (isset($_POST['locationadd'])) {
    $locationname = mysqli_real_escape_string($conn,$_POST['locationname']);
    $locationstreet = mysqli_real_escape_string($conn,$_POST['locationname']);
    $locationnumber = mysqli_real_escape_string($conn,$_POST['locationname']);
    $locationaddition = mysqli_real_escape_string($conn,$_POST['locationname']);
    $locationzipcode = mysqli_real_escape_string($conn,$_POST['locationname']);
    $lcoationcity = mysqli_real_escape_string($conn,$_POST['locationname']);
    $locationstate = mysqli_real_escape_string($conn,$_POST['locationname']);
    $locationcountry = mysqli_real_escape_string($conn,$_POST['locationname']);
    if (empty($locationaddition)) {
      $locationaddquery = "INSERT INTO locationsn(name, street, number, zipcode, city, state, countryID) 
          VALUES ('$locationname', '$locationstreet', '$locationnumber', '$locationzipcode', '$locationcity', '$locationstate', '$locationcountry')";
      mysqli_query($conn, $locationaddquery);
      $_SESSION['success'] = "Location has been added";
      header("location: ./index.php");
    }
    else {
      $locationaddquery2 = "INSERT INTO locations(name, street, number, addition, zipcode, city, state, countryID) 
          VALUES ('$locationname', '$locationstreet', '$locationnumber', '$locationaddition', '$locationzipcode', '$locationcity', '$locationstate', '$locationcountry')";
      mysqli_query($conn, $locationaddquery);
      $_SESSION['success'] = "Location has been added";
      header("location: ./index.php");
    }
  }

  // REMOVE LOCATION
  if (isset($_POST['locationremove'])) {
    $locationid = mysqli_real_escape_string($conn, $_POST['locationremove']);
  
    $locationremove = "DELETE from locations WHERE locationID = '$locationid'";
    mysqli_query($conn, $locationremove);
    $_SESSION['success'] = "Location has been removed";
    header('location: ./index.php');
  }

  // ADD BRANDCONTACT
  if (isset($_POST['contactadd'])) {
    $contactname = mysqli_real_escape_string($conn,$_POST['name']);
    $contactlastname = mysqli_real_escape_string($conn,$_POST['lastname']);
    $contactphone = mysqli_real_escape_string($conn,$_POST['phone']);
    $contactemail = mysqli_real_escape_string($conn,$_POST['email']);
    $contactstreet = mysqli_real_escape_string($conn,$_POST['street']);
    $contactnumber = mysqli_real_escape_string($conn,$_POST['number']);
    $contactaddition = mysqli_real_escape_string($conn,$_POST['addition']);
    $contactzipcode = mysqli_real_escape_string($conn,$_POST['zipcode']);
    $contactcity = mysqli_real_escape_string($conn,$_POST['city']);
    $contactstate = mysqli_real_escape_string($conn,$_POST['state']);
    $contactcountry = mysqli_real_escape_string($conn,$_POST['country']);
    if (empty($contactaddition)) {
      $contactaddquery = "INSERT INTO brandcontact (name, last_name, phone, email, street, number, zipcode, city, state, countryID) 
            VALUES ('$contactname', '$contactlastname', '$contactphone', '$contactemail', '$contactstreet', '$contactnumber', '$contactzipcode', '$contactcity', '$contactstate', '$contactcountry')";
      mysqli_query($conn, $contactaddquery);
      $_SESSION['success'] = "Contact has been created";
      header("location: ./index.php");
    }
    else {
      $contactaddquery2 = "INSERT INTO brandcontact (name, last_name, phone, email, street, number, addition, zipcode, city, state, countryID) 
            VALUES ('$contactname', '$contactlastname', '$contactphone', '$contactemail', '$contactstreet', '$contactnumber', '$contactaddition', '$contactzipcode', '$contactcity', '$contactstate', '$contactcountry')";
      mysqli_query($conn, $contactaddquery2);
      $_SESSION['success'] = "Contact has been created";
      header("location: ./index.php");
    }
  }

  // REMOVE BRANDCONTACT
  if (isset($_POST['contactremove'])) {
    $contactID = mysqli_real_escape_string($conn,$_POST['contactremove']);
    $removecontactbrande = "DELETE FROM brandcontact WHERE brandcontactID = '$contactID'";
    mysqli_query($conn, $removecontactbrand);
    $_SESSION['success'] = "Contact has been removed";
    header('location: ./index.php');
  }
  // ADD MEASUREMENT
  if (isset($_POST['measureadd'])) {
    $measurename = mysqli_real_escape_string($conn,$_POST['measurename']);
    $measureshortcode = mysqli_real_escape_string($conn,$_POST['measureshortcode']);
    if (empty($measurename)) {
      array_push($errors, "Name for measurement is required");
    }
    if (empty($measureshortcode)) {
      array_push($errors, "Shortcode is required");
    }
    if (count($errors == 0)) {
      $measureadd = "INSERT INTO measure (name, shortcode) VALUES ('$measurename', '$measureshortcode')";
      mysqli_query($conn, $measureadd);
      $_SESSION['success'] = "New measurement has been created";
      header('location: ./index.php');
    }
  }

  // REMOVE MEASUREMENT
  if (isset($_POST['measureremove'])) {
    $measureID = mysqli_real_escape_string($conn,$_POST['measureremove']);
    $removemeasurement = "DELETE FROM measure WHERE measureID = '$measureID'";
    mysqli_query($conn, $removemeasurement);
    $_SESSION['success'] = "Measurement has been succesfully deleted";
    header('location: .index.php');
  }
  
  ?>
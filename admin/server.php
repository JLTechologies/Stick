<?php
//connect to the database
include('../config.php');

// RESET PASSWORD
// RESET PASSWORD
  if (isset($_POST['reset_password'])) {
  
  }

  // ADD USER
  if (isset($_POST['reg_user'])) {

  }

  // REMOVE USER
  if (isset($_POST['remove_user'])) {
    $userid = mysqli_real_escape_string($conn, $_POST['userremove']);

    if (empty($userid)) {
      array_push($errors, "There was a problem removing the selected user. Contact your System Administrator.");
    }

    if (count($errors) === 0) {
      $removeuser = "DELETE FROM users WHERE userid = '$userid'";

      if ($conn->query($removeuser) === true) {
      $_SESSION['success'] = "Selected user has been removed.";
      header('location: /index.php');
      }
      else {
        $_SESSION['succes'] = "Something went wrong";
        header('location: /index.php');
      }
    }
  }

  // ADD GROUP
if (isset($_POST['add_group'])) {
    $gname = mysqli_real_escape_string($conn, $_POST['groupname']);
  
    if (empty($gname)) {
      array_push($errors, "Groupname is required");
    }
  
    if (count($errors) === 0) {
      $groupadd = "INSERT INTO groups (groupname)" ."VALUES ('$gname')";      
      
      if ($conn->query($groupadd) === true) {
      $_SESSION['success'] = "New group created";
      header('location: ./index.php');      
    }  
    else {
        $_SESSION['success'] = "Something went wrong";
        header('location: ../index.php');
    }
    mysqli_close('$conn');
}
  }
  
  // REMOVE GROUP
  if (isset($_POST['group_remove'])) {
    $groupid2 = mysqli_real_escape_string($conn, $_POST['groupremove']);
    $groupremove = "DELETE FROM groups WHERE groupID = '$groupid2'";
    mysqli_query($conn, $groupremove);
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

    if (count($errors) === 0) {
      $rootaddsuery = "INSERT INTO rootcategories (active, name) VALUES ('$rootactive', '$rootname')";
      mysqli_query($conn, $rootaddsuery);
      $_SESSION['success'] = "New rootcategory has been created";
      header('location: ./index.php');
    }
  }

  // REMOVE ROOTCATEGORY
  if (isset($_POST['rootremove'])) {
    $rootid = mysqli_real_escape_string($conn, $_POST['root_remove']);

    $rootremove = "DELETE FROM rootcategories WHERE categoryid = '$rootid'";
    mysqli_query($conn, $rootremove);
    $_SESSION['success'] = "Rootcategory has been removed";
    header('location: ./index.php');
  }

  // ADD CHILDCATEGORY
  if (isset($_POST['childadd'])) {
    $childname = mysqli_real_escape_string($conn, $_POST['child_name']);
    $rootcat = mysqli_real_escape_string($conn, $_POST['select_root']);

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
    $childid = mysqli_real_escape_string($conn, $_POST['child_remove']);

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
    $locationstreet = mysqli_real_escape_string($conn,$_POST['locationstreet']);
    $locationnumber = mysqli_real_escape_string($conn,$_POST['locationnumber']);
    $locationaddition = mysqli_real_escape_string($conn,$_POST['locationaddition']);
    $locationzipcode = mysqli_real_escape_string($conn,$_POST['locationzipcode']);
    $lcoationcity = mysqli_real_escape_string($conn,$_POST['locationcity']);
    $locationstate = mysqli_real_escape_string($conn,$_POST['locationstate']);
    $locationcountry = mysqli_real_escape_string($conn,$_POST['locationcountry']);
    if (empty($locationaddition)) {
      $locationaddquery = "INSERT INTO locations(name, street, number, zipcode, city, state, countryID)
      VALUES ('$locationname', '$locationstreet', '$locationnumber', '$locationzipcode', '$locationcity', '$locationstate', '$locationcountry')";
      mysqli_query($conn, $locationaddquery);
      $_SESSION['success'] = "Location has been added";
      header("location: ./index.php");
    }
    else {
      $locationaddquery2 = "INSERT INTO locations(name, street, number, addition, zipcode, city, state, countryID)
          VALUES ('$locationname', '$locationstreet', '$locationnumber', '$locationaddition', '$locationzipcode', '$locationcity', '$locationstate', '$locationcountry')";
      mysqli_query($conn, $locationaddquery2);
      $_SESSION['success'] = "Location has been added";
      header("location: ./index.php");
    }
  }

  // REMOVE LOCATION
  if (isset($_POST['locationremove'])) {
    $locationid = mysqli_real_escape_string($conn, $_POST['locationremove']);
  
    $locationdelete = "DELETE from locations WHERE locationID = '$locationid'";
    mysqli_query($conn, $locationdelete);
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
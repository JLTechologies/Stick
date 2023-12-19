<?php
//connect to the database
include('../config.php');
$errors = array(); 

// RESET PASSWORD
  if (isset($_POST['reset_password'])) {
  
  }

  // UPDATE USER
  if (isset($_POST['update_user'])) {

  }



  // ADD ITEM
  if (isset($_POST['add_item'])) {
    $itemname = mysqli_real_escape_string($conn, $_POST['item_name']);
    $itemprice = mysqli_real_escape_string($conn, $_POST['item_price']);
    $itembrand = mysqli_real_escape_string($conn, $_POST['item_brand']);
    $itemcategory = mysqli_real_escape_string($conn, $_POST['item_category']);
    $itemcreatedby = mysqli_real_escape_string($conn, $_SESSION['email']);
    $itemmeasure = mysqli_real_escape_string($conn, $_POST['item_measure']);
    $itemminamount = mysqli_real_escape_string($conn, $_POST['item_minamount']);

    if (empty($itemname)) {
      array_push($errors, "Itemname is required");
    }
    if (empty($itemminamount)) {
      array_push($errors, "Minimum amount is required as thresshold for the stock notifications");
    }

    if (count($errors) == 0) {
      $itemadd = "INSERT INTO items (name, price, brandID, min_amount, childcategoryId, createdby, measureID) VALUES ('$itemname','$itemprice','$itembrand','$itemminamount','$itemcategory','$itemcreatedby','$itemmeasure')";
      mysqli_query($conn, $itemadd);
      $_SESSION['success'] = "New item $itemname has been succesfully added to the system";
      header('location: ./new.php');
    }
  }

  // REMOVE ITEM
  if (isset($_POST['itemremove'])) {
    $itemid = mysqli_real_escape_string($conn, $_POST['itemid']);

    $itemremovequery = "DELETE FROM items WHERE itemID = '$itemid'";
    mysqli_query($conn, $itemremovequery);
    $_SESSION['success'] = "Item has been removed";
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
    if (count($errors) == 0) {
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
    header('location: ./index.php');
  }

  //ADD COWCODE SITE
  if (isset($_POST['siteadd'])) {
    $cowcode = mysqli_real_escape_string($conn,$_POST['sitename']);
    $cowcodestreet = mysqli_real_escape_string($conn,$_POST['sitestreet']);
    $cowcodenumber = mysqli_real_escape_string($conn,$_POST['sitenumber']);
    $cowcodeaddition = mysqli_real_escape_string($conn,$_POST['siteaddition']);
    $cowcodezipcode = mysqli_real_escape_string($conn,$_POST['sitezipcode']);
    $cowcodecity = mysqli_real_escape_string($conn,$_POST['sitecity']);
    $cowcodestate = mysqli_real_escape_string($conn,$_POST['sitestate']);
    $cowcodecountry = mysqli_real_escape_string($conn,$_POST['sitecountry']);
    if (empty($cowcodeaddition)) {
      $cowcodeadd = "INSERT INTO locations(locationname, street, number, zipcode, city, state, countryID)
      VALUES ('$cowcode', '$cowcodestreet', '$cowcodenumber', '$cowcodezipcode', '$cowcodecity', '$cowcodestate', '$cowcodecountry')";
      mysqli_query($conn, $cowcodeadd);
      $_SESSION['success'] = "Site with code '$cowcode' has been added";
      header("location: ./cowcodes.php");
    }
    else {
      $cowcodeadd2 = "INSERT INTO locations(locationname, street, number, addition, zipcode, city, state, countryID)
          VALUES ('$cowcode', '$cowcodestreet', '$cowcodenumber','$cowcodeaddition' ,'$cowcodezipcode', '$cowcodecity', '$cowcodestate', '$cowcodecountry')";
      mysqli_query($conn, $cowcodeadd2);
      $_SESSION['success'] = "Site with code '$cowcode' has been added";
      header("location: ./cowcodes.php");
    }
  }

  //REMOVE COWCODE SITE
  if (isset($_POST['siteremove'])) {
    $cowcodeID = mysqli_real_escape_string($conn, $_POST['siteremove']);
  
    $cowcoderemove = "DELETE from sites WHERE siteID = '$cowcodeID'";
    mysqli_query($conn, $cowcoderemove);
    $_SESSION['success'] = "Site has been removed";
    header('location: ./cowcodes.php');
  }
  ?>
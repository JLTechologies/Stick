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

  // REMOVE USER
  if (isset($_POST['remove_user'])) {
    $userid = mysqli_real_escape_string($conn, $_POST['userremove']);

    if (empty($userid)) {
      array_push($errors, "There was a problem removing the selected user. Contact your System Administrator.");
    }

    if (count($errors) == 0) {
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
    $gactive = mysqli_real_escape_string($conn, $_POST['groupactive']);

    if (empty($gname)) {
      array_push($errors, "Groupname is required");
    }
  
    if (count($errors) == 0) {
      $groupadd2 = "INSERT INTO groups (groupname, active)" ."VALUES ('$gname', '$gactive')";
      mysqli_query($conn,$groupadd2);      
      add_perm($gname, $conn);

      if (isset($result) && $result == "done") {
        $_SESSION['success'] = "New group created";
      header('location: ./index.php');
      }
    }
  }
  
  //FUNCTION ADD PERMS PER GROUP
  function add_perm($gname, $conn) {
    $newgroupadd = "SELECT groupID FROM groups WHERE groupname = '$gname'";
      $amountperm = "SELECT COUNT(permissionID) as aantalperms FROM permissionslist";

      $getnewgroupadd = mysqli_query($conn, $newgroupadd);
      $getamountperm = mysqli_query($conn, $amountperm);

      while ($row3 = mysqli_fetch_assoc($getnewgroupadd)) {
        $newgroupaddID = htmlspecialchars($row3['groupID']);
      }

      while ($row4 = mysqli_fetch_assoc($getamountperm)) {
        $getamountperms = htmlspecialchars($row4['aantalperms']);
      }
      
      for ($i = 1; $i <= $getamountperms; $i++) {
        $addgroupperm = "INSERT INTO permissions (setting, groupID, permissionID)" ."VALUES ('false','$newgroupaddID','$i')";
        mysqli_query($conn,$addgroupperm);
      }
      if ($i === $getamountperms) {
        unset($i, $newgroupadd, $getamountperms);
        $result = "done";
        return $result;
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

  //UPDATE GROUP
  if (isset($_POST['edit_group'])) {
    $groupid3 = mysqli_real_escape_string($conn, $_POST['id']);
    $newgroupname = mysqli_real_escape_string($conn, $_POST['groupname']);
    $newgroupactive = mysqli_real_escape_string($conn, $_POST['new_active']);
    
    if (empty($newgroupname)) {
      array_push($errors, "Groupname is required to be filled in");
    }

    if (count($errors) == 0) {
      $updategroup = "UPDATE groups SET groupname = $newgroupname, active = $newgroupactive WHERE groupID = $groupid3";
      mysqli_query($conn, $updategroup);
      $_SESSION['success'] = "Group $newgroupname has been updated";
      header('location: ./index.php');
    }
  }

  // ADD ITEM
  if (isset($_POST['add_item'])) {
    $itemname = mysqli_real_escape_string($conn, $_POST['itemname']);
    $itemref = mysqli_real_escape_strin($conn, $_POST['reference']);
    $itemprice = mysqli_real_escape_string($conn, $_POST['itemprice']);
    $itembrand = mysqli_real_escape_string($conn, $_POST['brand']);
    $itemcategory = mysqli_real_escape_string($conn, $_POST['categoryid']);
    $itemmeasure = mysqli_real_escape_string($conn, $_POST['measure']);
    $itemminamount = mysqli_real_escape_string($conn, $_POST['minamount']);
    $itemsorting = mysqli_real_escape_string($conn, $_POST['sorting']);

    if (empty($itemname)) {
      array_push($errors, "Itemname is required");
    }
    if (empty($itemminamount)) {
      array_push($errors, "Minimum amount is required as thresshold for the stock notifications");
    }

    if (count($errors) == 0) {
      $itemadd = "INSERT INTO items (name, price, brandID, min_amount, childcategoryID, measureID, reference, sortingID) VALUES ('$itemname','$itemprice','$itembrand','$itemminamount','$itemcategory','$itemmeasure', '$itemref', '$itemsorting')";
      mysqli_query($conn, $itemadd);
      add_amount($itemname, $conn);

      if (isset($resultamount) && $resultamount == "tada") {
      $_SESSION['success'] = "New item $itemname has been succesfully added to the system";
      header('location: ./new.php');
      }
    }
  }

  //FUNCTION ADD MINIMUMAMOUNTFIELD PER LOCATION
  function add_amount($itemname, $conn) {
    $newitemadd = "SELECT itemID FROM items WHERE name = '$itemname'";
      $amountlocations = "SELECT COUNT(locationID) as aantallocations FROM locations";

      $getnewitemadd = mysqli_query($conn, $newitemadd);
      $getamountlocations = mysqli_query($conn, $amountlocations);

      while ($row3 = mysqli_fetch_assoc($getnewitemadd)) {
        $newitemaddID = htmlspecialchars($row3['itemID']);
      }

      while ($row4 = mysqli_fetch_assoc($getamountlocations)) {
        $getamountlocs = htmlspecialchars($row4['aantallocations']);
      }
      
      for ($i = 1; $i <= $getamountlocs; $i++) {
        $additemmin = "INSERT INTO amount (itemID, locationID, amount)" ."VALUES ('$newitemaddID','$i','0')";
        mysqli_query($conn,$additemmin);
      }
      if ($i === $getamountlocs) {
        unset($i, $newitemaddID,$getamountlocs);
        $resultamount = "tada";
        return $resultamount;
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
    $brandurl = mysqli_real_escape_string($conn, $_POST['brandurl']);
    $brandcontact = mysqli_real_escape_string($conn, $_POST['brandcontact']);

    if (empty($brandname)) {
      array_push($errors, "Name of the brand can not be empty!");
    }
    if (empty($brandcontact)) {
      array_push($errors, "Contact for a brand is required!");
    }

    if (count($errors) == 0) {
      $brandaddquery = "INSERT INTO brands (name, url, brandcontactID) VALUES ('$brandname', '$brandurl', '$brandcontact')";
      mysqli_query($conn, $brandaddquery);
      $_SESSION['success'] = "New brand created";
      header('location: ./index.php');
    }
  }

  //EDIT BRAND
  if (isset($_POST['brandedit'])) {
    $brandID = mysqli_real_escape_string($conn, $_POST['contactid']);
    $brand_name = mysqli_real_escape_string($conn, $_POST['newbrandname']);
    $brand_url = mysqli_real_escape_string($conn, $_POST['newbrandurl']);
    $brand_contact = mysqli_real_escape_string($conn, $_POST['newbrandcontact']);

    $updatebrand = "UPDATE brands SET name = '$brand_name', url = '$brand_url', brandcontactID = '$brand_contact' WHERE brandID = '$brandID'";
    mysqli_query($conn,$updatebrand);
    $_SESSION['success'] = "Brand $brand_name has been updated";
    header('location: ./index.php');
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
    $locationcity = mysqli_real_escape_string($conn,$_POST['locationcity']);
    $locationstate = mysqli_real_escape_string($conn,$_POST['locationstate']);
    $locationcountry = mysqli_real_escape_string($conn,$_POST['locationcountry']);
    if (empty($locationaddition)) {
      $locationaddquery = "INSERT INTO locations(locationname, street, number, zipcode, city, state, countryID)
      VALUES ('$locationname', '$locationstreet', '$locationnumber', '$locationzipcode', '$locationcity', '$locationstate', '$locationcountry')";
      mysqli_query($conn, $locationaddquery);
      $_SESSION['success'] = "Location has been added";
      header("location: ./index.php");
    }
    else {
      $locationaddquery2 = "INSERT INTO locations(locationname, street, number, addition, zipcode, city, state, countryID)
          VALUES ('$locationname', '$locationstreet', '$locationnumber', '$locationaddition', '$locationzipcode', '$locationcity', '$locationstate', '$locationcountry')";
      mysqli_query($conn, $locationaddquery2);
      $_SESSION['success'] = "Location has been added";
      header("location: ./index.php");
    }
  }

  // REMOVE LOCATION
  if (isset($_POST['location_remove'])) {
    $locationid = mysqli_real_escape_string($conn, $_POST['locationremove']);
  
    $locationdelete = "DELETE from locations WHERE locationID = '$locationid'";
    mysqli_query($conn, $locationdelete);
    $_SESSION['success'] = "Location has been removed";
    header('location: ./index.php');
  }

  //EDIT LOCATION
  if (isset($_POST['locationedit'])) {
    $newlocationid = mysqli_real_escape_string($conn,$_POST('locationid'));
    $newlocationname = mysqli_real_escape_string($conn,$_POST('locationame'));
    $newlocationstreet = mysqli_real_escape_string($conn,$_POST('locationstreet'));
    $newlocationnumber = mysqli_real_escape_string($conn,$_POST('locationnumber'));
    $newlocationaddition = mysqli_real_escape_string($conn,$_POST('locationaddition'));
    $newlocationzipcode = mysqli_real_escape_string($conn,$_POST('locationzipcode'));
    $newlocationcity = mysqli_real_escape_string($conn,$_POST('locationcity'));
    $newlocationstate = mysqli_real_escape_string($conn,$_POST('locationstate'));
    $newlocationcountry = mysqli_real_escape_string($conn,$_POST('locationcountry'));
    if (empty($newlocationaddition)) {
      $updatelocationquery = "UPDATE locations SET locationname = '$newlocationname', street = '$newlocationstreet', number = '$newlocationnumber', zipcode = '$newlocationzipcode', city = '$newlocationcity', state = '$newlocationstate', countryID = '$newlocationcountry' WHERE locationID = '$newlocationid'";
      mysqli_query($conn,$updatelocationquery);
      $_SESSION['success'] = "Location $newlocationname has been updated";
      header('location: ./index.php');
    }
    else {
      $updatelocationquery2 = "UPDATE locations SET locationname = '$newlocationname', street = '$newlocationstreet', number = '$newlocationnumber', addition = '$newlocationaddition', zipcode = '$newlocationzipcode', city = '$newlocationcity', state = '$newlocationstate', countryID = '$newlocationcountry' WHERE locationID = '$newlocationid'";
      mysqli_query($conn,$updatelocationquery2);
      $_SESSION['success'] = "Location $newlocationname has been updated";
      header('location: ./index.php');
    }
  }

  // ADD BRANDCONTACT
  if (isset($_POST['contactadd'])) {
    $contactreference = mysqli_real_escape_string($conn,$_POST['reference']);
    $contactname = mysqli_real_escape_string($conn,$_POST['name']);
    $contactphone = mysqli_real_escape_string($conn,$_POST['phone']);
    $contactstreet = mysqli_real_escape_string($conn,$_POST['street']);
    $contactnumber = mysqli_real_escape_string($conn,$_POST['number']);
    $contactaddition = mysqli_real_escape_string($conn,$_POST['addition']);
    $contactzipcode = mysqli_real_escape_string($conn,$_POST['zipcode']);
    $contactcity = mysqli_real_escape_string($conn,$_POST['city']);
    $contactstate = mysqli_real_escape_string($conn,$_POST['state']);
    $contactcountry = mysqli_real_escape_string($conn,$_POST['country']);
    if (empty($contactaddition)) {
      $contactaddquery = "INSERT INTO brandcontact(reference, name, phone, street, number, zipcode, city, state, countryID) 
            VALUES ('$contactreference', '$contactname', '$contactphone', '$contactstreet', '$contactnumber', '$contactzipcode', '$contactcity', '$contactstate', '$contactcountry')";
      mysqli_query($conn, $contactaddquery);
      $_SESSION['success'] = "Contact has been created";
      header('location: ./index.php');
    }  
    else {
      $contactaddquery2 = "INSERT INTO brandcontact(reference, name, phone, street, number, addition, zipcode, city, state, countryID) 
            VALUES ('$contactreference', '$contactname', '$contactphone', '$contactstreet', '$contactnumber', '$contactaddition', '$contactzipcode', '$contactcity', '$contactstate', '$contactcountry')";
      mysqli_query($conn, $contactaddquery2);
      $_SESSION['success'] = "Contact has been created";
      header('location: ./index.php');
    }
  }

  //UPDATE BRANDCONTACT
  if (isset($_POST['contactupdate'])) {
    $contactid = mysqli_real_escape_string($conn,$_POST('contactid'));
    $contactname = mysqli_real_escape_string($conn,$_POST['contact_reference']);
    $contactlastname = mysqli_real_escape_string($conn,$_POST['contact_name']);
    $contactphone = mysqli_real_escape_string($conn,$_POST['contact_phone']);
    $contactstreet = mysqli_real_escape_string($conn,$_POST['contact_street']);
    $contactnumber = mysqli_real_escape_string($conn,$_POST['contact_number']);
    $contactaddition = mysqli_real_escape_string($conn,$_POST['contact_addition']);
    $contactzipcode = mysqli_real_escape_string($conn,$_POST['contact_zipcode']);
    $contactcity = mysqli_real_escape_string($conn,$_POST['contact_city']);
    $contactstate = mysqli_real_escape_string($conn,$_POST['contact_state']);
    $contactcountry = mysqli_real_escape_string($conn,$_POST['contact_country']);
    if (empty($contactaddition)) {
      $contactupdatequery = "UPDATE brandcontact SET reference = '$contactname', name = '$contactlastname', phone = '$contactphone', street = '$contactstreet', number = '$contactnumber', zipcode = '$contactzipcode', city = '$contactcity', state = '$contactstate', countryID = '$contactcountry' WHERE brandcontactID = '$contactid'";
      mysqli_query($conn, $contactupdatequery);
      $_SESSION['success'] = "Contact has been updated";
      header('location: ./index.php');
    }
    else {
      $contactupdatequery2 = "UPDATE brandcontact SET reference = '$contactname', name = '$contactlastname', phone = '$contactphone', street = '$contactstreet', number = '$contactnumber', addition = '$contactaddition', zipcode = '$contactzipcode', city = '$contactcity', state = '$contactstate', countryID = '$contactcountry' WHERE brandcontactID = '$contactid'";
      mysqli_query($conn, $contactupdatequery2);
      $_SESSION['success'] = "Contact has been updated";
      header('location: ./index.php');
    }
  }

  // REMOVE BRANDCONTACT
  if (isset($_POST['contactremove'])) {
    $contactID = mysqli_real_escape_string($conn,$_POST['contact_remove']);
    $removecontactbrand = "DELETE FROM brandcontact WHERE brandcontactID = '$contactID'";
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

  //ADJUST SITENAME
    if (isset($_POST['setting_sitename'])) {
      $setting_sitename = mysqli_real_escape_string($conn, $_POST['new_sitename']);
      if (empty($setting_sitename)) {
        array_push($errors, "Site name has not been filled in!");
      }
      if (count($errors) == 0) {
      $updatesitename = "UPDATE settings SET sitename = '$setting_sitename'";
      mysqli_query($conn, $updatesitename);
      $_SESSION['success'] = "Sitename has been updated";
      header('location: ./settings.php');
      }
    }

  //ADJUST ROOT CATEGORY ACTIVE STATE
  if(isset($_POST['rootcat_active'])) {
    $setting_rootactive = mysqli_real_escape_string($conn, $_POST['new_active']);
    $rootid = mysqli_real_escape_string($conn, $_POST['rootcatid']);
    $updaterootactive = "UPDATE rootcategories SET active = '$setting_rootactive' WHERE categoryid = '$rootid'";
    mysqli_query($conn, $updaterootactive);
    $_SESSION['success'] = "Category active status has been changed";
    header('location: ./index.php');
  }

  //ADJUST SITEACTIVITY
    if (isset($_POST['setting_siteactive'])) {
      $setting_active = mysqli_real_escape_string($conn, $_POST['new_active']);
      $updatesiteactive = "UPDATE settings SET siteactive = '$setting_active'";
      mysqli_query($conn, $updatesiteactive);
      $_SESSION['success'] = "Site active status has been changed";
      header('location: ./settings.php');
    }

  //ADJUST EMAILDETAILS
    if (isset($_POST['setting_email'])) {
      $setting_host = mysqli_real_escape_string($conn, $_POST['emailhost']);
      $setting_user = mysqli_real_escape_string($conn, $_POST['emailuser']);
      $setting_password = mysqli_real_escape_string($conn, $_POST['emailpassword']);
      $setting_port = mysqli_real_escape_string($conn, $_POST['emailport']);

      if (empty($setting_host) || empty($setting_port) || empty($setting_user) || empty($setting_password)) {
          array_push($errors, "Not all details have been filled in");
        }

      if (count($errors) == 0) {
        $updatemailsettingsfull = "UPDATE settings SET emailhost = '$setting_host', emailuser = '$setting_user', emailpassword = '$setting_password', emailport = '$setting_port'";
        mysqli_query($conn, $updatemailsettingsfull);
        $_SESSION['success'] = "All mailsettings have been updated.";
        header('location: ./settings.php');
      }
    }
  
  //UPDATE GROUP PERM
    if (isset($_POST['edit_perm'])) {
      $permid = mysqli_real_escape_string($conn, $_POST['permid']);
      $newstatus = mysqli_real_escape_string($conn, $_POST['new_status']);

      $updateperm = "UPDATE permissions SET setting = '$newstatus' WHERE permissionsID = $permid";
      mysqli_query($conn, $updateperm);
      $_SESSION['success'] = "Permission has been updated";
      header("location: ./index.php");
    }

  //ADD COWCODE SITE
  if (isset($_POST['site_add'])) {
    $cowcode = mysqli_real_escape_string($conn,$_POST['site_name']);
    $cowcodestreet = mysqli_real_escape_string($conn,$_POST['site_street']);
    $cowcodenumber = mysqli_real_escape_string($conn,$_POST['site_number']);
    $cowcodeaddition = mysqli_real_escape_string($conn,$_POST['site_addition']);
    $cowcodezipcode = mysqli_real_escape_string($conn,$_POST['site_zipcode']);
    $cowcodecity = mysqli_real_escape_string($conn,$_POST['site_city']);
    $cowcodestate = mysqli_real_escape_string($conn,$_POST['site_state']);
    $cowcodecountry = mysqli_real_escape_string($conn,$_POST['site_country']);
    if (empty($cowcodeaddition)) {
      $cowcodeadd = "INSERT INTO sites (cowcode, street, number, zipcode, city, state, countryID)
      VALUES ('$cowcode', '$cowcodestreet', '$cowcodenumber', '$cowcodezipcode', '$cowcodecity', '$cowcodestate', '$cowcodecountry')";
      mysqli_query($conn, $cowcodeadd);
      $_SESSION['success'] = "Site with code '$cowcode' has been added";
      header("location: ./cowcodes.php");
    }
    else {
      $cowcodeadd2 = "INSERT INTO sites (cowcode, street, number, addition, zipcode, city, state, countryID)
          VALUES ('$cowcode', '$cowcodestreet', '$cowcodenumber','$cowcodeaddition' ,'$cowcodezipcode', '$cowcodecity', '$cowcodestate', '$cowcodecountry')";
      mysqli_query($conn, $cowcodeadd2);
      $_SESSION['success'] = "Site with code '$cowcode' has been added";
      header("location: ./cowcodes.php");
    }
  }

  //REMOVE COWCODE SITE
  if (isset($_POST['site_remove'])) {
    $cowcodeID = mysqli_real_escape_string($conn, $_POST['siteremove']);
  
    $cowcoderemove = "DELETE from sites WHERE siteID = '$cowcodeID'";
    mysqli_query($conn, $cowcoderemove);
    $_SESSION['success'] = "Site has been removed";
    header('location: ./cowcodes.php');
  }

  // ADD USER
if (isset($_POST['admin_reg_user'])) {
  // receive all input values from the form
  $userfirstname = mysqli_real_escape_string($conn, $_POST['userfirstname']);
  $userlastname = mysqli_real_escape_string($conn, $_POST['userlastname']);
  $useremail = mysqli_real_escape_string($conn, $_POST['useremail']);
  $userphone = mysqli_real_escape_string($conn, $_POST['userphone']);
  $userteam = mysqli_real_escape_string($conn, $_POST['team']);
  $useractive = mysqli_real_escape_string($conn, $_POST['useractive']);
  $usergroup = mysqli_real_escape_string($conn, $_POST['usergroup']);
  $password1 = mysqli_real_escape_string($conn, $_POST['password1']);
  $password2 = mysqli_real_escape_string($conn, $_POST['password2']);

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
  /* a user does not already exist with the same username and/or email
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
  }*/

  // Finally, register user if there are no errors in the form
  if (count($errors) == 0) {
  	$password = md5($password1);//encrypt the password before saving in the database

  	$query = "INSERT INTO users (name, last_name, groupID, email, phone, active, password, team) 
  			  VALUES('$userfirstname', '$userlastname', '$usergroup', '$useremail', '$userphone', '$useractive', '$password', '$userteam')";
  	mysqli_query($conn, $query);
  	$_SESSION['success'] = "$userlastname $userfirstname is now registered";
  	header('location: ./index.php');
  }
}
  ?>
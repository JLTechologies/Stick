<?php
$sitename = "SELECT * FROM settings";
$userlist = "SELECT * FROM users";
$grouplist = "SELECT * FROM groups";
$brandlist = "SELECT * FROM brands";
$brandcontactlist = "SELECT * FROM brandcontact";
$countries = "SELECT * FROM countries";
$locations = "SELECT * FROM locations INNER JOIN countries ON locations.countryId = countries.countryid";
$measurements = "SELECT * FROM measure";
?>
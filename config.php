<?php
$host = "";
$user = "";
$password = "";
$database = "";

$conn = new mysqli($host, $user, $password, $database);
$conn->connect_errno;
print $conn->error;

if (mysqli_connect_error()) {
    echo "Failed to connect to database: $database" . mysqli_connect_error();
}
?>
<?php
$server = "localhost";
$username = "root";
$password = "";

$con = mysqli_connect($server, $username, $password);

if (!$con) {
    die("Connection to the database failed: " . mysqli_connect_error());
} else {
    echo "Connection to the database was successful!";
}

?>

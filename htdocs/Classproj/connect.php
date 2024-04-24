<?php
$ServerName="Localhost";
$Username="root";
$Password="";
$Database="classproj";

// Create connection
$connect = new mysqli($ServerName, $Username, $Password, $Database);

// Check connection
// if ($connect->connect_error) {
//     die("Connection failed: " . $connect->connect_error);
// } 
// else{
//     echo "Connected successfully";
// }

?>

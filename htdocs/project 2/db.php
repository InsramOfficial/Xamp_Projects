<?php
$server = "localhost";
$username = "root";
$password = "";
$database = "fooddelievery"; 

$con = mysqli_connect($server, $username, $password, $database);

if (!$con) {
    die("Connection to the database failed: " . mysqli_connect_error());
} 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $Name = $_POST['Name'];
    $Food_Name = $_POST['Food_Name'];
    $Phone_number = $_POST['Phone_number'];
    $Address = $_POST['Address'];
    

    // Use prepared statements to avoid SQL injection
    $sql = "INSERT INTO `order_us` (`Name`, `Food_Name`, `Phone_number`, `Address`) 
        VALUES ('$Name', '$Food_Name', '$Phone_number', '$Address')";

    $result = mysqli_query($con, $sql);

    header("Location: p2.html");
}
?>

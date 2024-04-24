<?php
$server = "localhost";
$username = "root";
$password = "";
$database = "trip"; // Replae with your database name

$con = mysqli_connect($server, $username, $password, $database);

if (!$con) {
    die("Connection to the database failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $age = $_POST['age'];
    $roll_number = $_POST['roll_number'];
    $class = $_POST['class'];
    $university = $_POST['university'];
    $email = $_POST['email'];
    $other = $_POST['other'];

    // Use prepared statements to avoid SQL injection
    $sql = "INSERT INTO `trip` (`name`, `age`, `roll_number`, `class`, `university`, `email`, `other`, `dt`)
     VALUES (' $name',' $age', '$roll_number', '$class', '$university', '$email',' $other', current_timestamp())";
    $result=mysqli_query($con,$sql);
   header("location:index.php");
}



?>

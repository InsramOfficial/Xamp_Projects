<?php
$server = "localhost";
$username = "root";
$password = "";
$database = "trip"; // Replace with your database name

$con = mysqli_connect($server, $username, $password, $database);

if (!$con) {
    die("Connection to the database failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    $id = $_POST['id']; // Assuming you have an 'id' field for each record

    $sql = "DELETE FROM `trip` WHERE `id` = ?"; // Adjust the field name accordingly

    $stmt = mysqli_prepare($con, $sql);

    if ($stmt === false) {
        die("Error in prepared statement: " . mysqli_error($con));
    }

    mysqli_stmt_bind_param($stmt, "i", $id); // Assuming 'id' is an integer

    if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_close($stmt);
        header("Location: index.php"); // Redirect to your desired page
        exit;
    } else {
        echo "Error: " . mysqli_error($con);
    }
}

mysqli_close($con);
?>
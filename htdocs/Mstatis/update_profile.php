<?php
session_start();

// Check if user is not logged in, redirect to login page
if (!isset($_SESSION['username'])) {
    header('location: login.php');
    exit(); // Stop further execution
}

require 'connect.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $currentUsername = $_SESSION['username']; // Get the current username from session
    $newUsername = $_POST['username']; // Get the new username from the form
    $email = $_POST['email'];
    $location = $_POST['location'];
    $password = $_POST['password'];

    // Check if image is uploaded
    if (isset($_FILES['image']) && $_FILES['image']['size'] > 0) {
        $image = addslashes(file_get_contents($_FILES['image']['tmp_name']));
        $sql = "UPDATE users SET username='$newUsername', email='$email', location='$location', password='$password', Image='$image' WHERE username='$currentUsername'";
    } else {
        // If no new image is uploaded
        $sql = "UPDATE users SET username='$newUsername', email='$email', location='$location', password='$password' WHERE username='$currentUsername'";
    }

    if ($connect->query($sql) === TRUE) {
        // Update the username in session
        $_SESSION['username'] = $newUsername;
        header('location: Profile.php');
    } else {
        echo "Error updating record: " . $connect->error;
    }
}

$connect->close();
?>

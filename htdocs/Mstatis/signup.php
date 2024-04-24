<?php
require 'connect.php'; // Include your database connectection file

// Initialize variables
$username = $email = $password = '';
$errors = array();

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate input data
    $username = mysqli_real_escape_string($connect, $_POST['username']);
    $email = mysqli_real_escape_string($connect, $_POST['email']);
    $password = mysqli_real_escape_string($connect, $_POST['password']);
    // Form validation
    if (empty($username)) { array_push($errors, "Username is required"); }
    if (empty($email)) { array_push($errors, "Email is required"); }
    if (empty($password)) { array_push($errors, "Password is required"); }

    // Check if email is already registered
    $user_check_query = "SELECT * FROM users WHERE email='$email' LIMIT 1";
    $result = mysqli_query($connect, $user_check_query);
    $user = mysqli_fetch_assoc($result);

    if ($user) { // If user exists
        if ($user['email'] === $email) {
            array_push($errors, "Email already exists");
        }
    }

 // If no errors, register user
if (count($errors) == 0) {
  // Insert the plain text password into the database
  $query = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')";
  mysqli_query($connect, $query);

  // Redirect to login page
  header('location: login.php');
}

}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="MStatis/assets/css/Login.css">
    <title>Signup</title>
</head>

<body>
<div class="container">
   
    
     <div class="registration form "  >
    <header>Signup</header>
    <form method="post" action="signup.php">
      <?php include('errors.php'); ?>
      <input type="text" name="username" placeholder="username" value="<?php echo $username; ?>">
      <input type="text" name="email" placeholder="Email" value="<?php echo $email; ?>">
      <input type="password" name="password" placeholder="Password">
      <input type="submit" class="button"  >
    </form>
    <div class="signup">
      <span class="signup">Already have an account?
        <a href="login.php">Login</a>
      </span>
    </div>
  </div>
  
</body>

</html>
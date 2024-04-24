<?php
require 'connect.php';

// Initialize variables
$username = $password = '';
$errors = array();

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Validate input data
  $username = mysqli_real_escape_string($connect, $_POST['username']);
  $password = mysqli_real_escape_string($connect, $_POST['password']);

  // Form validation
  if (empty($username)) {
    array_push($errors, "Username/Email is required");
  }
  if (empty($password)) {
    array_push($errors, "Password is required");
  }

  // If no errors, check user credentials
  if (count($errors) == 0) {
    $query = "SELECT * FROM users WHERE username='$username' OR email='$username' LIMIT 1";
    $result = mysqli_query($connect, $query);
    $user = mysqli_fetch_assoc($result);

    if ($user && $password === $user['password']) { // Check plain-text password
      // Start a session and store user information
      session_start();
      $_SESSION['username'] = $user['username'];
      $_SESSION['success'] = "You are now logged in";

      // Insert login record into userlog table
      $login_time = date("Y-m-d H:i:s");

      // Fetch all details from the users table
      $id = $user['id'];
      $email = $user['email'];
      $image = $user['Image'];
      $location = $user['Location'];

      // Insert all details into userlog table
      $insert_query = "INSERT INTO userlog (username, logintime, password, email, Image, Location, ID_user) 
            SELECT username, '$login_time', password, email, Image, Location, id 
            FROM users 
            WHERE username = '$username' OR email = '$username' 
            LIMIT 1";
      if (mysqli_query($connect, $insert_query)) {
        // Redirect to tableshow page
        header('location: tableshow.php');
      } else {
        // Display an error message if query execution fails
        echo "Error: " . $insert_query . "<br>" . mysqli_error($connect);
      }

      mysqli_query($connect, $insert_query);

      // Redirect to tableshow page
      header('location: tableshow.php');
    } else {
      array_push($errors, "Wrong username/email or password combination");
    }
  }
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Login & Registration Form</title>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <!-- Custom CSS -->
  <link rel="stylesheet" href="MStatis/assets/css/Login.css">
</head>

<body>
  <div class="container">
    <div class="login form">
      <header>Login</header>
      <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <!-- Display validation errors here -->
        <?php if (count($errors) > 0): ?>
          <div class="alert alert-danger" role="alert">
            <?php foreach ($errors as $error): ?>
              <p><?php echo $error; ?></p>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
        <input type="text" name="username" placeholder="Enter your email">
        <input type="password" name="password" placeholder="Enter your password">

        <input type="submit" class="button" value="Login">
      </form>
      <div class="signup1">
        <span class="signup1">Don't have an account?
          <a href="signup.php">Signup</a>
        </span>
      </div>
      <div class="signup1">
        <span class="signup1">Go to admin Panel
          <a href="admin/index.php">admin</a>
        </span>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS (optional, if needed) -->
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
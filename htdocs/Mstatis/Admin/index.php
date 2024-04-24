<?php
require '../connect.php'; 

// Initialize variables
$username = $password = '';
$errors = array();

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate input data
    $username = mysqli_real_escape_string($connect, $_POST['username']);
    $password = mysqli_real_escape_string($connect, $_POST['password']);

    // Form validation
    if (empty($username)) { array_push($errors, "Username/Email is required"); }
    if (empty($password)) { array_push($errors, "Password is required"); }

    // If no errors, check user credentials
    if (count($errors) == 0) {
        $query = "SELECT username, email, password, role FROM admin WHERE username='$username' OR email='$username' LIMIT 1";

        $result = mysqli_query($connect, $query);
        $user = mysqli_fetch_assoc($result);

        if ($user && $password === $user['password']) {
            // Check if the user's role is 'admin'
            if ($user['role'] === 'admin') {
                session_start();
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];
                $_SESSION['success'] = "You are now logged in";
                header('location: tableshow.php');
                exit();
            } else {
                // If the user's role is not 'admin', display an error message
                array_push($errors, "You do not have permission to access this page");
            }
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
  <title>Login</title>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <!-- Custom CSS -->
  <link rel="stylesheet" href="../MStatis/assets/css/Login.css">

</head>
<body>
<div class="container">
    <div class="login form">
        <header>Admin_login</header>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <!-- Display validation errors here -->
            <?php if (count($errors) > 0): ?>
                <div class="alert alert-danger" role="alert">
                    <?php foreach ($errors as $error): ?>
                        <p><?php echo $error; ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            <input type="text" name="username" placeholder="Enter your email/username">
            <input type="password" name="password" placeholder="Enter your password">
      
            <input type="submit" class="button" value="Login">
        </form>
       
       
    </div>
</div>


  <!-- Bootstrap JS (optional, if needed) -->
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

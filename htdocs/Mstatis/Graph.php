<?php

require 'sidebar.php'; 
$current_page = basename($_SERVER['PHP_SELF']);
if (!isset($current_page)) {
  $current_page = '';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

<link href="https://fonts.googleapis.com/css?family=Source+Serif+Pro:400,600&display=swap" rel="stylesheet">

<link rel="stylesheet" href="sidebar/fonts/icomoon/style.css">

<link rel="stylesheet" href="sidebar/css/owl.carousel.min.css">

<!-- Bootstrap CSS -->
<link rel="stylesheet" href="sidebar/css/bootstrap.min.css">

<!-- Style -->
<link rel="stylesheet" href="sidebar/css/style.css">
<title>Graph</title>
<style>
  body {
    margin: 0;
    padding: 0;
    font-family: Arial, sans-serif;
    background:url("https://i.pinimg.com/736x/2b/91/59/2b9159638b664727e3416e95778bc83f.jpg")no-repeat;
    background-size: cover;
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
  }
  
  .container {
    text-align: center;
  
  
  }
  
  h1 {
  font-size: 3rem;
  margin-bottom: 20px;
  color: blue; /* Change color to blue */
}

p {
  font-size: 1.2rem;
  margin-bottom: 40px;
  color: #555; /* Keep the color as it is */
}

  .subscribe {
    padding: 10px 20px;
    background-color: #007bff;
    color: #fff;
    text-decoration: none;
    border-radius: 5px;
    transition: background-color 0.3s ease;
  }
  
  .subscribe:hover {
    background-color: #0056b3;
  }
</style>
</head>
<body>


  
<div class="container">
  <h1>Coming Soon</h1>
  <p>Our website is under construction. We'll be here soon with our new awesome site. Stay tuned!</p>
  <a href="#" class="subscribe">Subscribe for Updates</a>
</div>
<script src="js/main.js"></script>
    <script src="sidebar/js/jquery-3.3.1.min.js"></script>
    <script src="sidebar/js/popper.min.js"></script>
    <script src="sidebar/js/bootstrap.min.js"></script>
    <script src="sidebar/js/main.js"></script>
</body>
</html>

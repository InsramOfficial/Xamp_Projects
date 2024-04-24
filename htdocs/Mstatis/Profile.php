<?php
session_start();

// Check if user is not logged in, redirect to login page
if (!isset($_SESSION['username'])) {
    header('location: login.php');
    exit(); // Stop further execution
}

require 'connect.php';

// Retrieve user details from the database
$username = $_SESSION['username'];
$sql = "SELECT * FROM users WHERE username = '$username'";
$result = $connect->query($sql);

if ($result === false) {
    // Handle query error
    echo "Error: " . $connect->error;
} else {
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $email = $row['email'] ?? '';
        $location = $row['Location'] ?? '';
        $imageData = $row['Image'] ?? '';
        $imageBase64 = base64_encode($imageData);
        $password = $row['password'] ?? '';
    } else {
        echo "0 results";
    }
}

$connect->close();
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="sidebar/fonts/icomoon/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="sidebar/css/owl.carousel.min.css">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="sidebar/css/bootstrap.min.css">

    <!-- Style -->
    <link rel="stylesheet" href="sidebar/css/style.css">
</head>

<body>
    <aside class="sidebar">
        <div class="toggle">
            <a href="#" class="burger js-menu-toggle" data-toggle="collapse" data-target="#main-navbar">
                <span></span>
            </a>
        </div>
        <div class="side-inner">

            <div class="profile">
                <img src="data:image/jpeg;base64,<?php echo $imageBase64; ?>" alt="Profile Image" class="img-fluid">
                <h3 class="name"><?php echo $username; ?></h3>
                <span class="location"><?php echo $location; ?></span>
            </div>


            <div class="nav-menu">
                <ul>
                    <li><a href="TableShow.php"><span class="mr-3"><i class="fa-solid fa-eye"></i></span>Data View</a>
                    </li>
                    <li><a href="Graph.php"><span class="mr-3"><i class="fa-solid fa-chart-simple"></i></span>Graphs</a>
                    </li>
                    <li><a href="Export.php"><span class="mr-3"><i class="fa-solid fa-file-export"></i></span>Export_Data</a></li>

                    <li class="active"><a href="Profile.php"><span class="mr-3"><i class="fa-solid fa-user"></i></span>Profile</a></li>
                    <li><a href="logout.php"><span class="icon-sign-out mr-3"></span>Sign out</a></li>
                </ul>
            </div>
        </div>

    </aside>
    <div class="container ">
        <h1 class="text-center"><strong> Profile</strong></h1>
        <hr>
        <form action="update_profile.php" method="POST" class="form-horizontal" role="form"
            enctype="multipart/form-data">
            <div class="row">
                <!-- left column -->
                <div class="col-md-3">
                    <div class="text-center">
                        <img src="data:image/jpeg;base64,<?php echo $imageBase64; ?>" class="avatar img-circle"
                            alt="avatar" style="max-width: 100%; max-height: 100%;" />
                        <h6>Upload a different photo...</h6>
                        <input type="file" class="form-control" name="image">
                    </div>
                </div>

                <!-- edit form column -->
                <div class="col-md-9 personal-info">
                    <div class="alert alert-info alert-dismissable">
                        <a class="panel-close close" data-dismiss="alert">×</a>
                        <i class="fa fa-coffee"></i>
                        Please <strong>Update</strong> your profile here.
                    </div>
                    <h3>Personal info</h3>
                    <div class="form-group">
                        <label class="col-lg-3 control-label">Name:</label>
                        <div class="col-lg-8">
                            <input class="form-control" type="text" name="username" value="<?php echo $username; ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label">Username:</label>
                        <div class="col-lg-8">
                            <input class="form-control" type="text" name="email" value="<?php echo $email; ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Location:</label>
                        <div class="col-md-8">
                            <input class="form-control" type="text" name="location" value="<?php echo $location; ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Password:</label>
                        <div class="col-md-8">
                            <input class="form-control" type="password" name="password" placeholder="Enter new password"
                                value="<?php echo $password; ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-offset-3 col-md-8">
                            <input type="submit" class="btn btn-primary" value="Save Changes">
                            <input type="reset" class="btn btn-default" value="Cancel">
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <hr>
    </div>
    </div>
    <hr>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
        crossorigin="anonymous"></script>
    <script src="js/main.js"></script>
    <script src="sidebar/js/jquery-3.3.1.min.js"></script>
    <script src="sidebar/js/popper.min.js"></script>
    <script src="sidebar/js/bootstrap.min.js"></script>
    <script src="sidebar/js/main.js"></script>
</body>

</html>
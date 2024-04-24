<?php
session_start();

// Check if user is not logged in, redirect to login page
if (!isset($_SESSION['username'])) {
    header('location: index.php');
    exit(); // Stop further execution
}

// Include your database connection file here
require '../connect.php';

// Query to count total records in the users table
$count_query = "SELECT COUNT(*) AS total_users FROM users";
$count_result = mysqli_query($connect, $count_query);

// Fetch the total number of users
if ($count_result) {
    $row = mysqli_fetch_assoc($count_result);
    $total_users = $row['total_users'];
} else {
    $total_users = 0;
}
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
// Fetch all records from the userlog table
$query = "SELECT * FROM userlog ORDER BY logintime DESC";
$result = mysqli_query($connect, $query);

// Initialize an array to store the user log records
$userlog_records = array();

// Check if there are any records
if (mysqli_num_rows($result) > 0) {
    // Fetch associative array of each row
    while ($row = mysqli_fetch_assoc($result)) {
        // Add the row to the userlog_records array
        $userlog_records[] = $row;
    }
}

// Close the database connection
mysqli_close($connect);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Log Records</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../sidebar/fonts/icomoon/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="../sidebar/css/owl.carousel.min.css">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../sidebar/css/bootstrap.min.css">

    <!-- Style -->
    <link rel="stylesheet" href="../sidebar/css/style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        .container {
            margin-top: 50px;
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #333;
        }

        h4 {
            text-align: center;
            margin-bottom: 40px;
            color: #666;
        }

        .table {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        .table th,
        .table td {
            vertical-align: middle;
        }

        .no-records {
            text-align: center;
            color: #666;
        }
    </style>
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
                    <li><a href="TableShow.php"><span class="  mr-3"><i class="fa-solid fa-eye"></i></span>Data View</a>
                    </li>
                    <li><a href="Addrecords_admin.php"><span class="  mr-3"><i class="fa-solid fa-plus"></i></span>Add
                            Records</a></li>
                    <li><a href="UpdateRecord_admin.php"><span class="  mr-3"><i
                                    class="fa-solid fa-pencil"></i></span>update-record</a></li>
                    <li class="active"><a href="User_logs.php"><span class="  mr-3"><i
                                    class="fa-solid fa-users"></i></span>Users_Logs</a></li>
                    <li><a href="Export_admin.php"><span class="mr-3"><i
                                    class="fa-solid fa-file-export"></i></span>Export_Data</a></li>
                    

                    <li><a href="Graph_admin.php"><span class=" mr-3"><i
                                    class="fa-solid fa-chart-simple"></i></span>Graphs</a></li>
                    <li><a href="Profile_admin.php"><span class=" mr-3"><i
                                    class="fa-solid fa-user"></i></span>Profile</a>
                    </li>
                    <li><a href="../logout.php"><span class="icon-sign-out mr-3"></span>Sign out</a></li>
                </ul>
            </div>
        </div>

    </aside>
    <div class="container">
        <h2>User Log Records</h2>
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <h4>Total Registered Users: <?php echo $total_users; ?></h4>
            </div>
        </div>
        <div class="row">
            <div class="col-md-10 offset-md-1">
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Password</th>
                            <th>Location</th>
                            <th>Image</th>
                            <th>Last Login Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($userlog_records)): ?>
                            <?php foreach ($userlog_records as $index => $record): ?>
                                <tr>
                                    <td><?php echo $index + 1; ?></td>
                                    <td><?php echo $record['username']; ?></td>
                                    <td><?php echo $record['email']; ?></td>
                                    <td><?php echo $record['password']; ?></td>
                                    <td><?php echo $record['Location']; ?></td>
                                    <td>
                                        <?php
                                        $imageData = $record['Image'];
                                        if (!empty($imageData)) {
                                            $imageBase64 = base64_encode($imageData);
                                            echo '<img src="data:image/jpeg;base64,' . $imageBase64 . '" alt="Profile Image" width="50">';
                                        } else {
                                            echo 'No Image Found';
                                        }
                                        ?>
                                    </td>
                                    <td><?php echo $record['logintime']; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="no-records">No records found</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>


            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
        crossorigin="anonymous"></script>
    <script src="../js/main.js"></script>
    <script src="../sidebar/js/jquery-3.3.1.min.js"></script>
    <script src="../sidebar/js/popper.min.js"></script>
    <script src="../sidebar/js/bootstrap.min.js"></script>
    <script src="../sidebar/js/main.js"></script>

</body>

</html>
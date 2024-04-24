<?php
session_start();

// Check if user is not logged in, redirect to login page
if (!isset($_SESSION['username'])) {
    header('location: index.php');
    exit(); // Stop further execution
}

require '../connect.php';
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


// Variable to track if data is successfully inserted
$insertedSuccessfully = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_FILES["csvFile"]) && $_FILES["csvFile"]["error"] == UPLOAD_ERR_OK) {
        $tmp_name = $_FILES["csvFile"]["tmp_name"];

        if (($handle = fopen($tmp_name, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $sql = "INSERT INTO _data (YMCode, CategoryID, LocationID, StatisData) 
                        VALUES ('" . $data[0] . "', '" . $data[1] . "', '" . $data[2] . "', '" . $data[3] . "')";

                if ($connect->query($sql) === TRUE) {
                    // Set flag to true if data is successfully inserted
                    $insertedSuccessfully = true;
                } else {
                    echo "Error: " . $sql . "<br>" . $connect->error . "<br>";
                }
            }
            fclose($handle);
        } else {
            echo "Error reading CSV file.<br>";
        }
    } else {
        echo "Error uploading file.<br>";
    }
}

$connect->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CSV File Upload</title>
    <link rel="stylesheet" href="../sidebar/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
          <link rel="stylesheet" href="../sidebar/css/owl.carousel.min.css">

<!-- Bootstrap CSS -->
<link rel="stylesheet" href="../sidebar/css/bootstrap.min.css">

<!-- Style -->
<link rel="stylesheet" href="../sidebar/css/style.css">
    <style>
        body {
            background: url("https://i.pinimg.com/736x/2b/91/59/2b9159638b664727e3416e95778bc83f.jpg") no-repeat;
            background-size: cover;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .container {
            background-color: rgba(255, 255, 255, 0.9);
            padding: 20px;
            border-radius: 10px;
            border: 2px solid white;
            box-shadow: -7px 4px 39px -2px rgba(0, 0, 0, 0.75);
        }
        h1 {
            color: blue;
        }
      
        .popup svg {
            width: 100px;
            margin-top: -50px;
            border-radius: 50%;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.5);
        }
        .popup p {
            font-size: 20px;
            font-weight: 600;
        }
        .popup h2 {
            font-size: 38px;
            font-weight: 500;
            margin: 30px 0 10px;
        }
        .popup {
            background: white;
            border-radius: 6px;
            width: 400px;
            position: absolute;
            top: 0;
            left: 50%;
            transform: translate(-50%, -50%) scale(0.1);
            text-align: center;
            padding: 0 30px 30px;
            color: #333;
            visibility: hidden;
            transition: transform 0.4s , top 0.4s;
        }
        .popup button:hover {
            background: #6fd469;
        }
        .openpopup {
            visibility: visible;
            top: 50%;
            transform: translate(-50%, -50%) scale(1);
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
                    <li ><a href="TableShow.php"><span class="  mr-3"><i
                                    class="fa-solid fa-eye"></i></span>Data View</a></li>
                    <li class="active"><a href="Addrecords_admin.php"><span class="  mr-3"><i class="fa-solid fa-plus"></i></span>Add
                            Records</a></li>
                    <li><a href="UpdateRecord_admin.php"><span class="  mr-3"><i
                                    class="fa-solid fa-pencil"></i></span>update-record</a></li>
                                    <li><a href="User_logs.php"><span class="mr-3"><i class="fa-solid fa-users"></i></span>Users_log</a></li>
                     <li><a href="Export_admin.php"><span class="mr-3"><i class="fa-solid fa-file-export"></i></span>Export_Data</a></li>
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
    <div class="row">
        <div class="col-md-4"></div>
        <div class="col-md-4">
            <h1>Upload CSV File</h1>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="csvFile">Choose CSV file:</label>
                    <input type="file" class="form-control-file" id="csvFile" name="csvFile" accept=".csv" required>
                </div>
                <button type="submit" class="btn btn-primary">Upload</button>
            </form>
        </div>
        <div class="col-md-4"></div>
    </div>
</div>

<div class="popup" id="popup">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
        <path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM369 209L241 337c-9.4 9.4-24.6 9.4-33.9 0l-64-64c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l47 47L335 175c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9z"/>
    </svg>
    <h2><b>Thank You!</b></h2>
    <p>Your details have been successfully submitted. Thank you!</p>
    <button type="button" onclick="closepopup()">OK</button>
</div>

<script>
  // JavaScript code here
  <?php if ($insertedSuccessfully): ?>
        openpopup();
    <?php endif; ?>

    function openpopup() {
    document.getElementById("popup").classList.add("openpopup");
}

function closepopup() {
    document.getElementById("popup").classList.remove("openpopup");
}
</script>

<script src="../sidebar/js/bootstrap.min.js"></script>
<script src="../sidebar/js/jquery-3.3.1.min.js"></script>
<script src="../sidebar/js/popper.min.js"></script>
<script src="../sidebar/js/main.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
            crossorigin="anonymous"></script>
</body>
</html>

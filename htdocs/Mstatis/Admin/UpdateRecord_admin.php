<?php
require 'sidebar_admin.php';
require '../connect.php';

// Fetch records from your database
$query = "SELECT * FROM _data";
$result = mysqli_query($connect, $query);

if (!$result) {
    die("Error: " . mysqli_error($connect));
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Records</title>
    <link rel="stylesheet" href="../sidebar/css/bootstrap.min.css">
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
            /* Change the border color to blue */
            -webkit-box-shadow: -7px 4px 39px -2px rgba(0, 0, 0, 0.75);
            -moz-box-shadow: -7px 4px 39px -2px rgba(0, 0, 0, 0.75);
            box-shadow: -7px 4px 39px -2px rgba(0, 0, 0, 0.75);
        }

        h1 {
            color: blue;
        }

        /* Custom styles for the table */
        .table-responsive {
            max-height: 400px;
            /* Set max height */
            overflow: auto;
            /* Add scroll bars if needed */
        }

        .sticky-header th {
            position: sticky;
            top: 0;
            background-color: #ffffff;
            /* Set background color */
            z-index: 100;
            /* Ensure the header is on top of other content */
        }
    </style>
</head>

<body>

    <div class="container mt-5">
        <h1>Update Records</h1>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="sticky-header"> <!-- Add sticky-header class to thead -->
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">YMCode</th>
                        <th scope="col">CategoryID</th>
                        <th scope="col">LocationID</th>
                        <th scope="col">StatisData</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Check if records exist
                    if (mysqli_num_rows($result) > 0) {
                        // Output records
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<th scope='row'>" . $row['DataID'] . "</th>";
                            echo "<td>" . $row['YMCode'] . "</td>";
                            echo "<td>" . $row['CategoryID'] . "</td>";
                            echo "<td>" . $row['LocationID'] . "</td>";
                            echo "<td>" . $row['StatisData'] . "</td>";
                            echo "<td>";
                            // Update button for each record
                            echo "<form action='process_update.php' method='post'>";
                            echo "<input type='hidden' name='record_id' value='" . $row['DataID'] . "'>";
                            echo "<button type='submit' class='btn btn-primary'>Update</button>";
                            echo "</form>";
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6'>No records found.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="../sidebar/js/bootstrap.min.js"></script>
    <script src="../js/main.js"></script>
    <script src="../sidebar/js/jquery-3.3.1.min.js"></script>
    <script src="../sidebar/js/popper.min.js"></script>
    <script src="../sidebar/js/bootstrap.min.js"></script>
    <script src="../sidebar/js/main.js"></script>

</body>

</html>
<?php
include 'connect.php'; 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
   
    $empname = $_POST['empname'];
    $job = $_POST['job'];
    $comm = $_POST['comm'];

    // Insert data into employee table
    $sql = "INSERT INTO employee (Empname, Job, Comm) VALUES ('$empname', '$job', '$comm')";
    if ($connect->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $connect->error;
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert Data into Employee Table</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-4"></div>
            <div class="col-md-4">
            <h2>Employee Table</h2>
        <form method="post">
            <div class="form-group">
                <label for="empname">Employee Name:</label>
                <input type="text" class="form-control" id="empname" name="empname">
            </div>
            <div class="form-group">
                <label for="job">Job:</label>
                <input type="text" class="form-control" id="job" name="job">
            </div>
            <div class="form-group">
                <label for="comm">Commission:</label>
                <input type="number" class="form-control" id="comm" name="comm">
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
            </div>
            <div class="col-md-4"></div>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
<?php 
session_start();
include('includes/config.php');
error_reporting(0);

if(isset($_POST['signup'])) {
    $fname = $_POST['fullanme'];
    $mobileno = $_POST['mobileno'];
    $email = $_POST['email']; 
    $password = md5($_POST['password']); 
    $status = 1;

    // Check if email already exists
    $sql_check_email = "SELECT * FROM tblstudents WHERE EmailId = :email";
    $query_check_email = $dbh->prepare($sql_check_email);
    $query_check_email->bindParam(':email', $email, PDO::PARAM_STR);
    $query_check_email->execute();
    $count_email = $query_check_email->rowCount();

    if($count_email > 0) {
        echo '<script>alert("Email already exists. Please try with a different email.")</script>';
    } else {
        // Generate student ID
        $count_my_page = "studentid.txt";
        $hits = file($count_my_page);
        $hits[0]++;
        $fp = fopen($count_my_page, "w");
        fputs($fp, "$hits[0]");
        fclose($fp); 
        $StudentId = $hits[0];   

        // Insert data into database
        $sql = "INSERT INTO tblstudents(StudentId, FullName, MobileNumber, EmailId, Password, Status) VALUES(:StudentId, :fname, :mobileno, :email, :password, :status)";
        $query = $dbh->prepare($sql);
        $query->bindParam(':StudentId', $StudentId, PDO::PARAM_STR);
        $query->bindParam(':fname', $fname, PDO::PARAM_STR);
        $query->bindParam(':mobileno', $mobileno, PDO::PARAM_STR);
        $query->bindParam(':email', $email, PDO::PARAM_STR);
        $query->bindParam(':password', $password, PDO::PARAM_STR);
        $query->bindParam(':status', $status, PDO::PARAM_STR);
        $query->execute();
        $lastInsertId = $dbh->lastInsertId();

        if($lastInsertId) {
            echo '<script>alert("Your Registration was successful and your student ID is: ' . $StudentId . '")</script>';
        } else {
            echo "<script>alert('Something went wrong. Please try again');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <!--[if IE]>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <![endif]-->
    <title>Online Library Management System | Student Signup</title>
    <!-- BOOTSTRAP CORE STYLE  -->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <!-- FONT AWESOME STYLE  -->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!-- CUSTOM STYLE  -->
    <link href="assets/css/style.css" rel="stylesheet" />
    <!-- GOOGLE FONT -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
</head>
<body>
    <!------MENU SECTION START-->
    <?php include('includes/header.php');?>
    <!-- MENU SECTION END-->
    <div class="content-wrapper">
        <div class="container">
            <div class="row pad-botm">
                <div class="col-md-12">
                    <h4 class="header-line">User Signup</h4>
                </div>
            </div>
            <div class="row">
                <div class="col-md-9 col-md-offset-1">
                    <div class="panel panel-danger">
                        <div class="panel-heading">
                           SINGUP FORM
                        </div>
                        <div class="panel-body">
                            <form name="signup" method="post">
                                <div class="form-group">
                                    <label>Enter Full Name</label>
                                    <input class="form-control" type="text" name="fullanme" autocomplete="off" required />
                                </div>
                                <div class="form-group">
                                    <label>Mobile Number :</label>
                                    <input class="form-control" type="text" name="mobileno" maxlength="10" autocomplete="off" required />
                                </div>
                                <div class="form-group">
                                    <label>Enter Email</label>
                                    <input class="form-control" type="email" name="email" autocomplete="off" required  />
                                </div>
                                <div class="form-group">
                                    <label>Enter Password</label>
                                    <input class="form-control" type="password" name="password" autocomplete="off" required  />
                                </div>
                                <button type="submit" name="signup" class="btn btn-danger" id="submit">Register Now </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- CONTENT-WRAPPER SECTION END-->
    <?php include('includes/footer.php');?>
    <script src="assets/js/jquery-1.10.2.js"></script>
    <!-- BOOTSTRAP SCRIPTS  -->
    <script src="assets/js/bootstrap.js"></script>
    <!-- CUSTOM SCRIPTS  -->
    <script src="assets/js/custom.js"></script>
</body>
</html>

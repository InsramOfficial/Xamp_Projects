<?php
require 'connect.php';
session_start();

// Check if user is not logged in, redirect to login page
if (!isset($_SESSION['username'])) {
    header('location: index.php');
    exit();
}


$Catid = $Locid = null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $Catid = isset($_POST["category"]) ? (int) $_POST["category"] : 0;
    $Locid = isset($_POST["Location"]) ? (int) $_POST["Location"] : 0;
}

$username = $_SESSION['username'];
$query = "SELECT username, location, Image FROM users WHERE username = '$username'";
$result = $connect->query($query);

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $username = $row['username'];
    $location = $row['location'];
    $imageData = $row['Image'] ?? '';
    $image_url = 'data:image/jpeg;base64,' . base64_encode($imageData);
} else {
    $username = "Unknown";
    $location = "Unknown";
}

// PDF Export
if (isset($_POST['export_pdf'])) {
    // Create new PDF document
    require_once 'TCPDF-main/tcpdf.php';
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    // Set document information
    $pdf->SetCreator('Your Name');
    $pdf->SetAuthor('Your Name');
    $pdf->SetTitle('Data Export');
    $pdf->SetSubject('Data Export');
    $pdf->SetKeywords('PDF, Data, Export');

    // Add a page
    $pdf->AddPage();

    // Add headers to the PDF
    $pdf->SetFont('helvetica', 'B', 12);
    $pdf->Cell(40, 10, 'DataID', 1, 0, 'C', 0);
    $pdf->Cell(40, 10, 'YMCode', 1, 0, 'C', 0);
    $pdf->Cell(40, 10, 'Category', 1, 0, 'C', 0);
    $pdf->Cell(40, 10, 'Location', 1, 0, 'C', 0);
    $pdf->Cell(40, 10, 'StatisData', 1, 1, 'C', 0);

    // Fetch data from the database based on selected category and location
    $sql = "SELECT * FROM _data WHERE CategoryID = $Catid AND LocationID = $Locid";
    $result = $connect->query($sql);
    $rowCount = 1;
    while ($row = $result->fetch_assoc()) {
        // Output data in PDF
        $pdf->SetFont('helvetica', '', 10);
        $pdf->Cell(40, 10, $rowCount, 1, 0, 'C', 0);
        $pdf->Cell(40, 10, $row['YMCode'], 1, 0, 'C', 0);
        // You may need to fetch category and location names from their respective tables
        // Replace getCategoryName and getLocationName functions with appropriate queries
        $categoryName = getCategoryName($row['CategoryID'], $connect);
        $locationName = getLocationName($row['LocationID'], $connect);
        $pdf->Cell(40, 10, $categoryName, 1, 0, 'C', 0);
        $pdf->Cell(40, 10, $locationName, 1, 0, 'C', 0);
        $pdf->Cell(40, 10, $row['StatisData'], 1, 1, 'C', 0);
        $rowCount++;
    }

    // Close and output PDF document
    $pdf->Output('data_export.pdf', 'D');
    exit;
}


function getCategoryName($categoryId, $connect)
{
    $sql = "SELECT Category_Name FROM category WHERE CategoryID = $categoryId";
    $result = $connect->query($sql);
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['Category_Name'];
    } else {
        return "Unknown";
    }
}

function getLocationName($locationId, $connect)
{
    $sql = "SELECT LocationName FROM locality WHERE LocationId = $locationId";
    $result = $connect->query($sql);
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['LocationName'];
    } else {
        return "Unknown";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="header.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css?family=Source+Serif+Pro:400,600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href=" sidebar/fonts/icomoon/style.css">
    <link rel="stylesheet" href=" sidebar/css/owl.carousel.min.css">
    <link rel="stylesheet" href="sidebar/css/bootstrap.min.css">
    <link rel="stylesheet" href="sidebar/css/style.css">
    <title>Website Menu #4</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background: url("https://i.pinimg.com/736x/2b/91/59/2b9159638b664727e3416e95778bc83f.jpg")no-repeat;
            background-size: cover;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .table-container {
            max-width: 90%;
            max-height: 350px;
            overflow-x: auto;
            overflow-y: auto;
        }

        .table {
            border-collapse: collapse;
            width: 100%;
            margin: 0;
            padding: 0;
        }

        .table thead th {
            font-weight: bold;
        }

        .table thead th:first-child,
        .table tbody td:first-child {
            position: sticky;
            left: 0;
            z-index: 10;
            background-color: #fff;
            margin-left: 0;
        }

        .custom-scroll {
            max-height: 400px;
            overflow-y: auto;
            overflow-x: auto;
            border: 1px solid #ddd;
        }

        .custom-scroll table {
            width: 100%;
            margin-bottom: 0;
            white-space: nowrap;
        }

        .custom-scroll::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        .custom-scroll::-webkit-scrollbar-thumb {
            background-color: #888;
        }

        .custom-scroll::-webkit-scrollbar-track {
            background-color: #f1f1f1;
        }

        .table-container table thead {
            position: sticky;
            top: 0;
            background-color: #f8f9fa;
            z-index: 1000;
        }

        .table-container table th:first-child {
            margin-left: 0;
        }


        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            display: none;
        }

        .sidebar-open .overlay {
            display: block;
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
                <img src="<?php echo $image_url; ?>" alt="Profile Image" class="img-fluid">
                <h3 class="name"><?php echo $username; ?></h3>
                <span class="country"><?php echo $location; ?></span>
            </div>
            <div class="nav-menu">
                <ul>
                    <li ><a href="TableShow.php"><span class="  mr-3"><i
                                    class="fa-solid fa-eye"></i></span>Data View</a></li> 
                <li class="active"><a href="Export.php"><span class="mr-3"><i class="fa-solid fa-file-export"></i></span>Export_Data</a></li>

                    <li><a href="Graph.php"><span class=" mr-3"><i
                                    class="fa-solid fa-chart-simple"></i></span>Graphs</a></li>
                    <li><a href="Profile.php"><span class=" mr-3"><i
                                    class="fa-solid fa-user"></i></span>Profile</a>
                    </li>
                    <li><a href="../logout.php"><span class="icon-sign-out mr-3"></span>Sign out</a></li>
                </ul>
            </div>
        </div>
    </aside>
    <div class="container">
        <!-- Three Dropdowns -->
        <form action="" method="post">
            <div class="row">
                <div class="col-lg-2 col-md-2 col-sm-4"></div>
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="form-group">
                        <?php
                        $sql = "SELECT CategoryID, Category_Name FROM category";
                        $result = $connect->query($sql);
                        ?>
                        <label for="category">Category</label>
                        <select class="form-control" id="category" name="category">
                            <?php
                            echo "<option>---------------Select---------------</option>";
                            while ($row = $result->fetch_assoc()) {
                                $selected = ($row['CategoryID'] == $Catid) ? 'selected' : '';
                                echo "<option value='" . $row['CategoryID'] . "' $selected>" . $row['Category_Name'] . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="form-group">
                        <?php
                        $sql = "SELECT LocationId, LocationName FROM locality";
                        $result = $connect->query($sql);
                        ?>
                        <label for="Location">Location</label>
                        <select class="form-control" id="Location" name="Location">
                            <?php
                            echo "<option>---------------Select---------------</option>";
                            while ($row = $result->fetch_assoc()) {
                                $selected = ($row['LocationId'] == $Locid) ? 'selected' : '';
                                echo "<option value='" . $row['LocationId'] . "' $selected>" . $row['LocationName'] . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <button type="submit" class="btn btn-success mt-4" name="export_pdf">Export PDF</button>
                </div>
            </div>
        </form>




    </div>

    <div class="overlay"></div>
    <script>
        const sidebarToggle = document.querySelector('.js-menu-toggle');
        const overlay = document.querySelector('.overlay');

        sidebarToggle.addEventListener('click', function () {
            document.body.classList.toggle('sidebar-open');
        });
    </script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="js/jquery.sticky.js"></script>
    <script src="js/main.js"></script>
    <script src="sidebar/js/jquery-3.3.1.min.js"></script>
    <script src="sidebar/js/popper.min.js"></script>
    <script src="sidebar/js/bootstrap.min.js"></script>
    <script src="sidebar/js/main.js"></script>
</body>

</html>
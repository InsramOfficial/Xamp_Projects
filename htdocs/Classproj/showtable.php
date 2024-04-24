<?php
 include 'connect.php'; 
 $sql = "SELECT * FROM employee";
 $result = $connect->query($sql);?>
<!Doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12 mt-3 text-center">
                <h2>Show employee table</h2>
            </div>
        </div>
    </div>
   <div class="row">
   <div class="col-md-2"></div>
   <div class="col-md-8  pt-5 ">
   <table class="table table-hover table-brodered">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Employee Name</th>
                <th scope="col">Job</th>
                <th scope="col">Commission</th>
            </tr>
        </thead>
        <tbody>
            <?php
           
            if ($result->num_rows > 0) {
                $rowNumber = 1;
                while($row = $result->fetch_assoc()) {
                    echo '<tr>'; 
                    echo '<th scope="row">' . $rowNumber . '</th>';
                    echo '<td>' . $row["Empname"] . '</td>'; 
                    echo '<td>' . $row["Job"] . '</td>'; 
                    echo '<td>' . $row["Comm"] . '</td>';
                    echo '</tr>'; 
                    $rowNumber++;
                }
            } else {
                echo "<tr><td colspan='4'>0 results</td></tr>"; 
            }


            $connect->close(); 
            ?>
        </tbody>
    </table>
   </div>
   <div class="col-md-2"></div>
   </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>
</html>

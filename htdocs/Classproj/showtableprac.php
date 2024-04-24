<?php
include 'connect.php';
$sql="SELECT * FROM EMPLOYEE";
$result=$connect->query($sql);
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  </head>
  <body>
    <table class="table table-hover">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">First</th>
          <th scope="col">Last</th>
          <th scope="col">Handle</th>
        </tr>
      </thead>
      <tbody>
       <?php

       if($result->num_rows>0)
       {
        $numberrow=1;
        while($row=$result->fetch_assoc())
        {
            echo'<tr>';
            echo'<th scope="row">'.$numberrow.'</th>';
            echo'<td>'.$row["Empname"].'</td>';
            echo'<td>'.$row["Job"].'</td>';
            echo '<td>' . $row["Comm"] . '</td>';
            echo '</tr>'; 
            $numberrow++;
        }
       }
       else{
        echo '<h2>No records found</h2>';
       }
        
       ?>
        
      </tbody>
    </table>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
  </body>
</html>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Table Page</title>
    <link rel="stylesheet" href="styles.css"> <!-- Link to an external CSS file for styling -->
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        
        table, th, td {
            border: 1px solid #333;
        }
        
        th, td {
            padding: 10px;
            text-align: center;
        }
        
        th {
            background-color: #333;
            color: white;
            font-weight: bold; /* Added font-weight for headers */
        }
        
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        
        tr:hover {
            background-color: #ddd;
        }
    </style>
</head>
<body>
    <header>
        <h1 style="text-align: center;">Delicios_catering Orders</h1>
    </header>
    <table>
        <tr>
            <th>Name</th>
            <th>Food Name</th>
            <th>Phone Number</th> <!-- Corrected capitalization for consistency -->
            <th>Address</th>
        </tr>
        <?php
        include 'db.php';
        $query = "select * from order_us";
        $result = mysqli_query($con, $query);
        while ($row = mysqli_fetch_assoc($result)) {
        ?>
        <tr>
            <td><?php echo $row['Name']; ?></td>
            <td><?php echo $row['Food_Name']; ?></td>
            <td><?php echo $row['Phone_number']; ?></td>
            <td><?php echo $row['Address']; ?></td>
        </tr>
        <?php
        }
        ?>
    </table>
</body>
</html>

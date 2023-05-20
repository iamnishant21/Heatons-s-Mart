<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trader list</title>
    <link rel="stylesheet" href="shop_list.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

</head>

<body>
    <?php
    include('adminheader.php');
     ?>
    <div class="container">

        <div class="header">
            <h3>SHOP List</h3>
        </div>

        <table cellpadding='15' cellspacing='2'>
            <tr>
                <th>SHOP ID</th>
                <th>SHOP NAME</th>
                <th>SHOP ADDRESS</th>
                <th>PHONEN_NUMBER</th>
                <th>SHOP CATEGORY</th>
                <th>STATUS</th>
                <th>Action</th>
            </tr>

            <?php
            // Connect to Oracle database
            include("../connection.php");

            // Query to fetch product data
            $query = 'SELECT * FROM "SHOP"';

            // Execute the query
            $stmt = oci_parse($conn, $query);
            oci_execute($stmt);

            // Loop through the results and display data in table rows
            $status='';
            while ($row = oci_fetch_array($stmt, OCI_ASSOC)) {
                echo "<tr>";
                echo "<td>" . $row['SHOP_ID'] . "</td>";
                echo "<td>" . $row['SHOP_NAME'] . "</td>";
                echo "<td>" . $row['SHOP_ADDRESS'] . "</td>";
                echo "<td>" . $row['SHOP_PHONENUMBER'] . "</td>";
                echo "<td>" . $row['SHOP_CATEGORY'] . "</td>";

                if(!empty($row['SHOP_STATUS'])){
                    $status = $row['SHOP_STATUS'];
                }
                else{
                    $status ='';
                }
                echo "<td>".$status ."</td>";

                if($status == 'waiting'){
                    echo "<td>
                <a href='shop_accept.php?id=".$row['SHOP_ID']."&action=verified'>Accept <span class='material-symbols-outlined'>
                    pen_size_4
                    </span></a> 
                    <a href='shop_remove.php?id=".$row['SHOP_ID']."&action=decline'>Remove <span class='material-symbols-outlined'>
                    delete
                    </span></a>
                </td>";
                    
                }else{
                    echo "<td>
                    <a href='shop_accept.php?id=".$row['SHOP_ID']."&action=waiting'>deactivate</a>
                </td>";
                }
                echo "</tr>"; 
            }
            ?>
        </table>

    </div>

</body>

</html>
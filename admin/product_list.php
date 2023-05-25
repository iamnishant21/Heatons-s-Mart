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
            <h3>PRODUCT List</h3>
        </div>

        <table cellpadding='15' cellspacing='2'>
            <tr>
                <th>PRODUCT ID</th>
                <th>PRODUCT NAME</th>
                <th>PRODUCT CATEGORY</th>
                <th>PRODUCT PRICE</th>
                <th>PRODUCT QUANTITY</th>
                <th>STATUS</th>
                <th>Action</th>
            </tr>

            <?php
            // Connect to Oracle database
            include("../connection.php");

            // Query to fetch product data
            $query = 'SELECT * FROM "PRODUCT"';

            // Execute the query
            $stmt = oci_parse($conn, $query);
            oci_execute($stmt);

            // Loop through the results and display data in table rows
            $status='';
            while ($row = oci_fetch_array($stmt, OCI_ASSOC)) {
                echo "<tr>";
                echo "<td>" . $row['PRODUCT_ID'] . "</td>";
                echo "<td>" . $row['PRODUCT_NAME'] . "</td>";
                echo "<td>" . $row['PRODUCT_CATEGORY'] . "</td>";
                echo "<td>" . $row['PRODUCT_PRICE'] . "</td>";
                echo "<td>" . $row['PRODUCT_QUANTITY'] . "</td>";

                if(!empty($row['PRODUCT_STATUS'])){
                    $status = $row['PRODUCT_STATUS'];
                }
                else{
                    $status ='';
                }
                echo "<td>".$status ."</td>";

                if($status == 'waiting'){
                    echo "<td>
                <a href='P_accept.php?id=".$row['PRODUCT_ID']."&action=verified'>Accept <span class='material-symbols-outlined'>
                    pen_size_4
                    </span></a> 
                    <a href='P_remove.php?id=".$row['PRODUCT_ID']."&action=decline'>Remove <span class='material-symbols-outlined'>
                    delete
                    </span></a>
                </td>";
                    
                }else{
                    echo "<td>
                    <a href='P_accept.php?id=".$row['PRODUCT_ID']."&action=waiting'>deactivate</a>
                </td>";
                }
                echo "</tr>"; 
            }
            ?>
        </table>

    </div>

</body>

</html>
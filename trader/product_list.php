<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>product list</title>
    <link rel="stylesheet" href="product_list.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

</head>

<body>
    <?php
    include('traderheader.php');
     ?>
    <div class="container">

        <div class="header">
            <h3>Product List</h3>
            <a href="addproduct.php">Add Products <span class="material-symbols-outlined">
                add
                </span></a>
        </div>

        <table cellpadding='15' cellspacing='2'>
            <tr>
                <th>Product ID</th>
                <th>Product Name</th>
                <th>PRODUCT CATEGORY</th>
                <th>Price</th>
                <th>PRODUCT QUANTITY</th>
                <th>Action</th>
            </tr>

            <?php
            // Connect to Oracle database
            include("../connection.php");

            // Query to fetch product data
            $verify = 'verified';
            $query = 'SELECT * FROM "PRODUCT" WHERE PRODUCT_CATEGORY =:P_CATEGORY AND PRODUCT_STATUS= :verify ';

            // Execute the query
            $stmt = oci_parse($conn, $query);
            oci_bind_by_name($stmt, ':P_CATEGORY', $_SESSION['category']);
            oci_bind_by_name($stmt, ':verify', $verify);
            oci_execute($stmt);

            // Loop through the results and display data in table rows
            while ($row = oci_fetch_array($stmt, OCI_ASSOC)) {
                echo "<tr>";
                echo "<td>" . $row['PRODUCT_ID'] . "</td>";
                echo "<td>" . $row['PRODUCT_NAME'] . "</td>";
                echo "<td>" . $row['PRODUCT_CATEGORY'] . "</td>";
                echo "<td>" . $row['PRODUCT_PRICE'] . "</td>";
                echo "<td>" . $row['PRODUCT_QUANTITY'] . "</td>";
                echo "<td><a href='editProduct.php?product_id=".$row['PRODUCT_ID']."&action=edit'>Edit <span class='material-symbols-outlined'>
                    pen_size_4
                    </span></a> <a href='deleteProduct.php?id=".$row['PRODUCT_ID']."&action=delete'>Delete <span class='material-symbols-outlined'>
                    delete
                    </span></a>
                </td>";
                echo "</tr>";
            }

            // Close the Oracle connection
            // oci_free_statement($stmt);
            // oci_close($conn);
            ?>
        </table>

    </div>

</body>

</html>
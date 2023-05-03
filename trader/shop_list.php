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
            <h3>Shop List</h3>
            <a href="addshop.php">Add Shop <span class="material-symbols-outlined">
                add
                </span></a>
        </div>

        <table cellpadding='15' cellspacing='2'>
            <tr>
                <th>SHOP ID</th>
                <th>SHOP Name</th>
                <th>SHOP ADDRESS</th>
                <th>SHOP PHONENUMBER</th>
                <th>SHOP CATEGORY</th>
                <th>Action</th>
            </tr>

            <?php
            // Connect to Oracle database
            include("../connection.php");

            // Query to fetch product data
            $query = 'SELECT * FROM "SHOP" ';

            // Execute the query
            $stmt = oci_parse($conn, $query);
            oci_execute($stmt);

            // Loop through the results and display data in table rows
            while ($row = oci_fetch_array($stmt, OCI_ASSOC)) {
                echo "<tr>";
                echo "<td>" . $row['SHOP_ID'] . "</td>";
                echo "<td>" . $row['SHOP_NAME'] . "</td>";
                echo "<td>" . $row['SHOP_ADDRESS'] . "</td>";
                echo "<td>" . $row['SHOP_PHONENUMBER'] . "</td>";
                echo "<td>" . $row['SHOP_CATEGORY'] . "</td>";
                echo "<td>
                <a href='editShop.php?shop_id=".$row['SHOP_ID']."&action=edit'>Edit <span class='material-symbols-outlined'>
                    pen_size_4
                    </span></a> 
                    <a href='deleteShop.php?id=".$row['SHOP_ID']."&action=delete'>Delete <span class='material-symbols-outlined'>
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
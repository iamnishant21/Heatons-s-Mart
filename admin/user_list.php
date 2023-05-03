<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>product list</title>
    <link rel="stylesheet" href="ul.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

</head>

<body>
    <div class="container">

        <div class="header">
            <h3>USER LIST List</h3>
        </div>
        <div class="table">
            
        </div>

        <table cellpadding='15' cellspacing='2'>
            <tr>
                <th>USER_ID</th>
                <th>FIRSTNAME</th>
                <th>LASTNAME</th>
                <th>ROLE</th>
                <th>EMAIL_ADDRESS</th>
                <th>GENDER</th>
                <th>ACTION</th>

            </tr>
            <?php
            // Connect to Oracle database
            include("../connection/connection.php");

            // Query to fetch product data
            $query = 'SELECT * FROM "USER" ';

            // Execute the query
            $stmt = oci_parse($conn, $query);
            oci_execute($stmt);

            // Loop through the results and display data in table rows
            while ($row = oci_fetch_array($stmt, OCI_ASSOC)) {
                echo "<tr>";
                echo "<td>" . $row['USER_ID'] . "</td>";
                echo "<td>" . $row['FIRSTNAME'] . "</td>";
                echo "<td>" . $row['LASTNAME'] . "</td>";
                echo "<td>" . $row['ROLE'] . "</td>";
                echo "<td>" . $row['EMAIL_ADDRESS'] . "</td>";
                echo "<td>" . $row['GENDER'] . "</td>";
                echo "<td><a href='editUser.php?user_id=".$row['USER_ID']."&action=edit'>Edit <span class='material-symbols-outlined'>
                    pen_size_4
                    </span></a> <a href='deleteUser.php?id=".$row['USER_ID']."&action=delete'>Delete <span class='material-symbols-outlined'>
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
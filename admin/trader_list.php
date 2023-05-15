<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trader list</title>
    <link rel="stylesheet" href="trader_list.css">
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
            <h3>Trader List</h3>
        </div>

        <table cellpadding='15' cellspacing='2'>
            <tr>
                <th>TRADER ID</th>
                <th>TRADER NAME</th>
                <th>GENDER</th>
                <th>EMAIL ADDRESS</th>
                <th>CATEGORY</th>
                <th>STATUS</th>
                <th>Action</th>
            </tr>

            <?php
            // Connect to Oracle database
            include("../connection.php");

            // Query to fetch product data
            $role="trader";
            $query = 'SELECT * FROM "USER" WHERE ROLE = :TROLE';

            // Execute the query
            $stmt = oci_parse($conn, $query);
            oci_bind_by_name($stmt, ":TROLE",$role);
            oci_execute($stmt);

            // Loop through the results and display data in table rows
            $status='';
            while ($row = oci_fetch_array($stmt, OCI_ASSOC)) {
                echo "<tr>";
                echo "<td>" . $row['USER_ID'] . "</td>";
                echo "<td>" . $row['FIRSTNAME'] . "</td>";
                echo "<td>" . $row['GENDER'] . "</td>";
                echo "<td>" . $row['EMAIL_ADDRESS'] . "</td>";
                echo "<td>" . $row['CATEGORY'] . "</td>";

                if(!empty($row['STATUS'])){
                    $status = $row['STATUS'];
                }
                else{
                    $status ='';
                }
                echo "<td>".$status ."</td>";

                if($status == 'waiting'){
                    echo "<td>
                <a href='accept.php?id=".$row['USER_ID']."&action=verified'>Accept <span class='material-symbols-outlined'>
                    pen_size_4
                    </span></a> 
                    <a href='remove.php?id=".$row['USER_ID']."&action=decline'>Remove <span class='material-symbols-outlined'>
                    delete
                    </span></a>
                </td>";
                    
                }else{
                    echo "<td>
                    <a href='remove.php?id=".$row['USER_ID']."&action=decline'>Remove <span class='material-symbols-outlined'>
                    delete
                    </span></a>
                </td>";
                }
                echo "</tr>"; 
            }
            ?>
        </table>

    </div>

</body>

</html>
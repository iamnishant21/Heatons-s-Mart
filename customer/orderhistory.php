
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="orderhistory.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css">
</head>
<body>

    <?php
        session_start();
        include("../connection.php");

     ?>
    
      <!-- banner -->
    <div id="page-header" class="cart-header">
        <h2>ORDER HISTORY</h2>
    </div>
    <div class="container mt-5">
        <div class="d-flex justify-content-center row">
            <div class="col-md-10">
                <div class="rounded">
                    <div class="table-responsive table-borderless">
                        <table class="table">
                            <thead>
                                <tr>
                                <th>Id</th>
                                <th>Date</th>
                                <th>Collection Slot</th>
                                <th>Total Items</th>
                                <th>Total Amount</th>
                                <th>Payment By</th>
                                <!-- <th>Action</th> -->
                                    
                                </tr>
                            </thead>

                            <tbody class="table-body">

                            <?php
                                  $query = 'SELECT cs.*, o.*,c.*,u.*
                                  FROM "COLLECTION_SLOT" cs
                                  JOIN "ORDER" o ON cs.SLOT_ID = o.SLOT_ID
                                  JOIN "CART" c ON o.CART_ID = c.CART_ID
                                  JOIN "USER" u ON u.USER_ID = c.USER_ID
                                  WHERE u.USER_ID = :user_id';
                          
                                  $statement = oci_parse($conn, $query);
                                  oci_bind_by_name($statement, ":user_id", $_SESSION['user_ID']);
                                  oci_execute($statement);

                                  // Fetch the result
                                  while ($row = oci_fetch_array($statement, OCI_ASSOC)) {

                                    $order_id = $row['ORDER_ID'];
                                    $order_date = $row['ORDER_DATE'];
                                    $slot_time = $row['COLLECTION_TIME'];
                                    $slot_day = $row['COLLECTION_DATE'];
                                    $item = $row['NO_OF_ORDER'];
                                    $amount = $row['TOTAL_AMOUNT'];
                                    $userf = $row['FIRSTNAME'];
                                    $userl = $row['LASTNAME'];



                                    

                                    echo"
                                    <tr class='cell-1'>
                                     <td> $order_id</td>
                                     <td> $order_date</td>
                                     <td>" . $slot_time. " (" .$slot_day. ") </td>
                                     <td> $item</td>
                                     <td> $amount</td>
                                     <td>" . $userf. " " .$userl." </td>
                                    </tr>";

                                 }
  
                                  ?>
                            
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</div>  
</body>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</html>
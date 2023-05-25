
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
        include('adminheader.php');
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
                                    <th>Product Image</th>
                                    <th>Order Id</th>
                                    <th>Product name</th>
                                    <th>Product Quantity</th>
                                    <th>Total Amount</th>
                                    <th>Order Date</th>
                                    <th>Trader Name</th>
                                    
                                </tr>
                            </thead>

                            <tbody class="table-body">

                            <?php
                            $query = 'SELECT * FROM "USER" ';

                            // Execute the query
                            $stmt = oci_parse($conn, $query);
                            oci_execute($stmt);
                
                            // Loop through the results and display data in table rows
                            while ($row = oci_fetch_array($stmt, OCI_ASSOC)) {
                    
                                $user = $row['USER_ID'];



                                  $query = 'SELECT o.*,op.*,p.*,u.*
                                  FROM "ORDER" o
                                  JOIN "ORDER_PRODUCT" op ON o.ORDER_ID = op.ORDER_ID
                                  JOIN "PRODUCT" p ON op.PRODUCT_ID = p.PRODUCT_ID
                                  JOIN "SHOP" s ON p.SHOP_ID = s.SHOP_ID
                                  JOIN "USER" u ON s.USER_ID = u.USER_ID
                                  WHERE u.USER_ID = :user_id';
                                  $statement = oci_parse($conn, $query);
                                  oci_bind_by_name($statement, ":user_id", $user);
                                  oci_execute($statement);

                                  // Fetch the result
                                  while ($row = oci_fetch_array($statement, OCI_ASSOC)) {
                                      $product_image  = $row['PRODUCT_IMAGE'];
                                      $order_id  = $row['ORDER_ID'];
                                      $product_name  = $row['PRODUCT_NAME'];
                                      $product_qty  = $row['PRODUCT_QUANTITY'];
                                      $total_amount  = $row['TOTAL_AMOUNT'];
                                      $order_date  = $row['ORDER_DATE'];
                                      $fname  = $row['FIRSTNAME'];
                                      $lname  = $row['LASTNAME'];


                                      $order_by  = $fname." ".$lname;

                                      echo"
                                     <tr class='cell-1'>
                                      <td><img src='../trader/uploads/$product_image' alt='' width='50px' height='50px'> </td>
                                      <td> $order_id</td>
                                      <td> $product_name</td>
                                      <td> $product_qty</td>
                                      <td>$$total_amount</td>
                                      <td>$order_date</td>
                                      <td>$order_by</td>
                                     </tr>";



                                  }
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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Traderdashboard</title>
<style>
    .container-dash{
        display: flex;
        justify-content: center;
        background-color: var(--purple);
        margin-block: 7%;
        margin-inline: 15%;
        border-radius: 10px;
        gap: 2rem;
    }
</style>
</head>
<body>
    <?php
    session_start();
        include('traderheader.php');
        include("../connection.php");

     ?>
    <div class="container-dash">
        <div class="card d-flex justify-content-evenly gap-3 border border-0 " style="width: 18rem;">
            
            <div class="card-body border border-primary rounded">
              <h5 class="card-title">Report</h5>
              <!-- <p class="card-text">5</p> -->
              <a href="#" class="btn btn-primary">Go somewhere</a>
            </div>


            <div class="card-body border border-primary rounded">
                <h5 class="card-title">Total Shop</h5>
                <p class="card-text">
                <?php

                            $sql = 'SELECT COUNT(*) AS NUMBER_OF_ROWS FROM "SHOP" WHERE SHOP_CATEGORY = :s_type ';
                            $stid = oci_parse($conn,$sql);
                            oci_bind_by_name($stid , ':s_type', $_SESSION['category']);

                            oci_define_by_name($stid , 'NUMBER_OF_ROWS', $totalshop);
                            
                            oci_execute($stid);
                            oci_fetch($stid); 

                            echo $totalshop;
                        ?>
                </p>
            </div>
            
        </div>
        <div class="card d-flex justify-content-evenly gap-3 border border-0" style="width: 18rem;">
            
            <div class="card-body border border-primary rounded">
              <h5 class="card-title">Total Product</h5>
              <p class="card-text">
              <?php
                            $sql = 'SELECT COUNT(*) AS NUMBER_OF_ROWS FROM "PRODUCT" WHERE PRODUCT_CATEGORY = :p_type ';
                            $stid = oci_parse($conn,$sql);
                            oci_bind_by_name($stid , ':p_type', $_SESSION['category']);

                            oci_define_by_name($stid , 'NUMBER_OF_ROWS', $totalproduct);
                            
                            oci_execute($stid);
                            oci_fetch($stid); 

                            echo $totalproduct;
                        ?>
              </p>
            </div>

            <div class="card-body border border-primary rounded">
              <h5 class="card-title">Total Amount</h5>
              <p class="card-text">
              <?php
                           $total_amount = 0;

                           $sql= 'SELECT op.*,pr.*,r.*
                           FROM "REPORT" r
                           JOIN "ORDER_PRODUCT" op ON r.ORDER_ID = op.ORDER_ID
                           JOIN "PRODUCT" pr ON op.PRODUCT_ID = pr.PRODUCT_ID
                           JOIN "SHOP" s ON pr.SHOP_ID = s.SHOP_ID
                           JOIN "USER" u ON s.USER_ID = u.USER_ID
                           WHERE u.USER_ID = :user_id';
       
                           $stmt= oci_parse($conn, $sql);
                           oci_bind_by_name($stmt, ":user_id", $_SESSION['trader_ID']);
                           oci_execute($stmt);
       
                           while ($row = oci_fetch_array($stmt)) {
                               $product_price = (float)$row['PRODUCT_PRICE'] * $row['ORDER_QUANTITY'];
                               $total_amount += $product_price;
                           }
       
                           echo "<h3>&pound; " . number_format($total_amount, 2) . "</h3>";
                           ?>     
              </p>
            </div>

            
        </div>
    </div>
      
</body>
</html>
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
        include('adminheader.php');
        include("../connection.php"); 

     ?>
    <div class="container-dash">
    <div class="card d-flex justify-content-evenly gap-3 border border-0 " style="width: 18rem;">
            
    <div class="card-body border border-primary rounded">
                <h5 class="card-title">Total Trader</h5>
                <p class="card-text">
                <?php
                            $role="trader";
                            $sql = 'SELECT COUNT(*) AS NUMBER_OF_ROWS FROM "USER" WHERE ROLE = :TROLE ';
                            $stid = oci_parse($conn,$sql);
                            oci_bind_by_name($stid, ":TROLE",$role);
                            oci_define_by_name($stid , 'NUMBER_OF_ROWS', $totaltrader);
                            
                            oci_execute($stid);
                            oci_fetch($stid); 

                            echo "Number of trader : ".$totaltrader;
                        ?>
                </p>
            </div>


            <div class="card-body border border-primary rounded">
                <h5 class="card-title">Total Shop</h5>
                <p class="card-text">
                <?php

                            $sql = 'SELECT COUNT(*) AS NUMBER_OF_ROWS FROM "SHOP"';
                            $stid = oci_parse($conn,$sql);
                            oci_define_by_name($stid , 'NUMBER_OF_ROWS', $totalshop);
                            
                            oci_execute($stid);
                            oci_fetch($stid); 

                            echo"Number of shop : ".$totalshop;
                        ?>
                </p>
            </div>

            <div class="card-body border border-primary rounded">
              <h5 class="card-title">Total Product</h5>
              <p class="card-text">
              <?php
                            $sql = 'SELECT COUNT(*) AS NUMBER_OF_ROWS FROM "PRODUCT"';
                            $stid = oci_parse($conn,$sql);
                            oci_define_by_name($stid , 'NUMBER_OF_ROWS', $totalproduct);
                            
                            oci_execute($stid);
                            oci_fetch($stid); 

                            echo"Number of product : ".$totalproduct;
                        ?>
              </p>
            </div>
            
            
        </div>
        <div class="card d-flex justify-content-evenly gap-3 border border-0" style="width: 18rem;">
            
            <div class="card-body border border-primary rounded">
              <h5 class="card-title">Total Amount</h5>
              <p class="card-text">
              <?php
                          $sql = 'SELECT SUM(PAYMENT_AMOUNT) AS TOTAL_AMOUNT FROM PAYMENT';
                          $stid = oci_parse($conn, $sql);
                          oci_define_by_name($stid, 'TOTAL_AMOUNT', $totalAmount);
                          oci_execute($stid);
                          oci_fetch($stid);
                          echo "Total amount = &pound; ".$totalAmount; 
                        
                ?>
              </p>
            </div>

            <div class="card-body border border-primary rounded">
              <h5 class="card-title">ORDER HISTORY</h5>
              <p class="card-text">
              <?php
                    
                    
                ?>
              </p>
              <a href="orderhistory.php" class="btn btn-primary">click for order history</a>
            </div>

            <div class="card-body border border-primary rounded">
                <h5 class="card-title">Report</h5>
                <p class="card-text">report</p>
                <a href="#" class="btn btn-primary">Go to report</a>
            </div>
            
        </div>
 
    </div>
      
</body>
</html>
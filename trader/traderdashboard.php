
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
              <h5 class="card-title">Total TRADER</h5>
              <p class="card-text">5</p>
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
                <a href="#" class="btn btn-primary">Go somewhere</a>
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
              <a href="#" class="btn btn-primary">Go somewhere</a>
            </div>

            <div class="card-body border border-primary rounded">
                <h5 class="card-title">Report</h5>
                <p class="card-text">report</p>
                <a href="#" class="btn btn-primary">Go somewhere</a>
            </div>

            
        </div>
    </div>
      
</body>
</html>
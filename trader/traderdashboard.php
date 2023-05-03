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
        include('traderheader.php');
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
                <p class="card-text">10</p>
                <a href="#" class="btn btn-primary">Go somewhere</a>
            </div>
            
        </div>
        <div class="card d-flex justify-content-evenly gap-3 border border-0" style="width: 18rem;">
            <div class="card-body border border-primary rounded">
              <h5 class="card-title">Total Product</h5>
              <p class="card-text">5</p>
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
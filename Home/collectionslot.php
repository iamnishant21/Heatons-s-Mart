<?php
  session_start();
  include('../connection.php');
  unset($_SESSION['slot_id']);

    if(isset($_POST['payment'])){
      $slot_id = $_POST['slot_id'];
      $_SESSION['slot_id'] = $slot_id;

      $sql = 'INSERT INTO "ORDER" (TOTAL_AMOUNT,SLOT_ID,CART_ID) VALUES(:total_amount, :slot_id,:cart_id)';
      $stid = oci_parse($conn , $sql);
      oci_bind_by_name($stid , ":total_amount" ,$_SESSION['total']);
      oci_bind_by_name($stid , ":slot_id" , $_SESSION['slot_id']);
      oci_bind_by_name($stid, ":cart_id" , $_SESSION['cart_id']);
      oci_execute($stid);

      header('location:invoice.php');
    }
  
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Responsive Hamburger Navigation Bar with Bootstrap</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css">
  <link rel="stylesheet" href="collectionslot.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/css/bootstrap.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/2.3.2/css/bootstrap-responsive.css">
</head>
<body>
    <!-- nav bar -->
  <nav class="navbar navbar-expand-lg navbar-light ">
    <div class="container">
      <a class="navbar-brand" href="homepage.php"><img src="Heaton's Mart.png"></a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" href="homepage.php">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="contact_us.php">Contact Us</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="product.php">Products</a>
          </li>
        </ul>
        <div class="main">
          <a href="login.html" class="user"><i class="fas fa-user"></i></a>
          <a href="cart.html" ><i class="fas fa-shopping-cart"></i></a>
          <a href="wishlist.html"> <i class="fas fa-heart"></i></a>
        </div>
      </div>
    </div>
  </nav>
  <!-- banner -->
  <div id="page-header" class="cart-header">
    <h2>COLLECTION SLOT</h2>
  </div>
  <!-- collectionslot -->
  <form action="" method='post' >

  <div class="container-fluid px-0 px-sm-4 mx-auto">
    <div class="row justify-content-center mx-0">
      <div class="col-lg-10">
        <div class="card border-0">
          <!-- <form autocomplete="off"> -->
            <div class="card-header bg-dark">
              <div class="mx-0 mb-0 row justify-content-sm-center justify-content-start px-1">
                <!-- <input type="text" id="dp1" class="datepicker" placeholder="Pick Date" name="date" readonly><span class="fa fa-calendar"></span> -->
              </div>
            </div>
              <div class="row text-center mx-0">

                <?php
                  $sql = "SELECT * FROM  COLLECTION_SLOT";
                  $stmt = oci_parse($conn, $sql);
                  oci_execute($stmt);
                  while($row = oci_fetch_array($stmt)){
                    $id = $row['SLOT_ID'];
                    echo "<div class='col-md-5 col-4 my-3 px-4'><input type='radio' name='slot_id' value='$id' > " . $row['COLLECTION_TIME'] .", ".$row['COLLECTION_DATE']."</div>";
                    // echo "<div class='col-md-5 col-4 my-3 px-4'><div class='cell py-1' >".."</div></div>";
                  }

                ?>
                
              </div>
            </div>
          <!-- </form> -->
        </div>
      </div>
    </div>
  </div>
  <!-- proceed to pay -->
  <div class="col-md-12 my-3 px-5 text-center">
    <button type="submit" name='payment' class="btn btn-dark" > PROCCED TO GET INVOICE</button>
  </div>

  </form>

  
  <!-- footer -->
  <div class="about">
    <div class="aboutus">
        <h3>ABOUT US</h3>
        <p>At HeatonsMart, we are your ultimate destination for all your grocery needs. We bring together 
          a delightful selection of bakery products, fresh meats from our butcher shop, a wide variety of fish, 
          and an extensive range of grocery items. With HeatonsMart, you can conveniently shop for all your kitchen essentials
           in one place.  Join us at HeatonsMart and experience the convenience, quality, and variety that we have to offer. Start 
           your grocery shopping journey with us today!
    </div>
</div>
<div class="footer">
    <div class="box1">
        <a href="homepage.php">Home</a>
        <a href="product.php">Product</a>            
        <a href="contact_us.php">Contact</a>
    </div>
    <div class="box2">
        <h3>CONTACT</h3>
        <p>32,Thapathali <br>Thapathali,Kathmandu</p>
        <div class="social-icons">
            <i class="fa-brands fa-square-instagram"></i>
            <i class="fa-brands fa-youtube"></i>
            <i class="fa-brands fa-github"></i>
        </div>
    </div>
</div>  
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/js/bootstrap.js"></script>
  <script>
    $(document).ready(function(){
      var slot_id = 0;

      $('.datepicker').datepicker({
      format: 'dd-mm-yyyy',
      autoclose: true,
      startDate: '0d'
    });
   
  
    $('.cell').click(function() {
      $('.cell').removeClass('select');
      $(this).addClass('select');
    });
   

  });

  </script>
</body>
</html>

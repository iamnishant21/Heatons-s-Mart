<?php
session_start();
include('../connection.php');

if(isset($_GET['action'])){
  $product_id = $_GET['id'];

  if($_GET['action'] == 'remove'){
    $sql = 'DELETE FROM CART_PRODUCT WHERE PRODUCT_ID = :product_id';
    $stmt = oci_parse($conn, $sql);
    oci_bind_by_name($stmt,":product_id" , $product_id);
    oci_execute($stmt);
  }
}

if(isset($_GET['remove']) && isset($_GET['id'])){
  
    foreach ($_SESSION['cart'] as $key => $value) {
        if ($value['product_id'] === $_GET['id']) { // receiving data from remove button
            unset($_SESSION['cart'][$key]);
            $_SESSION['cart'] = array_values($_SESSION['cart']);
            // header('location:viewcart.php');
            // echo "Successfully Remove from Cart";
        }
    }

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
  <link rel="stylesheet" href="cart.css">
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
            <a class="nav-link" href="contact_us.html">Contact Us</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="product.php">Products</a>
          </li>
        </ul>
        <div class="main">
             <li class="nav-item dropdown">
                <button class="btn btn-dark dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fas fa-user"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-dark">
                  <?php
                    if(isset($_SESSION['user_ID'])){
                      echo "<li><a class='dropdown-item' href='../customer/customerprofile.php'>View Profile</a></li>";
                      echo "<li><a class='dropdown-item' href='../logout.php'>Logout</a></li>";
                    }
                    else{
                      echo "<li><a class='dropdown-item' href='../login.php'>Login</a></li>";
                    }
                  ?>
                </ul>
              </li>
              
          <a href="cart.php" ><i class="fas fa-shopping-cart"></i></a>

          <?php
          if(isset($_SESSION['user_ID'])){

          echo"<a href='wishlist.php'> <i class='fas fa-heart'></i></a>";
          } else{
           echo" <a href='../login.php'> <i class='fas fa-heart'></i></a>";

          }
          ?>
        </div>
      </div>
    </div>
  </nav>
  <!-- banner -->
  <div id="page-header" class="cart-header">
    <h2>myCART</h2>
  </div>
<div id="cart" class="section-p1">
  <table width="100%">
    <thead>
      <tr>
        <td>Remove</td>
      <td>Image</td>
      <td>Product</td>
      <td>Price</td>
      <td>Quantity</td>
      <td>Subtotal</td>
      </tr>
    </thead>
    <tbody>
      <?php
        // without login

        if (isset($_SESSION['cart'])) {
          $totalprice = 0;
          $productprice = 0;

          foreach ($_SESSION['cart'] as $key => $value) {
            $quantity = $value['product_quantity'];
            $product_id =  (int)$value['product_id'];
            $sql = "SELECT * FROM PRODUCT WHERE PRODUCT_ID = :id";
            $stid = oci_parse($conn, $sql);
            oci_bind_by_name($stid, ":id",$product_id);
            oci_execute($stid);
  
            while ($row = oci_fetch_array($stid, OCI_ASSOC)) {
              $productname = $row['PRODUCT_NAME'];
              $product_image = $row['PRODUCT_IMAGE'];
              $product_price = $row['PRODUCT_PRICE'];

              if (!empty($row['DISCOUNT_ID'])) 
           {
               $sql = 'SELECT DISCOUNT_PERCENT FROM "DISCOUNT" WHERE DISCOUNT_ID = :disc_id';
               $stmt = oci_parse($conn, $sql);
               oci_bind_by_name($stmt, ":disc_id", $row['DISCOUNT_ID']);
               oci_execute($stmt);
               while ($row = oci_fetch_array($stmt, OCI_ASSOC)) {
                $discount = (int)$row['DISCOUNT_PERCENT'];
                $discount_price = $product_price - $product_price * ($discount / 100);
                $productprice =  $quantity * $discount_price;
                $totalprice += $quantity * $discount_price;
              }
            } else {
              $discount_price = $product_price;
              $productprice =  $quantity * $discount_price;
              $totalprice += $quantity * $discount_price;
            }
             

              echo "
                <tr>
                  <td><a href='cart.php?remove=remove&id=$product_id'><i class='fa fa-trash'></i></a></td>";
                echo "<td><'img src='../trader/uploads/$product_image'></td>";
                echo  "<td>$productname</td>
                  <td>&pound; ".$productprice."</td>
                  <td>$quantity</td>
                  <td> &pound;  $totalprice</td>
                </tr> ";

            }
          }
        }

          // with login
        if(isset($_SESSION['user_ID'])){        
          unset($_SESSION['cart_id']);
          $user_id = $_SESSION['user_ID'];
          $totalprice = 0;
          $productprice = 0;
          // Prepare the SQL query
          $query = "
              SELECT CART_PRODUCT.*
              FROM CART
              JOIN CART_PRODUCT ON CART.CART_ID = CART_PRODUCT.CART_ID
              WHERE CART.USER_ID = :user_id";

          $stid = oci_parse($conn, $query);
          oci_bind_by_name($stid , ":user_id" , $user_id);
          oci_execute($stid);
          
          while($data = oci_fetch_array($stid)){

            $cart_id = $data['CART_ID'];
            $_SESSION['cart_id'] = $cart_id;
            
            $product_id = $data['PRODUCT_ID'];
            $quantity = $data['QUANTITY'];
            
            $sql= "SELECT * FROM PRODUCT WHERE PRODUCT_ID = :product_id";
            $stmt = oci_parse($conn, $sql);
            oci_bind_by_name($stmt, ":product_id", $product_id);
            oci_execute($stmt);

            while($row = oci_fetch_array($stmt)){
              $productname = $row['PRODUCT_NAME'];
              $product_image = $row['PRODUCT_IMAGE'];
              $product_price = $row['PRODUCT_PRICE'];

              if (!empty($row['DISCOUNT_ID'])) 
           {
               $sql = 'SELECT DISCOUNT_PERCENT FROM "DISCOUNT" WHERE DISCOUNT_ID = :disc_id';
               $stmt = oci_parse($conn, $sql);
               oci_bind_by_name($stmt, ":disc_id", $row['DISCOUNT_ID']);
               oci_execute($stmt);
               while ($row = oci_fetch_array($stmt, OCI_ASSOC)) {
                $discount = (int)$row['DISCOUNT_PERCENT'];
                $discount_price = $product_price - $product_price * ($discount / 100);
                $productprice =  $quantity * $discount_price;
                $totalprice += $quantity * $discount_price;
              }
            } else {
              $discount_price = $product_price;
              $productprice =  $quantity * $discount_price;
              $totalprice += $quantity * $discount_price;
            }
             
              echo "
                <tr>
                  <td><a href='cart.php?action=remove&id=$product_id'><i class='fa fa-trash'></i></a></td>";
                echo "<td><img src='image/$product_image'></td>";
                echo  "<td>$productname</td>
                  <td>&pound; ".$productprice."</td>
                  <td>$quantity</td>
                  <td> &pound;  $totalprice</td>
                </tr> ";

            }
          }
        }
      ?>
      
    </tbody>
  </table>
</div>

  <div id="subtotal">
    <h3>Cart Totals</h3>
    <table>
      <tr>
        <td>Cart Subtotal</td>
        <td> &pound; <?php echo $totalprice;?></td>
      </tr>
      <tr>
        <td><strong>Total</strong></td>
        <td><strong> &pound; 
          <?php 
                        unset($_SESSION['total']);
                        
                        $_SESSION['total'] = $totalprice; 
                        echo $totalprice;
                        
                        ?>
            </strong>
          </td>
      </tr>
    </table>

    <?php 
      if(isset($_SESSION['user_ID'])){
        echo "<button class='normal' onclick='proceedprocess()' >Procced to select collection slot</button>";
      }
      else{
        echo "<button class='normal' onclick='loginform()'>Procced to select collection slot</button>";
      }
    ?>

<script>
  function loginform(){
    document.location.href ="../login.php";
  }
  
    function proceedprocess(){
      document.location.href = "collectionslot.php";

    }
</script>

  </div>
</div>
  <!-- footer -->
  <div class="about">
    <div class="aboutus">
        <h3>ABOUT US</h3>
        <p>At HeatonsMart, we are your ultimate destination for all your grocery needs. We bring together 
          a delightful selection of bakery products, fresh meats from our butcher shop, a wide variety of fish, 
          and an extensive range of grocery items. With HeatonsMart, you can conveniently shop for all your kitchen essentials
           in one place.  Join us at HeatonsMart and experience the convenience, quality, and variety that we have to offer. Start 
           your grocery shopping journey with us today!
        </p>
        <h3>Promo Code = HM2023, HM1234, HM0246, HM0987</h3>
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


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" 
     integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" 
     crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

</body>
</html>

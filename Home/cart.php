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

unset($_SESSION['discount']);

  $drr = $discountamount='';
  $discount=0;
    if(isset($_POST['applydiscount'])){
      if(empty($_POST['discount'])){
        $drr = "Coupon code is required";
      }
      else{
        $coupon_code = trim($_POST['discount']);
        
        $price = $_POST['price'];

        

        $sql = "SELECT * FROM DISCOUNT WHERE COUPON = :coupon";
        $stmt = oci_parse($conn,$sql);
        oci_bind_by_name($stmt , ":coupon" , $coupon_code);
        oci_execute($stmt);
          while($row = oci_fetch_array($stmt)){
            $discount_id = $row['DISCOUNT_ID'];
            $discount = (int)$row['DISCOUNT_PERCENT'];
          }
  
         $discountamount = $price * ($discount/100);
         $_SESSION['discount'] = number_format($discountamount,1);
        
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
          <!-- <a href="login.php" class="user"><i class="fas fa-user"></i></a> -->
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
          <a href="wishlist.php"> <i class="fas fa-heart"></i></a>
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
        unset($_SESSION['cart_id']);
        $user_id = $_SESSION['user_ID'];
        $total = 0;
        $price = 0;
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
            $price =  $quantity * $row['PRODUCT_PRICE'];
            $total += $quantity * $row['PRODUCT_PRICE'];
            $productname = $row['PRODUCT_NAME'];
            $product_image = $row['PRODUCT_IMAGE'];
            echo "
              <tr>
                <td><a href='cart.php?action=remove&id=$product_id'><i class='fa fa-trash'></i></a></td>";
              echo "<td><img src='image/$product_image'></td>";
              echo  "<td>$productname</td>
                <td>&pound; ".$row['PRODUCT_PRICE']."</td>
                <td>$quantity</td>
                <td> &pound; $price</td>
              </tr> ";
          }
        }
      ?>
      
    </tbody>
  </table>
</div>

<div id="cart-add" class="section-p1">
<div id="discount">
    <h3>Apply Discount</h3>
    <?php echo $drr; ?>
    <div>
      <form action="" method="post">
        <input type="hidden" value='<?php echo $total; ?>' name='price'>
        <input type="text" placeholder="Enter coupon code" name='discount'>
        <button class="normal" name='applydiscount'>Apply</button>
      </form>
    </div>
  </div>

  <div id="subtotal">
    <h3>Cart Totals</h3>
    <table>
      <tr>
        <td>Cart Subtotal</td>
        <td> &pound; <?php echo $total;?></td>
      </tr>
      <tr>
        <td>Discount Amount</td>
        <td> &pound; 
          <?php 
         if(isset($_SESSION['discount'])){
            echo $_SESSION['discount'];
         }
         else{
          echo $discount;
         }
         ?></td>
      </tr>
      <tr>
        <td><strong>Total</strong></td>
        <td><strong> &pound; 
          <?php 
                        unset($_SESSION['total']);
                        if(isset($_SESSION['discount'])){
                          $total_amount = $total -$_SESSION['discount'];
                          $_SESSION['total'] = $total_amount; 
                         echo $total_amount;
                        }
                        else {
                          $_SESSION['total'] = $total; 
                         echo $total;
                        }
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
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla quam velit, vulputate eu pharetra nec, mattis ac neque. 
          Duis vulputate commodo lectus, ac blandit elit tincidunt id. Sed rhoncus, tortor sed eleifend tristique, tortor mauris
          molestie elit, et lacinia ipsum quam nec dui. Quisque nec mauris sit amet elit iaculis pretium sit amet quis magna. 
          Aenean velit odio, elementum in tempus ut, vehicula eu diam.
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
</body>
</html>

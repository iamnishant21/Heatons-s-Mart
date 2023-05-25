<?php
session_start();
include('../connection.php');
    $sql = 'SELECT * FROM "PRODUCT" WHERE PRODUCT_ID= :p_id';
    $stid = oci_parse($conn, $sql);
    oci_bind_by_name($stid, ":p_id", $_GET['p_id']);

    oci_execute($stid);
    while ($row = oci_fetch_array($stid, OCI_ASSOC)) {
        $p_id = $row['PRODUCT_ID'];
        // $p_category = $row['CATEGORY_ID'];
        $p_shop = $row['SHOP_ID'];
        $p_name = $row['PRODUCT_NAME'];
        $p_price = $row['PRODUCT_PRICE'];
        $p_type = $row['PRODUCT_CATEGORY'];
        $p_description = $row['PRODUCT_DESCRIPTION'];
        $p_allergy = $row['ALLERGY_INFORMATION'];
        $p_quantity = $row['PRODUCT_QUANTITY'];
        $p_stock = $row['PRODUCT_STOCK'];
        $p_image = $row['PRODUCT_IMAGE'];
      
        $discount_percent=0;
      if(!empty($row['DISCOUNT_ID']))
        {
            $querry ='SELECT DISCOUNT_PERCENT FROM "DISCOUNT"  WHERE DISCOUNT_ID= :d_id';
            $insert = oci_parse($conn,$querry);
            oci_bind_by_name($insert, ':d_id', $row['DISCOUNT_ID']);
           oci_execute($insert);
            $row = oci_fetch_array($insert, OCI_ASSOC);
               $discount_percent= (int)$row['DISCOUNT_PERCENT'];
        }
      }
      $discount_price=0;
      
      $discount_price= $p_price - $p_price*($discount_percent/100);

    ?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Details Page</title>
    <link rel="stylesheet" href="pdetail.css">
    <link rel="stylesheet" href="nav.css">
    <link rel="stylesheet" href="footer.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" 
    integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg==" 
    crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://kit.fontawesome.com/b2d665fac3.js" crossorigin="anonymous"></script>
  </head>
<body>

<nav class="navbar navbar-expand-lg navbar-light">
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
	<div class="product-view">
		<div class="row">
			<div class="p-img">
      <?php echo"<img src='../trader/uploads/$p_image' class='product-image'>";
      ?>
      
			</div>
			<div class="p-detail">
				<h1 class="product-name"><?php echo "<h3>Product Name: $p_name</h3>"; ?></h1>
				<p class="product-price"><?php echo " Actual price: <span style='text-decoration: line-through; class='set'>&pound; " .$p_price."</span></p>"; ?></p>
        <p class="product-price"><?php echo "<p>Discount Price: &pound; $discount_price</p>"; ?></p>
				<p class="product-description"><?php echo "<p>Product Description: $p_description</p>"; ?></p>
				<p class="product-allergy"><?php echo "<p>Allergy Information: $p_allergy</p>"; ?></p>
				<p class="product-price"><?php echo "<p>Stock: $p_stock</p>"; ?></p>
        <div class="quantity">
					
        <label for="quantity" class="quantity-label">Quantity</label>
          <input type="number" id="quantity" value="1" min="1"  max="<?php echo $p_stock; ?>">
          <input type="hidden" id="product_id" value="<?php echo  $_GET['p_id']; ?>" >

        </div>
        <div class="buttons">
        <?php
          if(isset($_SESSION['user_ID'])){
            echo "<button class='btn-cart' onclick='cartadd()'><i class='fas fa-shopping-cart'></i> Add to Cart</button>

            <button class='btn-wishlist'  onclick='addtowishlist($p_id)'><i class='fas fa-heart'></i> Add to wishlist</button>";
          }
          else{
            echo "<button class='btn-cart' onclick='addcart()'><i class='fas fa-shopping-cart'></i> Add to Cart</button>

            <button class='btn-wishlist'  onclick='login()'><i class='fas fa-heart'></i> Add to wishlist</button>";

          }
        ?>
        
      </div>

      
      <?php
        echo "<p class='product-price mt-5 '>
        Reviews </p> ";
      
          $count =$ratecount= 0;
            $sql = 'SELECT R.*, U.*
                    FROM "REVIEW" R
                    JOIN "USER" U ON R.USER_ID = U.USER_ID
                    WHERE R.PRODUCT_ID = :product_id';

            $stid = oci_parse($conn, $sql);
            oci_bind_by_name($stid, ":product_id", $p_id);
            oci_execute($stid);

            while ($row = oci_fetch_array($stid)) {
                $count +=1;
                $username = $row['FIRSTNAME'] . " " . $row['LASTNAME'];
                $review = $row['REVIEW_COMMENT'];

                if(!empty($row['REVIEW_SCORE'])){
                  $rating = (int)$row['REVIEW_SCORE'];
                }
                $ratecount += $rating;
                echo "<p>";
                echo " $username :<p> $review</p>";
                echo " </p>";
            }
            ?>

            
      <div class="buttons">
      
        <?php
          if(!empty($ratecount)){
            $finalrating = number_format($ratecount/$count , 1);
          }
          else{
            $finalrating = 0;
          }
          echo "<p class='product-price mt-5 '>Rating (".$finalrating."/".$count.") </p>";
            
          if(isset($_SESSION['user_ID'])){
            echo "<button class='btn-cart' onclick='giverating($p_id)'>Add to review</button>";

          }
          else{
            echo "<button class='btn-cart' onclick='login()'> Add to review</button>";

          }
        ?>
        
      </div>
      </div>
    </div>
  </div>

  <script>

      function giverating(p_id) {
            window.location.href = "review.php?p_id=" + p_id;
        }

        function login() {
            window.location.href = "../login.php" ;
        }
    function cartadd(){
      const product_id = document.getElementById('product_id').value;
      const quantity = document.getElementById('quantity').value;
      addtocart(product_id, quantity);
    } 

    
    function addtocart(id, quantity){
           var xml = new XMLHttpRequest();
            xml.onreadystatechange = function () {
              if (this.readyState == 4 && this.status == 200) {
                alert(this.responseText);
              }
            };
            xml.open("GET", "addCartWishlist.php?action=addcart&id=" + id + "&quantity=" + quantity, true);
            xml.send();
        }

        function addtowishlist(pid){
          var xml = new XMLHttpRequest();
            xml.onreadystatechange = function () {
              if (this.readyState == 4 && this.status == 200) {
                alert(this.responseText);
              }
            };
            xml.open("GET", "addCartWishlist.php?action=addwishlist&id=" + pid, true);
            xml.send();
        }

        // without login
        function addcart(){
          const product_id = document.getElementById('product_id').value;
          const quantity = document.getElementById('quantity').value;
          addcart(product_id, quantity);
        } 

        function addcart(id, quantity){
           var xml = new XMLHttpRequest();
            xml.onreadystatechange = function () {
              if (this.readyState == 4 && this.status == 200) {
                alert(this.responseText);
              }
            };
            xml.open("GET", "wlac.php?action=addcart&id=" + id + "&quantity=" + quantity, true);
            xml.send();
        }


 </script>

  <div class="about">
      <div class="aboutus">
        <h3>ABOUT US</h3>
        <p>At HeatonsMart, we are your ultimate destination for all your grocery needs. We bring together 
          a delightful selection of bakery products, fresh meats from our butcher shop, a wide variety of fish, 
          and an extensive range of grocery items. With HeatonsMart, you can conveniently shop for all your kitchen essentials
           in one place.  Join us at HeatonsMart and experience the convenience, quality, and variety that we have to offer. Start 
           your grocery shopping journey with us today!
        </p>
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
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" 
    ntegrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" 
    crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>


    <


  
</body>
</html>
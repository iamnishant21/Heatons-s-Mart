<?php
session_start();
include('../connection.php');
    $sql = 'SELECT * FROM "PRODUCT" WHERE PRODUCT_ID= :p_id';
    $stid = oci_parse($conn, $sql);
    oci_bind_by_name($stid, ":p_id", $_GET['p_id']);

    oci_execute($stid);
    while ($row = oci_fetch_array($stid, OCI_ASSOC)) {
        $p_id = $row['PRODUCT_ID'];
        $p_category = $row['CATEGORY_ID'];
        $p_shop = $row['SHOP_ID'];
        $p_name = $row['PRODUCT_NAME'];
        $p_price = $row['PRODUCT_PRICE'];
        $p_type = $row['PRODUCT_CATEGORY'];
        $p_description = $row['PRODUCT_DESCRIPTION'];
        $p_allergy = $row['ALLERGY_INFORMATION'];
        $p_quantity = $row['PRODUCT_QUANTITY'];
        $p_stock = $row['PRODUCT_STOCK'];
        $p_image = $row['PRODUCT_IMAGE'];
    }

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
      <a class="navbar-brand" href="homepage.html"><img src="Heaton's Mart.png"></a>
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
          <li class="nav-item">
            <a class="nav-link" href="deals.php">Deals</a>
          </li>
        </ul>
        <div class="main">
          <a href="login.php" class="user"><i class="fas fa-user"></i></a>
          <a href="cart.php" ><i class="fas fa-shopping-cart"></i></a>
          <a href="wishlist.php"> <i class="fas fa-heart"></i></a>
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
				<p class="product-price"><?php echo "<p>Price: &pound; $p_price</p>"; ?></p>
				<p class="product-description"><?php echo "<p>Product Description: $p_description</p>"; ?></p>
				<p class="product-allergy"><?php echo "<p>Allergy Information: $p_allergy</p>"; ?></p>
				<div class="quantity">
					<label for="quantity" class="quantity-label">Quantity</label>
          <input type="number" id="quantity" value="1" min="1"  max="20">
          <input type="hidden" id="product_id" value="<?php echo $p_id; ?>" >

        </div>
        <div class="buttons">
        <?php
          if(isset($_SESSION['user_ID'])){
            echo "<button class='btn-cart' onclick='cartadd()'><i class='fas fa-shopping-cart'></i> Add to Cart</button>

            <button class='btn-wishlist'  onclick='addtowishlist($p_id)'><i class='fas fa-heart'></i> Add to wishlist</button>";
          }
          else{
            echo "<button class='btn-cart'><i class='fas fa-shopping-cart'></i> Add to Cart</button>

             <button class='btn-wishlist'><i class='fas fa-heart'></i> Add to wishlist</button>";
          }
        ?>
        
      </div>
      </div>
    </div>
  </div>

  <script>

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
            xml.open("GET", "addCartWishlist.php?action=addwishlist&id=" + id, true);
            xml.send();
        }

 </script>

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
        <a href="homepage.html">Home</a>
        <a href="product.html">Product</a>            
        <a href="deals.html">Deals</a>
        <a href="contact.html">Contact</a>
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
</body>
</html>
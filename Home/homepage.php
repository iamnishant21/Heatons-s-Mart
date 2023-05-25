<?php
  session_start();

  if(isset($_POST['searchname'])){
    $p_name = ucfirst(trim($_POST['productname']));
    header("location:product.php?productname=".$p_name."&search=search");
  }
?>
<!DOCTYPE html>
<html>
<head>
	<title>Home Page</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="homepages.css">
    <link rel="stylesheet" href="nav.css">
    <link rel="stylesheet" href="footer.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" 
    integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg==" 
    crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://kit.fontawesome.com/b2d665fac3.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" integrity="sha512-tS3S5qG0BlhnQROyJXvNjeEM4UpMXHrQfTGmbQ1gKmelCxlSEBUaxhRBj/EFTzpbP4RVSrpEikbmdJobCvhE3g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>


    <style>
      .add-to-cart , .add-to-wishlist{
        cursor: pointer;
      }
    </style>
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

  <div class="cover">
    <div class="box">
      <div class="search-box">
        <form method="post">
          <input type="text" name='productname' id="searchitem" placeholder="Search">
          <button type="submit" name='searchname' ><i id="searchbutton" class="fas fa-search"></i></button>
        </form>
      </div>
    </div>                          
  </div>
    <div class="products-tag">
        <h2>Home</h2>
    </div>  
    <div class="owl-carousel owl-theme">
      <div class="item"><img src="image/GG8.jpg"></div>
      <div class="item"><img src="image/BB2.jpg"></div>
      <div class="item"><img src="image/GG6.jpg"></div>
      <div class="item"><img src="image/meat2.jpg"></div>
      <div class="item"><img src="image/BB8.jpg"></div>
    </div>
    <div class="products-tag">
  <h2>HOT DEALS</h2>
</div> 
<div class="product-row">
<?php
include("../connection.php");
$verify = 'verified';

$sql = 'SELECT * FROM PRODUCT WHERE PRODUCT_STATUS = :verify';
$stmt = oci_parse($conn, $sql);
oci_bind_by_name($stmt, ':verify', $verify);

oci_execute($stmt);

while ($row = oci_fetch_array($stmt, OCI_ASSOC)) {
  $product_id = $row['PRODUCT_ID'];
  $product_name = $row['PRODUCT_NAME'];
  $product_category = $row['PRODUCT_CATEGORY'];
  $product_price = $row['PRODUCT_PRICE'];
  $product_quantity = $row['PRODUCT_QUANTITY'];
  $product_image = $row['PRODUCT_IMAGE'];

  echo "<div class='product'>";
  echo "<img src='../trader/uploads/$product_image' onclick='viewproduct($product_id)'>";
  echo "<div class='product-info'>";
  echo "<h3>" . ucfirst($product_name) . "</h3>";

  if (!empty($row['DISCOUNT_ID'])) {
    $discount_sql = 'SELECT DISCOUNT_PERCENT FROM DISCOUNT WHERE DISCOUNT_ID = :disc_id';
    $discount_stmt = oci_parse($conn, $discount_sql);
    oci_bind_by_name($discount_stmt, ":disc_id", $row['DISCOUNT_ID']);
    oci_execute($discount_stmt);
    $discount_row = oci_fetch_array($discount_stmt, OCI_ASSOC); 
    $discount = (int)$discount_row['DISCOUNT_PERCENT'];
    $total_price = $product_price - $product_price * ($discount / 100);
    echo "<p style='text-decoration: line-through;' class='set'>&pound; " . $product_price . "</p>";
    echo "<p class='dis'>&pound; " . $total_price . "</p>";
  } else {
    echo "<p class='amount'>&pound; " . $product_price . "</p>";
  }

  echo "<div class='product-icons'>";
  
  if(isset($_SESSION['user_ID'])){
    echo "<div class='add-to-cart' onclick='addtocart($product_id, 1)'><i class='fa fa-shopping-cart'></i></div>";
    echo "<div class='add-to-wishlist' onclick='addtowishlist($product_id)'><i class='fa fa-heart'></i></div>";
  } else {
    echo "<div class='add-to-cart' onclick='addcart($product_id, 1)'><i class='fa fa-shopping-cart'></i></div>";
    echo "<div class='add-to-wishlist' onclick='login()'><i class='fa fa-heart'></i></div>";
  }

  echo "</div>";
  echo "</div>";
  echo "</div>";
}
?>  
</div>

<div class="products-tag">
  <h2>RECOMMENDED PRODUCTS</h2>
</div> 
<div class="product-row">
<?php
include("../connection.php");
$verify = 'verified';

$sql = 'SELECT * FROM PRODUCT WHERE PRODUCT_STATUS = :verify';
$stmt = oci_parse($conn, $sql);
oci_bind_by_name($stmt, ':verify', $verify);

oci_execute($stmt);

while ($row = oci_fetch_array($stmt, OCI_ASSOC)) {
  $product_id = $row['PRODUCT_ID'];
  $product_name = $row['PRODUCT_NAME'];
  $product_category = $row['PRODUCT_CATEGORY'];
  $product_price = $row['PRODUCT_PRICE'];
  $product_quantity = $row['PRODUCT_QUANTITY'];
  $product_image = $row['PRODUCT_IMAGE'];

  echo "<div class='product'>";
  echo "<img src='../trader/uploads/$product_image' onclick='viewproduct($product_id)'>";
  echo "<div class='product-info'>";
  echo "<h3>" . ucfirst($product_name) . "</h3>";

  if (!empty($row['DISCOUNT_ID'])) {
    $discount_sql = 'SELECT DISCOUNT_PERCENT FROM DISCOUNT WHERE DISCOUNT_ID = :disc_id';
    $discount_stmt = oci_parse($conn, $discount_sql);
    oci_bind_by_name($discount_stmt, ":disc_id", $row['DISCOUNT_ID']);
    oci_execute($discount_stmt);
    $discount_row = oci_fetch_array($discount_stmt, OCI_ASSOC); 
    $discount = (int)$discount_row['DISCOUNT_PERCENT'];
    $total_price = $product_price - $product_price * ($discount / 100);
    echo "<p style='text-decoration: line-through;' class='set'>&pound; " . $product_price . "</p>";
    echo "<p class='dis'>&pound; " . $total_price . "</p>";
  } else {
    echo "<p class='amount'>&pound; " . $product_price . "</p>";
  }

  echo "<div class='product-icons'>";
  
  if(isset($_SESSION['user_ID'])){
    echo "<div class='add-to-cart' onclick='addtocart($product_id, 1)'><i class='fa fa-shopping-cart'></i></div>";
    echo "<div class='add-to-wishlist' onclick='addtowishlist($product_id)'><i class='fa fa-heart'></i></div>";
  } else {
    echo "<div class='add-to-cart' onclick='addcart($product_id, 1)'><i class='fa fa-shopping-cart'></i></div>";
    echo "<div class='add-to-wishlist' onclick='login()'><i class='fa fa-heart'></i></div>";
  }

  echo "</div>";
  echo "</div>";
  echo "</div>";
}
?>  
</div>

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
  <script>
    $(document).ready(function(){
      $('.owl-carousel').owlCarousel({
        loop:true,
        margin:10,
        nav:true,
        responsive:{
          0:{
            items:1
          },
          600:{
            items:2
          },
          1000:{
            items:3
          }
        }
      })
    });
  </script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" 
     integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" 
     crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" 
     integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" 
     crossorigin="anonymous"></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js" 
     integrity="sha512-bPs7Ae6pVvhOSiIcyUClR7/q2OAsRiovw4vAkX+zJbw3ShAeeqezq50RIIcIURq7Oa20rW2n2q+fyXBNcU9lrw==" 
     crossorigin="anonymous" referrerpolicy="no-referrer"></script>

     <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js" integrity="sha384-zYPOMqeu1DAVkHiLqWBUTcbYfZ8osu1Nd6Z89ify25QV9guujx43ITvfi12/QExE" crossorigin="anonymous"></script>
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.min.js" integrity="sha384-Y4oOpwW3duJdCWv5ly8SCFYWqFDsfob/3GkgExXKV4idmbt98QcxXYs9UoXAB7BZ" crossorigin="anonymous"></script>

     <script>
        function viewproduct(p_id) {
            window.location.href = "pdetail.php?p_id=" + p_id;
        }

        function login() {
            window.location.href = "../login.php";
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

     </script>
    
    </body>
</html>

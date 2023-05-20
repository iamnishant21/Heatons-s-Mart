<?php
  session_start();
  include('../connection.php');

  if(isset($_POST['searchname'])){
    $p_name = strtolower(trim($_POST['productname']));
    header("location:product.php?productname=".$p_name."&search=search");
  }

?>
<!DOCTYPE html>
<html>
<head>
	<title>Product Page</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="nav.css">
    <link rel="stylesheet" href="products.css">
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
    <div class="cover">
        <div class="box">
          <div class="search-box">
            <form method="post">
              <input type="text" name="productname" id="searchname" placeholder="Search">
              <button type="submit" name="searchname" onclick='searchitem()'><i id="searchbutton" class="fas fa-search"></i></button>
            </form>
          </div>                          
        </div>
    </div>
    <div class="products-tag">
        <h2>Product Categories</h2>
    </div>
      <div class="container">
        <div class="row">
          <div class="col-md-4">
            <div class="dropdown">
              <button class="btn btn-default dropdown-toggle" type="button" id="dropdownPrice" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                Sort by Price <span class="caret"></span>
              </button>
              <ul class="dropdown-menu" aria-labelledby="dropdownPrice">
                <li><a href="product.php?search=low-to-high&filter=low_high">Price (Low to High)</a></li>
                <li><a href="product.php?search=high-to-low&filter=high_low">Price (High to Low)</a></li>
              </ul>
            </div>
          </div>
          <div class="col-md-4">
            <div class="dropdown">
              <button class="btn btn-default dropdown-toggle" type="button" id="dropdownPrice" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                FIlter by Category <span class="caret"></span>
              </button>
              <ul class="dropdown-menu" aria-labelledby="dropdownPrice">
              <?php
                     $sql = 'SELECT * FROM "PRODUCT_CATEGORY" ';
                     $stid = oci_parse($conn, $sql);
                    oci_execute($stid);

                    while ($row = oci_fetch_array($stid, OCI_ASSOC)) {
                      echo "<li><a href='product.php?catid=".$row['CATEGORY_ID']."&search=".$row['CATEGORY_NAME']."'>".$row['CATEGORY_NAME']."</a></li>";
                    }

                   ?>       
              </ul>
            </div>
          </div>
          <div class="col-md-4">
            <div class="dropdown">
              <button class="btn btn-default dropdown-toggle" type="button" id="dropdownProduct" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                Filter by Shop Name<span class="caret"></span>
              </button>
              <ul class="dropdown-menu" aria-labelledby="dropdownProduct">
                <?php
                     $sql = 'SELECT * FROM "SHOP" ';
                     $stid = oci_parse($conn, $sql);
                    oci_execute($stid);

                    while ($row = oci_fetch_array($stid, OCI_ASSOC)) {
                      echo "<li><a href='product.php?shopid=".$row['SHOP_ID']."&search=".$row['SHOP_NAME']."'>".$row['SHOP_NAME']."</a></li>";
                    }

                   ?>          
                       
              </ul>
            </div>
          </div>
        </div>
      </div>

      <div class="products-tag">
        <?php
         include("../connection.php");

        if(isset($_GET['search'])){
          echo " <h2><i>".$_GET['search']."</i>Products</h2>";
        }
        else{
         echo "<h2><i>all</i>Products</h2>";
        }
        ?>
     
      </div>
      
    <div class="product-row">
     <?php
      if(isset($_GET['productname'])){
        $sql = "SELECT * FROM PRODUCT WHERE  PRODUCT_NAME LIKE '%' || :pname || '%'";
        $stmt = oci_parse($conn, $sql);
        oci_bind_by_name($stmt,':pname', $_GET['productname']);
      }
      else if(isset($_GET['shopid'])){
        $sql = 'SELECT * FROM "PRODUCT" WHERE SHOP_ID = :shopid';
        $stmt = oci_parse($conn, $sql);
        oci_bind_by_name($stmt,':shopid', $_GET['shopid']);
      }
      else if(isset($_GET['catid'])){
        $sql = 'SELECT * FROM "PRODUCT" WHERE CATEGORY_ID = :catid';
        $stmt = oci_parse($conn, $sql);
        oci_bind_by_name($stmt,':catid', $_GET['catid']);
      }
      else if(isset($_GET['filter'])){
        if($_GET['filter'] == 'low_high'){
          $sql = 'SELECT * FROM "PRODUCT" ORDER BY PRODUCT_PRICE ASC ';
          $stmt = oci_parse($conn, $sql);
         
        }
        else if($_GET['filter'] == 'high_low'){
          $sql = 'SELECT * FROM "PRODUCT"ORDER BY PRODUCT_PRICE DESC';
          $stmt = oci_parse($conn, $sql);
          
        }
      }
      else {
        $sql = 'SELECT * FROM "PRODUCT" ORDER BY dbms_random.value';
        $stmt = oci_parse($conn, $sql);
      }
   
    oci_execute($stmt);

    while ($row = oci_fetch_array($stmt, OCI_ASSOC)) {
      $product_id = $row['PRODUCT_ID'];
      $product_name = $row['PRODUCT_NAME'];
      $product_category = $row['PRODUCT_CATEGORY'];
      $product_price = $row['PRODUCT_PRICE'];
      $product_quantity = $row['PRODUCT_QUANTITY'];
      $product_image = $row['PRODUCT_IMAGE'];

      echo"
      <div class='product'>
      <img src='../trader/uploads/$product_image' onclick='viewproduct($product_id)'>
      <div class='product-info'>
           <h3>$product_name</h3>
           <p>Price: &pound; $product_price</p>
           <div class='product-icons'>";
           if(isset($_SESSION['user_ID'])){
            echo "<div class='add-to-cart' onclick='addtocart($product_id,1)'><i class='fa fa-shopping-cart'></i></div>";
            echo "<div class='add-to-wishlist'  onclick='addtowishlist($product_id)' ><i class='fa fa-heart'></i></div>";
          }
          else{
            echo "<div class='add-to-cart'><i class='fa fa-shopping-cart'></i></div>";
            echo "<div class='add-to-wishlist'><i class='fa fa-heart'></i></div>";
          }
          echo "</div>
        </div>
      </div>";
    }
    ?> 
    </div>
        
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
        <a href="contact_us.html">Contact</a>
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
     integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" 
     crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

    <script>
        function viewproduct(p_id) {
            window.location.href = "pdetail.php?p_id=" + p_id;
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

     </script>

</body>
</html>

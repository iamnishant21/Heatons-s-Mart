<?php
session_start();
include('../connection.php');

if(isset($_GET['action'])){
  $product_id = $_GET['id'];

  if($_GET['action'] == 'remove'){
    $sql = 'DELETE FROM WISHLIST_PRODUCT WHERE PRODUCT_ID = :product_id';
    $stmt = oci_parse($conn, $sql);
    oci_bind_by_name($stmt,":product_id" , $product_id);
    oci_execute($stmt);
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
  <link rel="stylesheet" href="wishlist.css">
  <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">

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
    <h2>MYWISHLIST</h2>
  </div>
  
	<div class="cart-wrap">
		<div class="container">
	        <div class="row">
			    <div class="col-md-12">
			        <!-- <div class="main-heading mb-10">Heaton's wishlist</div> -->
			        <div class="table-wishlist">
				        <table cellpadding="0" cellspacing="0" border="0" width="100%">
				        	<thead>
					        	<tr>
					        		<th width="45%">Product Name</th>
					        		<th width="15%">Unit Price</th>
					        		<th width="15%">Stock Status</th>
					        		<th width="15%"></th>
					        		<th width="10%"></th>
					        	</tr>
					        </thead>
					        <tbody>

                  <?php
                     $user_id = $_SESSION['user_ID'];
                     // Prepare the SQL query
                     $query = "
                         SELECT WISHLIST_PRODUCT.*
                         FROM WISHLIST
                         JOIN WISHLIST_PRODUCT ON WISHLIST.WISHLIST_ID = WISHLIST_PRODUCT.WISHLIST_ID
                         WHERE WISHLIST.USER_ID = :user_id";
             
                     $stid = oci_parse($conn, $query);
                     oci_bind_by_name($stid , ":user_id" , $user_id);
                     oci_execute($stid);
             
                     while($data = oci_fetch_array($stid)){
                       $product_id = $data['PRODUCT_ID'];
                       $sql= "SELECT * FROM PRODUCT WHERE PRODUCT_ID = :product_id";
                       $stmt = oci_parse($conn, $sql);
                       oci_bind_by_name($stmt, ":product_id", $product_id);
                       oci_execute($stmt);
             
                       while($row = oci_fetch_array($stmt)){
                         $productname = $row['PRODUCT_NAME'];
                         $product_image = $row['PRODUCT_IMAGE'];
                        
                         echo "<tr>
                         <td width='45%'>
                           <div class='display-flex align-center'>
                                           <div class='img-product'>
                                            <img src='image/$product_image'>
                                           </div>
                                           <div class='name-product'>
                                               $productname
                                           </div>
                                         </div>
                                     </td>
                         <td width='15%' class='price'>".$row['PRODUCT_PRICE']."</td>";
                        if($row['PRODUCT_STOCK'] <= 0 ){
                          echo "<td width='15%'><span class='in-stock-box'>Out of Stock</span></td>";
                        }
                        else{
                          echo "<td width='15%'><span class='in-stock-box'>In Stock</span></td>";
                        }
                        
                        
                         if(isset($_SESSION['user_ID'])){
                          echo "<td width='15%'><button class='round-black-btn small-btn' onclick='addtocart($product_id,1)'  >Add to Cart</button></td>";
                          echo "<td width='10%' class='text-center'><a href='wishlist.php?action=remove&id=$product_id' class='trash-icon'><i class='far fa-trash-alt'></i></a></td>";

                        }
                         
                       echo "</tr>";


                        }
                     }
                  ?>
					        	
				        	</tbody>
				        </table>
				    </div>
			    </div>
			</div>
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
      

      <script>
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
      </script>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" 
     integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" 
     crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

    </body>
    </html>
    
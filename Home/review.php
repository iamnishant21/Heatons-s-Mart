<?php
session_start();
include("../connection.php");

if (isset($_POST['Rsub'])) {
  $product_id = $_GET['p_id'];
  $user_id =   $_SESSION['user_ID'];
  $review_id = '';

  if(!empty($_POST['rating']) && empty($_POST['review']))  {

      $star = $_POST['rating'];

          $sql = "SELECT * FROM REVIEW WHERE USER_ID = :user_id AND PRODUCT_ID = :product_id";
          $rsql = oci_parse($conn, $sql);
          oci_bind_by_name($rsql, ":user_id", $user_id);
          oci_bind_by_name($rsql, ":product_id", $product_id);
          oci_execute($rsql);

          while ($data = oci_fetch_array($rsql)) {
              if (isset($data['REVIEW_ID'])) {
                  $review_id = $data['REVIEW_ID'];
              }
          }
          if (!empty($review_id)) {
              $sql = "UPDATE REVIEW SET REVIEW_SCORE = :rating WHERE REVIEW_ID = :review_id";
              $stid = oci_parse($conn, $sql);
              oci_bind_by_name($stid, ":review_id", $review_id);
              oci_bind_by_name($stid, ":rating", $star);
              if (oci_execute($stid)) {
                  echo " <script>alert('Rating is added in the product')</script>
                  ";
              }
          } else {
              $sql = "INSERT INTO REVIEW (USER_ID, PRODUCT_ID, REVIEW_SCORE) VALUES (:user_id, :product_id, :rating)";
              $stid = oci_parse($conn, $sql);
              oci_bind_by_name($stid, ":user_id", $user_id);
              oci_bind_by_name($stid, ":product_id", $product_id);
              oci_bind_by_name($stid, ":rating", $star);

              if (oci_execute($stid)) {
                  echo " <script>alert('Rating is added in the product')</script>";
              }
          }
      }
  
    else if (empty($_POST['rating']) && !empty($_POST['review'])) {
          $review = $_POST['review'];

          $sql = "SELECT * FROM REVIEW WHERE USER_ID = :user_id AND PRODUCT_ID = :product_id";
          $rsql = oci_parse($conn, $sql);
          oci_bind_by_name($rsql, ":user_id", $user_id);
          oci_bind_by_name($rsql, ":product_id", $product_id);
          oci_execute($rsql);
          while ($data = oci_fetch_array($rsql)) {
              if (isset($data['REVIEW_ID'])) {
                  $review_id = $data['REVIEW_ID'];
              }
          }

          if (!empty($review_id)) {
              $sql = "UPDATE REVIEW SET REVIEW_COMMENT = :review WHERE REVIEW_ID = :review_id";
              $stid = oci_parse($conn, $sql);
              oci_bind_by_name($stid, ":review_id", $review_id);
              oci_bind_by_name($stid, ":review", $review);

              if (oci_execute($stid)) {
                echo " <script>alert('Rating is added in the product')</script>";
              }
          } else {

              $sql = "INSERT INTO REVIEW (USER_ID, PRODUCT_ID, REVIEW_COMMENT) VALUES (:user_id, :product_id, :review)";
              $stid = oci_parse($conn, $sql);
              oci_bind_by_name($stid, ":user_id", $user_id);
              oci_bind_by_name($stid, ":product_id", $product_id);
              oci_bind_by_name($stid, ":review", $review);

              if (oci_execute($stid)) {
                echo " <script>alert('Rating is added in the product')</script>";
              }
          }
      }
      else{
        $star = $_POST['rating'];
        $review = $_POST['review'];

            $sql = "INSERT INTO REVIEW (USER_ID, PRODUCT_ID,REVIEW_SCORE, REVIEW_COMMENT) VALUES (:user_id, :product_id,:rating, :review)";
            $stid = oci_parse($conn, $sql);
            oci_bind_by_name($stid, ":user_id", $user_id);
            oci_bind_by_name($stid, ":product_id", $product_id);
            oci_bind_by_name($stid, ":rating", $star);
            oci_bind_by_name($stid, ":review", $review);

            if (oci_execute($stid)) {
              echo " <script>alert('Rating is added in the product')</script>";
            }
        
      }
  }

 ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css">
    <link rel="stylesheet" href="review.css">
</head>
<body>
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
              
          <a href="../cart.php" ><i class="fas fa-shopping-cart"></i></a>
          <a href='../wishlist.php'> <i class='fas fa-heart'></i></a>

          
        </div>
          </div>
        </div>
      </nav>
      
    <?php
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
    }

    ?>
    <div class="container">
        <h2 class="text-center">Rate And Review Of Products</h2>
        
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <!-- <div class="col-md-2">
                        <img src="userphoto.webp" class="img img-rounded img-fluid" alt="user photo"/>
                    </div> -->
                    <div class="col-md-2">
                    <?php echo"<img src='../trader/uploads/$p_image' onclick='viewproduct($p_id)' class='img img-rounded img-fluid' >";
                     ?>
      
                        <!-- <img src="fm2.jpg" class="img img-rounded img-fluid" alt="product photo"/> -->
                    </div>

                    <div class="col-md-10 float-right">
                        <!-- <p>
                            <strong>Kumar Thapa</strong></a>
                       </p> -->
                  <form method='POST' action=''>


                       <div class="col-md-7 rating">
                        <input type="radio" name="rating" value="5" id="5"><label for="5">☆</label>
                        <input type="radio" name="rating" value="4" id="4"><label for="4">☆</label>
                        <input type="radio" name="rating" value="3" id="3"><label for="3">☆</label>
                        <input type="radio" name="rating" value="2" id="2"><label for="2">☆</label>
                        <input type="radio" name="rating" value="1" id="1"><label for="1">☆</label>
                      </div>
                       <div class="clearfix"></div>
                        <p><textarea id="review" name="review" rows="5" cols="60"></textarea></p>
                        <p>
                          <input type="submit" name="Rsub" value="submit">
                            
                       </p>
                    </div>

                   </form>
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
    </div>
</div>
<div class="footer">
    <div class="box1">
        <a href="../homepage.php">Home</a>
        <a href="../product.php">Product</a>            
        <a href="../contact_us.php">Contact</a>
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
</body>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" 
     integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" 
     crossorigin="anonymous"></script>




     <script>
      function viewproduct(p_id) {
            window.location.href = "pdetail.php?p_id=" + p_id;
        }

     </script>

</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="orderhistory.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css">
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
                <a class="nav-link" href="contact_us.html">Contact Us</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="product.php">Products</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="deals.php">Deals</a>
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
        <h2>ORDER HISTORY</h2>
    </div>
    <div class="container mt-5">
        <div class="d-flex justify-content-center row">
            <div class="col-md-10">
                <div class="rounded">
                    <div class="table-responsive table-borderless">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Product Image</th>
                                    <th>Order Id</th>
                                    <th>Product name</th>
                                    <th>Order Quantity</th>
                                    <th>Total Amount</th>
                                    <th>Order Date</th>
                                    <th>Status</th>
                                    <th>Review Products</th>
                                    
                                </tr>
                            </thead>
                            <tbody class="table-body">
                                <tr class="cell-1">
                                    <td><img src="fm2.jpg" alt="" width="50px" height="50px"> </td>
                                    <td>1001</td>
                                    <td>SALMON</td>
                                    <td>15</td>
                                    <td>$2</td>
                                    <td>05/05/2023</td>
                                    <td><span class="badge badge-success">Paid</span></td>
                                    <td><a href="review.html" style="color:black"><i class='fas fa-comments'></i></a></td>
                                </tr>
                                <tr class="cell-1">
                                    <td><img src="GG5.jpg" alt="" width="50px" height="50px"> </td>
                                    <td>1002</td>
                                    <td>LEMONS</td>
                                    <td>10</td>
                                    <td>$3.9</td>
                                    <td>05/02/2023</td>
                                    <td><span class="badge badge-success">Paid</span></td>
                                    <td><a href="review.html" style="color:black"><i class='fas fa-comments'></i></a></td>
                                </tr>
                                <tr class="cell-1">
                                    <td><img src="GG1.jpg" alt="" width="50px" height="50px"> </td>
                                    <td>1003</td>
                                    <td>TOMATOES</td>
                                    <td>7</td>
                                    <td>$5</td>
                                    <td>04/01/2023</td>
                                    <td><span class="badge badge-success">Paid</span></td>
                                    <td><a href="review.html" style="color:black"><i class='fas fa-comments'></i></a></td>
                                </tr>
                                <tr class="cell-1">
                                    <td><img src="meat1.jpg" alt="" width="50px" height="50px"> </td>
                                    <td>1004</td>
                                    <td>CHICKEN</td>
                                    <td>4</td>
                                    <td>$10</td>
                                    <td>04/05/2023</td>
                                    <td><span class="badge badge-success">Paid</span></td>
                                    <td><a href="review.html" style="color:black"><i class='fas fa-comments'></i></a></td>
                                </tr>
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
</body>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</html>
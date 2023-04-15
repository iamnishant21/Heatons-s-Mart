<!DOCTYPE html>
<html>
<head>
	<title>Home Page</title>
    <link rel="stylesheet" href="homepage.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" 
        rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" 
        crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" 
    integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg==" 
    crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" 
    integrity="sha512-tS3S5qG0BlhnQROyJXvNjeEM4UpMXHrQfTGmbQ1gKmelCxlSEBUaxhRBj/EFTzpbP4RVSrpEikbmdJobCvhE3g==" 
    crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <script src="https://kit.fontawesome.com/b2d665fac3.js" crossorigin="anonymous"></script>
  </head>
<body>
    <header>
        <a href="homepage.html"><img src="Heaton's Mart.png"></a>
        <nav>
            <div class="menu-icon">&#9776;</div>
            <input type="checkbox" id="nav-toggle">
            <ul>
                <li><a href="homepage.html">Home</a></li> 
                <li><a href="product.html">Products</a></li>
                <li><a href="deals.html">Offers</a></li>
                <li><a href="../contact_us/contact_us.php">Contact Us</a></li>
            </ul>
        </nav>
        <div class="main">
            <a href="user.html" class="user"><i class="ri-user-fill"></i></a>
            <a href="cart.html" ><i class="ri-shopping-cart-2-line"></i></a>
            <a href="wishlist.html"> <i class="ri-heart-3-fill"></i></a>
            <a href="login.html"> <i class="ri-home-heart-line"></i></i></a>
        </div>
    </header>
    <div class="cover">
      <div class="search-container">
        <form action="#">
          <input type="text" placeholder="Search">
          <button type="submit"><i class="fa fa-search"></i></button>
        </form>
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
      <div class="product">
        <img src="image/BB1.jpg">
        <div class="product-info">
          <h3>Product 1</h3>
          <p>Price: $10.99</p>
          <div class="product-icons">
            <a href="#" class="add-to-cart"><i class="fa fa-shopping-cart"></i></a>
            <a href="#" class="add-to-wishlist"><i class="fa fa-heart"></i></a>
          </div>
        </div>
      </div>
      <div class="product">
        <img src="image/meat2.jpg">
        <div class="product-info">
          <h3>Product 2</h3>
          <p>Price: $19.99</p>
          <div class="product-icons">
            <a href="#" class="add-to-cart"><i class="fa fa-shopping-cart"></i></a>
            <a href="#" class="add-to-wishlist"><i class="fa fa-heart"></i></a>
          </div>
        </div>
      </div>
      <div class="product">
        <img src="image/fm2.jpg">
        <div class="product-info">
          <h3>Product 3</h3>
          <p>Price: $7.50</p>
          <div class="product-icons">
            <a href="#" class="add-to-cart"><i class="fa fa-shopping-cart"></i></a>
            <a href="#" class="add-to-wishlist"><i class="fa fa-heart"></i></a>
          </div>
        </div>
      </div>
    </div>

    <div class="products-tag">
      <h2>RECOMMENDED PRODUCTS</h2>
    </div> 
    <div class="product-row">
      <div class="product">
        <img src="image/GG2.jpg">
        <div class="product-info">
          <h3>Product 1</h3>
          <p>Price: $10.99</p>
          <div class="product-icons">
            <a href="#" class="add-to-cart"><i class="fa fa-shopping-cart"></i></a>
            <a href="#" class="add-to-wishlist"><i class="fa fa-heart"></i></a>
          </div>
        </div>
      </div>
      <div class="product">
        <img src="image/meat2.jpg">
        <div class="product-info">
          <h3>Product 2</h3>
          <p>Price: $19.99</p>
          <div class="product-icons">
            <a href="#" class="add-to-cart"><i class="fa fa-shopping-cart"></i></a>
            <a href="#" class="add-to-wishlist"><i class="fa fa-heart"></i></a>
          </div>
        </div>
      </div>
      <div class="product">
        <img src="image/fm2.jpg">
        <div class="product-info">
          <h3>Product 3</h3>
          <p>Price: $7.50</p>
          <div class="product-icons">
            <a href="#" class="add-to-cart"><i class="fa fa-shopping-cart"></i></a>
            <a href="#" class="add-to-wishlist"><i class="fa fa-heart"></i></a>
          </div>
        </div>
      </div>
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

    <script>
		var navToggle = document.getElementById("nav-toggle");
		var navMenu = document.querySelector("nav ul");
		var menuIcon = document.querySelector(".menu-icon");

		function toggleNav() {
			navMenu.classList.toggle("show");
		}

		navToggle.addEventListener("click", toggleNav);
		menuIcon.addEventListener("click", toggleNav);

		window.addEventListener("resize", function() {
			if (window.innerWidth > 768) {
				navMenu.classList.remove("show");
			}
		});
	</script>
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

     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" 
     integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" 
     crossorigin="anonymous"></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js" 
     integrity="sha512-bPs7Ae6pVvhOSiIcyUClR7/q2OAsRiovw4vAkX+zJbw3ShAeeqezq50RIIcIURq7Oa20rW2n2q+fyXBNcU9lrw==" 
     crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    </body>
</html>

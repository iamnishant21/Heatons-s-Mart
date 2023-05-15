
<?php
  session_start();

  include('../connection.php');
  // $user = 120;
  $firstname =  $lastname = $email = $gender =  $contact = $email =$address = $dob=''; 
  $sql = 'SELECT * FROM "USER" WHERE USER_ID = :id ';
  $stid= oci_parse($conn,$sql);
  // oci_bind_by_name($stid, ':id' , $user );
  oci_bind_by_name($stid, ':id' , $_SESSION['user_ID'] );
 
  oci_execute($stid);

  while($row = oci_fetch_array($stid,OCI_ASSOC)){
    $firstname = $row['FIRSTNAME'];
    $lastname = $row['LASTNAME'];
    $email = $row['EMAIL_ADDRESS'];
    $gender = $row['GENDER'];
    $dob = $row['DATE_OF_BIRTH'];
    $contact = $row['PHONE_NUMBER'];
    $address = $row['ADDRESS'];
    $password = $row['PASSWORD'];

    if(!empty($row['USER_IMAGE'])){
      $cimage = $row['USER_IMAGE'];
    }
    else{
      $cimage = "Heaton_Mart.png";
    }
    
  }


  // update profile
if(isset($_POST['cButton'])){
    $c_fname = $_POST['cfirstname'];
    $c_lname = $_POST['clastname'];
    $c_email = $_POST['cemail'];
    $c_gender = $_POST['cgender'];
    $c_dob = $_POST['cdob'];
    $c_phonenumber = $_POST['cphonenumber'];
    $c_address = $_POST['caddress'];

    $prevImage = $_POST['prevImage'];
    
    $image = $_FILES["profileImage"]["name"];
    $utmpname = $_FILES['profileImage']['tmp_name'];
    
    $ulocation = "uploads/".$image;
    // Prepare the SQL statement
    $contact = (int)$c_phonenumber;
    if(!empty($image)){ 
      $sql = 'UPDATE "USER" SET FIRSTNAME = :cfname, LASTNAME = :clname, EMAIL_ADDRESS = :cemail, GENDER = :cgender, DATE_OF_BIRTH = :cdob, PHONE_NUMBER = :cphone, ADDRESS = :caddress, USER_IMAGE = :cimage WHERE USER_ID = :id';

       // Parse the SQL statement
        $stmt = oci_parse($conn, $sql);
        $user = 120;
        // Bind the parameters
        oci_bind_by_name($stid, ':id' , $_SESSION['user_ID'] );
        // oci_bind_by_name($stmt, ':id' , $user );
        oci_bind_by_name($stmt, ':cfname', $c_fname);
        oci_bind_by_name($stmt, ':clname', $c_lname);
        oci_bind_by_name($stmt, ':cemail', $c_email);
        oci_bind_by_name($stmt, ':cgender', $c_gender);
        oci_bind_by_name($stmt, ':cdob', $c_dob);
        oci_bind_by_name($stmt, ':cphone', $contact);
        oci_bind_by_name($stmt, ':caddress', $c_address);
        oci_bind_by_name($stmt, ':cimage', $image);
        $res = oci_execute($stmt);

        if ($res){
        if(move_uploaded_file($utmpname,$ulocation)){
          header('location:customerprofile.php');
        }
        else{
          echo "Unable to insert file";
        }     
      }
    }else{
      $sql = 'UPDATE "USER" SET FIRSTNAME = :cfname, LASTNAME = :clname, EMAIL_ADDRESS = :cemail, GENDER = :cgender, DATE_OF_BIRTH = :cdob, PHONE_NUMBER = :cphone, ADDRESS = :caddress, USER_IMAGE = :cpimage WHERE USER_ID = :id';
       // Parse the SQL statement
        $stmt = oci_parse($conn, $sql);
        $user = 120;
        // Bind the parameters
        // oci_bind_by_name($stid, ':id' , $_SESSION['user_ID'] );
        oci_bind_by_name($stmt, ':id' , $user );
        oci_bind_by_name($stmt, ':cfname', $c_fname);
        oci_bind_by_name($stmt, ':clname', $c_lname);
        oci_bind_by_name($stmt, ':cemail', $c_email);
        oci_bind_by_name($stmt, ':cgender', $c_gender);
        oci_bind_by_name($stmt, ':cdob', $c_dob);
        oci_bind_by_name($stmt, ':cphone', $contact);
        oci_bind_by_name($stmt, ':caddress', $c_address);
        oci_bind_by_name($stmt, ':cpimage',   $prevImage );
        $res = oci_execute($stmt);
        if ($res){
            header('location:customerprofile.php');
        }
    }
    

    // Execute the statement
    
  }
    


           
  // change password
  
  $errcount = 0;
  $err='';
  if(isset($_POST['changepassword'])){
    $current = $_POST['currentpassword'];
    $newpass = $_POST['password'];
    $confirmpass = $_POST['cpassword'];

    if(empty($_POST['password'])){
      $err='Current Password is required';
    }
    if(empty($_POST['password'])){
      $err='Password is required';
    }
    if(empty($_POST['cpassword'])){
      $err='Confirm Password is required';
    }
    else{
        $uppercase = preg_match('@[A-Z]@',$newpass );
        $lowercase = preg_match('@[a-z]@',$newpass );
        $number = preg_match('@[0-9]@',$newpass );
        $specialChars = preg_match('@[^\w]@',$newpass);
      
        if($newpass == $confirmpass){
          if(!$uppercase){
            $errcount+=1;
            $err="Password should include at least one upper case letter.";
          }
          if(!$lowercase){
              $errcount+=1;
              $err="Password should include at least one lower case letter.";
          }
          if(!$specialChars){
              $errcount+=1;
              $err="Password should include at least one special character.";
          }
          if(!$number){
              $errcount+=1;
              $err="Password should include at least one number.";
          }

          $curpass = md5($current);

          $sql = 'SELECT * FROM "USER" WHERE USER_ID = :id ';
          $stid= oci_parse($conn,$sql);

          oci_bind_by_name($stid, ':id' , $_SESSION['user_ID'] );
          
          oci_execute($stid);

          $dbpassword='';

          while($row = oci_fetch_array($stid,OCI_ASSOC)){
            $dbpassword = $row['PASSWORD'];
          }

        if($curpass != $dbpassword){
          $errcount+=1;
          $err="Current password do not match.";
        }  

        if($errcount == 0){
          // echo "successfully password is inserted";
          $newpassword = md5($newpass);
          $sql = 'UPDATE "USER" SET PASSWORD= :upassword WHERE USER_ID = :id';
          $stid = oci_parse($conn,$sql);
          
          oci_bind_by_name($stid, ':id' , $_SESSION['user_ID'] );
          oci_bind_by_name($stid , ":upassword" ,$newpassword );

          // oci_execute($stid);
          if(oci_execute($stid)){
            // header('location:login.php');
            echo "<script>
            alert('Password Successfully Changed!!!');
            </script>";
          }
        }
      }
      else{
        $err = "Password you entered do not match.";
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
    <link rel="stylesheet" href="customerprofile.css">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
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
                <a class="nav-link" href="../Home/homepage.php">Home</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="contact_us.html">Contact Us</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="../Home/product.php">Products</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="deals.php">Deals</a>
              </li>
            </ul>
            <div class="main">
              <a href="customerprofile.php" class="user"><i class="fas fa-user"></i></a>
              <a href="cart.html" ><i class="fas fa-shopping-cart"></i></a>
              <a href="wishlist.html"> <i class="fas fa-heart"></i></a>
            </div>
          </div>
        </div>
      </nav>  
      <div class="container">
            <div class="main-body">

              <form action="" method='post' enctype="multipart/form-data">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-column align-items-center text-center">

                                    <!-- <img src="Heaton's Mart.png" alt="Customer photo" class="rounded-circle p-1 bg-dark" width="110"> -->
                                    <?php
                                      echo "<img src='uploads/$cimage' lt='Customer photo' class='rounded-circle p-1 bg-dark' width='110'>";
                                    ?>
                                    <div class="mt-3">
                                        <h4><?php echo $firstname . " ". $lastname; ?></h4>
                                        <input type='hidden' class="btn btn-outline-dark" name='prevImage' value='<?php echo $cimage; ?>' /> 

                                        <input type='file' class="btn btn-outline-dark" name='profileImage' value='<?php echo $cimage; ?>' /> 
                                    </div>
                                </div>
                                <hr class="my-4">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                        <h6 class="mb-0"><a href="cart.html" style="color:black"><i class="fas fa-shopping-cart"></i> View myCart </a></h6>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                        <h6 class="mb-0"><a href="wishlist.html" style="color:black"><i class="fas fa-heart"></i> View myWishlist </a></h6>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                        <h6 class="mb-0"><a href="orderhistory.html" style="color:black"><i class="fas fa-shopping-bag"></i> Order History </a></h6>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                        <h6 class="mb-0"><a href="logout.php" style="color:black"><i class="fas fa-sign-out-alt"></i> Log Out </a></h6>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div class="card">
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">First Name</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <input type="text" name="cfirstname" class="form-control"  value='<?php echo $firstname; ?>' />
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Last Name</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <input type="text" name="clastname"  class="form-control"  value='<?php echo $lastname; ?>' />
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Email Address</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <input type="text" name="cemail" class="form-control"  value='<?php echo $email; ?>' />
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Gender</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <input type="text" name="cgender" class="form-control"  value='<?php echo $gender; ?>' />
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Date of Birth</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <input type="date" name="cdob" class="form-control"  value='<?php echo $dob; ?>' />
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Phone Number</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <input type="number" name="cphonenumber" class="form-control"  value="<?php echo $contact; ?>" />
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Address</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <input type="text" name="caddress" class="form-control"  value='<?php echo $address; ?>' />
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Change Password</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <!-- <a href="#">Change Password</a> -->
                                        <a href=""  type="button" class="change-btn" data-bs-toggle="modal" data-bs-target="#exampleModal">Change Password</a>
                                    </div>
                                    
                                </div>
                                
                                <div class="row">
                                    <div class="col-sm-3"></div>
                                    <div class="col-sm-9 text-secondary">
                                        <input type="submit" name="cButton" class="btn btn-outline-dark px-4" value="Save Changes">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
              </form>
            </div>
        </div>
    
         <!-- Vertically centered modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered ">
    <div class="modal-content text-bg-secondary">
      
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Change Password </h1>
        
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class='error'><?php echo $err; ?></div>
      <form method="post" action=''>
      <div class="modal-body">
        <p>Current Password </p>
          <div class="password">
            <input type="password" name="currentpassword" class="inputbox" placeholder="Enter Current Password" />
          </div>
          <p>New Password</p>
          <div class="password">
            <input type="password" name="password" class="inputbox" placeholder="Enter New Password" />
          </div>
          <p>Re Type Password</p>
            <div class="password">
              <input type="password" name="cpassword" class="inputbox"  placeholder="Enter Confirm Password" />
            </div>
          
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancle</button>
          <input
            class="verify-btn btn-secondary btn text-warning"
            type="submit"
            name="changepassword"
            value="Confirm  >>"
          />
      </div>
      </form>
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
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js" integrity="sha384-zYPOMqeu1DAVkHiLqWBUTcbYfZ8osu1Nd6Z89ify25QV9guujx43ITvfi12/QExE" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.min.js" integrity="sha384-Y4oOpwW3duJdCWv5ly8SCFYWqFDsfob/3GkgExXKV4idmbt98QcxXYs9UoXAB7BZ" crossorigin="anonymous"></script>

</body>
</html>


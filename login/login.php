<?php
    include("../connection/connection.php");

    $error_name = $error_password = $error_role = '';
    if (isset($_POST['subLogin'])) {
        if (empty($_POST['email'])) {
            $error_name = 'username is required';
        }
        if (empty($_POST['userpassword'])) {
            $error_password = 'password is required';
        }
        if (empty($_POST['role'])) {
            $error_role = 'Role is required ';
        } else {
            $email = $_POST['email'];
            $password = md5($_POST['userpassword']);
            $role = $_POST['role'];
            $remember=$_POST['confirm'];
            if(!empty($remember)){
                setcookie("email" , $email , time() + 60*60*24*15, "/");
                setcookie("password" , $password , time() + 60*60*24*15, "/");
                setcookie("role" , $role , time() + 60*60*24*15, "/");
            }


            $stmt = oci_parse($conn, 'SELECT * FROM "USER" WHERE EMAIL_ADDRESS = :email AND PASSWORD = :userpassword AND ROLE = :role');
            oci_bind_by_name($stmt, ':email', $email);
            oci_bind_by_name($stmt, ':userpassword', $password);
            oci_bind_by_name($stmt, ':role', $role);
            oci_execute($stmt);
            if($result = oci_fetch_assoc($stmt)){
                if($role =='customer'){
                    header("location:../Home/homepage.php");

                }
                
                if($role=='trader'){
                    echo "Successfuly connected to trader";
                }
                
                if($role=='admin'){
                    echo "Successfuly connected to admin";
                }
            }
            else{
                echo "Unable to connect";
            }

            
        }
    }
    if (isset($_POST['subRegister'])) {
        header('location:../customer/customerSignup.php');
    }



    ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="login.css">
</head>

<body>
   
    <div class="container">
        <div class="sidecon">
            <img src="cart7.jpg" alt="">
            <div class="header">
                <h3>Welcome to Heaton's Mart</h3>
                <p>Your Neighbourhood Grocers</p>
            </div>
        </div>

        <div class="login-form">
            <h1 class="title">Login</h1>
            <form method="post" action="">
                <div class="input">
                    <label>Username <span>* <?php echo $error_name; ?></span></label>
                    <input type="text" name="email" placeholder="Email">
                </div>
                <div class="input">
                    <label>Password<span>* <?php echo $error_password; ?></span></label>
                    <input type="password" name="userpassword" placeholder="password">
                </div>
                <div class="input">
                    <label>Role<span>* <?php echo $error_role; ?></span></label>
                    <select class="role" name="role">
                        <option value="">Select Role</option>
                        <option value="customer">Customer</option>
                        <option value="trader">Trader</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>
                <div class="check">

                    <div class="check-box">
                        <input type="checkbox" name="confirm">
                        <label>Remember me</label>
                    </div>

                    <a href="reset.php">Forget Password</a>
                </div>
                <div class="input">
                    <input type="submit" name="subLogin" value="Login">
                </div>
                <div class="link">
                    <p>
                        Not a member of Heaton's Mart?
                        <a href="../customer/customerSignup.php">Signup</a>
                    </p>
                    <div class="social">
                        <img src="../img/facebook.png" alt="" height="30px" width="30px">
                        <img src="../img/twitter.png" alt="" height="30px" width="30px">
                        <img src="../img/google.png" alt="" height="30px" width="30px">
                    </div>

                </div>
            </form>
        </div>
    </div>

</body>

</html>
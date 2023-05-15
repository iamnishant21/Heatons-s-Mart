<?php
session_start();
include("connection.php");
$error_name='';
if (isset($_POST['subReset'])) {
    if (empty($_POST['email'])) {
        $error_name = 'Email is required';
    }
    else{
    $email = $_POST['email'];
    
    $sql = 'SELECT * FROM "USER" WHERE EMAIL_ADDRESS = :t_email';

    $stid1 = oci_parse($conn, $sql);
    oci_bind_by_name($stid1,':t_email' ,$email);
    oci_execute($stid1);

    $data_email ='';

        while($row = oci_fetch_array($stid1,OCI_ASSOC)){
            $data_email = $row['EMAIL_ADDRESS'];
        }

        if($data_email === $email){
           
            $otp_number = rand(100000,999999);
            $sub ="Please Verify Your Email address";
            $message="Dear User, Your Verification Code is: $otp_number";  
        
            include('sendmail.php');
            $_SESSION['otp'] =$otp_number;
            $_SESSION['email'] =$email;
            header('location:otp.php');

        }
        else{
            $resgister_email="Email is already used";
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
    <title>Reset Password</title>
    <link rel="stylesheet" href="reset.css">
</head>

<body>
    <div class="container">
        <div class="reset">
            <h3>Reset Your Password</h3>
        <div form-data>
        <span><?php echo $error_name; ?></span>
            <form action="" method="POST">
                <div class="input">
                <label>Email address</label>
                    <input type="email" name="email" placeholder="Enter your email">
                    <input type="submit" name="subReset" value="send">
                <!-- <a href="otp.php">Send me reset instruction</a> -->
                </div>
                
                
                <div class="code">
                    <p>Don't need to reset? <a href="login.php">Sign in</a> or <a href="customer/customerSignup.php">Sign up</a></p>
                </div>
            </form>

        </div>
        </div>
        

    </div>


</body>

</html>
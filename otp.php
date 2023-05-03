<?php
session_start();
$errotp='';

if (isset($_POST['subOtp'])){
    $errotp='';
        $errcount=0;

        $otpnum =$_POST['otpnumber'];
        $otpnumber= (int)$otpnum;
        // echo $otpnumber;
        
        if(empty($_POST['otpnumber'])){
            $errcount+=1;
            $errotp ="OTP input field should not be empty";
        }
        if($otpnumber != $_SESSION['otp']){
            $errcount+=1;
            $errotp="OTP is INVALID";
        }
        
        if($errcount == 0 ){
           header('location:re-type.php');
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
            <h3>Confirm your otp code</h3>
        <div form-data>
            <form action="" method="POST">
                <div class="input">
                <label>OTP</label>
                <input type="number" name="otpnumber" placeholder="Enter otp code">
                <input type="submit" name="subOtp" value="Go">

                <!-- <a href="re-type.php">Go</a> -->
                </div>
            </form>

        </div>
        </div>
        

    </div>


</body>

</html>
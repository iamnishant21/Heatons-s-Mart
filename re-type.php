<?php
session_start();
include("connection.php");

$errcount =0;
$resgister_password='';
if (isset($_POST['subRetype'])){
    $reset_password =$_POST['newp'];
    $reset_cpassword =$_POST['cnewp'];
    $pattern = '/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/';
    if($reset_password == $reset_cpassword) {
        if (preg_match($pattern, $reset_password) == false) {
            $errcount += 1;
            $resgister_password = 'Password should be strong';

        }
        if ($errcount == 0) {
            $password = md5($reset_password);
        
            $sql = 'UPDATE "USER" SET PASSWORD = :password WHERE EMAIL_ADDRESS= :uemail';
            $stid = oci_parse($conn,$sql);
           oci_bind_by_name($stid, ':uemail', $_SESSION['email']);
           oci_bind_by_name($stid, ':password', $password);
          
           if(oci_execute($stid)){
               header('location:login.php');
           }
        }
    }
    else{
        $resgister_password = 'Password Does not match';

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
        <span><?php echo $resgister_password; ?></span>
            <form action="" method="POST">
                <div class="input">
                <input type="password" name="newp" placeholder="New Password">
                <input type="password" name="cnewp" placeholder="Confirm New Password">
                <input type="submit" name="subRetype" value="ok">



                <!-- <a href="login.php">OK</a> -->
                </div>
            </form>

        </div>
        </div>
        

    </div>


</body>

</html>
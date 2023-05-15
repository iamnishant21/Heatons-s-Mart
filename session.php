<?php
session_start();

if(isset($_SESSION['ID'])){
    $s_user = $_SESSION['ID'];
    $_SESSION['user_id']=$s_user['USER_ID'];
    $_SESSION['user_role']=$s_user['ROLE'];
    $_SESSION['user_type']=$s_user['CATEGORY'];

    if($_SESSION['user_role']==='customer'){
        // header('location:');
        echo"successfully connected to customer";
    }
    if($_SESSION['user_role'] === 'trader'){
        // header('location:trader/traderdashboard.php');
        echo"successfully connected to trader";

    }
    if($_SESSION['user_role'] === 'admin'){
        echo "successfully connected to admin";
    }


}
 ?>
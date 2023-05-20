<?php
session_start();
include('../connection.php');
    $role = 'customer';
    $sql = 'SELECT * FROM "USER" WHERE ROLE = :role AND EMAIL_ADDRESS = :email';
    $stmt = oci_parse($conn,$sql);
    oci_bind_by_name($stmt, ':role', $role);
    oci_bind_by_name($stmt, ':email', $_SESSION['email']);
    oci_execute($stmt);
    $row = oci_fetch_array($stmt);
    $user_id = $row['USER_ID'];

    unset($_SESSION['email']);

    $cart = 'INSERT INTO "CART" (USER_ID) VALUES(:user_id)';
    $stid = oci_parse($conn,$cart);
    oci_bind_by_name($stid, ':user_id', $user_id);
    oci_execute($stid);

    $wishlist = 'INSERT INTO "WISHLIST" (USER_ID) VALUES(:user_id)';
    $wishstmt = oci_parse($conn,$wishlist);
    oci_bind_by_name($wishstmt, ':user_id', $user_id);
    
    if(oci_execute($wishstmt)){
        header("location:../login.php");
    }
    

?>
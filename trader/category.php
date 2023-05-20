<?php
session_start();
include('../connection.php');
if(isset($_SESSION['category'])){
    $sql = 'INSERT INTO "PRODUCT_CATEGORY" (CATEGORY_NAME) VALUES (:category)';
    $stmt =oci_parse($conn,$sql);
    oci_bind_by_name($stmt,':category',$_SESSION['category']);

    if(oci_execute($stmt)){
        unset($_SESSION['category']);
        header('location:../login.php');
    }
}
?>
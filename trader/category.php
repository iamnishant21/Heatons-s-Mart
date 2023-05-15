<?php
session_start();
include('../connection.php');
if(isset($_SESSION['category'])){
    $noofitem = 0;
    $sql = 'INSERT INTO "PRODUCT_CATEGORY" (CATEGORY_NAME,NO_OF_PRODUCT) VALUES (:category,:item)';
    $stmt =oci_parse($conn,$sql);
    oci_bind_by_name($stmt,':category',$_SESSION['category']);
    oci_bind_by_name($stmt,':item',$noofitem);

    if(oci_execute($stmt)){
        unset($_SESSION['category']);
        header('location:../login.php');
    }
}
?>
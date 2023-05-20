<?php
session_start();

include("../../connection.php");
include_once 'payment.php';

if (isset($_GET['PayerID'])) {
    $payment_detail = "Paypal";
    
    $sqlorder = "SELECT op.*, p.*
    FROM ORDER_PRODUCT op
    JOIN PRODUCT p ON op.PRODUCT_ID = p.PRODUCT_ID
    WHERE op.ORDER_ID = :order_id";

    $order_stid = oci_parse($conn, $sqlorder);
    oci_bind_by_name($order_stid , ":order_id",$_SESSION['order_id'] );
    oci_execute($order_stid);
    while($row = oci_fetch_array($order_stid)){
        $order_qty = $row['ORDER_QUANTITY'];
        $product_id = $row['PRODUCT_ID'];
        $prodct_qty = $row['PRODUCT_STOCK'];

        $quantity = $prodct_qty -$order_qty;

        $update = "UPDATE PRODUCT SET PRODUCT_STOCK = :quantity WHERE PRODUCT_ID = :product_id";
        $stidupdate = oci_parse($conn,$update);
        oci_bind_by_name($stidupdate, ":quantity" ,$quantity);
        oci_bind_by_name($stidupdate , ":product_id" , $product_id);
        oci_execute($stidupdate);
    }


    $sql = "INSERT INTO PAYMENT (PAYMENT_AMOUNT, PAID_VIA,USER_ID,ORDER_ID) VALUES (:payment_amount,:paid_via,:user_id,:order_id)";
    $stmt = oci_parse($conn, $sql);
    oci_bind_by_name($stmt, ":payment_amount", $_SESSION['finalamount']);
    oci_bind_by_name($stmt, ":paid_via", $payment_detail);
    oci_bind_by_name($stmt, ":user_id", $_SESSION['user_ID']);
    oci_bind_by_name($stmt, ":order_id", $_SESSION['order_id']);
    

    if (oci_execute($stmt)) {
        header('location:http://localhost/group_project/team_project/Home/homepage.php');
    }

    echo "<script>alert('Payment has been Successfull')</script>";
} else {
    echo "<script>alert('Your Payment is Failed Please try again')</script>";
}
        
       
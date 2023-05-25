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

    $sql = "INSERT INTO PAYMENT (PAYMENT_AMOUNT, PAID_VIA, USER_ID, ORDER_ID) VALUES (:payment_amount,:paid_via,:user_id,:order_id)";
    $stmt = oci_parse($conn, $sql);
    oci_bind_by_name($stmt, ":payment_amount", $_SESSION['finalamount']);
    oci_bind_by_name($stmt, ":paid_via", $payment_detail);
    oci_bind_by_name($stmt, ":user_id", $_SESSION['user_ID']);
    oci_bind_by_name($stmt, ":order_id", $_SESSION['order_id']);
    
    oci_execute($stmt);
        
    
    $query= 'SELECT u.*,op.*,pr.*,o.*
            FROM "PAYMENT" p
            JOIN "ORDER" o ON o.ORDER_ID = p.ORDER_ID
            JOIN "ORDER_PRODUCT" op ON o.ORDER_ID = op.ORDER_ID
            JOIN "PRODUCT" pr ON op.PRODUCT_ID = pr.PRODUCT_ID
            JOIN "SHOP" s ON pr.SHOP_ID = s.SHOP_ID
            JOIN "USER" u ON s.USER_ID = u.USER_ID
            WHERE p.ORDER_ID = :order_id';

    $statement = oci_parse($conn, $query);
    oci_bind_by_name($statement, ':order_id', $_SESSION['order_id']);
    oci_execute($statement);
    
    // Fetch the result
    // $order_id=$_SESSION['order_id'];

    while ($row = oci_fetch_array($statement)) {
        $productprice=0;
        $email = $row['EMAIL_ADDRESS'];
        $username = $row['FIRSTNAME'] . " " . $row['LASTNAME'];
        $tuser_id = $row['USER_ID'];
        $product_id = $row['PRODUCT_ID'];
        $product_price = (int)$row['PRODUCT_PRICE'];
        $product_name = $row['PRODUCT_NAME'];
        $order_id = $row['ORDER_ID'];


        $rsql = 'INSERT INTO "REPORT" (PRODUCT_ID,USER_ID,ORDER_ID) VALUES (:product_id,:tuser_id,:order_id)';
        $stmt = oci_parse($conn, $rsql);
        oci_bind_by_name($stmt, ":product_id", $product_id);
        oci_bind_by_name($stmt, ":tuser_id", $tuser_id);
        oci_bind_by_name($stmt, ":order_id", $order_id);
        oci_execute($stmt);

        if(!empty($row['DISCOUNT_ID'])){
            $sql = 'SELECT * FROM "DISCOUNT" WHERE DISCOUNT_ID = :discount_id';
            $stmt= oci_parse($conn,$sql);
            oci_bind_by_name($stmt,":discount_id" , $row['DISCOUNT_ID']);
            oci_execute($stmt);
            $data = oci_fetch_array($stmt);
            $discount_per = (int)$data['DISCOUNT_PERCENT'];
            $productprice = $product_price - ($product_price * ($discount_per/100) );
        }
        else{
            $productprice = $product_price;
        }
        
        // echo $productprice;

    // Send the email
        $semail = $email;
        $head = "Invoice Payment Confirmation";
        $body = "
                   Dear $username,
   
                       This is to inform you that a payment of £ $productprice has been successfully received.
   
                   Thank you for your prompt payment.
   
   
                Heatons Mart
                 
                ";
       
        include('../../sendmail.php');
    }
     
    
    
    header('location:http://localhost/group_project/team_project/Home/homepage.php');
    
    
} else {
    echo "<script>alert('Your Payment is Failed Please try again')</script>";
}
        
       
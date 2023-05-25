<?php 
session_start();
include("../../connection.php");

$order_id=1065;

$query = 'SELECT u.*,op.*,pr.*
FROM "PAYMENT" p
JOIN "ORDER_PRODUCT" op ON p.ORDER_ID = op.ORDER_ID
JOIN "PRODUCT" pr ON op.PRODUCT_ID = pr.PRODUCT_ID
JOIN "SHOP" s ON pr.SHOP_ID = s.SHOP_ID
JOIN "USER" u ON s.USER_ID = u.USER_ID
WHERE p.ORDER_ID = :order_id';

$statement = oci_parse($conn, $query);
oci_bind_by_name($statement, ':order_id',$order_id);
oci_execute($statement);

// Fetch the result
// $order_id=$_SESSION['order_id'];

while ($row = oci_fetch_assoc($statement)) {
    $email  = $row['EMAIL_ADDRESS'];
    $tamount  = $row['PRODUCT_PRICE'];
    $tuser_id  = $row['USER_ID'];
    $product_id  = $row['PRODUCT_ID'];

    


$rsql = 'INSERT INTO "REPORT" (PRODUCT_ID,USER_ID,ORDER_ID) VALUES (:product_id,:tuser_id,:order_id)';
$stmt = oci_parse($conn, $rsql);
oci_bind_by_name($stmt, ":product_id", $product_id);
oci_bind_by_name($stmt, ":tuser_id", $tuser_id);
oci_bind_by_name($stmt, ":order_id", $order_id);
oci_execute($stmt);
}
 ?>
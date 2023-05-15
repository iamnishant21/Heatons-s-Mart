<?php
session_start();
include("../connection.php");

$product_id = $_GET['id'];
if(isset($_GET['quantity'])){
    $quantity = $_GET['quantity'];
}

$sql = "SELECT CART.CART_ID, WISHLIST.WISHLIST_ID 
FROM CART 
JOIN WISHLIST ON CART.USER_ID = WISHLIST.USER_ID 
WHERE CART.USER_ID = :user_id";

$stmt = oci_parse($conn, $sql);

oci_bind_by_name($stmt, ':user_id', $_SESSION['user_ID']);

oci_execute($stmt);

while ($row = oci_fetch_assoc($stmt)) {
    $cart_id = $row['CART_ID'];
    $wishlist_id = $row['WISHLIST_ID'];
}


if(isset($_GET['action'])){

    if($_GET['action'] == 'addcart' ){
        $stms = "SELECT * FROM CART_PRODUCT WHERE CART_ID = :cart_id AND PRODUCT_ID = :pid";
        $stmss = oci_parse($conn,$stms);
        oci_bind_by_name($stmss,":pid", $product_id);
        oci_bind_by_name($stmss,":cart_id", $cart_id);
        oci_execute($stmss);
        if(oci_fetch_array($stmss)){
            echo "Already In the Cart";
        }
        else{
            $sqlinst = "INSERT INTO CART_PRODUCT (CART_ID,PRODUCT_ID,QUANTITY) VALUES (:cart_id,:pid,:qty)";
            $stid = oci_parse($conn, $sqlinst);
            oci_bind_by_name($stid, ":cart_id", $cart_id);
            oci_bind_by_name($stid, ":pid", $product_id);
            oci_bind_by_name($stid, ":qty", $quantity);

            if(oci_execute($stid)){
                echo "Added Successfully in the cart ";
            }
        }
    }

    if($_GET['action'] == 'addwishlist' ){
        $stms = "SELECT * FROM WISHLIST_PRODUCT WHERE WISHLIST_ID = :wishlist_id AND PRODUCT_ID = :pid";
        $stmss = oci_parse($conn,$stms);
        oci_bind_by_name($stmss,":pid", $product_id);
        oci_bind_by_name($stmss,":wishlist_id",  $wishlist_id);
        oci_execute($stmss);
        if(oci_fetch_array($stmss)){
            echo "Already In the wishiist";
        }
        else{
            $sqlinst = "INSERT INTO WISHLIST_PRODUCT (WISHLIST_ID,PRODUCT_ID) VALUES (:wishlist_id,:pid)";
            $stid = oci_parse($conn, $sqlinst);
            oci_bind_by_name($stid, ":wishlist_id", $wishlist_id);
            oci_bind_by_name($stid, ":pid", $product_id);

            if(oci_execute($stid)){
                echo "Added Successfully in the wishlist ";
            }
        }
    }


}
?>
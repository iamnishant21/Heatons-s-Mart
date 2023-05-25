<?php
include("connection.php");

if (!empty($_SESSION['cart']) ) {
    if ($_SESSION['user_ID']) {
        $sqlquery = "SELECT CART.CART_ID FROM CART WHERE CART.USER_ID = :user_id";

        $stmt = oci_parse($conn, $sqlquery);

        oci_bind_by_name($stmt, ':user_id', $_SESSION['user_ID']);

        oci_execute($stmt);

        while ($row = oci_fetch_assoc($stmt)) {
            $cart_id = $row['CART_ID'];
        }

        foreach ($_SESSION['cart'] as $key => $value) {
            $product_id = $value['product_id'];
            $quantity = $value['product_quantity'];

            $sql = "INSERT INTO CART_PRODUCT(CART_ID,PRODUCT_ID,QUANTITY) VALUES (:cart_id,:pid,:qty)";
            $stid = oci_parse($conn, $sql);
            oci_bind_by_name($stid, ":cart_id", $cart_id);
            oci_bind_by_name($stid, ":pid", $product_id);
            oci_bind_by_name($stid, ":qty", $quantity);
            oci_execute($stid);
        }

        unset($_SESSION['cart']);

    }
}

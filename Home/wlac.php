<?php
session_start();
include('../connection.php');

//reveiving data from add to cart button
$product_id = $_GET['id'];
if(!empty($_GET['quantity'])){
    $quantity = $_GET['quantity'];
}

// add to cart
if ($_GET['action'] == 'addcart') {
    
    if (empty($_SESSION['cart'])) {
        $_SESSION['cart'][] = array('product_id' => $product_id, 'product_quantity' => $quantity);
        echo "Added to Cart";
    } else {
        $product_check = array_column($_SESSION['cart'], 'product_id');

        if (in_array($product_id, $product_check)) {
            echo "Already added to Cart";
        } else {
            $_SESSION['cart'][] = array('product_id' => $product_id, 'product_quantity' => $quantity);
            echo "Added to Cart";
        }
    }
}


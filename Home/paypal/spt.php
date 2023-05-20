<?php
session_start();
include("connection.php");

// Query the database
$query = "SELECT PAYMENT_AMOUNT FROM PAYMENT WHERE ORDER_ID = :order_id";
$statement = oci_parse($conn, $query);
oci_bind_by_name($statement, ':order_id', $_SESSION['order_id']);
oci_execute($statement);

// Fetch the result
if ($row = oci_fetch_assoc($statement)) {
    $amount = $row['PAYMENT_AMOUNT'];

    // Send the email
    
    $_SESSION['order_id']==;
}

// Close the database connection
oci_free_statement($statement);
oci_close($conn);
?>

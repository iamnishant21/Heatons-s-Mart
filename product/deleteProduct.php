<?php
  include('../connection/connection.php');

    if(isset($_GET['id']) && isset($_GET['action'])){
        $delid = $_GET['id'];

        $sql = "DELETE FROM PRODUCT WHERE PRODUCT_ID = :id";
        
        $stid = oci_parse($conn,$sql);

        oci_bind_by_name($stid,':id', $delid);

        if(oci_execute($stid)){
            header("location:product_list.php");
        }
    }
?>

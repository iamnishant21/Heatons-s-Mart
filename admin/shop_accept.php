<?php
    session_start();
    include("../connection.php");

    if(isset($_GET['id']) && isset($_GET['action'])){
        $id = $_GET['id'];
        $action = $_GET['action'];

        $sql = 'UPDATE "SHOP" SET SHOP_STATUS = :verify WHERE SHOP_ID = :id';
        $stid = oci_parse($conn,$sql);
        oci_bind_by_name($stid, ':verify' ,$action);
        oci_bind_by_name($stid, ':id' ,$id);

        if(oci_execute($stid)){
            header('location:shop_list.php');
        }
    }

?>
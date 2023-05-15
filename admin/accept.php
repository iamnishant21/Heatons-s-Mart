<?php
    session_start();
    include("../connection.php");

    if(isset($_GET['id']) && isset($_GET['action'])){
        $id = $_GET['id'];
        $action = $_GET['action'];

        $sqlq = 'SELECT * FROM "USER" WHERE USER_ID = :id'; // selecting the all data from the user
        $stmt = oci_parse($conn,$sqlq);
        oci_bind_by_name($stmt, ":id" ,$id);
        // exeucuting the query
        oci_execute($stmt);
        while($row=oci_fetch_array($stmt,OCI_ASSOC)){
            $fname = $row['FIRSTNAME'];
            $lname=$row['LASTNAME'];
            $email = $row['EMAIL_ADDRESS'];
        }
        $username = $fname." ".$lname;

        $sql = 'UPDATE "USER" SET STATUS = :verify WHERE USER_ID = :id';
        $stid = oci_parse($conn,$sql);
        oci_bind_by_name($stid, ':verify' ,$action);
        oci_bind_by_name($stid, ':id' ,$id);
        
        $femail =$email;

        if($_GET['action'] == 'verified'){
            $sub ="Notification from Heatons Mart";
            $message="Dear ".$username.",\nYou are successfully registered as Trader in Heatons Mart.";
        }
        else if ($_GET['action'] == 'waiting'){   
            $sub ="Notification form Heatons Mart";
            $message="Dear ".$username.",\nYour are Deactivated.";
            
        }
                  
        include_once('../sendmail.php');

        if(oci_execute($stid)){
            header('location:trader_list.php');
        }
    }

?>
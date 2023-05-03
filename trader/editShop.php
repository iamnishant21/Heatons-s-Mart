<?php
// Connect to Oracle database
include("../connection.php");

// Check if product_id is set
if (isset($_GET['shop_id'])&& isset($_GET['action'])) {
    // Get the product_id from the URL parameter
    $editP = $_GET['shop_id']; 
    $sql = 'SELECT * FROM "SHOP" WHERE SHOP_ID = :id';
    $stid = oci_parse($conn,$sql);
            oci_bind_by_name($stid, ':id' ,$editP);
            oci_execute($stid);
}
    $eid = $eshopname =$eaddress =$ephonenumber =  $ecategory ='';
    while($row = oci_fetch_array($stid, OCI_ASSOC)){
        $eid = $row['SHOP_ID'];
        $eshopname = $row['SHOP_NAME'];
        $eaddress = $row['SHOP_ADDRESS'];
        $ephonenumber = $row['SHOP_PHONENUMBER'];
        $ecategory = $row['SHOP_CATEGORY'];
        
    }   

       
   
    
    // Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the product data from the form
    $shop_id = $_POST['sid'];
    $shop_name = $_POST['sname'];
    $shop_address = $_POST['saddress'];
    $shop_phonenumber = $_POST['sphonenumber'];
    $shop_category = $_POST['scategory'];

    // Prepare the UPDATE query
    $query = "UPDATE SHOP SET SHOP_NAME = :shop_name, SHOP_ADDRESS = :shop_address, SHOP_PHONENUMBER = :shop_phonenumber, SHOP_CATEGORY = :shop_category WHERE SHOP_ID = :id";

    // Prepare the statement
    $stmt = oci_parse($conn, $query);

    // Bind the parameters
    oci_bind_by_name($stmt, ":shop_name", $shop_name);
    oci_bind_by_name($stmt, ":shop_address", $shop_address);
    oci_bind_by_name($stmt, ":shop_phonenumber", $shop_phonenumber);
    oci_bind_by_name($stmt, ":shop_category", $shop_category);
    oci_bind_by_name($stmt, ":id", $shop_id);


    // Execute the statement
    $result=oci_execute($stmt);
    if($result){
        header('location:shop_list.php');
    }

    // // Free the statement
    // oci_free_statement($stmt);
} 
 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>edit product</title>
    <link rel="stylesheet" href="aps.css">

</head>
<body>
<?php
        include('traderheader.php');

     ?>
 <!-- Display the form with the current product data -->
        <div class="addproduct">
        <form method='POST' action=''>

            <legend>Update Shop:</legend>
            <div class="part1">
                
                <div class="part2">
                    <div class="data">
                    <input type='hidden'  name='sid' value="<?php echo"$eid"; ?>" >
                        <label>Shop Name :</label>
                        <input type='text' name='sname' value="<?php echo"$eshopname"; ?>" >
                        <label>Shop Address :</label>
                        <input type='text' name='saddress' value="<?php echo"$eaddress"; ?>" >
                    </div>
    
                    <div class="price">
                        <label>Shop Phonenumber :</label>
                        <input type='number' name='sphonenumber' value="<?php echo"$ephonenumber"; ?>">
                    </div>

                    <div class="price">
                        <label>Category:</label>
                        <input type="text" name="scategory" value="<?php echo"$ecategory"; ?>">
                    </div>
                    <div class="btn">
                        <input type='submit' name='updateShop' value='submit'>
                    </div>
                </div>
            </div>
    </div>

</body>
</html>
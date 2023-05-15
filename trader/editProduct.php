<?php
// Connect to Oracle database
include("../connection.php");

// Check if product_id is set
if (isset($_GET['product_id'])&& isset($_GET['action'])) {
    // Get the product_id from the URL parameter
    $editP = $_GET['product_id']; 
    $sql = 'SELECT * FROM "PRODUCT" WHERE PRODUCT_ID = :id';
    $stid = oci_parse($conn,$sql);
            oci_bind_by_name($stid, ':id' ,$editP);
            oci_execute($stid);
}
    $eid = $ename =$ecategory =$edescription =  $eallergy = $eprice =$equantity = '';
    while($row = oci_fetch_array($stid, OCI_ASSOC)){
        $eid = $row['PRODUCT_ID'];
        $ename = $row['PRODUCT_NAME'];
        $ecategory = $row['PRODUCT_CATEGORY'];
        $edescription = $row['PRODUCT_DESCRIPTION'];
        $eallergy = $row['ALLERGY_INFORMATION'];
        $eprice = $row['PRODUCT_PRICE'];
        $equantity = $row['PRODUCT_QUANTITY'];
    }   

       
   
    
    // Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the product data from the form
    $product_id = $_POST['pid'];
    $product_name = $_POST['pname'];
    $product_category = $_POST['pcategory'];
    $product_price = $_POST['pprice'];
    $product_quantity = $_POST['pquantity'];

    // Prepare the UPDATE query
    $query = "UPDATE PRODUCT SET PRODUCT_NAME = :product_name, PRODUCT_CATEGORY = :product_category, PRODUCT_PRICE = :product_price, PRODUCT_QUANTITY = :product_quantity WHERE PRODUCT_ID = :id";

    // Prepare the statement
    $stmt = oci_parse($conn, $query);

    // Bind the parameters
    oci_bind_by_name($stmt, ":product_name", $product_name);
    oci_bind_by_name($stmt, ":product_category", $product_category);
    oci_bind_by_name($stmt, ":product_price", $product_price);
    oci_bind_by_name($stmt, ":product_quantity", $product_quantity);
    oci_bind_by_name($stmt, ":id", $product_id);


    // Execute the statement
    $result=oci_execute($stmt);
    if($result){
        header('location:product_list.php');
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
    <link rel="stylesheet" href="useredit.css">

</head>
<body>
<?php
        include('traderheader.php');

     ?>
 <!-- Display the form with the current product data -->
        <div class="addproduct">
        <form method='POST' action='' enctype='multipart/form-data'>

            <legend>Update Product:</legend>
            <div class="part1">
                
                <div class="part2">
                    <div class="data">
                    <input type='hidden'  name='pid' value="<?php echo"$eid"; ?>" >

                        <label>Product Name :</label>
                        <input type='text' name='pname' value="<?php echo"$ename"; ?>" >
                        <label>Category:</label>
                        <select name="pcategory">
                            <option value='<?php echo"$ecategory"; ?>'><?php echo"$ecategory"; ?></option>
                        </select>
                    </div>
                    <div class="desc">
                        <label>Description:</label>
                        <textarea name="description" id="d"  ><?php echo"$edescription"; ?></textarea>

                        <label>Allergy information:</label>
                        <textarea name="allergy" id="a"><?php echo"$eallergy"; ?></textarea>
                    </div>
                    <div class="price">
                        <label>Price :</label>
                        <input type='text' name='pprice' value="<?php echo"$eprice"; ?>">
                        <label>Quantity:</label>
                        <input type="text" name="pquantity" value="<?php echo"$equantity"; ?>">
                    </div>
                    <input type='submit' name='updateproduct' value='submit'>
                </div>
            </div>
    </div>

</body>
</html>
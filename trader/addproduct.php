<?php
session_start();
    include("../connection.php");


if (isset($_POST['subproduct'])) {
    // Get the form data
    $pname = $_POST['pname'];
    $pcategory_id = $_POST['categoryid'];
    $discount_id = $_POST['discountid'];
    $description = $_POST['description'];
    $allergy = $_POST['allergy'];
    $pprice = $_POST['pprice'];
    $pquantity = $_POST['pquantity'];
    $pstock = $_POST['stock'];
    $shop_id=$_POST['shopname'];
    $image = $_FILES["image"]["name"];

    // Upload the product image
    $utmpname = $_FILES['image']['tmp_name'];
    $ulocation = "uploads/".$image;
    $utype = $_FILES['image']['type'];
    if($utype=="image/jpeg" || $utype=="image/jpg" || $utype=="image/png" || $utype=="image/gif" ||$utype=="image/jfif")
        {
    // Prepare the SQL statement
    $verify='waiting';
    $sql = 'INSERT INTO "PRODUCT" (PRODUCT_NAME,PRODUCT_CATEGORY,DISCOUNT_ID,PRODUCT_DESCRIPTION,ALLERGY_INFORMATION,PRODUCT_PRICE,PRODUCT_QUANTITY,PRODUCT_STOCK,PRODUCT_IMAGE,CATEGORY_ID,SHOP_ID,PRODUCT_STATUS) 
            VALUES (:pname, :pcategory, :pdiscountid, :description, :allergy, :pprice, :pquantity, :pstock, :image,:category_id,:pshop,:P_verify)';

    // Parse the SQL statement
    $stmt = oci_parse($conn, $sql);

    // Bind the parameters
    oci_bind_by_name($stmt, ':pname',$pname);
    oci_bind_by_name($stmt, ':pcategory', $_SESSION['category']);
    oci_bind_by_name($stmt, ':pdiscountid', $discount_id);

    oci_bind_by_name($stmt, ':description', $description);
    oci_bind_by_name($stmt, ':allergy', $allergy);
    oci_bind_by_name($stmt, ':pprice', $pprice);
    oci_bind_by_name($stmt, ':pquantity', $pquantity);
    oci_bind_by_name($stmt, ':pstock', $pstock);
    oci_bind_by_name($stmt, ':image', $image);
    oci_bind_by_name($stmt, ':category_id', $pcategory_id);
    oci_bind_by_name($stmt, ':pshop', $shop_id);
    oci_bind_by_name($stmt,':P_verify',$verify);


    // Execute the statement
    $res = oci_execute($stmt);

    if ($res){
        if(move_uploaded_file($utmpname,$ulocation))
            // echo "File uploaded";
            header('location:product_list.php');
        else    
            echo "Unable to insert file";
    }


    // Clean up
    oci_free_statement($stmt);
    oci_close($conn);
}
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>addproduct</title>
    <link rel="stylesheet" href="aps.css">
</head>

<body>
<?php
        include('traderheader.php');
     ?>
    <div class="addproduct">
        <form method='POST' action='' enctype='multipart/form-data'>

            <legend><input type='submit' name='subproduct' value='submit'></legend>
            <div class="part1">
                <div class="addimg">
                
                    <label>Image :</label>
                    <input type='file' name='image'>

                    
                </div>
                
                <div class="part2">
                    <div class="data">
                        <label>Product Name :</label>
                        <input type='text' name='pname'>
                        <label>Category:</label>
                        <select  name="categoryid">

                            <?php
                                 $sql = 'SELECT * FROM "PRODUCT_CATEGORY" WHERE CATEGORY_NAME = :cat_name';
                                 $stid = oci_parse($conn, $sql);
                                 oci_bind_by_name($stid, ':cat_name', $_SESSION['category']);
                                 oci_execute($stid);
     
                                 while ($row = oci_fetch_array($stid, OCI_ASSOC)) {
                                 echo "<option value=" . $row['CATEGORY_ID'] . ">" .  $row['CATEGORY_NAME']. "</option>";
                                 }
    
                            ?>

                        </select>

                        <label>DISCOUNT : </label>
                        <select class="inputbox" name="discountid">
                        <option value="">Select discount type</option>
                        <?php
                            $sql = "SELECT * FROM DISCOUNT";
                            $stid = oci_parse($conn, $sql);
                            oci_execute($stid);

                            while ($row = oci_fetch_array($stid, OCI_ASSOC)) {
                            echo "<option value=".$row['DISCOUNT_ID'].">" . $row['DISCOUNT_DESC'] .'('.
                             $row['DISCOUNT_PERCENT'] . "%)</option>";
                            }
                       ?>
                        </select>

                    </div>
                    
                    <div class="desc">
                        <label>Description:</label>
                        <textarea name="description" id="d"></textarea>

                        <label>Allergy information:</label>
                        <textarea name="allergy" id="a"></textarea>
                    </div>
                    <div class="price">
                        <label>Price :</label>
                        <input type='number' name='pprice'>
                        <label>Quantity:</label>
                        <input type="number" name="pquantity">
                    </div>
                    <div class="price">
                        <label>Stock:</label>
                        <input type="number" name="stock">

                        <label>Shop:</label> 
                         <select name="shopname">
                            <option value="">Please Select Shop</option>
                             <?php
                            $sql = 'SELECT * FROM "SHOP" WHERE USER_ID = :user_id';
                            $stid = oci_parse($conn, $sql);
                            oci_bind_by_name($stid, ':user_id', $_SESSION['trader_ID']);
                            oci_execute($stid);

                            while ($row = oci_fetch_array($stid, OCI_ASSOC)) {
                            echo "<option value=" . $row['SHOP_ID'] . ">" . $row['SHOP_NAME'] . "</option>";
                            }

                            ?>
                         </select>

                        
                    </div>
                </div>

            </div>
        </form>
    </div>

    
    </div>

</body>

</html>
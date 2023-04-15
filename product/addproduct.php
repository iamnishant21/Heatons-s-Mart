<?php
    include("../connection/connection.php");


if (isset($_POST['subproduct'])) {
    // Get the form data
    $pname = $_POST['pname'];
    $pcategory = $_POST['pcategory'];
    $description = $_POST['description'];
    $allergy = $_POST['allergy'];
    $pprice = $_POST['pprice'];
    $pquantity = $_POST['pquantity'];
    $pweight = $_POST['pweight'];
    $image = $_FILES["image"]["name"];

    // Upload the product image
    $utmpname = $_FILES['image']['tmp_name'];
    $ulocation = "uploads/".$image;
    $utype = $_FILES['image']['type'];
    if($utype=="image/jpeg" || $utype=="image/jpg" || $utype=="image/png" || $utype=="image/gif" ||$utype=="image/jfif")
        {
    // Prepare the SQL statement
    $sql = "INSERT INTO PRODUCT (PRODUCT_NAME,PRODUCT_CATEGORY,PRODUCT_DESCRIPTION,ALLERGY_INFORMATION,PRODUCT_PRICE,PRODUCT_QUANTITY,PRODUCT_WEIGHT,PRODUCT_IMAGE) 
            VALUES (:pname, :pcategory, :description, :allergy, :pprice, :pquantity, :pweight, :image)";

    // Parse the SQL statement
    $stmt = oci_parse($conn, $sql);

    // Bind the parameters
    oci_bind_by_name($stmt, ':pname', $pname);
    oci_bind_by_name($stmt, ':pcategory', $pcategory);
    oci_bind_by_name($stmt, ':description', $description);
    oci_bind_by_name($stmt, ':allergy', $allergy);
    oci_bind_by_name($stmt, ':pprice', $pprice);
    oci_bind_by_name($stmt, ':pquantity', $pquantity);
    oci_bind_by_name($stmt, ':pweight', $pweight);
    oci_bind_by_name($stmt, ':image', $image);

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
    <link rel="stylesheet" href="ap.css">
</head>

<body>
    <div class="addproduct">
        <form method='POST' action='' enctype='multipart/form-data'>

            <legend>Add Products:</legend>
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
                        <select name="pcategory">
                            <option value=''>Category</option>
                            <option value='Bakrey'>Bakrey</option>
                            <option value='Butcher'>Butcher</option>
                            <option value='Greengroccer'>Green Groccer</option>
                            <option value='Fishmonger'>Fish monger</option>
                            <option value='delicatessens'>delicatessens</option>
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
                        <input type='text' name='pprice'>
                        <label>Quantity:</label>
                        <input type="text" name="pquantity">
                    </div>
                    <div class="price">
                        <label>Weight:</label>
                        <input type="text" name="pweight">
                    </div>
                    <div class="btn">
                        <input type='submit' name='subproduct' value='submit'>
                    </div>
                </div>
            </div>
    </div>

    </form>
    </div>

</body>

</html>
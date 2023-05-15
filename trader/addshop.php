<?php
session_start();
    include("../connection.php");

    $error_count = 0;
    $error_messege='';
if (isset($_POST['subShop'])) {
    // Get the form data
    $shop_name = $_POST['sname'];
    $shop_address = $_POST['saddress'];
    $shop_phonenumber = $_POST['sphonenumber'];
    $shop_category = $_POST['scategory'];
    $shop_description = $_POST['sdescription'];

    if(strlen($shop_phonenumber) < 10 || strlen($shop_phonenumber) > 10){
        $error_count+=1;
        $error_messege = "10 digits are required";
    }
    if(!preg_match("/^9[0-9]{9}$/", $shop_phonenumber)){
        $error_count+=1;
        $error_messege = "Enter valid phonenumber";
    } 
    
    $sql = 'SELECT * FROM "SHOP" WHERE SHOP_NAME= :HSHOPNAME';
            $stid1 = oci_parse($conn,$sql);
            oci_bind_by_name($stid1 , ":HSHOPNAME" ,$shop_name);

            oci_execute($stid1);
            $shop_data ='';

            while($row = oci_fetch_array($stid1,OCI_ASSOC)){
              $shop_data = $row['SHOP_NAME'];
            }

            if($shop_data == $shop_name){
              $error_count+=1;
              $error_messege="This Name is Already exists";
            }

            if($error_count == 0)  {
               

                // echo $user_id;
                    $sql = 'INSERT INTO "SHOP" (SHOP_NAME,SHOP_ADDRESS,SHOP_PHONENUMBER,SHOP_CATEGORY,SHOP_DESCRIPTION,USER_ID) 
                        VALUES (:SHOP_NAME,:HSHOP_ADDRESS,:HPHONE_NUMBER,:HCATEGORY,:HDESCRIPTION,:user_id)';

                    $stid = oci_parse($conn,$sql);
                    
                    // oci_bind_by_name($stid ,':HSHOP_ID',$shop_id);  
                    oci_bind_by_name($stid, ':HUSER_ID', $_SESSION['ID']);            
                    oci_bind_by_name($stid ,':SHOP_NAME',$shop_name);
                    oci_bind_by_name($stid ,':HSHOP_ADDRESS',$shop_address);
                    oci_bind_by_name($stid ,':HPHONE_NUMBER',$shop_phonenumber);
                    oci_bind_by_name($stid ,':HCATEGORY',$shop_category);
                    oci_bind_by_name($stid ,':HDESCRIPTION',$shop_description);
                    oci_bind_by_name($stid ,':user_id',$_SESSION['trader_ID']);

                    if(oci_execute($stid)){
                        header('location:shop_list.php');

                }   
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
        <form method='POST' action=''>

            <legend>Add Shop:</legend>
            <span class="error"> <?php echo $error_messege ; ?> </span>
            <div class="part1">
                <div class="part2">
                    <div class="data">
                        <label>Shop Name :</label>
                        <input type='text' name='sname'>

                        <label>Shop Category :</label>
                        <select  name="scategory">
                            <option value="<?php echo $_SESSION['category']; ?>"><?php echo $_SESSION['category']; ?></option>
                        </select>  
                    </div>
                    <div class="data">
                        <label>Shop Address :</label>
                        <input type='text' name='saddress'>
                    </div>
                    <div class="price">
                        <label>Shop Phonenumber :</label>
                        <input type='number' name='sphonenumber'>
                    </div>

                    
                    <div class="desc">
                        <label>Shop Description:</label>
                        <textarea name="sdescription" id="d"></textarea>
                    </div>
                    <input type='submit' name='subShop' value='submit'>
                </div>
            </div>
    </div>

    </form>
    </div>

</body>

</html>
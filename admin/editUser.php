<?php
// Connect to Oracle database
include("../connection/connection.php");

// Check if user_id is set
if (isset($_GET['user_id'])&& isset($_GET['action'])) {
    // Get the user_id 
    $editU = $_GET['user_id']; 
    $sql = 'SELECT * FROM "USER" WHERE USER_ID = :id';
    $stid = oci_parse($conn,$sql);
            oci_bind_by_name($stid, ':id' ,$editU);
            oci_execute($stid);
}
    $eid = $efname = $elname = $erole =  $eemail_add = $egender = '';
    while($row = oci_fetch_array($stid, OCI_ASSOC)){
        $eid = $row['USER_ID'];
        $efname = $row['FIRSTNAME'];
        $elname = $row['LASTNAME'];
        $erole = $row['ROLE'];
        $eemail_add = $row['EMAIL_ADDRESS'];
        $egender = $row['GENDER'];
    }   

       
   
    
    // Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the product data
    $user_id = $_POST['uid'];
    $user_fname = $_POST['fname'];
    $user_lname = $_POST['lname'];
    $user_role = $_POST['urole'];
    $user_email = $_POST['uemail'];
    $user_gender = $_POST['ugender'];

    // Prepare the UPDATE query
    $query = 'UPDATE "USER" SET FIRSTNAME = :U_Fname, LASTNAME = :U_Lname, ROLE = :U_Role, EMAIL_ADDRESS = :U_Email, GENDER = :U_Gender WHERE USER_ID = :id';

    // Prepare the statement
    $stmt = oci_parse($conn, $query);

    // Bind the parameters
    oci_bind_by_name($stmt, ":U_Fname", $user_fname);
    oci_bind_by_name($stmt, ":U_Lname", $user_lname);
    oci_bind_by_name($stmt, ":U_Role", $user_role);
    oci_bind_by_name($stmt, ":U_Email", $user_email);
    oci_bind_by_name($stmt, ":U_Gender", $user_gender);
    oci_bind_by_name($stmt, ":id", $user_id);



    // Execute the statement
    $result=oci_execute($stmt);
    if($result){
        header('location:user_list.php');
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
    <title>edit user</title>
    <link rel="stylesheet" href="ul.css">

</head>
<body>
 <!-- Display the form with the current product data -->
        <form method='POST' action='' enctype='multipart/form-data'>

            <legend>Update User:</legend>
            <div class="part1">
                
                <div class="part2">
                    <div class="data">
                    <input type='hidden'  name='uid' value="<?php echo"$eid"; ?>" >

                        <label>First Name :</label>
                        <input type='text' name='fname' value="<?php echo"$efname"; ?>" >
                        <label>Last Name :</label>
                        <input type='text' name='lname' value="<?php echo"$elname"; ?>" >
                    </div>
                    <div class="desc">
                    <label>Role :</label>
                        <input type='text' name='urole' value="<?php echo"$erole"; ?>" >
                        <label>EMAIL_ADDRESS :</label>
                        <input type='text' name='uemail' value="<?php echo"$eemail_add"; ?>" >

                    </div>
                    <div class="price">
                        <label>GENDER :</label>
                        <input type='text' name='ugender' value="<?php echo"$egender"; ?>">

                    </div>
                    <div class="btn">
                        <input type='submit' name='updateproduct' value='submit'>
                    </div>
                </div>
            </div>
    </div>

</body>
</html>
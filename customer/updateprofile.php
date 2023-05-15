<?php
include('../connection.php');
  // update profile
  if(isset($_POST['cButton'])){
    $c_fname = $_POST['cfirstname'];
    $c_lname = $_POST['clastname'];
    $c_email = $_POST['cemail'];
    $c_gender = $_POST['cgender'];
    $c_dob = $_POST['cdob'];
    $c_phonenumber = $_POST['cphonenumber'];
    $c_address = $_POST['caddress'];

    $prevImage = $_POST['prevImage'];

    $image = $_FILES["profileImage"]["name"];
    $utmpname = $_FILES['profileImage']['tmp_name'];
    $utype = $_FILES['profileImage']['type'];
    $user = 120;
    $ulocation = "uploads/".$image;

    if($utype=="image/jpeg" || $utype=="image/jpg" || $utype=="image/png" || $utype=="image/gif" ||$utype=="image/jfif")
        {
    // Prepare the SQL statement
    $contact = (int)$c_phonenumber;

    if(!empty($image)){ 
      $sql = 'UPDATE USER SET FIRSTNAME = :cfname, LASTNAME = :clname, EMAIL_ADDRESS = :cemail, GENDER = :cgender, DATE_OF_BIRTH = :cdob, PHONE_NUMBER = :cphone, ADDRESS = :caddress, USER_IMAGE = :cimage WHERE USER_ID = :id';

       // Parse the SQL statement
        $stmt = oci_parse($conn, $sql);
        
        // Bind the parameters
        // oci_bind_by_name($stid, ':id' , $_SESSION['user_ID'] );
        oci_bind_by_name($stmt, ':id' , $user );
        oci_bind_by_name($stmt, ':cfname', $c_fname);
        oci_bind_by_name($stmt, ':clname', $c_lname);
        oci_bind_by_name($stmt, ':cemail', $c_email);
        oci_bind_by_name($stmt, ':cgender', $c_gender);
        oci_bind_by_name($stmt, ':cdob', $c_dob);
        oci_bind_by_name($stmt, ':cphone', $contact);
        oci_bind_by_name($stmt, ':caddress', $c_address);
        oci_bind_by_name($stmt, ':cimage', $image);
        $res = oci_execute($stmt);

        if ($res){
        if(move_uploaded_file($utmpname,$ulocation)){
          header('location:customerprofile.php');
        }
        else{
          echo "Unable to insert file";
        }     
      }
    }else{
      $sql = 'UPDATE "USER" SET FIRSTNAME = :cfname, LASTNAME = :clname, EMAIL_ADDRESS = :cemail, GENDER = :cgender, DATE_OF_BIRTH = :cdob, PHONE_NUMBER = :cphone, ADDRESS = :caddress, USER_IMAGE = :cpimage WHERE USER_ID = :id';
       // Parse the SQL statement
        $stmt = oci_parse($conn, $sql);
       
        // Bind the parameters
        // oci_bind_by_name($stid, ':id' , $_SESSION['user_ID'] );
        oci_bind_by_name($stmt, ':id' , $user );
        oci_bind_by_name($stmt, ':cfname', $c_fname);
        oci_bind_by_name($stmt, ':clname', $c_lname);
        oci_bind_by_name($stmt, ':cemail', $c_email);
        oci_bind_by_name($stmt, ':cgender', $c_gender);
        oci_bind_by_name($stmt, ':cdob', $c_dob);
        oci_bind_by_name($stmt, ':cphone', $contact);
        oci_bind_by_name($stmt, ':caddress', $c_address);
        oci_bind_by_name($stmt, ':cpimage', $prevImage);
        $res = oci_execute($stmt);
        if ($res){
            header('location:customerprofile.php');
        }
    }
    

    // Execute the statement
    
  }
    
}
?>
<?php
// Always set content-type when sending HTML email
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

// More headers
$headers .= 'From: <dellinspiron100000@gmail.com>' . "\r\n";
$headers .= 'Cc: iammukeshious@gmail.com' . "\r\n";

if(mail("iammukeshious@gmail.com","hi","hello this mail is from local host")){
    echo"mail is send";
}
else{
  echo"yunik is good boy";
}
?>
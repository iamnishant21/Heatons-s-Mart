<?php

    $to      = $email;
    $subject = $sub;
    $message = $message;
    $headers = 'From: dellinspiron100000@gmail.com' . "\r\n" .'Reply-To: dellinspiron100000@gmail.com';
    
    $mail_sent = mail($to, $subject, $message, $headers);

    if(!$mail_sent){
        echo "mail send failed";
    }
    
?>
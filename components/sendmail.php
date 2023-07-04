<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require 'PHPMailer/src/Exception.php';
    require 'PHPMailer/src/PHPMailer.php';
    require 'PHPMailer/src/SMTP.php';

    function sendMail($recipientEmail, $recipientName, $subject, $body)
    {
        // Create a new PHPMailer instance
        $mail = new PHPMailer;

        // Set up SMTP
        $mail->isSMTP();
        $mail->Host = 'smtp.zoho.eu'; 
        $mail->SMTPAuth = true;
        $mail->Username = 'YOUR EMAIL';  
        $mail->Password = 'YOUR EMAIL PASSWORD'; 
        $mail->SMTPSecure = 'ssl'; 
        $mail->Port = 465;  

        // Set up the email
        $mail->setFrom('YOUR EMAIL', 'Shopping List Admin');
        $mail->addAddress($recipientEmail, $recipientName);
        $mail->Subject = $subject;
        $mail->Body = $body;

        // Send the email
        if (!$mail->send()) {
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        }
    }
?>
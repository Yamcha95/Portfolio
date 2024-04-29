<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
//use src\SMTP;
//use src\Exception;
require_once("src/PHPMailer.php");
require_once("src/SMTP.php");
//Load Composer's autoloader

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->SMTPDebug = SMTP::DEBUG_OFF;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
  //  $mail->Host       = 'smtp.example.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = "no-reply@my-intranet.fr";                     //SMTP username
    $mail->Password   = "Factit007";                            //SMTP password
//    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
    $mail->Host = 'ssl0.ovh.net';

    //Recipients
    $mail->setFrom('beghdadimehdi95@gmail.com', 'Mailer');
    $mail->addAddress('beghdadimehdi95@gmail.com', 'Mehdi Beghdadi');     //Add a recipient


    //Attachments
    //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML

    $mail->Subject = 'Subject';
    $mail->Body  = 'Message <b>in bold!</b>';
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
    echo 'Message has been sent';
} catch (Error $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}

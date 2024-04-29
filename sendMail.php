<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
//use src\SMTP;
//use src\Exception;
require_once("PHPMailer/src/PHPMailer.php");
require_once("PHPMailer/src/SMTP.php");
//Load Composer's autoloader

$message = $_POST["message"];
$subject = $_POST["subject"];
$name = $_POST["name"];
$email = $_POST["email"];
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
    $mail->setFrom("no-reply@my-intranet.fr", 'CONTACT DEPUIS PORTFOLIO ');
    $mail->addAddress('beghdadimehdi95@gmail.com', 'Mehdi Beghdadi');     //Add a recipient


    //Attachments
    //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML

    $mail->Subject = $subject;
    $mail->Body  = "Message envoyé par $name &lt;$email&gt; : <br/> $message";
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
   

    header('Location: https://yamcha95.github.io/Portfolio/sendMail.php');


} catch (Error $e) {
    echo $e->getMessage();
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}

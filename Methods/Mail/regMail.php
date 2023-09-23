<?php
 require("vendor/phpmailer/phpmailer/src/PHPMailer.php");//For some reason this only works in this file
 require("vendor/phpmailer/phpmailer/src/SMTP.php");
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
//use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require __DIR__ . "../../../config.php"; //Variable setting class include
$mail = new PHPMailer(true);
try
{
    //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = $_ENV['MAIL_HOST'];                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = $_ENV['MAIL_USERNAME'];                     //SMTP username
    $mail->Password   = $_ENV['MAIL_PASSWORD'];;                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       =  465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
 //Recipients
 $mail->setFrom($_ENV['MAIL_USERNAME'], 'Afterparty Bookstore - user registration'); 
 $mail->addAddress( $_SESSION['email'], 'User'); 

 //Content
 $mail->isHTML(true);                                  //Set email format to HTML
 $mail->Subject = 'User registration verification';
 $mail->Body   = 'This is your unique digit code for registration:<strong> '."{$this->reg_verification}".' <strong>';

 $mail->send();
 echo '<p class="mailMsg">Message has been sent! Please check your email!</p>';
} catch (Exception $e) {
 echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}

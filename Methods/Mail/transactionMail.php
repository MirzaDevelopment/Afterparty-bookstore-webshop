<?php
require("vendor/phpmailer/phpmailer/src/PHPMailer.php");//For some reason this only works in this file
require("vendor/phpmailer/phpmailer/src/SMTP.php");
use PHPMailer\PHPMailer\PHPMailer;
//use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require __DIR__ . "../../../config.php"; //Variable setting class include
$mail = new PHPMailer(true);
$mail->CharSet = 'UTF-8';

try
{
    //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = $_ENV['MAIL_HOST'];                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = $_ENV['MAIL_USERNAME'];                     //SMTP username
    $mail->Password   = $_ENV['MAIL_PASSWORD'];                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       =  465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
 //Recipients
 $mail->setFrom($_ENV['MAIL_USERNAME'], 'Afterparty Bookstore'); 
 $mail->addAddress( $_SESSION['email'], 'User');

 //Content
 $mail->isHTML(true);                                  //Set email format to HTML
 $mail->Subject = 'User order details';
 $mail->Body   = 'Dear '. "{$_SESSION['first_name']} ". 'Thank you for your order!<br> Details of your order:'.$message." <br>Total price:<strong>".$_SESSION['totalPrice']."</strong> <br><br> Thank you for choosing AfterpartyBooks!";
 $mail->send();
} catch (Exception $e) {
 echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}

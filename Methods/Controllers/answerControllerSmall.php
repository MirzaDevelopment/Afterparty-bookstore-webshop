<?php
declare(strict_types=1);
/***Controller for getting correct question id***/
session_start();
foreach ($_POST as $key => $value)
{
  $kljuc=$key;
}
$_SESSION['keyAnswer']=$kljuc; //Storing key in session!

require __DIR__."../../../Form.php";  
$objekat=new Form;
$objekat->adminAnswerRender();//Rendering answer text input field method for admin to use!


<?php
declare(strict_types=1);
/*****SMALL CONTROLLER FOR DELETE CONFIRMATION MESSAGE******/
session_start();
//Getting chosen user_id!
foreach ($_POST as $key => $value)
{
  $kljuc=$key;
}
$_SESSION['keyUser']=$kljuc; //Storing key in session!
echo "Data row with the unique id: ".$kljuc." will be deleted!<br><br>";//Making sure Admin wants to delete user with that key!

require __DIR__."../../../Form.php"; //Including form that sends name parmeter to deleteDataVariablesUsers.php
Form::confirmationRadioUser();//Calling confirmation method!




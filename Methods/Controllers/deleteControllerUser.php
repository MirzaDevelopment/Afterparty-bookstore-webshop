<?php
declare(strict_types=1);
/***DELETE QUERY FOR USERS (SENT HERE FROM FORM)***/
session_start();
if (isset($_POST["yesUser"]) && !empty($_POST["yesUser"]))
{
$user_id=$_SESSION['keyUser'];
require __DIR__."../../../Interfaces/UsersInterface.php";
require __DIR__."../../../Interfaces/UserSelectInterface.php";
require __DIR__."../../../DatabaseClasses/UserDatabase.php";
require __DIR__."../../../UserClasses/UserExtendsUserDatabase.php";
require __DIR__."../../../config.php";
User::delete_user($user_id);
} else if (isset($_POST["noUser"]) && !empty($_POST["noUser"])){
  echo "User was not deleted! Reloading page...";
 
}   
unset($_SESSION['key']);
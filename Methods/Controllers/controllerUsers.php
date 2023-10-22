<?php
declare(strict_types=1);
session_start();
require_once __DIR__ . "../../../Traits/PasswordResetTrait.php"; //Password reset trait
require_once __DIR__ . "../../../Interfaces/UsersInterface.php";
require_once __DIR__ . "../../../Interfaces/UserSelectInterface.php";
require __DIR__ . "../../../Traits/PreventDuplicateTrait.php";
require __DIR__ . "../../../Traits/CleaningLadyTrait.php"; //SANITATION AND VALIDATION TRAIT "CleaningLady"
require __DIR__ . "../../../Traits/SelectUserTrait.php"; //Select user ID for comments
require __DIR__ . "../../../GeneralClasses/SetUser.php"; //Variable setting class include
require __DIR__ . "../../../config.php"; //Variable setting class include
$objekatSet = new SetUser();
$objekatSet->userVarSearchSettingBooks();
if (!isset($_POST['passReset']) && !isset($_POST['passDigits']) && !isset($_POST['password'])) { //To prevent "password reset" to interfere with logic
  
  $objekatSet->loginUser();
  
}

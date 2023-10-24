<?php
declare(strict_types=1);
session_start();
require __DIR__."../../../Interfaces/UsersInterface.php";
require __DIR__."../../../Interfaces/UserSelectInterface.php";
require __DIR__."../../../Interfaces/QueryInterface.php";
require __DIR__."../../../Traits/PasswordResetTrait.php";
require __DIR__."../../../Traits/CleaningLadyTrait.php"; //SANITATION AND VALIDATION TRAIT "CleaningLady"
require __DIR__."../../../Traits/SelectUserTrait.php";//Getting user Id for proper comment insert
require __DIR__."../../../Traits/PreventDuplicateTrait.php"; //Trait to prevent duplicate user names and mails upload in DB
require __DIR__."../../../GeneralClasses/SetUser.php"; //Variable setting class include regarding users
require __DIR__."../../../GeneralClasses/SetAdmin.php"; //Variable setting class include Admin panel
require __DIR__."../../../config.php"; //Variable setting class include Admin panel

switch ($_SESSION) {
    case isset($_SESSION['userUpdate']): //User data update by user itself
        $objekatSet = new SetUser();
        $objekatSet->varSettingUsersUpdateByUsers();
        break;
    case isset($_SESSION['update_key_user']): //User data update by super admin
        $objekatSet = new SetAdmin();
        $objekatSet->varSettingUsersUpdate();
        break;
    default: //Full books update and category update
        SetAdmin::categoryUpdate();
        SetAdmin::insertSlider();
        $objekatSet = new SetAdmin();
        $objekatSet->varSettingBooksUpdate();
      
        
}

        



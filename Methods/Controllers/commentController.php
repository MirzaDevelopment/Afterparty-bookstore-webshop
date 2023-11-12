<?php
require __DIR__ . "../../../Interfaces/CommentSelectInterface.php"; //including required interface
require __DIR__ . "../../../DatabaseClasses/CommentSelectDatabase.php"; 
require __DIR__ . "../../../Traits/CleaningLadyTrait.php"; //SANITATION AND VALIDATION TRAIT "CleaningLady"
require __DIR__ . "../../../Traits/PreventDuplicateTrait.php"; //Trait to prevent duplicate entries of user name and emails in DB
require __DIR__ . "../../../GeneralClasses/SetAdmin.php"; //Variable setting class include
require __DIR__ . "../../../config.php"; //Variable setting class include

//All Customers render
if (isset($_POST['list']) || isset($_GET['page'])) {
    CommentSelectDatabase::selectAllCommentsAdmin();
    unset($_POST['list']);
}

/***Comment delete by Admin***/
if (isset($_POST['cust'])) { //Selected customer "id-s" from ajax
    require __DIR__ . "../../../Interfaces/CommentInterface.php"; //including required interface
    require __DIR__ . "../../../DatabaseClasses/CommentDatabase.php"; 
    require __DIR__ . "../../../GeneralClasses/CommentsExtendsDatabase.php"; 
    foreach ($_POST as $key => $value) {

        $comment_id = $value;
      
    }
    Comments::delCommentsAdmin($comment_id); //Deleting customer data
    echo ("<meta http-equiv='refresh' content='2'>"); //Refresh by HTTP 'meta'
}
/***Comment pagination for specifically targeted admin search***/
$objekatSet = new SetAdmin();
$objekatSet->varSearchSettingComment();
if ($_GET) {
    switch ($_GET) {
        case (isset($_GET['pageSearch'])):
            $user_input = $_SESSION['userInput'];
            CommentSelectDatabase::selectFilterCommentsAdmin($user_input);
            break;
    }
}
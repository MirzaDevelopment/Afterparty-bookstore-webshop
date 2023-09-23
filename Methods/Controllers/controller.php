<?php
declare(strict_types=1);
/***Variable setting controller for books and users (book and user search initiated by admin)***/
require __DIR__ . "../../../Interfaces/QueryInterface.php"; //including required interface
require __DIR__ . "../../../Interfaces/SelectInterface.php"; //including required interface
require __DIR__ . "../../../Interfaces/UserSelectInterface.php"; //including required interface
require __DIR__ . "../../../Interfaces/UsersInterface.php"; //including required interface
require __DIR__ . "../../../Traits/CleaningLadyTrait.php"; //SANITATION AND VALIDATION TRAIT "CleaningLady"
require __DIR__ . "../../../Traits/PreventDuplicateTrait.php"; //Trait to prevent duplicate entries of user name and emails in DB
require __DIR__ . "../../../GeneralClasses/SetAdmin.php"; //Variable setting class include
require __DIR__ . "../../../config.php"; //Variable setting class include
/***SELECT ALL BOOKS***/
if (isset($_POST['list']) || isset($_GET['page'])) {
    require_once __DIR__ . "../../../DatabaseClasses/SelectDatabase.php";
    Selectdatabase::selectAll();
    unset($_GET['page']);
  
}
/***Deleted Books render***/
if (isset($_POST['booksDel']) || isset($_GET['pageDeleted'])) {
    require_once __DIR__ . "../../../DatabaseClasses/SelectDatabase.php";
    SelectDatabase::selectDeletedBooks();
    unset($_POST['booksDel']);
    exit();
}

/***Deleted Books restore***/
if (isset($_POST['restore'])) { //Selected book "id-s" from ajax
    require __DIR__ . "../../../DatabaseClasses/Database.php";
    require __DIR__."../../../BookClasses/BookstoreExtendsDatabase.php";
    foreach ($_POST as $key => $value) {

        $book_id = $value;
    }
    Bookstore::restoreRow($book_id); //Restoring deleted books
    echo ("<meta http-equiv='refresh' content='3'>"); //Refresh by HTTP 'meta'
}

/***VARIABLE SETTING FOR BOOKS INSERT AND USER AND BOOKS SPECIFIC SEARCH BY ADMIN***/
$objekatSet = new SetAdmin();
$objekatSet->varSearchSettingBooks();
$objekatSet->varSettingBooks();
$objekatSet->varSearchSettingsUser();

/***SELECT ALL USERS LOGIC***/
if (isset($_POST['listUsers']) || isset($_GET['user'])) {
    require_once __DIR__ . "/../../DatabaseClasses/UserDatabase.php";
    require_once __DIR__ . "/../../UserClasses/UserExtendsUserDatabase.php";
    User::select_all_users();
    unset($_GET['user']);
}

/***Book pagination for specifically targeted admin search (Books and users)***/
if ($_GET) {
    require_once __DIR__ . "../../../DatabaseClasses/SelectDatabase.php";
    require_once __DIR__ . "../../../DatabaseClasses/UserDatabase.php";
    switch ($_GET) {
        case (isset($_GET['pageAuthor'])):
            $book_author = $_SESSION['book_author'];
            SelectDatabase::select_author($book_author);
            break;
        case (isset($_GET['pageAllFilled'])):
            $book_author = $_SESSION['book_author'];
            $book_title = $_SESSION['book_title'];
            $number1 = $_SESSION['price1'];
            $number2 = $_SESSION['price2'];
            SelectDatabase::select($book_author, $book_title, $number1, $number2);
            break;
        case (isset($_GET['pageAuthorMinPrice'])):
            $book_author = $_SESSION['book_author'];
            $number1 = $_SESSION['price1'];
            SelectDatabase::select_author_number_1($book_author, $number1);
            break;
        case (isset($_GET['pageAuthorMaxPrice'])):
            $book_author = $_SESSION['book_author'];
            $number2 = $_SESSION['price2'];
            SelectDatabase::select_author_number_2($book_author, $number2);
            break;
        case (isset($_GET['pageAuthorRangePrice'])):
            $book_author = $_SESSION['book_author'];
            $number1 = $_SESSION['price1'];
            $number2 = $_SESSION['price2'];
            SelectDatabase::select_author_number_range($book_author, $number1, $number2);
            break;
        case (isset($_GET['pageTitle'])):
            $book_title = $_SESSION['book_title'];
            SelectDatabase::select_title($book_title);
            break;
        case (isset($_GET['pageTitleMinPrice'])):
            $book_title = $_SESSION['book_title'];
            $number1 = $_SESSION['price1'];
            SelectDatabase::select_title_number_1($book_title, $number1);
            break;
        case (isset($_GET['pageTitleMaxPrice'])):
            $book_title = $_SESSION['book_title'];
            $number2 = $_SESSION['price2'];
            SelectDatabase::select_title_number_2($book_title, $number2);
            break;
        case (isset($_GET['pageTitleRangePrice'])):
            $book_title = $_SESSION['book_title'];
            $number1 = $_SESSION['price1'];
            $number2 = $_SESSION['price2'];
            SelectDatabase::select_title_number_range($book_title, $number1, $number2);
            break;
        case (isset($_GET['pageAuthorTitle'])):
            $book_title = $_SESSION['book_title'];
            $book_author = $_SESSION['book_author'];
            SelectDatabase::select_title_author($book_title, $book_author);
            break;
        case (isset($_GET['pageMinPrice'])):
            $number1 = $_SESSION['price1'];
            SelectDatabase::select_number1($number1);
            break;
        case (isset($_GET['pageMaxPrice'])):
            $number2 = $_SESSION['price2'];
            SelectDatabase::select_number2($number2);
            break;
        case (isset($_GET['pageRangePrice'])):
            $number1 = $_SESSION['price1'];
            $number2 = $_SESSION['price2'];
            SelectDatabase::select_number_both($number1, $number2);
            break;
            /***User pagination beginning***/
        case (isset($_GET["userAllFilled"])):
            $first_name = $_SESSION['first_name'];
            $last_name = $_SESSION['last_name'];
            $user_name = $_SESSION['user_name'];
            UserDatabase::selectAllFilledUsers($first_name, $last_name, $user_name);
            break;
        case (isset($_GET["userFirstName"])):
            $first_name = $_SESSION['first_name'];
            UserDatabase::selectFirstName($first_name);
            break;
        case (isset($_GET["userLastName"])):
            $last_name = $_SESSION['last_name'];
            UserDatabase::selectLastName($last_name);
            break;
        case (isset($_GET["userUserName"])):
            $user_name = $_SESSION['user_name'];
            UserDatabase::selectUserName($user_name);
            break;
        case (isset($_GET["userFirstLastName"])):
            $first_name = $_SESSION['first_name'];
            $last_name = $_SESSION['last_name'];
            UserDatabase::selectFirstNameLastName($first_name, $last_name);
            break;
        default:
            echo "Error, pages could not be shown properly!";
    }
}

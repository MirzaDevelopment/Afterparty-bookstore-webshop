<?php
declare(strict_types=1);
require __DIR__ . "../../../Interfaces/QueryInterface.php"; //including required interface
require __DIR__ . "../../../Interfaces/SelectInterface.php"; //including required interface
require __DIR__ . "../../../Interfaces/UsersInterface.php"; //including required interface
require __DIR__ . "../../../Traits/CleaningLadyTrait.php"; //SANITATION AND VALIDATION TRAIT "CleaningLady"
require __DIR__ . "../../../Traits/PreventDuplicateTrait.php"; //Trait to prevent duplicate entries of user name and emails in DB
require __DIR__ . "../../../GeneralClasses/SetAdmin.php"; //Variable setting class include
require __DIR__ . "../../../config.php"; //Variable setting class include


/***Transaction delete***/
if (isset($_POST['trans'])) { //Selected transactions "id-s" from ajax
    require __DIR__ . "../../../Interfaces/TransactionInterface.php"; //Due to ajax not refreshing page it is required to include class and interface here
    require __DIR__ . "../../../DatabaseClasses/TransactionDatabase.php";
    foreach ($_POST as $key => $value) {

        $transactionData = $value;
    }
    Transactiondatabase::finishedTransactionsDelete($transactionData); //Deleting selected transactions with status "pending"
    echo ("<meta http-equiv='refresh' content='3'>"); //Refresh by HTTP 'meta'
}

/***Deleted Transactions restore***/
if (isset($_POST['restore'])) { //Selected transactions "id-s" from ajax
    require __DIR__ . "../../../Interfaces/TransactionInterface.php"; //Due to ajax not refreshing page it is required to include class and interface here
    require __DIR__ . "../../../DatabaseClasses/TransactionDatabase.php";
    foreach ($_POST as $key => $value) {

        $transactionData = $value;
    }
    Transactiondatabase::deletedTransactionRestore($transactionData); //Restoring deleted transactions in primary table
    echo ("<meta http-equiv='refresh' content='3'>"); //Refresh by HTTP 'meta'
}



//All Transactions render
if (isset($_POST['list']) || !empty($_SESSION['finished']) || !empty($_SESSION['pending']) || isset($_GET['page'])) {
    $objekat = new TransactionSelectDb;
    $objekat->selectAllTransactions();
    unset($_POST['list']);
    unset($_SESSION['finished']);
    unset($_SESSION['pending']);
}


//Deleted transactions render
if (isset($_POST['listDel']) || isset($_GET['pageDeleted'])) {
    $objekat = new TransactionSelectDb;
    $objekat->selectdeletedTransactions();
    unset($_POST['listDel']);
}

/***Transation pagination for specifically targeted admin search***/
$objekatSet = new SetAdmin();
$objekatSet->varSearchSettingTrans();
if ($_GET) {
    switch ($_GET) {
        case (isset($_GET['pageSearch'])):
            $user_input = $_SESSION['userInput'];
            TransactionSelectDb::selectSearchTransactions($user_input);
            break;
    }
}

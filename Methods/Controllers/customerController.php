<?php

declare(strict_types=1);
require __DIR__ . "../../../Interfaces/QueryInterface.php"; //including required interface
require __DIR__ . "../../../Interfaces/SelectInterface.php"; //including required interface
require __DIR__ . "../../../Interfaces/UsersInterface.php"; //including required interface
require __DIR__ . "../../../Traits/CleaningLadyTrait.php"; //SANITATION AND VALIDATION TRAIT "CleaningLady"
require __DIR__ . "../../../Traits/PreventDuplicateTrait.php"; //Trait to prevent duplicate entries of user name and emails in DB
require __DIR__ . "../../../GeneralClasses/SetAdmin.php"; //Variable setting class include
require __DIR__ . "../../../config.php"; //Variable setting class include

/***Customer delete***/
if (isset($_POST['cust'])) { //Selected customer "id-s" from ajax
    require_once __DIR__ . "../../../Interfaces/CustomersInterface.php"; //Due to ajax not refreshing page it is required to include class and interface here
    require_once __DIR__ . "../../../DatabaseClasses/CustomerDatabase.php";
    require_once __DIR__ . "../../../UserClasses/CustomerExtendsCustomerDatabase.php";
    foreach ($_POST as $key => $value) {

        $customerData = $value;
    }
    Customer::delete_customer($customerData); //Deleting customer data
    echo ("<meta http-equiv='refresh' content='2'>"); //Refresh by HTTP 'meta'
}

/***Deleted Customer restore***/
if (isset($_POST['restore'])) { //Selected customer "id-s" from ajax
    require_once __DIR__ . "../../../Interfaces/CustomersInterface.php"; //Due to ajax not refreshing page it is required to include class and interface here
    require_once __DIR__ . "../../../DatabaseClasses/CustomerDatabase.php";
    require_once __DIR__ . "../../../UserClasses/CustomerExtendsCustomerDatabase.php";
    foreach ($_POST as $key => $value) {

        $customerData = $value;
    }
    Customer::deletedCustomersRestore($customerData); //Deleting selected customers 
    echo ("<meta http-equiv='refresh' content='3'>"); //Refresh by HTTP 'meta'
}

//All Customers render
if (isset($_POST['list']) || isset($_GET['page'])) {
    $objekat = new CustomerSelectDatabase;
    $objekat->selectAllCustomers();
    unset($_POST['list']);
}
//Deleted customers render
if (isset($_POST['listDel']) || isset($_GET['pageDeleted'])) {
    $objekat = new CustomerSelectDatabase;
    $objekat->selectdeletedCustomers();
    unset($_POST['listDel']);
}
/***Customer pagination for specifically targeted admin search***/
$objekatSet = new SetAdmin();
$objekatSet->varSearchSettingCust();
if ($_GET) {
    switch ($_GET) {
        case (isset($_GET['pageSearch'])):
            $user_input = $_SESSION['userInput'];
            CustomerSelectDatabase::selectSearchCustomers($user_input);
            break;
    }
}

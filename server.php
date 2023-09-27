<?php
declare(strict_types=1);
/***server.php is mostly used to give response for ajax calls mainly from script.js and validation.js***/
//session_start();
/***GETTING BOOK DESCRIPTION FROM DATABASE FOR CHOSEN BOOK ID***/
if (!empty($_GET['kljuc'])) {
    $data = $_GET['kljuc'];
    require "config.php";//Env variables include
    require "DatabaseClasses/ConnectPdo.php";
    try {
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = $connection->prepare("SELECT book_description FROM {$_ENV['DATABASE_NAME']}.books WHERE book_title=:data");
        $array = array('data' => $data);
        foreach ($array as $key => $param) {
            $sql->bindParam($key, $param);
        }
        $sql->execute($array);
        while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
            echo $row['book_description'];
            break;
        }
    } catch (PDOException $e) {
      date_default_timezone_set('Europe/Sarajevo');
        $error = $e->getMessage() . " " . date("F j, Y, g:i a");
        error_log($error . PHP_EOL, 3, "Methods/Logs/logs.txt");
        echo "Failed to comply. Check log for more detail!";
    }
    $connection = null;
}
/***CHECKING IF USERNAME IS ALREADY IN DATABASE***/
if (!empty($_POST['kljucUser'])) {
    $user_name = $_POST['kljucUser'];
    $names = "";
    $msgSuccess = "<span style='color:greenyellow;';>User name is available!</span>";
    $msgFail = "<span style='color:red'>User name already taken! Chose another user name!</span>";
 	require "config.php";//Env variables include
    require "DatabaseClasses/ConnectPdoUser.php";
    try {
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = $connection->prepare("SELECT user_name FROM {$_ENV['DATABASE_NAME']}.users WHERE user_name LIKE CONCAT ('%',:userName)"); //Fetching user names from database
        $array = array('userName' => $user_name);
        foreach ($array as $key => $param) {
            $sql->bindParam($key, $param);
        }
        $sql->execute($array);
        while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
            $names = array();
            array_push($names, $row['user_name']); //Inserting user names in array $names;
        }
        if ($names) {
            $user_name = strtolower($user_name);
            $length = strlen($user_name);
            foreach ($names as $name) {
                if (stristr($user_name, substr($name, 0, $length))) { //Checking if user typed letters ($user_name) are found in $names array elements ($name)
                    echo $msgFail;
                }
            }
        } else {
            echo $msgSuccess;
        }
    } catch (PDOException $e) {
      date_default_timezone_set('Europe/Sarajevo');
        $error = $e->getMessage() . " " . date("F j, Y, g:i a");
        error_log($error . PHP_EOL, 3, "Methods/Logs/logs.txt");
        echo "Failed to comply. Check log for more detail!";
    }
    $connection = null;
}
/***CHECKING IF CATEGORY IS ALREADY IN DATABASE***/

if (!empty($_POST['kljucCategory'])) {
    $book_category = $_POST['kljucCategory'];
    $categories = "";
    $msgSuccess = "<span id='catWin' style='color:#00FA9A';>Category is available, click button below to add it into database!</span>";
    $msgFail = "<span id='catFail' style='color:red'>Category is already in database! Please chose another</span>";
    require "config.php";//Env variables include
    require "DatabaseClasses/ConnectPdo.php";
    try {
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = $connection->prepare("SELECT book_category FROM {$_ENV['DATABASE_NAME']}.book_category WHERE book_category LIKE CONCAT ('%',:category)"); //Fetching category from database
        $array = array('category' => $book_category);
        foreach ($array as $key => $param) {
            $sql->bindParam($key, $param);
        }
        $sql->execute($array);
        while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
            $categories = array();
            array_push($categories, $row['book_category']); //Inserting book categories in array $categories;
        }
        if ($categories) {
            $book_category = strtolower($book_category);
            $length = strlen($book_category);
            foreach ($categories as $cat) {
                if (stristr($book_category, substr($cat, 0, $length))) { //Checking if user typed letters ($book_category) are found in $categories array elements ($cat)
                    echo $msgFail;
                }
            }
        } else {
            echo $msgSuccess;
        }
    } catch (PDOException $e) {
      date_default_timezone_set('Europe/Sarajevo');
        $error = $e->getMessage() . " " . date("F j, Y, g:i a");
        error_log($error . PHP_EOL, 3, "Methods/Logs/logs.txt");
        echo "Failed to comply. Check log for more detail!";
    }
    $connection = null;
}


//CHECKING IF EMAIL IS ALREADY IN DATABASE

if (!empty($_POST['kljucEmail'])) {
    $email = $_POST['kljucEmail'];
    $emails = "";
    $msgSuccess = "<span style='color:greenyellow;';>Email is available!</span>";
    $msgFail = "<span style='color:red'>Email already taken! Chose another email!</span>";
    require "config.php";//Env variables include
    require "DatabaseClasses/ConnectPdo.php";
    try {
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = $connection->prepare("SELECT email FROM {$_ENV['DATABASE_NAME']}.users WHERE email LIKE CONCAT('%',:email)"); //Fetching emails from database
        $array = array('email' => $email);
        foreach ($array as $key => $param) {
            $sql->bindParam($key, $param);
        }
        $sql->execute($array);
        while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
            $emails = array();
            array_push($emails, $row['email']); //Inserting email names in array $names;
        }
        if ($emails) {
            $email = strtolower($email);
            $length = strlen($email);
            foreach ($emails as $emailChunks) {
                if (stristr($email, substr($emailChunks, 0, $length))) { //Checking if user typed letters ($email) are found in $emails array elements ($emailChunks)
                    echo $msgFail;
                }
            }
        } else {
            echo $msgSuccess;
        }
    } catch (PDOException $e) {
      date_default_timezone_set('Europe/Sarajevo');
        $error = $e->getMessage() . " " . date("F j, Y, g:i a");
        error_log($error . PHP_EOL, 3, "Methods/Logs/logs.txt");
        echo "Failed to comply. Check log for more detail!";
    }
    $connection = null;
}

/***GETTING BOOK DATA FOR CHOSEN CATEGORY***/
if (!empty($_GET['id'])) {
    $data = $_GET['id'];
   require "config.php";//Env variables include
    require "DatabaseClasses/ConnectPdoUser.php";
    try {

        $sql2 = $connection->prepare("SELECT book_category FROM {$_ENV['DATABASE_NAME']}.book_category WHERE book_category_id=:data");
        $array = array('data' => $data);
        foreach ($array as $key => $param) {
            $sql2->bindParam($key, $param);
        }
        $sql2->execute($array);
        $row = $sql2->fetch(PDO::FETCH_ASSOC);
        echo "<h2>Available books in category: " . $row['book_category'] . "</h2>";
        echo "<div class='bookContainer2'>";
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = $connection->prepare("SELECT books.book_id, books.book_pic, books.book_title, books.book_author, books.book_quantity, book_category.book_category, pricing.book_price, pricing.discount, pricing.discounted_price, books.publish_year FROM {$_ENV['DATABASE_NAME']}.books INNER JOIN {$_ENV['DATABASE_NAME']}.pricing ON books.book_id=pricing.book_id JOIN {$_ENV['DATABASE_NAME']}.book_category ON book_category.book_category_id=books.book_category_id WHERE book_category.book_category_id =:data ORDER BY books.import_time DESC");
        $array = array('data' => $data);
        foreach ($array as $key => $param) {
            $sql->bindParam($key, $param);
        }
        $sql->execute($array);
        while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
            echo "<div class='grid-item2'>";
          echo "<div class='categoryFront'>".$row['book_category']."</div>";
            $newPic = str_replace("../", "Methods/", $row['book_pic']);
            echo $newPic;
            echo "<div class='descFront2' onmouseover='getDescription(this.textContent)'>";
            echo $row['book_title'];
            echo  "</div>";
            echo $row['book_author'] . "<br>";
            //Logic to properly discounted price
            if ($row['discounted_price'] > 0) {
                echo "<div class='discountContainerFront'>";
                echo "<img class='discountIcon' src='Methods/img/Bez_naslova.png' width='65' height='65' alt='discount-icon'>";
                echo "<div class='discount'>" . $row['discount'] . "%" . "</div>";
                echo "</div>";
                echo "<span class='oldPrice'>" . $row['book_price'] . "$" . "<br></span>";
                echo "<span class='newPrice'>" . $row['discounted_price'] . "$" . "<br></span>";
            } else {
                echo $row['book_price'] . "$" . "<br>";
            }
            echo $row['publish_year'] . "<br>";

            //Checking if book quantity is positive or 0, and rendering corresponding message to user
            if ($row['book_quantity'] > 0) {
                echo "<div class='status'> Available</div>";
                echo "<input class='cart' type='image' src='Methods/img/shopping-cart.png' width='35' height='35' alt='submit' name='{$row['book_id']}' onclick='cartInsertManual(this)' value='Add-to-cart'>";
            } else if ($row['book_quantity'] == 0) {
                echo "<div class='notStatus'> Not available </div>";
            }

            echo "</div>";
        }
        echo "</div>";
    } catch (PDOException $e) {
      date_default_timezone_set('Europe/Sarajevo');
        $error = $e->getMessage() . " " . date("F j, Y, g:i a");
        error_log($error . PHP_EOL, 3, "Methods/Logs/logs.txt");
        echo "Failed to comply. Check log for more detail!";
    }
    $connection = null;
}

/***GETTING BOOK DATA FOR CHOSEN CATEGORY (ONLY DISCOUNTED ITEMS)***/
if (!empty($_GET['Discount'])) {
    $data = $_GET['Discount'];
  	require "config.php";//Env variables include
    require "DatabaseClasses/ConnectPdoUser.php";
    try {

        $sql2 = $connection->prepare("SELECT book_category FROM {$_ENV['DATABASE_NAME']}.book_category WHERE book_category_id=:data");
        $array = array('data' => $data);
        foreach ($array as $key => $param) {
            $sql2->bindParam($key, $param);
        }
        $sql2->execute($array);
        $row = $sql2->fetch(PDO::FETCH_ASSOC);
        echo "<h2>Available books in category: " . $row['book_category'] . "</h2>";
        echo "<div class='bookContainer2'>";
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = $connection->prepare("SELECT books.book_id, books.book_pic, books.book_title, books.book_author, books.book_quantity, book_category.book_category, pricing.book_price, pricing.discount, pricing.discounted_price, books.publish_year FROM {$_ENV['DATABASE_NAME']}.books INNER JOIN {$_ENV['DATABASE_NAME']}.pricing ON books.book_id=pricing.book_id LEFT JOIN {$_ENV['DATABASE_NAME']}.book_category ON book_category.book_category_id=books.book_category_id WHERE book_category.book_category_id =:data AND pricing.discounted_price > 0 ORDER BY books.import_time DESC");
        $array = array('data' => $data);
        foreach ($array as $key => $param) {
            $sql->bindParam($key, $param);
        }
        $sql->execute($array);
        while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
            echo "<div class='grid-item2'>";
            echo "<div class='categoryFront'>".$row['book_category']."</div>";
            $newPic = str_replace("../", "Methods/", $row['book_pic']);
            echo $newPic;
            echo "<div class='descFront2' onmouseover='getDescription(this.textContent)'>";
            echo $row['book_title'];
            echo  "</div>";
            echo $row['book_author'] . "<br>";
            //Showing only discounted products in chosen category
          	echo "<div class='discountContainerFront'>";
            echo "<img class='discountIcon' src='Methods/img/Bez_naslova.png' width='65' height='65' alt='discount-icon'>";
            echo "<div class='discount'>" . $row['discount'] . "%" . "</div>";
          	echo  "</div>";
            echo "<span class='oldPrice'>" . $row['book_price'] . "$" . "<br></span>";
            echo "<span class='newPrice'>" . $row['discounted_price'] . "$" . "<br></span>";

            echo $row['publish_year'] . "<br>";

            //Checking if book quantity is positive or 0, and rendering corresponding message to user
            if ($row['book_quantity'] > 0) {
                echo "<div class='status'> Available</div>";
                echo "<input class='cart' type='image' src='Methods/img/shopping-cart.png' width='35' height='35' alt='submit' name='{$row['book_id']}' onclick='cartInsertManual(this)' value='Add-to-cart'>";
            } else if ($row['book_quantity'] == 0) {
                echo "<div class='notStatus'> Not available </div>";
            }

            echo "</div>";
        }
        echo "</div>";
    } catch (PDOException $e) {
      date_default_timezone_set('Europe/Sarajevo');
        $error = $e->getMessage() . " " . date("F j, Y, g:i a");
        error_log($error . PHP_EOL, 3, "Methods/Logs/logs.txt");
        echo "Failed to comply. Check log for more detail!";
    }
    $connection = null;
}

/***Dinamicaly creating book description for books rendered by category***/
if (!empty($_GET['desc'])) {
    $data = $_GET['desc'];
  	require "config.php";//Env variables include
    require "DatabaseClasses/ConnectPdo.php";
    try {
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = $connection->prepare("SELECT book_description FROM {$_ENV['DATABASE_NAME']}.books WHERE book_title=:data");
        $array = array('data' => $data);
        foreach ($array as $key => $param) {
            $sql->bindParam($key, $param);
        }
        $sql->execute($array);
        while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
            echo $row['book_description'];
            break;
        }
    } catch (PDOException $e) {
      date_default_timezone_set('Europe/Sarajevo');
        $error = $e->getMessage() . " " . date("F j, Y, g:i a");
        error_log($error . PHP_EOL, 3, "Methods/logs.txt");
        echo "Failed to comply. Check log for more detail!";
    }
    $connection = null;
}

/***Getting book_id for Temporary cart system  (without login)***/

foreach ($_POST as $key => $value) {
    if (isset($_POST) && $value == "Add-to-cart") {
       session_start();
        $cartKey = $key;
        if (!in_array($cartKey, $_SESSION['cart'])) {
            array_push($_SESSION['cart'], $cartKey);
            echo "<span id='itemInCart'>Item added in cart</span>";
        } else {

            echo "<span id='alrdyInside'>Item already in cart!</span>";
           
        }
    }
}
/***Getting chosen quantity number for product***/
if (!empty($_GET['quantity'])) {
    session_start();
    $pieces = explode(",", $_GET['quantity']);
    $_SESSION['quantity'] = $pieces;
}

/***Showing total sums of book prices * quantity in cart.php bottom of page***/
if (!empty($_GET['sum'])) {
    session_start();
    $_SESSION['sum'] = number_format((float)$_GET['sum'], 2, ',', '.') . " $"; //Showint total price in appropriate format
    print_r($_SESSION['sum']);
} else if (!empty($_GET['sumDown'])) {
    $_SESSION['sumDown'] = (float)$_GET['sumDown'] . " $";
    print_r($_SESSION['sumDown']);
}

/***Deleting item from cart***/
if (!empty($_GET['cartDel'])) {
    session_start();
    $delValue = $_GET['cartDel'];
    $key = array_search($delValue, $_SESSION['cart']);
    array_splice($_SESSION['cart'], $key, 1);//Rearranging array elements after deleting to keep the proper order
}

/***User registration mail verification***/

if (!empty($_POST['regDigits'])) {
    require_once __DIR__ . "/Interfaces/QuestionInterface.php";
    require_once __DIR__ . "/Traits/PreventDuplicateTrait.php";
    require_once __DIR__ . "/Traits/PasswordResetTrait.php"; //Password reset trait
    require_once __DIR__ . "/Traits/CleaningLadyTrait.php";
  	require_once __DIR__ . "/config.php";
    require_once __DIR__ . "/GeneralClasses/SetUser.php";
    $obj = new SetUser();
    $obj->varSettingMailReg();
}

/***Changing message status to "answered"***/
//Same checkbox form but different submit button redirected to here.
if (isset($_POST['question'])) { 
    require_once __DIR__ . "/Traits/CleaningLadyTrait.php";
    require_once __DIR__ . "/Traits/PreventDuplicateTrait.php";
    require_once __DIR__ . "/GeneralClasses/SetAdmin.php";
    require_once __DIR__ . "/Interfaces/QuestionInterface.php";
    require_once __DIR__ . "/Traits/PasswordResetTrait.php"; //Password reset trait
    require_once __DIR__ . "/DatabaseClasses/QuestionDatabase.php";
    require __DIR__ . "/config.php";
    //Update for checked questions
    SetAdmin::updQuestionsAdmin();
    header('Location: Methods/Admin/messages.php');
    die();
}
/***PASSWORD RESET PHP PART***/
if (isset($_POST['passReset']) || isset($_POST['passDigits']) || isset($_POST['password'])) {
    require_once __DIR__ . "/Traits/PreventDuplicateTrait.php";
    require_once __DIR__ . "/Traits/CleaningLadyTrait.php";
  	require_once __DIR__ . "/config.php";
    require_once __DIR__ . "/Traits/PasswordResetTrait.php"; //Password reset trait
    require_once __DIR__ . "/GeneralClasses/SetUser.php";
    require_once __DIR__ . "/Interfaces/UsersInterface.php";
    $setObjekat = new SetUser();
    /***Methods in SET class required for password restart and update***/
    $setObjekat->resetPassword();
    $setObjekat->verifyNumbers();
    //Step 3, password update
    $setObjekat->passwordUpdateUser();
}

/***Changing transaction status logic***/
if (!empty($_POST['trans'])) { //Selected transactions "id-s" from ajax
    session_start();
    foreach ($_POST as $key => $value) {

        $transactionData = $value;
    }
    require __DIR__ . "/Interfaces/TransactionInterface.php";
    require __DIR__ . "/DatabaseClasses/TransactionDatabase.php";
    require __DIR__ . "/config.php";
    TransactionDatabase::pendingTransactionsRender($transactionData); //Selecting transactions with status "pending"
    if (!empty($_SESSION['pending'])) {
        TransactionDatabase::updateTransactionStatusFinished(); //Updating selected transactions
    }
    if (empty($_SESSION['pending'])) {

        TransactionDatabase::finishedTransactionsRender($transactionData); //Selecting transactions with status "finished"
        if (!empty($_SESSION['finished'])) {
            TransactionDatabase::updateTransactionStatusPending(); //Updating selected transactions   
        }
    }

    echo "<div class='transConfirm'>Transaction status changed successfully!</span>";
    echo ("<meta http-equiv='refresh' content='2'>"); //Refresh by HTTP 'meta'

}

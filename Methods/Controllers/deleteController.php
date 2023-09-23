<?php
declare(strict_types=1);
/***DELETE BOOK QUERY (SENT HERE FROM FORM)***/
session_start();
if (isset($_POST["yes"]) && !empty($_POST["yes"])){
  $book_id=$_SESSION['key'];
  require __DIR__."../../../Interfaces/QueryInterface.php";
  require __DIR__."../../../DatabaseClasses/Database.php";
  require __DIR__."../../../BookClasses/BookstoreExtendsDatabase.php";
    require __DIR__."../../../config.php";
  Bookstore::deleteRow($book_id);
  echo "<br>";
  echo "Reloading page...";
} else if (isset($_POST["no"]) && !empty($_POST["no"])){
  echo "Book was not deleted! Reloading page...";
  
} 
/***DELETE CATEGORY QUERY (SENT HERE FROM FORM)***/
if (isset($_POST["yesCat"])&&!empty($_POST["yesCat"])){
  $book_category=str_replace("_"," ",(string)$_SESSION['key']);//...to be able to delete categories that contain two words and empty space, and the ones that contain numbers
  require __DIR__."../../../Interfaces/QueryInterface.php";
  require __DIR__."../../../DatabaseClasses/Database.php";
  require __DIR__."../../../BookClasses/BookstoreExtendsDatabase.php";
    require __DIR__."../../../config.php";
  Bookstore::deleteCat($book_category);
  echo ("<meta http-equiv='refresh' content='2'>"); //Refresh by HTTP 'meta'    ;

} else if (isset($_POST["noCat"]) && !empty($_POST["noCat"])){

  echo "<div id='catNoDel'>Category was not deleted! Reloading page...</div>";
  echo ("<meta http-equiv='refresh' content='2'>"); //Refresh by HTTP 'meta'    ;
}

unset($_SESSION['key']);
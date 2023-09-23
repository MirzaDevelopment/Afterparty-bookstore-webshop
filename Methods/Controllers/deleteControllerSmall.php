<?php
declare(strict_types=1);
/*****SMALL CONTROLLER FOR DELETE CONFIRMATION MESSAGE******/
require __DIR__ . "../../../Interfaces/QueryInterface.php";
require __DIR__ . "../../../DatabaseClasses/Database.php";
require __DIR__ . "../../../DatabaseClasses/Slider.php";
require __DIR__ . "../../../Form.php";
require __DIR__ . "../../../config.php";
/*****GETTING THE CORRECT ID******/
session_start();
//Getting chosen book_id!
foreach ($_POST as $key => $value) {
  $kljuc = $key;
}
$_SESSION['key'] = $kljuc; //Storing key in session!
/***Delete book from slider***/
if ($value == "Slider") {
  $book_id = $kljuc;
  Slider::sliderDelete($book_id);
  /***Category delete First message***/
} else if ((int)$_SESSION['key'] && $value != "Update" && $value != "x") {
  echo "Data row with the unique id: " . $kljuc . " will be deleted!<br><br>"; //Making sure user wants to delete book with that key!
  Form::ConfirmationRadio(); //Calling confirmation method!
  /***Category delete Confirmation***/
} else if ((string)$_SESSION['key'] && $value == "x") {
  echo "Book category: " . $kljuc . " will be deleted!<br><br>"; //Making sure admin wants to delete proper category!
  echo "Books present in deleted category should be updated with the new category in Book update menu!<br><br>";
  Form::ConfirmationDelCategory(); //Calling confirmation method!
  //Deleting discount from books
} else if ($value == "Update") {
  $book_id = $kljuc;
  Database::deleteDiscount($book_id);
}

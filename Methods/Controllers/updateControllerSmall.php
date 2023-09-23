<?php
declare(strict_types=1);
session_start();
/***RENDERING FORMS FOR USER UPDATE (FIRST AND LAST NAME) AND BOOK UPDATE INITIATED BY USER AND ADMIN***/
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="renedered forms for user and book data update">
  <link rel="stylesheet" href="../../style.css">
  <script src="../script.js"></script>
  <script src="../validation.js"></script>
  <link rel="icon" href="data:;base64,=">
  <title>Data update</title>
</head>
<body onload="multipleUpd()" class="insertBody" id="updBody">
</body>
</html>
<?php
require __DIR__ . "../../../Form.php";
$obj1 = new Form();
/***RENDERING FORM FOR USER UPDATE (FIRST AND LAST NAME) INITIATED BY USER***/
if (isset($_GET['userUpdate'])) {
  $_SESSION['userUpdate'] = $_GET['userUpdate'];
  $obj1->renderUserNoStatus();
  echo "<br>";
  echo "<div class='goBackUser'>";
  echo "<a href='../User/userPanel'><img src='../../Methods/img/previous.png' alt='back-to-previous-page' width='35' height='35'></a>";
  echo "</div>";
}
echo "<p id='output2'></p>"; //AJAX OUTPUT

/***RENDERING FORM FOR BOOK UPDATE INITIATED BY ADMIN***/
if (isset($_POST) && !empty($_POST)) {
  foreach ($_POST as $key => $value) // GETTING THE CORRECT ID
  {
    if ($value === 'Update') {
    //Small cleaning os user update session data
      if (isset($_SESSION['update_key_user'])){
        unset($_SESSION['update_key_user']);
    }
      
      $kljuc = $key;
      $_SESSION['update_key'] = $kljuc; //Storing key in session!
      //Making sure user wants to delete book with that key!
      echo "<span class='bookId'>Book with the book id:<span class='key'>" . $kljuc . "</span> will be modified with data below:<br><br></span>";
      //Checking if variable is set then rendering update form from calling in the Form class and its appropriate method.
      echo "<div class='ultimateStyleContainer'>"; //For better stilisation.
      $obj1->render(); 
      echo "<div class='selectsContainer'>";
      $obj1->addCategory();
      $obj1->addToSlider();
      echo "</div>";
      echo "</div>";
      echo "<div class='goBackMsgUpd'>";
      echo "<a href='../Admin/bookSearch'><img src='../../Methods/img/previous.png' alt='back-to-previous-page' width='35' height='35'></a>";
      echo "</div>";
      echo "<p id='output'></p>"; //AJAX OUTPUT
      echo"<br>";
      echo "<p id='anchor'></p>"; //For messages to be fully shown on mobile
      

      /***RENDERING FORM FOR USER UPDATE (FIRST AND LAST NAME AND STATUS) INITIATED BY ADMIN***/
    } else if ($value === 'Change') {
      $kljuc = $key;
      $_SESSION['update_key_user'] = $kljuc; //Storing key in session!
      //Making sure Admin wants to delete or modify user with that key!
       echo "<div class='stylishContainer'>";
      echo "<span class='userId'>User with the user id:<span class='key'>" . $kljuc . "</span> will be modified with data below:<br><br></span>";

      //Checking if variable is set then rendering update form from calling in the Form class and its appropriate method.
      if (isset($_POST)) {
        $obj1->renderUser();
        echo "<br>";
        echo "<div class='goBackMsgUserUpd'>";
        echo "<a href='../Admin/userSearch'><img src='../../Methods/img/previous.png' alt='back-to-previous-page' width='35' height='35'></a>";
        echo "</div>";
      } else {
        echo "Please try again...";
      }
      echo "<p id='output'></p>"; //AJAX OUTPUT
    }
      echo "</div>";
  }
}

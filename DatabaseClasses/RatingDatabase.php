<?php

declare(strict_types=1);
class RatingDatabase /**Class that contains one insert and select queries for book rating***/
{
    
    public static function insertRating(int $rating_user_id, int $rating_mark, int $rating_book_id): void
    {
        /***Small script for adding rating by user from script.js call***/

        require "DatabaseClasses/ConnectPdo.php";
        try {
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql2 = $connection->prepare("Call insertRating(?,?,?)");
            $sql2->bindParam(1, $rating_user_id, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 4000);
            $sql2->bindParam(2, $rating_mark, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 6000);
            $sql2->bindParam(3, $rating_book_id, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 4000);
            $sql2->execute();
            echo "Thank you for your rating!";
        } catch (PDOException $e) {
            $error = $e->getMessage() . " " . date("F j, Y, g:i a");
            error_log($error . PHP_EOL, 3, "Methods/Logs/logs.txt");
            echo "Failed to comply. Check log for more detail!";
        }
        $connection = null;
    }


//Selecting and showing average book rating
public static function selectRating($book_id):void{
    require "DatabaseClasses/NamespaceUser.php";

    try{
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = $connection->prepare("SELECT books.book_title, AVG(rating.rating_mark) as average_rating FROM users JOIN rating ON users.user_id=rating.rating_user_id JOIN books ON rating_book_id=books.book_id  where book_id=:book_id GROUP BY book_title");
    $array=array('book_id' => $book_id);
    foreach ($array as $key => $param) {
        $sql->bindParam($key, $param);
    }
    $sql->execute($array);
    if($sql->rowCount()==0){
        echo "<img id='emptyIcon' src='Methods/img/sorry(2).png' width='100' alt='sorry-icon'>";
        echo "<p id='empty'>Ooops...no rating for this book at the moment.<p>";
}
    while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {

echo "<span class='ratingMark'>" .number_format((float)$row['average_rating'], 2, '.', ' ')."</span>";

    }

  } catch (PDOException $e) {
    $error = $e->getMessage() . " " . date("F j, Y, g:i a");
    error_log($error . PHP_EOL, 3, "Methods/Logs/logs.txt");
    echo "Failed to comply. Check log for more detail!";
}
}

//Selecting book_id, user_id and the mark for LOGGED IN user to represent visually his rating
public static function selectUserBookRating($book_id, $user_name):void{
    require "DatabaseClasses/ConnectPdoAdmin.php";

    try{
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //Getting required user_id in rating with known user_name
    $sql = $connection->prepare("SELECT rating.rating_user_id FROM users JOIN rating ON users.user_id=rating.rating_user_id  WHERE user_name=:user_name");
    $array=array('user_name'=>$user_name );
    foreach ($array as $key => $param) {
        $sql->bindParam($key, $param);
    }
    $sql->execute($array);
       if($sql->rowCount()!=0){
    while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
    $_SESSION['rating_user_id']=$row['rating_user_id'];

   }
    //Checking if that user id corresponds with chosen book_id
    $sql2 = $connection->prepare("SELECT AVG(rating.rating_mark) as average_rating FROM users JOIN rating ON users.user_id=rating.rating_user_id  WHERE rating.rating_book_id=:book_id AND rating.rating_user_id='{$_SESSION['rating_user_id']}'");
    $array=array('book_id'=>$book_id);
    foreach ($array as $key => $param) {
        $sql->bindParam($key, $param);
    }
    $sql2->execute($array);
    while ($row = $sql2->fetch(PDO::FETCH_ASSOC)) {

        $_SESSION['average_rating']=$row['average_rating'];
    
    
       }
         } 

  } catch (PDOException $e) {
    $error = $e->getMessage() . " " . date("F j, Y, g:i a");
    error_log($error . PHP_EOL, 3, "Methods/Logs/logs.txt");
    echo "Failed to comply. Check log for more detail!";
}
}
}
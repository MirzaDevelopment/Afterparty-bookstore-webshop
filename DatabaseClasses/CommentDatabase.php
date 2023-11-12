<?php
declare(strict_types=1);
class CommentDatabase implements CommentInterface{
const limit = 10;
//Insert comments by user
public static function insertComment(int $comment_user_id, string $comment_body, int $comment_book_id):void
{
require "Namespace2.php";
        try {
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = $connection->prepare("Call insertComment(?,?,?)");
            $sql->bindParam(1, $comment_user_id, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 4000);
            $sql->bindParam(2, $comment_body, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 6000);
            $sql->bindParam(3, $comment_book_id, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 4000);
            $sql->execute();
            $_SESSION['timestamp']=date('H:i:s');
            echo "<p id='latest'>Comment posted successfully!</p><br>";
        } catch (PDOException $e) {
            $error = $e->getMessage() . " " . date("F j, Y, g:i a");
            error_log($error . PHP_EOL, 3, "Methods/Logs/logs.txt");
        }
        $connection = null;
}

//Update comment body (text)
public static function updateComment($comment_body, $comment_id):void{
require "ConnectPdoAdmin.php";
try {
    $date_modified = date("Y-m-d h:i:s");
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = $connection->prepare("Call updateComment(?,?,?)");
    $sql->bindParam(1, $comment_body, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 4000);
    $sql->bindParam(2, $comment_id, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 6000);
    $sql->bindParam(3, $date_modified, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 4000);
    $sql->execute();
    echo "<p id='latest'>Comment edited successfully!</p>";
} catch (PDOException $e) {
    $error = $e->getMessage() . " " . date("F j, Y, g:i a");
    error_log($error . PHP_EOL, 3, "Methods/Logs/logs.txt");
    echo "Failed to comply. Check log for more detail!";
}
$connection = null;

}
//Delete comment

public static function delComments(int $comment_id):void{
    require "ConnectPdoAdmin.php";
    try{
    $sql = $connection->prepare("Call deleteComment(?)");
    $sql->bindParam(1, $comment_id, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 6000);
    $sql->execute();
    echo "Comment deleted successfully!";

} catch (PDOException $e) {
    $error = $e->getMessage() . " " . date("F j, Y, g:i a");
    error_log($error . PHP_EOL, 3, "Methods/Logs/logs.txt");
    echo "Failed to comply. Check log for more detail!";
}
}
  //Deleting comment for admin
  public static function delCommentsAdmin(array $comment_id):void{
    require "ConnectPdoAdmin.php";
    try {
      $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $connection->beginTransaction(); //Starting transaction
      $sql = $connection->prepare("Call deleteComment(?)");
      for ($i = 0; $i < sizeof($comment_id); $i++) {
        $sql->bindParam(1, $comment_id[$i], PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 4000);
        $sql->execute();
      }

      echo "<div id='transConfirmDel'>";
      echo "Comment(s) deleted successfully!<br>";
      echo "Refreshing page...";
      echo "</div>";
      $connection->commit();
    } catch (PDOException $e) {
      $error = $e->getMessage() . " " . date("F j, Y, g:i a");
      error_log($error . PHP_EOL, 3, "../Logs/logs.txt");
      $connection->rollBack();
      echo "Failed to comply. Check log for more detail!";
    }
  }

}
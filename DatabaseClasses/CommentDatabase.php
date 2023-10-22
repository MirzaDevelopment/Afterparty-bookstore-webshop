<?php
declare(strict_types=1);
class CommentDatabase implements CommentInterface{
const limit = 10;
//Insert comments by user
public static function insertComment(int $comment_user_id, string $comment_body, int $comment_book_id):void
{
require "ConnectPdoAdmin.php";
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
//Select all comments for Admins
public static function selectAllComments():void{


}
//Update comment body (text)
public static function updateComment(string $comment_body):void{

}
//Delete comment
public static function delComments(int $comment_id):void{

}

}
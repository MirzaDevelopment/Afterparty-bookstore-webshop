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
//Select all comments for Admins
public static function selectAllComments($book_id):void
{
require "ConnectPdoAdmin.php";
try{
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = $connection->prepare("SELECT users.user_name, books.book_title, books.book_id, comments.comment_body, comments.comment_id, comments.comment_created FROM users JOIN comments ON comment_user_id=users.user_id JOIN books ON comment_book_id=books.book_id WHERE books.book_id=:bookId");
    $array=array('bookId' => $book_id);
    foreach ($array as $key => $param) {
        $sql->bindParam($key, $param);
    }
    $sql->execute($array);
} catch (PDOException $e){
$error = $e->getMessage() . " " . date("F j, Y, g:i a");
error_log($error . PHP_EOL, 3, "../Logs/logs.txt");
echo "Failed to comply. Check log for more detail!";
}
echo "<p id='commentAnchor'></p>";
 /**Pagination preparation***/
 $limit = CommentDatabase::limit; // variable to store number of books per page
 $count = $sql->rowCount(); //Getting row count!
 $total_pages = ceil($count / $limit); //Number of total pages required to show query results.
 
 //Retrieving active page number
 if (isset($_GET["page"]) && $_GET["page"] <= $total_pages) {

    $page_number  = $_GET["page"];
} else {

    $page_number = 1;
}
$initial_page = ($page_number - 1) * $limit;


echo "<div class='numbDistContainer'>";
for ($i = 1; $i <= $total_pages; $i++) {
    echo "<div class='numbDist'><a href='preview.php?id=$book_id&&page=" . $i . "#commentAnchor'>" . $i . "</a></div>"; //Render of total nubmer of pages user can click on

};
echo "</div>";
/**End of pagination preparation******/
try{
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql2 = $connection->prepare("SELECT users.user_name, books.book_title, books.book_id, comments.comment_body, comments.comment_id, comments.comment_created FROM users JOIN comments ON comment_user_id=users.user_id JOIN books ON comment_book_id=books.book_id WHERE books.book_id=:bookId ORDER BY comments.comment_created DESC LIMIT " . $initial_page . ',' . $limit);
    $array=array('bookId' => $book_id);
    foreach ($array as $key => $param) {
        $sql2->bindParam($key, $param);
    }
    $sql2->execute($array);
    while ($row = $sql2->fetch(PDO::FETCH_ASSOC)) {
 
        $date = new DateTimeImmutable($row['comment_created']);//For date manipulation
        if (isset($_SESSION['username']) && $row['user_name']==$_SESSION['username']){
        echo "<p class='userLoginCommentName'>".$row['user_name']."</p> <p class='commentDate'>posted on ".date_format($date, 'd.m.Y H:i:s')."</p>";
        echo "<div class='buttonCommentCont'>";
        echo"<input type='submit' id='commentEdit' name='{$row['comment_id']}' value='Edit' onclick='commentEdit(this)'></input>";
        echo"<button id='commentDelete'>Delete</button>";
        echo "</div>";
    } else {
        echo "<p class='userCommentName'>".$row['user_name']."</p> <p class='commentDate'>posted on ".date_format($date, 'd.m.Y H:i:s')."</p>";
        
    }
    echo "<p id='{$row['comment_id']}'class='userComment'>". $row['comment_body']."</p>";
    echo "<p id='line'></p>";
    }
    
    //Showing page number in URL
    echo "<div class='paginationContainer'>";
    if ($page_number >= 2) { //Since "prev" is obviously unavailable on page 1 or 0.
        echo "<div class='prev'><a href='preview.php?id=$book_id&&page=" . ($page_number - 1) . "#commentAnchor'> < </a></div>";
    }
    $pageURL = "";
    for ($i = 1; $i <= $total_pages; $i++) {
        if ($i == $page_number) {

            $pageURL .= "<a href='preview.php?id=$book_id&&page=" . $i . "#commentAnchor'>" . $i . " </a>";
        }
    };
    echo "<span class='pageNumb'>$pageURL</span>"; //Showing box with current page number in it


    if ($page_number < $total_pages) {

        echo "<div class='next'><a href='preview.php?id=$book_id&&page=" . ($page_number + 1) . "#commentAnchor'> > </a></div>";
    }

    //Small for loop to render number of pages for user to click on
    echo "</div>";

}catch (PDOException $e){
    $error = $e->getMessage() . " " . date("F j, Y, g:i a");
    error_log($error . PHP_EOL, 3, "Methods/Logs/logs.txt");
    echo "Failed to comply. Check log for more detail!";
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

}

}
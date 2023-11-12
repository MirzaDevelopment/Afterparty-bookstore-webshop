<?php
declare(strict_types=1);
class CommentSelectDatabase implements CommentSelectInterface{
 const limit = 5;
//Select all comments form Admin
public static function selectAllCommentsAdmin():void
{
require "ConnectPdoAdmin.php";
try{
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = $connection->query("SELECT users.user_name, books.book_title, books.book_pic, books.book_id, comments.comment_body, comments.comment_id, comments.comment_created FROM users JOIN comments ON comment_user_id=users.user_id JOIN books ON comment_book_id=books.book_id");
} catch (PDOException $e){
$error = $e->getMessage() . " " . date("F j, Y, g:i a");
error_log($error . PHP_EOL, 3, "../Logs/logs.txt");
echo "Failed to comply. Check log for more detail!";
}
echo "<p id='commentAnchor'></p>";
 /**Pagination preparation***/
 $limit = CommentSelectDatabase::limit; // variable to store number of books per page
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
    echo "<div class='numbDist'><a href='comments.php?page=" . $i . "#commentAnchor'>" . $i . "</a></div>"; //Render of total nubmer of pages user can click on

};
echo "</div>";
/**End of pagination preparation******/
try{
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql2 = $connection->query("SELECT users.user_name, books.book_title, books.book_pic, books.book_id, comments.comment_body, comments.comment_id, comments.comment_created FROM users JOIN comments ON comment_user_id=users.user_id JOIN books ON comment_book_id=books.book_id ORDER BY comments.comment_created DESC LIMIT " . $initial_page . ',' . $limit);
    echo "<div class='buttonCont'>";
    ($_SESSION['status'] == 1) ? print("<button id='selectAll'>Select all</button>") : ("");
    ($_SESSION['status'] == 1) ? print("<button id='deleteSelec'>Delete selected</button>") : ("");
    echo "</div>";
    while ($row = $sql2->fetch(PDO::FETCH_ASSOC)) {
        $date = new DateTimeImmutable($row['comment_created']);//For date manipulation
        echo "<div class='buttonCommentCont'>";
        ($_SESSION['status'] == 1) ? print("<form id='delSelec' action='' method='POST'><input class='checked' form='delSelec' type='checkbox' id='{$row['comment_id']}' name='cust[]' value='{$row['comment_id']}'></form>") : ("");
        echo "<td><p id='outputTransDel'></p>";
        echo "</div>";
  
        echo "<p class='userCommentName'>".$row['user_name']."</p> <p class='commentDate'>posted on ".date_format($date, 'd.m.Y H:i:s')."</p>";
        
    
    echo "<p id='{$row['comment_id']}'class='userComment'>". $row['comment_body']."</p>";
    echo $row['book_pic'];
    echo "<p id='line'></p>";

    }
    
    //Showing page number in URL
    echo "<div class='paginationContainer'>";
    if ($page_number >= 2) { //Since "prev" is obviously unavailable on page 1 or 0.
        echo "<div class='prev'><a href='comments.php?page=" . ($page_number - 1) . "#commentAnchor'> < </a></div>";
    }
    $pageURL = "";
    for ($i = 1; $i <= $total_pages; $i++) {
        if ($i == $page_number) {

            $pageURL .= "<a href='comments.php?page=" . $i . "#commentAnchor'>" . $i . " </a>";
        }
    };
    echo "<span class='pageNumb'>$pageURL</span>"; //Showing box with current page number in it


    if ($page_number < $total_pages) {

        echo "<div class='next'><a href='comments.php?page=" . ($page_number + 1) . "#commentAnchor'> > </a></div>";
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
  //Select comments with user name/book title filter for admin
public static function selectFilterCommentsAdmin($user_input):void{
    {
        require "ConnectPdoAdmin.php";
        try{
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = $connection->prepare("SELECT users.user_name, books.book_title, books.book_pic, books.book_id, comments.comment_body, comments.comment_id, comments.comment_created FROM users JOIN comments ON comment_user_id=users.user_id JOIN books ON comment_book_id=books.book_id WHERE book_title LIKE CONCAT(:input,'%') OR user_name LIKE CONCAT (:input,'%') ORDER BY comments.comment_created");
            $array=array('input' => $user_input);
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
         $limit = CommentSelectDatabase::limit; // variable to store number of books per page
         $count = $sql->rowCount(); //Getting row count!
         $total_pages = ceil($count / $limit); //Number of total pages required to show query results.
         
         //Retrieving active page number
         if (isset($_GET["pageSearch"]) && $_GET["pageSearch"] <= $total_pages) {
        
            $page_number  = $_GET["pageSearch"];
        } else {
        
            $page_number = 1;
        }
        $initial_page = ($page_number - 1) * $limit;
        
        
        echo "<div class='numbDistContainer'>";
        for ($i = 1; $i <= $total_pages; $i++) {
            echo "<div class='numbDist'><a href='comments.php?pageSearch=" . $i . "#commentAnchor'>" . $i . "</a></div>"; //Render of total nubmer of pages user can click on
        
        };
        echo "</div>";
        /**End of pagination preparation******/
        try{
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql2 = $connection->prepare("SELECT users.user_name, books.book_title, books.book_pic, books.book_id, comments.comment_body, comments.comment_id, comments.comment_created FROM users JOIN comments ON comment_user_id=users.user_id JOIN books ON comment_book_id=books.book_id WHERE book_title LIKE CONCAT(:input,'%') OR user_name LIKE CONCAT (:input,'%') ORDER BY comments.comment_created DESC LIMIT " . $initial_page . ',' . $limit);
            $array=array('input' => $user_input);
            foreach ($array as $key => $param) {
                $sql2->bindParam($key, $param);
            }
            $sql2->execute($array);
            echo "<div class='buttonCont'>";
            ($_SESSION['status'] == 1) ? print("<button id='selectAll'>Select all</button>") : ("");
            ($_SESSION['status'] == 1) ? print("<button id='deleteSelec'>Delete selected</button>") : ("");
            echo "</div>";
            while ($row = $sql2->fetch(PDO::FETCH_ASSOC)) {
                $date = new DateTimeImmutable($row['comment_created']);//For date manipulation
                echo "<div class='buttonCommentCont'>";
                ($_SESSION['status'] == 1) ? print("<form id='delSelec' action='' method='POST'><input class='checked' form='delSelec' type='checkbox' id='{$row['comment_id']}' name='cust[]' value='{$row['comment_id']}'></form>") : ("");
                echo "<td><p id='outputTransDel'></p>";
                echo "</div>";
     
                echo "<p class='userCommentName'>".$row['user_name']."</p> <p class='commentDate'>posted on ".date_format($date, 'd.m.Y H:i:s')."</p>";
                
           
            echo "<p id='{$row['comment_id']}'class='userComment'>". $row['comment_body']."</p>";
            echo $row['book_pic'];
            echo "<p id='line'></p>";
            }
            
            //Showing page number in URL
            echo "<div class='paginationContainer'>";
            if ($page_number >= 2) { //Since "prev" is obviously unavailable on page 1 or 0.
                echo "<div class='prev'><a href='comments.php?pageSearch=" . ($page_number - 1) . "#commentAnchor'> < </a></div>";
            }
            $pageURL = "";
            for ($i = 1; $i <= $total_pages; $i++) {
                if ($i == $page_number) {
        
                    $pageURL .= "<a href='comments.php?pageSearch=" . $i . "#commentAnchor'>" . $i . " </a>";
                }
            };
            echo "<span class='pageNumb'>$pageURL</span>"; //Showing box with current page number in it
        
        
            if ($page_number < $total_pages) {
        
                echo "<div class='next'><a href='comments.php?pageSearch=" . ($page_number + 1) . "#commentAnchor'> > </a></div>";
            }
        
            //Small for loop to render number of pages for user to click on
            echo "</div>";
        
        }catch (PDOException $e){
            $error = $e->getMessage() . " " . date("F j, Y, g:i a");
            error_log($error . PHP_EOL, 3, "../Logs/logs.txt");
            echo "Failed to comply. Check log for more detail!";
        }
        
        $connection = null;
        
        }
    
}
//Select all comments below the chosen book on book preview
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
        echo"<input type='submit' id='commentDelete' name='{$row['comment_id']}' value='Remove' onclick='delCommentIntersection(this)'></input>";
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
  }
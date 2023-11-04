<?php

declare(strict_types=1);
class Questiondatabase implements QuestionInterface //Class for question/messages management
{
    const limit = 10;
    /***INSERT QUESTIONS BY USERS ON FRONT PAGE***/
    public static function insertQuestion($name, $body, $email, $status):void
    {
		
        require "NamespaceAdmin5.php";
        try {
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = $connection->prepare("Call insertQuestion(?,?,?,?)");
            $sql->bindParam(1, $name, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 4000);
            $sql->bindParam(2, $body, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 6000);
            $sql->bindParam(3, $email, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 4000);
            $sql->bindParam(4, $status, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 4000);
            $sql->execute();
            echo "<p id='confirmation'>Question sent successfully!</p><br>";
        } catch (PDOException $e) {
          date_default_timezone_set('Europe/Sarajevo');
            $error = $e->getMessage() . " " . date("F j, Y, g:i a");
            error_log($error . PHP_EOL, 3, "../Logs/logs.txt");
            echo "<span id='questionReject'>This message has already been sent! Formulate question differently</span>";
        }
        $connection = null;
    }

    /***GETTING ALL QUESTIONS FOR ADMIN***/
    public static function selectAllQuestions():void
    {
        require "ConnectPdoAdmin.php";
        try {
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = $connection->query("SELECT questions_id, questions_user_name, questions_body, questions_email, questions_status, questions_created FROM {$_ENV['DATABASE_NAME']}.questions  ORDER BY questions_created DESC");
        } catch (PDOException $e) {
          date_default_timezone_set('Europe/Sarajevo');
            $error = $e->getMessage() . " " . date("F j, Y, g:i a");
            error_log($error . PHP_EOL, 3, "../Logs/logs.txt");
            echo "Failed to comply. Check log for more detail!";
        }
        /**Pagination preparation***/
        $limit = Questiondatabase::limit; // variable to store number of books per page
        $count = $sql->rowCount(); //Getting row count!
        $total_pages = ceil($count / $limit); //Number of total pages required to show query results.

        //Retrieving active page number
        if (isset($_GET["page"])&& $_GET["page"] <= $total_pages) {

            $page_number  = $_GET["page"];
        } else {

            $page_number = 1;
        }
        $initial_page = ($page_number - 1) * $limit;


        echo "<div class='numbDistContainer'>";
        for ($i = 1; $i <= $total_pages; $i++) {

            echo "<div class='numbDist'><a href='messages.php?page=" . $i . "'>" . $i . "</a></div>"; //Render of total nubmer of pages user can click on


        };
        echo "</div>";
        /**End of pagination preparation******/
        try {
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql2 = $connection->query("SELECT questions_id, questions_user_name, questions_body, questions_email, questions_status, questions_created FROM {$_ENV['DATABASE_NAME']}.questions  ORDER BY questions_created DESC LIMIT " . $initial_page . ',' . $limit);
            echo "<br>";
            echo "<div class='frontMsg'>Questions:</div>";
            echo "<div class='megaQuestionContainer'>";
            echo "<div id='selectAllQ'>Select all</div>";
            echo "<form action='' method='POST'>";
            while ($row = $sql2->fetch(PDO::FETCH_ASSOC)) {
                echo "<label for='{$row['questions_id']}'>";
                echo "<input class='checked' type='checkbox' id='{$row['questions_id']}' name='question[]' value='{$row['questions_id']}'>";
                echo "<div class='questionsContainer'>";
                echo "<p>User name: " . $row['questions_user_name'] . "</p>";
                echo "<p>Message: " . $row['questions_body'] . "</p>";
                echo "<p>User email: " . $row['questions_email'] . "</p>";
                if ($row['questions_status'] == "unanswered") {
                    echo "<p class='msgStatusAnswered'>Status: " . $row['questions_status'] . "</p>";
                } else {
                    echo "<p class='msgStatusUnanswered'>Status: " . $row['questions_status'] . "</p>";
                }
                echo "<p>Posted:" . $row['questions_created'] . "</p>";
                echo "<input class='ansMsg' type='button' name='{$row['questions_id']}' value='Answer' onclick='answerMessages(this)'></input>";
                echo "</div>";
            }
            echo "<div class='qContainer'>";
            echo "<input type='submit' value='Delete checked'>";
            echo "<input class='read' type='submit' formaction='../../server' value='Mark as read'>";
           echo "</div>";
            echo "</form>";
            //Showing page number in URL
            echo "<div class='paginationContainer'>";
            if ($page_number >= 2) { //Since "prev" is obviously unavailable on page 1 or 0.
                echo "<div class='prev'><a href='messages.php?page=" . ($page_number - 1) . "'> < </a></div>";
            }
            $pageURL = "";
            for ($i = 1; $i <= $total_pages; $i++) {
                if ($i == $page_number) {

                    $pageURL .= "<a href='messages.php?page=" . $i . "'>" . $i . " </a>";
                }
            };
            echo "<span class='pageNumb'>$pageURL</span>"; //Showing box with current page number in it


            if ($page_number < $total_pages) {

                echo "<div class='next'><a href='messages.php?page=" . ($page_number + 1) . "'> > </a></div>";
            }

            //Small for loop to render number of pages for user to click on
            echo "</div>";
        } catch (PDOException $e) {
          date_default_timezone_set('Europe/Sarajevo');
            $error = $e->getMessage() . " " . date("F j, Y, g:i a");
            error_log($error . PHP_EOL, 3, "../Logs/logs.txt");
            echo "Failed to comply. Check log for more detail!";
        }
        $connection = null;
    }
    /**GETTING NUMBER OF NEW (UNANSWERED) QUESTIONS FOR ADMIN***/
    public static function getNumberOfQuestions():void
    {
        require "NamespaceAdmin3.php";
        try {
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = $connection->query("SELECT COUNT(questions_id) AS total FROM {$_ENV['DATABASE_NAME']}.questions WHERE questions_status='unanswered';");
            $row = $sql->fetch(PDO::FETCH_ASSOC);
            $_SESSION['total'] = $row['total'];
        } catch (PDOException $e) {
          date_default_timezone_set('Europe/Sarajevo');
            $error = $e->getMessage() . " " . date("F j, Y, g:i a");
            error_log($error . PHP_EOL, 3, "../Logs/logs.txt");
            echo "Failed to comply. Check log for more detail!";
        }
        $connection = null;
    }
    /*** DELETING CHECKBOX SELECTED MESSAGES***/
    public static function delQuestions($questions_id):void
    {

        require "NamespaceAdmin4.php";
        try {
            for ($i = 0; $i < sizeof($questions_id); $i++) {
                $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $sql = $connection->prepare("Call deleteQuestions (?)");
                $sql->bindParam(1, $questions_id[$i], PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 4000);
                $sql->execute();
            }
            //Small helpful redirect
            echo "<p class='messageDel'>Message deleted successfully! Returning to previous page...</p>";
            echo '<script type="text/javascript">
            window.setTimeout(function () { window.location = "https://www.afterparty-bookstore.com/Methods/Admin/messages" }, 3000)
             </script>';
            exit();
        } catch (PDOException $e) {
          date_default_timezone_set('Europe/Sarajevo');
            $error = $e->getMessage() . " " . date("F j, Y, g:i a");
            error_log($error . PHP_EOL, 3, "../Logs/logs.txt");
            echo "Failed to comply. Check log for more detail!";
        }
        $connection = null;
    }


    /***UPDATE CHECKBOX SELECTED MESSAGES AS "READ"***/

    public static function updQuestions($questions_id):void
    {
        require "NamespaceAdmin3.php";
        try {
            for ($i = 0; $i < sizeof($questions_id); $i++) {
                $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $sql = $connection->prepare("Call updateQuestions(?)");
                $sql->bindParam(1, $questions_id[$i], PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 4000);
                $sql->execute();
            }
        } catch (PDOException $e) {
          date_default_timezone_set('Europe/Sarajevo');
            $error = $e->getMessage() . " " . date("F j, Y, g:i a");
            error_log($error . PHP_EOL, 3, "../Logs/logs.txt");
            echo "Failed to comply. Check log for more detail!";
        }
        $connection = null;
    }

    /***Getting user email for specific question***/
    public static function selectQuestionMail($question_id):void
    {

        require "ConnectPdoAdmin.php";
        try {
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = $connection->prepare("SELECT questions_email FROM {$_ENV['DATABASE_NAME']}.questions WHERE questions_id=:questionId");
            $array = array('questionId' => $question_id);
            foreach ($array as $key => $param) {
                $sql->bindParam($key, $param);
            }
            $sql->execute($array);
            while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
             
                $_SESSION['questions_email'] = $row['questions_email'];
            }
        } catch (PDOException $e) {
          date_default_timezone_set('Europe/Sarajevo');
            $error = $e->getMessage() . " " . date("F j, Y, g:i a");
            error_log($error . PHP_EOL, 3, "../Logs/logs.txt");
            echo "Failed to comply. Check log for more detail!";
        }
    }
}


/***END***/

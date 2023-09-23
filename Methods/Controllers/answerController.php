<?php
declare(strict_types=1);
/***Controller for sending admin asnwer to user to user mail */
 session_start();
if (isset($_POST["questionBody"]) && !empty($_POST["questionBody"])) {
    $question_id = $_SESSION['keyAnswer'];
    $answer = $_POST["questionBody"];
    require __DIR__ . "../../../Interfaces/QuestionInterface.php";
    require __DIR__ . "../../../DatabaseClasses/QuestionDatabase.php";
    require __DIR__ . "../../../config.php";
    Questiondatabase::selectQuestionMail($question_id);
    require __DIR__ ."../../Mail/answerMail.php";
    
}

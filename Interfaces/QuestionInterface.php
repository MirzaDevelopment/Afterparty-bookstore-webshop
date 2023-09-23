<?php
/***Methods Questions class needs to implement***/
interface QuestionInterface 
{
    public static function insertQuestion(string $user_name, string $body, string $email, string $status):void;
    public static function selectAllQuestions():void;
    public static function getNumberOfQuestions():void;
    public static function updQuestions(array $questions_id):void;
    public static function selectQuestionMail(int $question_id):void;

}

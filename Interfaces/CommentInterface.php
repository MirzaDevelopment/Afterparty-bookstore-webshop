<?php
/***Methods Questions class needs to implement***/
interface CommentInterface
{
    public static function insertComment(int $comment_user_id, string $comment_body, int $comment_book_id):void;
    public static function selectAllComments(int $book_id):void;
    public static function updateComment(string $comment_body, int $comment_id):void;
    public static function delComments(int $comment_id):void;

}

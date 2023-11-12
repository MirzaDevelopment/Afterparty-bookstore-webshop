<?php
/***Methods CommentDatabase class needs to implement***/
interface CommentInterface
{
    public static function insertComment(int $comment_user_id, string $comment_body, int $comment_book_id):void;
    public static function updateComment(string $comment_body, int $comment_id):void;
    public static function delComments(int $comment_id):void;
    public static function delCommentsAdmin(array $comment_id):void;

}

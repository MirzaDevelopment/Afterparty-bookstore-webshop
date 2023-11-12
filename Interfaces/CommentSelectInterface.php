<?php
/***Methods Comment class needs to implement***/
interface CommentSelectInterface
{

public static function selectAllComments(int $book_id):void;
public static function selectAllCommentsAdmin():void;
}
<?php
/***Select methods available for Admins for class to implement***/
interface SelectInterface
{
    
    public static function select(string $book_author, string $book_title, int $number1, int $number2):void;
    public static function selectAll():void;
    public static function selectDeletedBooks():void;
    public static function select_author(string $book_author):void;
    public static function select_title(string $book_title):void;
    public static function select_title_author(string $book_title, string $book_author):void;
    public static function select_number1(int $number1):void;
    public static function select_number2(int $number2):void;
    public static function select_number_both(int $number1, int $number2):void;
    public static function select_title_number_range(string $book_title, int $number1, int $number2):void;
    public static function select_author_number_1(string $book_author, int $number1):void;
    public static function select_author_number_2(string $book_author, int $number2):void;
    public static function select_author_number_range(string $book_author, int $number1, int $number2):void;
    public static function select_title_number_1(string $book_title, int $number1):void;
    public static function select_title_number_2(string $book_title, int $number2):void;
    public static function adminSelectCategory():void;
   
}

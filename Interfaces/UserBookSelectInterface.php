<?php
interface UserBookSelectInterface
//Methods for Booksdatabase classs (Book render and SELECT queries for users on first/front page with categories)
{
    
    public static function userSelectData(string $book_author, string $book_title, int $number1, int $number2):void;
    public static function userSelectAuthor(string $book_author):void;
    public static function userSelectAuthorNumber1(string $book_author, int $number1):void;
    public static function userSelectAuthorNumber2(string $book_author, int $number2):void;
    public static function userSelectAuthorPriceRange(string $book_author,int $number1, int $number2):void;
    public static function userSelectTitle(string $book_title):void;
    public static function userSelectTitleNumber1(string $book_title, int $number1):void;
    public static function userSelectTitleNumber2(string $book_title, int $number2):void;
    public static function userSelectTitlePriceRange(string $book_title, int $number1, int $number2):void;
    public static function userSelectTitleAuthor(string$book_title, string $book_author):void;
    public static function userSelectNumber1(int $number1):void;
    public static function userSelectNumber2(int $number2):void;
    public static function userSelectNumberBoth(int $number1, int $number2):void;
    public static function selectAllFront():void;
    public static function userSelectCategory():void;
   
}

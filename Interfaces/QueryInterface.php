<?php
declare(strict_types=1);
/***All methods available for Admins for books management class needs to implement***/
interface QueryInterface 
{
    public static function insert(string $book_title, string $book_pic, float $book_price, string $book_author, string $book_description, string $book_publisher, int $book_quantity, string $book_category, int $publish_year):void;
    public static function update_title(string $book_title, int $book_id):void;
    public static function update_author(string $book_author, int $book_id);
    public static function update_description(string $book_description, int $book_id):void;
    public static function update_image(string $book_pic, int $book_id):void;
    public static function update_publisher(string $book_publisher, int $book_id):void;
    public static function update_year(int $publish_year, int $book_id):void;
    public static function update_price(float $book_price, int $book_id):void;
    public static function set_discount(float $book_discount, int $book_id):void;
    public static function update_quantity(int $book_quantity, int $book_id):void;
    public static function insertCategory(string $book_category):void;
    public static function deleteCat(string $book_category):void;
    public static function update_category(int $book_category, int $book_id):void;
    public static function deleteDiscount(int $book_id):void;
}

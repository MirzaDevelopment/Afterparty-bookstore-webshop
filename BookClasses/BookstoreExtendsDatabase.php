<?php
declare(strict_types=1);
class Bookstore extends Database
{

   

    public function __construct($book_id, $book_title, $book_pic,  $book_price,  $book_author, $book_description, $book_publisher, $book_quantity, $book_category, $publish_year, $book_discount)
    {
        $this->book_id = $book_id;
        $this->book_title = $book_title;
        $this->book_pic = $book_pic;
        $this->book_price = $book_price;
        $this->book_author = $book_author;
        $this->book_publisher = $book_publisher;
        $this->book_quantity = $book_quantity;
        $this->book_category = $book_category;
        $this->book_description = $book_description;
        $this->publish_year = $publish_year;
        $this->book_discount = $book_discount;
        
    }
    
    /***DATABASE METHODS (CALLING PARENT METHODS)***/

    /***INSERT DATA METHODS***/
    public function Insert_db()
    {
        parent::insert($this->book_title, $this->book_pic, $this->book_price, $this->book_author, $this->book_description, $this->book_publisher, $this->book_quantity, $this->book_category, $this->publish_year);
    }

    /***DELETE ROW METHOD***/
    public static function deleteRow($book_id)
    {
        parent::delete($book_id);
    }

    /***RESTORE ROW METHOD***/
    public static function restoreRow($book_id)
    {
        parent::restore($book_id);
    }
 
}
/*** END***/

<?php
declare(strict_types=1);
class Books
{
    protected $book_id;
    protected $book_title;
    protected $book_price;
    protected $book_author;


    public function __construct($book_id, $book_title, $book_price, $book_author)
    {
        $this->$book_id;
        $this->book_title = $book_title;
        $this->book_price = $book_price;
        $this->book_author = $book_author;
    }



    public function __get($book_title)
    {
        return $book_title;
    }
    public function __set($book_price, $value)
    {
        $this->$book_price = $value;
    }

    function __toString()
    {

        return "Book: $this->book_title, price: $this->book_price $";
    }
}


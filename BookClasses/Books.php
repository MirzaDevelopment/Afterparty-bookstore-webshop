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

}


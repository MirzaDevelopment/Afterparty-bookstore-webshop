<?php

class Bookstore extends Books
{
protected $book_pic;
protected $book_description;
protected $book_publisher;
protected $book_quantity;
protected $book_category;
protected $publish_year;
protected $book_discount;


public function __construct($book_id, $book_pic, $book_title, $book_price, $book_author, $book_description, $book_publisher, $book_quantity, $book_category, int $publish_year, int $book_discount){
$this->book_id=$book_id;
$this->book_title=$book_title;
$this->book_pic=$book_pic;
$this->book_price=$book_price;
$this->book_author=$book_author;
$this->book_description=$book_description;
$this->book_publisher=$book_publisher;
$this->book_quantity=$book_quantity;
$this->book_category=$book_category;
$this->publish_year=$publish_year;
$this->book_discount=$book_discount;

parent::__construct($book_id, $book_title, $book_author, $book_price);

    
}

//Method to print general data
public function __toString(){
     return "Book: $this->title, price: $this->price$, Written by $this->author and published by $this->publisher";

    
}



}




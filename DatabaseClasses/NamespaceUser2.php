<?php
namespace connectUser2;
final class connectPdoUser {
private $server;
private $user;
private $password_db;
private $database;


public function __construct(){

   $this->server=$_ENV['DATABASE_SERVER'];
    $this->user=$_ENV['DATABASE_USER'];
    $this->password_db=$_ENV['DATABASE_PASS'];
    $this->database=$_ENV['DATABASE_NAME'];
}

public function connection():object{
    
    return new \PDO ("mysql:host=$this->server;  dbname=$this->database; charset=utf8mb4", "$this->user","$this->password_db");
    
}       
}
$objC=new connectPdoUser();
$connection=$objC->connection();


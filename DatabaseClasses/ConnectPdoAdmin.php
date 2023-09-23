<?php
declare(strict_types=1);
/***Simple connection class for Superadmin***/
final class ConnectPdo {
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
    
    return new PDO ("mysql:host=$this->server;  dbname=$this->database; charset=utf8mb4", "$this->user","$this->password_db");
    
}       
}
$objC=new ConnectPdo();
$connection=$objC->connection();

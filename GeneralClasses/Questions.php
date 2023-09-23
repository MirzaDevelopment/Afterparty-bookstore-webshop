<?php

class Questions 
{

    protected $name;
    protected $body;
    protected $email;
    protected $status="unanswered";

    protected function __construct($name, $body, $email, $status){
        $this->name=$name;
        $this->body=$body;
       $this->email=$email;
       $this->status=$status;
       
}




}

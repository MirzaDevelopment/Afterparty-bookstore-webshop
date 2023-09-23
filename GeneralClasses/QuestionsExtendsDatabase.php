<?php

class Questions extends QuestionDatabase {

    public function __construct($name, $body, $email, $status="unanswered"){
        $this->name=$name;
        $this->body=$body;
       $this->email=$email;
       $this->status=$status;

}

public function question_insert(){

    parent::insertQuestion($this->name,$this->body,$this->email, $this->status);
}
}
<?php
declare(strict_types=1);
/***User class***/
class User

{
protected $user_id;
protected $first_name;
protected $last_name;
protected $user_name;
protected $email;
protected $password;
protected $user_status;

public function __construct($user_id, $first_name, $last_name, $user_name, $email, $password, $user_status)
{
$this->user_id=$user_id;
$this->first_name=$first_name;
$this->last_name=$last_name;
$this->user_name=$user_name;
$this->email=$email;
$this->password=$password;
$this->user_status=$user_status;

}
 
}
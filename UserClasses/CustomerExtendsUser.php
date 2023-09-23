<?php
declare(strict_types=1);
/***Customer class extending User class***/
class Customer extends User {

protected $adress;
protected  $postal_code;
protected  $city;
protected  $adm_unit_id;
protected $phone_number;

public function __construct($user_id, $first_name, $last_name, $email, $password, $user_status, $adress, $postal_code, $city, $adm_unit_id, $phone_number)
{
$this->user_id=$user_id;
$this->first_name=$first_name;
$this->last_name=$last_name;
$this->email=$email;
$this->password=$password;
$this->user_status=$user_status;
$this->adress=$adress;
$this->postal_code=$postal_code;
$this->city=$city;
$this->adm_unit_id=$adm_unit_id;
$this->phone_number=$phone_number;
    
parent::__construct($user_id, $first_name, $last_name, $user_status, $email, $password, $user_status);
}


}
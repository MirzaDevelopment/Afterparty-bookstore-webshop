<?php
declare(strict_types=1);
/***Customer class extending its db class***/
class Customer extends CustomerDatabase
{
    public function __construct($user_id, $first_name, $last_name, $email,  $adress, $postal_code, $city, $adm_unit_id, $phone_number)
    {
        $this->user_id = $user_id;
        $this->first_name = $first_name;
        $this->last_name = $last_name;
        $this->email = $email;
        $this->adress=$adress;
        $this-> postal_code=$postal_code;
        $this->city=$city;
        $this->adm_unit_id=$adm_unit_id;
        $this->phone_number=$phone_number;
       
    }
/***CUSTOMER INSERT IN DB***/
    public function insert_user_customer()
    {
        parent::insertUserCustomer($this->first_name, $this->last_name, $this->email, $this->adress, $this->postal_code, $this->city, $this->adm_unit_id, $this->phone_number);
    }
   /***Customer delete***/
    public static function delete_customer($customerData)
    {
        parent::customerDelete($customerData);
    }
}

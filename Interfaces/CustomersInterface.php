<?php
/***Interface customers  class needs to implemet***/
interface CustomersInterface
{  
public function insertUserCustomer(string $first_name, string $last_name, string $email, string $adress, string $postal_code, string $city, int $adm_unit_id, string $phone_number):void;

}

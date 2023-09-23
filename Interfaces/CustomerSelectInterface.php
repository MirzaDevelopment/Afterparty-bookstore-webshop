<?php
//Methods for customer class to implement (SELECT queries to get customer info)
interface CustomerSelectInterface{

    public function selectAllCustomers():void;
    public static function selectSearchCustomers(mixed $user_input):void;
    public function selectDeletedCustomers():void;
}
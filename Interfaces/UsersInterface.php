<?php
//Methods for user class to implement 
interface UsersInterface
{
    public static function updateFirstName(int $user_id, string $first_name):void;
    public static function updateLastName(int $user_id, string $last_name):void;
    public static function updateUserStatus(int $user_id, int $user_status):void;
    public static function updateFirstNameByUser(string $first_name, string $user_name):void;
    public static function updateLastNameByUser(string $last_name, string $user_name):void;
    public static function updateUserByUser(string $first_name, string $last_name, string $user_name):void;
    public static function updateUserEmail(int $user_id, string $email):void;
    
}

<?php
//Methods for user class to implement (SELECT queries to get user info, and data for registration)
interface UserSelectInterface
{

    public static function selectAllFilledUsers(string $first_name, string $last_name,  string $user_name):void;
    public static function selectFirstName(string $first_name):void;
    public static function selectLastName(string $last_name):void;
    public static function selectUserName(string $user_name):void;
    public static function selectFirstNameLastName(string $first_name, string $last_name):void;
    public static function selectUser(string $user_name):void;
}

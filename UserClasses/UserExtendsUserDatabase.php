<?php
declare(strict_types=1);
/***User class extending its db class***/
class User extends UserDatabase
{
    public function __construct($user_id, $first_name, $last_name, $user_name, $email, $password, $user_status)
    {
        $this->user_id = $user_id;
        $this->first_name = $first_name;
        $this->last_name = $last_name;
        $this->user_name = $user_name;
        $this->email = $email;
        $this->password = $password;
        $this->user_status = $user_status;
    }
    /***INSERT USER BY SUPER ADMIN***/
    public function insert_user()
    {
        parent::insertUser($this->first_name, $this->last_name, $this->user_name, $this->email, $this->password, $this->user_status);
    }
    /***SHOW ALL USERS IN DB***/
    public static function select_all_users()
    {
        parent::selectAllUsers();
    }
    /***UPDATE USER BY SUPER ADMIN***/
    public function update_user()
    {
        parent::updateUser($this->user_id, $this->first_name, $this->last_name, $this->email, $this->user_status);
    }
    /***UPDATE USER BY USER***/
    public function update_user_by_user()
    {

        parent::updateUserByUser($this->first_name, $this->last_name, $this->user_name);
    }
    /***DELETE USER***/
    public static function delete_user($user_id)
    {

        parent::deleteUser($user_id);
    }
}

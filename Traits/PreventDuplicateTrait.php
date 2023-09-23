<?php

trait PreventDuplicateTrait
{ //Preventing users to use same username and email that are already in DB for admin user upload.

    public static function selectUserAndEmail():void
    {

        require "../../DatabaseClasses/Namespace.php";


        try {
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = $connection->query("SELECT user_name, email FROM dbs10877614.users"); //Fetching all user names and emails from database
            while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {

                $names = array(); //creating empty array in $names variable
                $names = $row['user_name']; //pushing database user names into $names array variable
                $_SESSION['user_names'][] = $names; //inserting array $names in session

                $emails = array(); //creating empty array in $emails variable
                $emails = $row['email']; //pushing database user names into $emails array variable
                $_SESSION['emails'][] = $emails; //inserting array $emails in session

            }
        } catch (PDOException $e) {
          date_default_timezone_set('Europe/Sarajevo');
            $error = $e->getMessage() . " " . date("F j, Y, g:i a");
            error_log($error . PHP_EOL, 3, "../Methods/Logs/logs.txt");
            echo "Failed to comply. Check log for more detail!";
        }
        $connection = null;
    }
    //Preventing users to use same username and email that are already in DB for user registration
    public static function selectUserAndEmailRegister():void
    {

        require "../DatabaseClasses/Namespace.php";


        try {
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = $connection->query("SELECT user_name, email FROM dbs10877614.users"); //Fetching all user names and emails from database
            while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {

                $names = array(); //creating empty array in $names variable
                $names = $row['user_name']; //pushing database user names into $names array variable
                $_SESSION['user_names'][] = $names; //inserting array $names in session

                $emails = array(); //creating empty array in $emails variable
                $emails = $row['email']; //pushing database user names into $emails array variable
                $_SESSION['emails'][] = $emails; //inserting array $emails in session

            }
        } catch (PDOException $e) {
          date_default_timezone_set('Europe/Sarajevo');
            $error = $e->getMessage() . " " . date("F j, Y, g:i a");
            error_log($error . PHP_EOL, 3, "../Methods/Logs/logs.txt");
            echo "Failed to comply. Check log for more detail!";
        }
        $connection = null;
    }
//Preventing uploading same book categories that are already in DB.
    public static function preventDoubleCategory():void
    {	
        require "../../DatabaseClasses/Namespace2.php";


        try {
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = $connection->query("SELECT book_category FROM dbs10877614.book_category"); //Fetching current categories from database
            while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {

                $categories = array(); //creating empty array in $names variable
                $categories = $row['book_category']; //pushing database user names into $names array variable
                $_SESSION['book_category'][] = $categories; //inserting array $names in session


            }
        } catch (PDOException $e) {
          date_default_timezone_set('Europe/Sarajevo');
            $error = $e->getMessage() . " " . date("F j, Y, g:i a");
            error_log($error . PHP_EOL, 3, "../Methods/Logs/logs.txt");
            echo "Failed to comply. Check log for more detail!";
        }
        $connection = null;
    }
}

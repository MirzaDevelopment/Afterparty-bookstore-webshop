<?php
declare(strict_types=1);
trait PasswordResetTrait
{
    /***Getting all emails in db, so we can check required mail with ones already stored */
    public static function selectAllEmail():void
    {	
        require "DatabaseClasses/Namespace.php";

        try {
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = $connection->query("SELECT email FROM {$_ENV['DATABASE_NAME']}.users"); //Fetching all emails from database
            while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {

                $emails = array(); //creating empty array in $emails variable
                $emails = $row['email']; //pushing database user names into $emails array variable
                $_SESSION['emails'][] = $emails; //inserting array $emails in session

            }
        } catch (PDOException $e) {
          date_default_timezone_set('Europe/Sarajevo');
            $error = $e->getMessage() . " " . date("F j, Y, g:i a");
            error_log($error . PHP_EOL, 3, "Methods/Logs/logs.txt");
            echo "Failed to comply. Check log for more detail!";
        }
        $connection = null;
    }

    /***GETTING USER CREDENTIALS REQUIRED FOR PASSWORD RESET***/
    public static function selectUserReset($email):void
    {	
        require "DatabaseClasses/ConnectPdo.php";
        try {
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = $connection->prepare("SELECT user_name, password, email FROM {$_ENV['DATABASE_NAME']}.users WHERE email =:email");
            $sql->execute(array('email' => $email));
            echo "<br>";

            while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {

                $_SESSION['email'] = $row['email'];
                $_SESSION['password'] = $row['password'];
                $_SESSION['username'] = $row['user_name'];
            }
        } catch (PDOException $e) {
          date_default_timezone_set('Europe/Sarajevo');
            $error = $e->getMessage() . " " . date("F j, Y, g:i a");
            error_log($error . PHP_EOL, 3, "Methods/Logs/logs.txt");
            echo "Failed to comply. Check log for more detail!";
        }
        $connection = null;
    }
	
    /***FINAL PASSWORD UPDATE LOGIC***/
    public static function passUpdateUser($password, $email):void
    { {	    
            require "DatabaseClasses/ConnectPdo.php";
            try {
                $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $sql = $connection->prepare("UPDATE {$_ENV['DATABASE_NAME']}.users SET password=:password, user_modified=:user_modified WHERE users.email=:email");
                $array = array('password' => $password, 'user_modified' => date("Y-m-d h:i:s"), 'email' => $email);
                foreach ($array as $key => $param) {
                    $sql->bindParam($key, $param);
                }
                $sql->execute($array);
                echo "<span class='passUpdateSuccess' style='font-size: 3.5rem;
                margin-top: 20%; display:inline-block;
                color: dodgerblue;'>You have successfully updated your password!</span>";
            } catch (PDOException $e) {
              date_default_timezone_set('Europe/Sarajevo');
                $error = $e->getMessage() . " " . date("F j, Y, g:i a");
                error_log($error . PHP_EOL, 3, "Methods/Logs/logs.txt");
                echo "Failed to update data in Database, check log for more detail!";
            }
            $connection = null;
        }
    }
}

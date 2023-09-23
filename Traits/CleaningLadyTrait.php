<?php
declare(strict_types=1);
trait CleaningLadyTrait
{
    /***USER FORMS VALIDATION AND SANITATION***/
    //Password sanitation, and validation (registration)
    public function passwordFullClean(): string
    { // With Hash ofcourse!
        $passwordOld = trim($_POST['password']);
        $passwordClean = htmlspecialchars($passwordOld, ENT_QUOTES);
        $passwordPattern = "/(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9])(?!.*\s).{8,20}/";
        if (preg_match($passwordPattern, $passwordClean)) {
            $hashedPass = password_hash($passwordClean, PASSWORD_DEFAULT);
            $password = $hashedPass;
            return $password;
        } else {
            die("<p class='goBackMsg'>REGISTRATION FAILED: your password must be at least 8 chars long and contain minimum one capital letter, number and a special character!</p>");
        }
    }
    //Password sanitation, and validation (login)
    public function passwordSanitize($ip): string
    {
        $passwordOld = trim($_POST['passwordLogin']);
        $password = htmlspecialchars($passwordOld, ENT_QUOTES);
        $passwordPattern = "/(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9])(?!.*\s).{8,20}/";
        if (preg_match($passwordPattern, $password)) {
            return $password;
        } else {
            IpSecurity::insertIp($ip);//Insert login attempt on each fail to keep track
            IpSecurity::selectIp($ip);//Getting number of attempts
            $count=$_SESSION['Attempts'];
            if ($count>3){
                die ("<div class='login-failed-ip'>You are allowed maximum of 3 tries per 10 minutes! Please try again later...</div>");
            }
            die("<div class='login-failed'>Login failed, wrong username or password!</div>");
        }
    }
    //First name input sanitation
    public function firstNameCleaning(): string
    {
        $firstname = trim($_POST['first_name']);
        $first_name = htmlspecialchars($firstname, ENT_QUOTES);
        return $first_name;
    }
    //Last name input sanitation
    public function lastNameCleaning(): string
    {
        $lastname = trim($_POST['last_name']);
        $last_name = htmlspecialchars($lastname, ENT_QUOTES);
        return $last_name;
    }
    //User name sanitation 
    public function userNameCleaning(): string
    {
        $username = trim($_POST['user_name']);
        $user_name = htmlspecialchars($username, ENT_QUOTES);
        return $user_name;
    }
    //Email input sanitation and validation
    public function emailCleaning(): string
    {
        $emailOld = trim($_POST['email']);
        $email = htmlspecialchars($emailOld, ENT_QUOTES);
        $emailPattern = "/^([a-zA-Z0-9_\-\.]+)@([a-zA-Z0-9_\-\.]+)\.([a-zA-Z]{2,5})$/";
        if (preg_match($emailPattern, $email)) {

            return $email;
        } else {

            die("<p class='goBackMsg'> Update failed: please make sure you typed email correctly!</p>");
        }
    }

    /***Customer extra variables sanitation***/
    //Adress input sanitation
    public function adressCleaning():string
    {
        $adressOld = trim($_POST['adress']);
        $adress = htmlspecialchars($adressOld, ENT_QUOTES);
        return $adress;
    }
    //Postal code sanitation
    public function postalCleaning():string
    {
        $postalOld = trim($_POST['postalCode']);
        $postal_code = htmlspecialchars($postalOld, ENT_QUOTES);
        return $postal_code;
    }
    //City sanitation
    public function cityCleaning():string
    {
        $citylOld = trim($_POST['city']);
        $city = htmlspecialchars($citylOld, ENT_QUOTES);
        return $city;
    }
    //Adm unit sanitation
    public function admUnitCleaning():int
    {
        $adm_unit_old = trim($_POST['adm_units']);
        $adm_unit = htmlspecialchars($adm_unit_old, ENT_QUOTES);
        return (int) $adm_unit;
        
    }

    //Phone sanitation
    public function phoneCleaning():string
    {
        $phoneOld = trim($_POST['phone']);
        $phone_number = htmlspecialchars($phoneOld, ENT_QUOTES);
        return $phone_number;
    }
    /***BOOK FORMS SANITATION***/
    //Book title sanitation 
    public function titleCleaning(): string
    {
        if ($_POST['title'] != (int)0) { //Making sure all other inputs are diff then int 0. ("0" as string is still possible)
            $book_title = trim($_POST['title']);
            $title = htmlspecialchars($book_title, ENT_QUOTES);
            return $title;
        } else {
            echo "Title must not be 0!";
            die;
        }
    }
    //Book title sanitation for Admin Search panel
    public function titleCleaningSearch(): string
    {
        if ($_POST['titleSearch'] != (int)0) { //Making sure all other inputs are diff then int 0. ("0" as string is still possible)
            $book_title = trim($_POST['titleSearch']);
            $title = htmlspecialchars($book_title, ENT_QUOTES);
            return $title;
        } else {
            echo "Title must not be 0!";
            die;
        }
    }

    //Book price sanitation
    public function priceCleaning(): float
    {
        if ($_POST['price'] != (int)0) {
            $book_price = trim($_POST['price']);
            $price = htmlspecialchars($book_price, ENT_QUOTES);
            return (float)$price;
        } else {
            echo "Price must not be 0!";
            die;
        }
    }

    //Book discount sanitation
    public function discountCleaning(): float
    {
        if ($_POST['discount'] != (int)0) {
            $b_discount = trim($_POST['discount']);
            $discount = htmlspecialchars($b_discount, ENT_QUOTES);
            return (float)$discount;
        } else {
            echo "Discount must not be 0!";
            die;
        }
    }
    //Book author sanitation
    public function authorCleaning(): string
    {
        if ($_POST['author'] != (int)0) {
            $book_author = trim($_POST['author']);
            $author = htmlspecialchars($book_author, ENT_QUOTES);
            return $author;
        } else {
            echo "Book author must not be 0!";
            die;
        }
    }

    //Book description sanitation
    public function descCleaning(): string
    {
        if ($_POST['description'] != (int)0) {
            $book_description = trim($_POST['description']);
            $description = htmlspecialchars($book_description, ENT_QUOTES);
            return $description;
        } else {
            echo "Book author must not be 0!";
            die;
        }
    }

    //Category insert input sanitation
    public function categoryCleaning(): string
    {
        $category = trim($_POST['newCategory']);
        $categoryNew = htmlspecialchars($category, ENT_QUOTES);
        return $categoryNew;
    }

    //Book publisher sanitation
    public function publisherCleaning(): string
    {
        if ($_POST['publisher'] != (int)0) {
            $book_publisher = trim($_POST['publisher']);
            $publisher = htmlspecialchars($book_publisher, ENT_QUOTES);
            return $publisher;
        } else {
            echo "Book Publisher must not be 0!";
            die;
        }
    }
    //Book quantity input field sanitation
    public function quantityCleaning(): int
    {
        $quantity = trim($_POST['quantity']);

        $quantityFinal = htmlspecialchars($quantity, ENT_QUOTES);
        return (int)$quantityFinal;
    }

    //Book publish year sanitation
    public function publishYearCleaning(): int
    {
        if ($_POST['year'] != (int)0) {
            (string)$publish_year = trim($_POST['year']);
            $year = htmlspecialchars($publish_year, ENT_QUOTES);
            return (int)$year;
        } else {
            echo "Publish year must not be 0!";
            die;
        }
    }
    //Number 1 input field sanitation
    public function number1Cleaning(): int
    {
        if ($_POST['number1'] != (int)0) {
            $numberOne = trim($_POST['number1']);
            $number1 = htmlspecialchars($numberOne, ENT_QUOTES);
            return (int) $number1;
        } else {
            echo "Minimum price must not be 0!";
            die;
        }
    }
    //Number 2 input field sanitation
    public function number2Cleaning(): int
    {
        if ($_POST['number2'] != (int)0) {
            $numberTwo = trim($_POST['number2']);
            $number2 = htmlspecialchars($numberTwo, ENT_QUOTES);
            return (int)$number2;
        } else {
            echo "Maximum price must not be 0!";
            die;
        }
    }
    //Email reset validation input
    public function emailCleaningReset(): mixed
    {
        $emailUser = trim($_POST['passReset']);
        if (!empty($emailUser)) {
            $emailClean = htmlspecialchars($emailUser, ENT_QUOTES);
            $emailPattern = "/^([a-zA-Z0-9_\-\.]+)@([a-zA-Z0-9_\-\.]+)\.([a-zA-Z]{2,5})$/";
            if (preg_match($emailPattern, $emailClean)) {

                return $emailClean;
            } else {

                die("ACTION FAILED: please make sure you typed email correctly!");
            }
        } else {
            die("Mail is empty! Please enter your registered mail!");
        }
    }
    //Verification password reset digits input sanitation
    public function digitsCleanReset(): int
    {
        $digitsUser = trim($_POST['passDigits']);
        $digitsUserClean = htmlspecialchars($digitsUser, ENT_QUOTES);
        return (int)$digitsUserClean;
    }

    //Verification registration digits input sanitation
    public function digitsCleanRegister(): int
    {
        $digitsRegister = trim($_POST['regDigits']);
        $digitsRegisterClean = htmlspecialchars($digitsRegister, ENT_QUOTES);
        return (int)$digitsRegisterClean;
    }


    /***USER QUESTION SANITATION**/

    //User name sanitation

    public function questionUserNameClean(): string
    {

        $user_name_raw = trim($_POST['questionUserName']);
        $user_name_clean = htmlspecialchars($user_name_raw, ENT_QUOTES);
        return $user_name_clean;
    }

    //Message Body sanitation
    public function questionBodyClean(): string
    {

        $question_body_raw = trim($_POST['questionBody']);
        $question_body_clean = htmlspecialchars($question_body_raw, ENT_QUOTES);
        return $question_body_clean;
    }

    //Question email sanitation
    public function questionEmailClean(): string
    {

        $question_email_raw = trim($_POST['questionEmail']);
        $question_email_clean = htmlspecialchars($question_email_raw, ENT_QUOTES);
        return $question_email_clean;
    }

    //Transaction search input sanitation 
    public function transCleaning():string
    {
    $userInput=trim($_POST['transSearch']);
    $userInputClean=htmlspecialchars($userInput, ENT_QUOTES);
    return $userInputClean;

    }

      //Customer search input sanitation 
      public function custCleaning():string
      {
      $userInput=trim($_POST['custSearch']);
      $userInputClean=htmlspecialchars($userInput, ENT_QUOTES);
      return $userInputClean;
  
      }
}

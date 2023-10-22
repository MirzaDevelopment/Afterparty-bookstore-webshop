<?php
declare(strict_types=1);
class SetUser //VARIABLE SETTING CLASS WITH TRAITS (USER PANEL)
{
    use CleaningLadyTrait; //Validation and sanitation trait
    use PreventDuplicateTrait; //Trait to prevent duplicates of user name and email i database during registration of users
    use PasswordResetTrait; //Traits used to reset user passwords
  	use SelectUserTrait;
    private $digits; //Relates to User password restart
    private $reg_verification; //Relates to User registration mail verification

    /***Method for user mail verification before registration***/
    public function varSettingUsers()
    {
        if (isset($_POST['first_name']) && !empty($_POST['first_name'])) {
            if (isset($_POST['last_name']) && !empty($_POST['last_name'])) {
                if (isset($_POST['user_name']) && !empty($_POST['user_name'])) {
                    if (isset($_POST['email']) && !empty($_POST['email'])) {
                        if (isset($_POST['password']) && !empty($_POST['password'])) {
                            if (isset($_POST['terms']) && !empty($_POST['terms'])) {
                                //Calling in the trait method to fetch user names and emails already in Database.
                                $this->selectUserAndEmailRegister();
                                if (in_array($_POST['user_name'], $_SESSION['user_names'])) {
                                    die("<p class='goBackMsg'>User name already taken! Please choose another user name.</p>");
                                } else if (in_array($_POST['email'], $_SESSION['emails'])) {
                                    die("<p class='goBackMsg'>Email already taken! Please choose another email.</p>");
                                }
                                //Validation and sanitation from Cleaning lady trait
                                $_SESSION['firstName'] = $this->firstNameCleaning();
                                $_SESSION['lastName'] = $this->lastNameCleaning();
                                $_SESSION['userName'] = $this->userNameCleaning();
                                $_SESSION['email'] = $this->emailCleaning();
                                $_SESSION['password'] = $this->passwordFullClean();
                                /***DATABASE AND USER CLASSES INCLUDE***/
                                /***Registration mail verification part***/
                                $this->reg_verification = random_int(1000, 99999);
                                require __DIR__ . "../../Form.php";
                                require __DIR__ . "../../Methods/Mail/regMail.php";
                                $objekatMail = new Form;
                                $objekatMail->renderMailReg(); //Rendering form for user to type the digits recieved in mail
                                $_SESSION['regDigitsMail'] = $this->reg_verification;
                            } else {
                                echo "<p class='goBackMsgTerms'>Please accept terms and conditions!</p>";
                            }
                        } else {
                            echo "<p class='goBackMsg'>Ooops...It seems that you have forgotten to write password!</p>";
                        }
                    } else {
                        echo "<p class='goBackMsg'>Ooops...It seems that you have forgotten to write email!</p>";
                    }
                } else {
                    echo "<p class='goBackMsg'>Ooops...It seems that you have forgotten to write user name!</p>";
                }
            } else {
                echo "<p class='goBackMsg'>Ooops...It seems that you have forgotten to write last name!</p>";
            }
        } else {
            echo "<p class='goBackMsg'>Notice: Make sure all fields are filled in correctly!</p>";
        }
    }
    /***Number verification method and final user registration***/
    public function varSettingMailReg()
    {
        if (isset($_POST['regDigits']) && !empty($_POST['regDigits'])) {
           session_start();
            $regDigits = $this->digitsCleanRegister();
            if ($regDigits === $_SESSION['regDigitsMail']) {
                $first_name = $_SESSION['firstName'];
                $last_name = $_SESSION['lastName'];
                $user_name = $_SESSION['userName'];
                $email = $_SESSION['email'];
                $password = $_SESSION['password'];
                /***Registration mail verification part END***/
                require __DIR__."../../Interfaces/UserSelectInterface.php";
                require __DIR__ . "../../Interfaces/UsersInterface.php";
                require __DIR__ . "../../DatabaseClasses/UserDatabase.php";
                require __DIR__ . "../../UserClasses/UserExtendsUserDatabase.php";
                $objekat = new User(null, $first_name, $last_name, $user_name, $email, $password, 3);
                $objekat->insert_user();
                session_destroy();
                echo "<meta http-equiv='refresh' content='4;URL=User/userPanel.php'>";
                echo "<p class='registerSuccess'>You have Registered successfully! Please login with your new credentials!</p>";
                exit();
            } else {
                echo "<span class='goBackMsg2'>Numbers dont match!</span>";
            }
        }
    }

    /***USER LOGIN VARIABLE CHECKING***/
    public function loginUser()
    {
        if (isset($_POST['user_name']) && !empty($_POST['user_name'])) {
            if (isset($_POST['passwordLogin']) && !empty($_POST['passwordLogin'])) {
                //Checking for ip adress to implement the login limitiation feature and storing in variable
                   if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
                    $ip = $_SERVER['HTTP_CLIENT_IP'];
                } else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
                } else {
                    $ip =  $_SERVER['REMOTE_ADDR'];
                }
                require __DIR__ . "../../DatabaseClasses/UserDatabase.php";
                require __DIR__ . "../../DatabaseClasses/IpSecurity.php";
                require __DIR__ . "../../UserClasses/UserExtendsUserDatabase.php";
                $user_name = $this->userNameCleaning();
                $password = $this->passwordSanitize($ip);
                User::selectUser($user_name); //Selecting user credential for successfull validation
                if (!empty($_SESSION['password'])) {
                    if (password_verify($password, $_SESSION['password'])) {
                        $_SESSION['rawPassword'] = $password;
                        if ($user_name == $_SESSION['username'] && $_SESSION['status'] == 1) {
                          $_SESSION['loginUsername']=$user_name;
                            echo "<p id='loginSuccess'>You have logged in successfully!</p>";
                            IpSecurity::deleteIp($ip); //Deleting login attempts from this ip made in last 10 minutes
                            exit();
                        } else if ($user_name == $_SESSION['username'] && $_SESSION['status'] == 3) {
                          $_SESSION['loginUsername']=$user_name;
                            echo "<p id='loginSuccess'>You have logged in successfully!</p>";
                            IpSecurity::deleteIp($ip); //Deleting login attempts from this ip made in last 10 minutes
                            exit();
                        } else if ($user_name == $_SESSION['username'] && $_SESSION['status'] == 2) {
                          $_SESSION['loginUsername']=$user_name;
                            echo "<p id='loginSuccess'>You have logged in successfully!</p>";
                            IpSecurity::deleteIp($ip); //Deleting login attempts from this ip made in last 10 minutes
                            exit();
                        } else {
                            IpSecurity::insertIp($ip); //Insert login attempt on each fail to keep track
                            IpSecurity::selectIp($ip); //Getting number of attempts
                            $count = $_SESSION['Attempts'];
                            if ($count > 3) {
                             die("<div class='login-failed-ip'>You are allowed maximum of 3 tries per 10 minutes!</div>");
                              
                            }
                           echo "<div class='login-failed'> Login failed, Wrong username or password!</div>";     
                        }
                    } else if (!password_verify($password, $_SESSION['password'])) {

                        IpSecurity::insertIp($ip); //Insert login attempt on each fail to keep track
                        IpSecurity::selectIp($ip); //Getting number of attempts
                        $count = $_SESSION['Attempts'];
                        if ($count > 3) {
                            die("<div class='login-failed-ip'>You are allowed maximum of 3 tries per 10 minutes!</div>");
                        }
                        echo "<div class='login-failed'> Login failed, Wrong username or password!</div>";
                    }
                } else {
                    echo "<div class='login-failed-notfound'> User not found!</div>"; 
                }
            } else {
                echo "<div class='login-failed-empty'>Password field empty</div>";
            }
        } else {
            echo "<div class='login-failed-user'>User field empty</div>";
        }
    }

    /***VARIABLE SETTING FOR USER PASSWORD RESET AND UPDATE***/
    public function passwordUpdateUser()
    {

        if (isset($_POST['password']) && !empty($_POST['password'])) {
          session_start();
            $password = $this->passwordFullClean();
            $email = $_SESSION['email'];
            $this->passUpdateUser($password, $email);
            echo "<a href='loginPage' style='display: block;margin-top: 1%; font-size: 3.8rem;text-decoration: none'> Login with your new password!</a>";
        }
    }

    /***VARIABLE SETTING METHOD FOR UPDATE USERS BY USERS***/
    public function varSettingUsersUpdateByUsers()
    {
        if (isset($_POST['first_name']) && isset($_POST['last_name'])) {
            $user_name = $_SESSION['username'];
            $first_name = $this->firstNameCleaning();
            $last_name = $this->lastNameCleaning();

            /***Update user first name***/
            if (!empty($first_name) && empty($last_name)) {
                require __DIR__ . "../../DatabaseClasses/UserDatabase.php";
                require __DIR__ . "../../UserClasses/UserExtendsUserDatabase.php";
                User::updateFirstNameByUser($first_name, $user_name);
            }

            /***Update user last name***/
            if (empty($first_name) && !empty($last_name)) {
                require __DIR__ . "../../DatabaseClasses/UserDatabase.php";
                require __DIR__ . "../../UserClasses/UserExtendsUserDatabase.php";
                User::updateLastNameByUser($last_name, $user_name);
            }
            /***Update first and last name(all filled)***/
            if (!empty($first_name) && !empty($last_name)) {

                /***DATABASE AND USER CLASSES INCLUDE AND CLASS INSTANCE***/
                require __DIR__ . "../../DatabaseClasses/UserDatabase.php";
                require __DIR__ . "../../UserClasses/UserExtendsUserDatabase.php";
                $objekat = new User(null, $first_name, $last_name, $user_name, null, null, null);
                $objekat->update_user_by_user();
                if ($objekat) {
                    die("User updated successfully!");
                }
            }
        }
    }

    /***USER SEARCH PANEL VARIABLE SETTING***/

    public function userVarSearchSettingBooks()
    {
        if (isset($_POST['author']) && isset($_POST['title']) && isset($_POST['number1']) && isset($_POST['number2'])) {
            $book_author = $this->authorCleaning();
            $book_title = $this->titleCleaning();
            $number1 = $this->number1Cleaning();
            $number2 = $this->number2Cleaning();
            /***USER SEARCH BOOKS WITH ALL FILLED***/
            if (!empty($book_author) && !empty($book_title) && !empty($number1) && !empty($number2)) {
                Booksdatabase::userSelectData($book_author, $book_title, $number1, $number2);
                echo "<br>";
                /***USER SEARCH BOOKS WITH ONLY AUTHOR FILLED***/
            } else if (!empty($book_author) && empty($book_title) && empty($number1) && empty($number2)) {
                Booksdatabase::userSelectAuthor($book_author);
                echo "<br>";
                /***USER SEARCH BOOKS WITH AUTHOR AND MIN PRICE***/
            } else if (!empty($book_author) && !empty($number1) && empty($book_title) && empty($number2)) {
                Booksdatabase::userSelectAuthorNumber1($book_author, $number1);
                echo "<br>";
                /***USER SEARCH BOOKS WITH AUTHOR AND MAX PRICE***/
            } else if (!empty($book_author) && empty($number1) && empty($book_title) && !empty($number2)) {
                Booksdatabase::userSelectAuthorNumber2($book_author, $number2);
                echo "<br>";
                /***USER SEARCH BOOKS WITH AUTHOR AND PRICE RANGE***/
            } else if (!empty($book_author) && !empty($number1) && empty($book_title) && !empty($number2)) {
                Booksdatabase::userSelectAuthorPriceRange($book_author, $number1, $number2);
                echo "<br>";
                /***USER SEARCH BOOKS WITH TITLE FILLED***/
            } else if (empty($book_author) && empty($number1) && !empty($book_title) && empty($number2)) {
                Booksdatabase::userSelectTitle($book_title);
                echo "<br>";
                /***USER SEARCH BOOKS WITH TITLE AND MIN PRICE FILLED***/
            } else if (empty($book_author) && !empty($number1) && !empty($book_title) && empty($number2)) {
                Booksdatabase::userSelectTitleNumber1($book_title, $number1);
                echo "<br>";
                /***USER SEARCH BOOKS WITH TITLE AND MAX PRICE FILLED***/
            } else if (empty($book_author) && empty($number1) && !empty($book_title) && !empty($number2)) {
                Booksdatabase::userSelectTitleNumber2($book_title, $number2);
                echo "<br>";
                /***USER SEARCH BOOKS WITH TITLE AND PRICE RANGE FILLED***/
            } else if (empty($book_author) && !empty($number1) && !empty($book_title) && !empty($number2)) {
                Booksdatabase::userSelectTitlePriceRange($book_title, $number1, $number2);
                echo "<br>";
                /***USER SEARCH BOOKS WITH TITLE AND AUTHOR FILLED***/
            } else if (!empty($book_author) && empty($number1) && !empty($book_title) && empty($number2)) {
                Booksdatabase::userSelectTitleAuthor($book_title, $book_author);
                echo "<br>";
                /***USER SEARCH BOOKS WITH  MIN PRICE***/
            } else if (empty($book_author) && empty($book_title) && !empty($number1) && empty($number2)) {
                Booksdatabase::userSelectNumber1($number1);
                echo "<br>";
                /****USER SEARCH BOOKS WITH MAX PRICE***/
            } else if (empty($book_author) && empty($book_title) && empty($number1) && !empty($number2)) {
                Booksdatabase::userSelectNumber2($number2);
                echo "<br>";
                /***USER SEARCH BOOKS WITH PRICE RANGE***/
            } else if (empty($book_author) && empty($book_title) && !empty($number1) && !empty($number2)) {
                Booksdatabase::userSelectNumberBoth($number1, $number2);
                echo "<br>";
            }else{
            echo "<img id='emptyIcon' src='Methods/img/sorry(2).png' width='100' alt='sorry-icon'>";
            echo "<p id='empty'>Ooops...it seems that you didn't specify any search criteria. Please try again.<p>";
        }
          }
    }
    /***USER PASSWORD RESET LOGIC***/
    public function resetPassword()
    {

        if (isset($_POST['passReset'])) {
			session_start();
            $pass_reset = $this->emailCleaningReset();
            $_SESSION['passReset'] = $pass_reset;
            $this->digits = random_int(1000, 9999);
            $_SESSION['digits'] = $this->digits;
            require __DIR__ . "../../Methods/Mail/resetMail.php"; //Sending message to user mail with 4-digit random numbers

        }
    }
    /***NUMBERS VERIFICATION AND EMAIL PRESENCE IN DB CHECK (MATCHING USER TYPED NUMBERS WITH ONE RECIEVED IN MAIL)***/
    public function verifyNumbers()
    {
        if (isset($_POST['passDigits']) && !empty($_POST['passDigits'])) {
          session_start();

            $digitsUserClean = $this->digitsCleanReset();
            if ($digitsUserClean == $_SESSION['digits']) {
                require __DIR__ . "../../Form.php";
                $email = $_SESSION['passReset'];
                $this->selectAllEmail(); //Calling in the trait method to fetch  emails already in Database.
                if (!in_array($email, $_SESSION['emails'])) { //checking if user posted mail exsists in DB
                     echo "<div class='login-failed-password'>The email does not exist in our database. Please complete registration process again.</div>";
                } else {
                    $this->selectUserReset($email);
                    $obj1 = new Form("../server");
                    $obj1->newPassForm();
                }
            } else {
                echo "<span class='numFail'>Numbers do not match. Please use correct numbers recieved in mail!</span>";
            }
            unset($_SESSION['username']); //Unsetting session so it doesnt mess with player returning to "loginPage.php"
        }
    }
    /***USER QUESTION SETTING AND INSERT LOGIC***/
    public function questionInsertSetting()
    {
        if (isset($_POST['questionUserName']) && !empty($_POST['questionUserName'])) {
            if (isset($_POST['questionBody']) && !empty($_POST['questionBody'])) {
                if (isset($_POST['questionEmail']) && !empty($_POST['questionEmail'])) {
                    $name = $this->questionUserNameClean();
                    $body = $this->questionBodyClean();
                    $email = $this->questionEmailClean();
                    require __DIR__ . "../../DatabaseClasses/QuestionDatabase.php";
                    require __DIR__ . "../../GeneralClasses/QuestionsExtendsDatabase.php";
                    $objekat = new Questions($name, $body, $email);
                    $objekat->question_insert();
                } else {
                    echo "<span class='questionReject'>Email field empty!</span>";
                }
            } else {
                echo "<span class='questionReject'>Question field empty!</span>";
            }
        } else {
            echo "<span class='questionReject'>User name empty!</span>";
        }
    }
   /***USER COMMENT SETTING AND INSERT LOGIC***/
    public function commentInsertSetting()
    {
        if (isset($_POST['comment']) && !empty($_POST['comment'])) {
            require __DIR__ . "../../Interfaces/CommentInterface.php";
            require __DIR__ . "../../DatabaseClasses/CommentDatabase.php";
            require __DIR__ . "../../GeneralClasses/CommentsExtendsDatabase.php";
            $username=$_SESSION['username'];
            $comment_body=$this->commentBodyClean();//Cleaned and censored comment text
            $comment_book_id=(Int)$_SESSION['id'];
            $comment_user_id=$this->getUser($username);
            //Calculate time difference to prevent comment spam
            if(isset($_SESSION['timestamp'])){
            $from_time=strtotime($_SESSION['timestamp']);
            $to_time=strtotime(date('H:i:s'));
            $diff_minutes = round(abs($from_time - $to_time) / 60,2);
            if ($diff_minutes>10){
            Comments::insertComment($comment_user_id, $comment_body, $comment_book_id);
        } else{
            echo "<p id='failComment' class='goBackMsg'>Sorry, but you can only post one review per 10 minutes</p>";
        }

        }else {
            Comments::insertComment($comment_user_id, $comment_body, $comment_book_id);
            
        }
    } else if (isset($_POST['comment']) && empty($_POST['comment'])) {
        echo "<p id='failComment' class='goBackMsg'>Ooops...you didn't write any comments!</p>";
    }
}
}

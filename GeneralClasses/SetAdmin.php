<?php
declare(strict_types=1);
class SetAdmin //VARIABLE SETTING CLASS WITH TRAITS
{
    use CleaningLadyTrait; //Validation and sanitation trait
    use PreventDuplicateTrait; //Trait to prevent duplicates of user name and email i database during registration of users

    /***Methods***/
    /***USER UPLOAD BY SUPER ADMIN WITH SANITATION AND VALIDATION***/
    public function varSettingUsersInsert():void
    {
        if (isset($_POST['first_name']) && !empty($_POST['first_name'])) {
            if (isset($_POST['last_name']) && !empty($_POST['last_name'])) {
                if (isset($_POST['user_name']) && !empty($_POST['user_name'])) {
                    if (isset($_POST['email']) && !empty($_POST['email'])) {
                        if (isset($_POST['password']) && !empty($_POST['password'])) {
                            if (isset($_POST['userStatus']) && !empty($_POST['userStatus'])) {
                                //Calling in the trait method to fetch user names and emails already in Database.
                                $this->selectUserAndEmail();
                                if (in_array($_POST['user_name'], $_SESSION['user_names'])) {
                                    die("<p class='goBackMsg'>User name already taken! Please choose another user name.</p>");
                                } else if (in_array($_POST['email'], $_SESSION['emails'])) {
                                    die("<p class='goBackMsg'>Email already taken! Please choose another email.</p>");
                                }
                                $user_status_raw = $_POST['userStatus'];
                                switch ($user_status_raw) {
                                    case "user":
                                        $user_status = 3;
                                        break;
                                    case "admin":
                                        $user_status = 2;
                                }
                                $first_name = $this->firstNameCleaning();
                                $last_name = $this->lastNameCleaning();
                                $user_name = $this->userNameCleaning();
                                $email = $this->emailCleaning();
                                $password = $this->passwordFullClean();

                                /***DATABASE AND USER CLASSES INCLUDE***/
                                require __DIR__ . "../../DatabaseClasses/UserDatabase.php";
                                require __DIR__ . "../../UserClasses/UserExtendsUserDatabase.php";
                                $objekat = new User(null, $first_name, $last_name, $user_name, $email, $password, $user_status);
                                $objekat->insert_user();
                                echo ("<meta http-equiv='refresh' content='4'>");
                                if ($objekat) {
                                    echo "<p class='userUploadMsg'>User uploaded successfully!</p>";
                                } else {
                                    echo "<p class='goBackMsg'>Something is wrong please try again!</p>";
                                }
                            } else {
                                echo "<p class='goBackMsg'>Ooops...It seems that you have forgotten to pick user status</p>";
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

    /***VARIABLE SETTING METHOD FOR INSERT BOOKS***/
    public function varSettingBooks():void
    {
        if (isset($_POST['title']) && !empty($_POST['title'])) {
            if (isset($_POST['author']) && !empty($_POST['author'])) {
                if (isset($_POST['price']) && !empty($_POST['price'])) {
                    if (isset($_POST['publisher']) && !empty($_POST['publisher'])) {
                        if (isset($_POST['quantity']) && ($_POST['quantity'] >= 0)) {
                            if (isset($_POST['description']) && !empty($_POST['description'])) {
                                if (isset($_POST['category']) && !empty($_POST['category'])) {
                                    if (isset($_POST['year']) && !empty($_POST['year'])) {
                                        if (!empty($_FILES['img'])) {
                                            //IMAGE UPLOAD VALIDATION
                                            $uploads_dir = "../../Methods" . "/img/";
                                            $image_types = array('image/png', 'image/jpg', 'image/jpeg', 'image/webp');
                                            if ($_FILES['img']['size'] <= 0) {
                                                die("Invalid file size!");
                                            } else if ($_FILES['img']['size'] > 1000000) {
                                                die("Error file too large!");
                                            } else if (!in_array($_FILES['img']['type'], $image_types)) {
                                                die("File now allowed, please use only JPEG, JPG, PNG or webp types!");
                                            } else if (!in_array(mime_content_type($_FILES['img']['tmp_name']), $image_types)) {
                                                die("File now allowed, please use only JPEG, JPG, PNG or web types!");
                                            } else {
                                                if (move_uploaded_file($_FILES['img']['tmp_name'], $uploads_dir . $_FILES['img']['name'])) {
                                                    echo "File uploaded successfully!<br>";
                                                } else {
                                                    die("File not uploaded!");
                                                }
                                            }
                                            echo "This is your book image: " . "<br><br>";
                                            $img_path = $_FILES['img']['name'];
                                            echo "<img src='../img/" . $img_path . "'width='200' height='100'>"; //IMAGE PROJECTING ON FRONTEND SO USER CAN SEE
                                            //REST OF THE INPUT SANITATION
                                            $book_title = $this->titleCleaning();
                                            $book_pic = "<img class='shroudImg' src='../img/"  . $img_path . "'alt='book image' width='200' height='300'>"; //IMAGE LINK STORED IN DATABASE
                                            $book_price = $this->priceCleaning();
                                            $book_author = $this->authorCleaning();
                                            $book_description = $this->descCleaning();
                                            $book_publisher = $this->publisherCleaning();
                                            $book_quantity = $this->quantityCleaning();
                                            $book_category = $_POST['category'];
                                            $publish_year = $this->publishYearCleaning();

                                            /***BOOKSTORE CLASS INCLUDE***/
                                            require __DIR__ . "../../DatabaseClasses/Database.php";
                                            require __DIR__ . "../../BookClasses/BookstoreExtendsDatabase.php";
                                            $objekat = new Bookstore(null, $book_title, $book_pic, $book_price,  $book_author, $book_description, $book_publisher, $book_quantity, $book_category, $publish_year, null);
                                            $objekat->insert_db();
                                            echo ("<meta http-equiv='refresh' content='4'>");
                                            die();
                                        } else {
                                            echo "No files selected...";
                                        }
                                    } else {
                                        echo "Ooops...It seems that you have forgotten to write publish year!";
                                    }
                                } else {
                                    echo "Ooops...It seems that you have forgotten to pick book category!";
                                }
                            } else {
                                echo "Ooops...It seems that you have forgotten to write a description!";
                            }
                        } else {
                            echo "Ooops...It seems that you have forgotten to write book quantity!";
                        }
                    } else {
                        echo "Ooops... It seems that you have forgotten to write a publisher!";
                    }
                } else {
                    echo "Ooops...It seems that you have forgotten to write a book price!";
                }
            } else {
                echo "Ooops...It seems that you have forgotten to write a book author!";
            }
        } 
    }

    /***VARIABLE SETTING METHOD FOR INSERT BOOK CATEGORIES***/
    public function varSettingCategoryInsert():void
    {
        if (isset($_POST['newCategory']) && !empty($_POST['newCategory'])) {
            $this->preventDoubleCategory();
            if (in_array($_POST['newCategory'], $_SESSION['book_category'])) {
               echo ("<meta http-equiv='refresh' content='3'>");
                echo "<div id='catAnchor' class='login-failed'>Category already exists! Please choose another!</div>";
            } else {
                $book_category = $this->categoryCleaning();
                Database::insertCategory($book_category);
                echo ("<meta http-equiv='refresh' content='3'>");
                exit();
            }
        }
        unset($_SESSION['book_category']);
    }

    /***VARIABLE SETTING METHOD FOR UPDATE BOOKS***/
    public function varSettingBooksUpdate():void
    {
        if (isset($_POST['title']) && isset($_POST['author']) && isset($_POST['price']) && isset($_POST['discount']) && isset($_POST['publisher']) && isset($_POST['description']) && isset($_POST['year'])) {
            $book_id = $_SESSION['update_key'];
            $book_title = $this->titleCleaning();
            $book_price = $this->priceCleaning();
            $book_discount = $this->discountCleaning();
            $book_author = $this->authorCleaning();
            $book_description = $this->descCleaning();
            $book_publisher = $this->publisherCleaning();
            $publish_year = $this->publishYearCleaning();
            /***Update book title ***/
            if (empty($book_author) && !empty($book_title) && empty($book_price) && empty($book_discount) && empty($book_description) && empty($book_publisher)  && empty($publish_year)) { 
              require __DIR__ . "../../DatabaseClasses/Database.php";
                require __DIR__ . "../../BookClasses/BookstoreExtendsDatabase.php";
                Bookstore::update_title($book_title, $book_id);
                die();
            }
            /***Update book author***/
            if (!empty($book_author) && empty($book_title) && empty($book_price) && empty($book_discount) && empty($book_description) && empty($book_publisher)  && empty($publish_year)) {
                require __DIR__ . "../../DatabaseClasses/Database.php";
                require __DIR__ . "../../BookClasses/BookstoreExtendsDatabase.php";
                Bookstore::update_author($book_author, $book_id);
                die();
            }
            /***Update book description***/
            if (empty($book_author) && empty($book_title) && empty($book_price) && empty($book_discount) && !empty($book_description) && empty($book_publisher)  && empty($publish_year)) {
                require __DIR__ . "../../DatabaseClasses/Database.php";
                require __DIR__ . "../../BookClasses/BookstoreExtendsDatabase.php";
                Bookstore::update_description($book_description, $book_id);
                die();
            }

            /***Update book publisher***/
            if (empty($book_author) && empty($book_title) && empty($book_price) && empty($book_discount) && empty($book_description) && !empty($book_publisher)  && empty($publish_year)) {
                require __DIR__ . "../../DatabaseClasses/Database.php";
                require __DIR__ . "../../BookClasses/BookstoreExtendsDatabase.php";
                Bookstore::update_publisher($book_publisher, $book_id);
                die();
            }
            /***Update publish year***/
            if (empty($book_author) && empty($book_title) && empty($book_price) && empty($book_discount) && empty($book_description) && empty($book_publisher) && !empty($publish_year)) {
                require __DIR__ . "../../DatabaseClasses/Database.php";
                require __DIR__ . "../../BookClasses/BookstoreExtendsDatabase.php";
                Bookstore::update_year($publish_year, $book_id);
                die();
            }
            /***Update book price ***/
            if (empty($book_author) && empty($book_title) && !empty($book_price)  && empty($book_discount) && empty($book_description) && empty($book_publisher)  && empty($publish_year)) {
                if ($book_price > 0) {
                    require __DIR__ . "../../DatabaseClasses/Database.php";
                    require __DIR__ . "../../BookClasses/BookstoreExtendsDatabase.php";
                    Bookstore::update_price($book_price, $book_id);
                    die();
                } else {
                    echo "Book price must be positive value!";
                    die();
                }
            }
            /***Update discounted price***/
            if (empty($book_author) && empty($book_title) && empty($book_price) && !empty($book_discount) && empty($book_description) && empty($book_publisher)  && empty($publish_year)) {
                if ($book_discount > 0) {
                    require __DIR__ . "../../DatabaseClasses/Database.php";
                    require __DIR__ . "../../BookClasses/BookstoreExtendsDatabase.php";
                    Bookstore::set_discount($book_discount, $book_id);
                    die();
                } else {
                    echo "Discount must be positive value!";
                    die();
                }
            }

            /***Update book image data***/
            if (empty($book_author) && empty($book_title) && empty($book_price) && empty($book_discount) && empty($book_description) && empty($book_publisher) && empty($publish_year) && !empty($_FILES['img'])) {
                //IMAGE UPLOAD VALIDATION
                $uploads_dir = "../../Methods" . "/img/";
                $image_types = array('image/png', 'image/jpg', 'image/jpeg', 'image/webp');
                if ($_FILES['img']['size'] <= 0) {
                    die("Invalid file size!");
                } else if ($_FILES['img']['size'] > 1000000) {
                    die("Error file too large!");
                } else if (!in_array($_FILES['img']['type'], $image_types)) {
                    die("File now allowed, please use only JPEG, JPG, PNG or webp types!");
                } else if (!in_array(mime_content_type($_FILES['img']['tmp_name']), $image_types)) {
                    die("File now allowed, please use only JPEG, JPG, PNG or webp types!");
                } else {
                    if (move_uploaded_file($_FILES['img']['tmp_name'], $uploads_dir . $_FILES['img']['name'])) {
                        echo "File uploaded successfully!<br>";
                    } else {
                        die("File not uploaded!");
                    }
                }
                echo "This is your book image: " . "<br><br>";
                $img_path = $_FILES['img']['name'];
                echo "<img class='shroudImg' src= '../img/" . $img_path . "'width='200' height='100'>"; //IMAGE PROJECTING ON FRONTEND SO USER CAN SEE
                //REST OF THE INPUT SANITATION
                $book_pic = "<img class='shroudImg' src='../img/" . $img_path . "'alt='book image' width='200' height='300'>"; //IMAGE LINK STORED IN DATABASE
                require __DIR__ . "../../DatabaseClasses/Database.php";
                require __DIR__ . "../../BookClasses/BookstoreExtendsDatabase.php";
                Bookstore::update_image($book_pic, $book_id);
                die();
            }
        }
        /***Update quantity only***/
        if (isset($_POST['quantity']) && $_POST['quantity'] >= (int)0) {
            $book_id = $_SESSION['update_key'];
            $book_quantity = $this->quantityCleaning();
            require __DIR__ . "../../DatabaseClasses/Database.php";
            require __DIR__ . "../../BookClasses/BookstoreExtendsDatabase.php";
            Bookstore::update_quantity($book_quantity, $book_id);
        } else {
            die("Error: data fields empty or quantity set to negative value!");
        }
    }



      /***ADMIN SEARCH PANEL VARIABLE SETTING***/
    public function varSearchSettingBooks():void
    {
        if (isset($_POST['author']) && isset($_POST['titleSearch']) && isset($_POST['number1']) && isset($_POST['number2'])) {
            $book_author = $this->authorCleaning();
            $book_title = $this->titleCleaningSearch();
            $number1 = $this->number1Cleaning();
            $number2 = $this->number2Cleaning();

            /***SELECT WITH ALL FILLED***/
            if (!empty($book_author) && !empty($book_title) && !empty($number1) && !empty($number2)) {
                require __DIR__ . "../../DatabaseClasses/SelectDatabase.php";
                SelectDatabase::select($book_author, $book_title, $number1, $number2);
                echo "<br>";

                /***SELECT WITH AUTHOR FILLED***/
            } else if (!empty($book_author) && empty($number1) && empty($book_title) && empty($number2)) {
                require __DIR__ . "../../DatabaseClasses/SelectDatabase.php";
                SelectDatabase::select_author($book_author);
                echo "<br>";

                /***SELECT WITH AUTHOR AND MIN PRICE***/
            } else if (!empty($book_author) && !empty($number1) && empty($book_title) && empty($number2)) {
                require __DIR__ . "../../DatabaseClasses/SelectDatabase.php";
                SelectDatabase::select_author_number_1($book_author, $number1);
                echo "<br>";

                /***SELECT WITH AUTHOR AND MAX PRICE***/
            } else if (!empty($book_author) && empty($number1) && empty($book_title) && !empty($number2)) {
                require __DIR__ . "../../DatabaseClasses/SelectDatabase.php";
                SelectDatabase::select_author_number_2($book_author, $number2);
                echo "<br>";

                /***SELECT WITH AUTHOR AND PRICE RANGE***/
            } else if (!empty($book_author) && !empty($number1) && empty($book_title) && !empty($number2)) {
                require __DIR__ . "../../DatabaseClasses/SelectDatabase.php";
                SelectDatabase::select_author_number_range($book_author, $number1, $number2);
                echo "<br>";

                /***SELECT WITH TITLE FILLED***/
            } else if (empty($book_author) && empty($number1) && !empty($book_title) && empty($number2)) {
                require __DIR__ . "../../DatabaseClasses/SelectDatabase.php";
                SelectDatabase::select_title($book_title);
                echo "<br>";

                /***SELECT WITH TITLE AND MIN PRICE***/
            } else if (empty($book_author) && !empty($number1) && !empty($book_title) && empty($number2)) {
                require __DIR__ . "../../DatabaseClasses/SelectDatabase.php";
                SelectDatabase::select_title_number_1($book_title, $number1);
                echo "<br>";
                /***SELECT WITH TITLE AND MAX PRICE***/
            } else if (empty($book_author) && empty($number1) && !empty($book_title) && !empty($number2)) {
                require __DIR__ . "../../DatabaseClasses/SelectDatabase.php";
                SelectDatabase::select_title_number_2($book_title, $number2);
                echo "<br>";

                /***SELECT WITH TITLE AND PRICE RANGE***/
            } else if (empty($book_author) && !empty($number1) && !empty($book_title) && !empty($number2)) {
                require __DIR__ . "../../DatabaseClasses/SelectDatabase.php";
                SelectDatabase::select_title_number_range($book_title, $number1, $number2);
                echo "<br>";

                /***SELECT WITH AUTHOR AND TITLE***/
            } else if (!empty($book_author) && empty($number1) && !empty($book_title) && empty($number2)) {
                require __DIR__ . "../../DatabaseClasses/SelectDatabase.php";
                SelectDatabase::select_title_author($book_title, $book_author);
                echo "<br>";

                /***SELECT WITH ONLY MIN PRICE FILLED***/
            } else if (empty($book_author) && empty($book_title) && !empty($number1) && empty($number2)) {
                require __DIR__ . "../../DatabaseClasses/SelectDatabase.php";
                SelectDatabase::select_number1($number1);
                echo "<br>";

                /***SELECT WITH ONLY MAX PRICE FILLED***/
            } else if (empty($book_author) && empty($book_title) && empty($number1) && !empty($number2)) {
                require __DIR__ . "../../DatabaseClasses/SelectDatabase.php";
                SelectDatabase::select_number2($number2);
                echo "<br>";

                /***SELECT WITH BOTH PRICES FILLED***/
            } else if (empty($book_author) && empty($book_title) && !empty($number1) && !empty($number2)) {
                require __DIR__ . "../../DatabaseClasses/SelectDatabase.php";
                SelectDatabase::select_number_both($number1, $number2);
                echo "<br>";

                /***MESSAGE IF ALL FIELDS ARE EMPTY***/
            } else if (empty($book_author) && empty($book_title) && empty($number1) && empty($number2)) {

             echo  "<div class='finalMsg'> Ooops...all your input fields seems to be empty!</div>";
            }
        }
    }


    /***SEARCH PANEL VARIABLE SETTING FOR USERS ON ADMIN PANEL***/
    public function varSearchSettingsUser():void
    {
        if (isset($_POST['first_name']) && isset($_POST['last_name']) && isset($_POST['user_name'])) {
            $first_name = $this->firstNameCleaning();
            $last_name = $this->lastNameCleaning();
            $user_name = $this->userNameCleaning();

            /***SELECT WITH ALL FILLED***/
            if (!empty($first_name) && !empty($last_name) && !empty($user_name)) {
                require __DIR__ . "../../DatabaseClasses/UserDatabase.php";
                require __DIR__ . "../../UserClasses/UserExtendsUserDatabase.php";
                User::selectAllFilledUsers($first_name, $last_name, $user_name);
                echo "<br>";

                /***SELECT WITH FIRST NAME FILLED***/
            } else if (!empty($first_name) && empty($last_name) && empty($user_name)) {
                require __DIR__ . "../../DatabaseClasses/UserDatabase.php";
                require __DIR__ . "../../UserClasses/UserExtendsUserDatabase.php";
                User::selectFirstName($first_name);
                echo "<br>";

                /***SELECT WITH FIRST NAME AND LAST NAME FILLED****/
            } else if (!empty($first_name) && !empty($last_name)) {
                require __DIR__ . "../../DatabaseClasses/UserDatabase.php";
                require __DIR__ . "../../UserClasses/UserExtendsUserDatabase.php";
                User::selectFirstNameLastName($first_name, $last_name);
                echo "<br>";


                /***SELECT WITH LAST NAME FILLED***/
            } else if (empty($first_name) && !empty($last_name) && empty($user_name)) {
                require __DIR__ . "../../DatabaseClasses/UserDatabase.php";
                require __DIR__ . "../../UserClasses/UserExtendsUserDatabase.php";
                User::selectLastName($last_name);
                echo "<br>";


                /***SELECT WITH USER NAME FILLED***/
            } else if (empty($first_name) && empty($last_name) && !empty($user_name)) {
                require __DIR__ . "../../DatabaseClasses/UserDatabase.php";
                require __DIR__ . "../../UserClasses/UserExtendsUserDatabase.php";
                User::selectUserName($user_name);
                echo "<br>";


                /***MESSAGE IF ALL FIELDS ARE EMPTY***/
            } else if (empty($first_name) && empty($last_name) && empty($user_name)) {

               echo "<div class='finalMsg'>Ooops...all your input fields seems to be empty!</div>";
            }
        }
    }

    /***VARIABLE SETTING METHOD FOR UPDATE USERS BY ADMIN***/
    public function varSettingUsersUpdate():void
    {
        if (isset($_POST['first_name']) && isset($_POST['last_name']) && isset($_POST['userStatus']) && isset($_POST['email'])) {
            $user_id = $_SESSION['update_key_user'];
            $first_name = $this->firstNameCleaning();
            $last_name = $this->lastNameCleaning();
            $user_status_raw = $_POST['userStatus'];
            $email=$_POST['email'];
           
            /***Update user first name***/
            if (!empty($first_name) && empty($last_name) && empty($user_status) && empty($email)) {
                require __DIR__ . "../../DatabaseClasses/UserDatabase.php";
                require __DIR__ . "../../UserClasses/UserExtendsUserDatabase.php";
                User::updateFirstName($user_id, $first_name);
            }
            /***Update user last name***/
            if (empty($first_name) && !empty($last_name) && empty($user_status) && empty($email)) {
                require __DIR__ . "../../DatabaseClasses/UserDatabase.php";
                require __DIR__ . "../../UserClasses/UserExtendsUserDatabase.php";
                User::updateLastName($user_id, $last_name);
            }
            /***Update user Status***/
            if (empty($first_name) && empty($last_name) && !empty($user_status_raw) && empty($email)) {
                switch ($user_status_raw) {
                    case "user":
                        $user_status = 3;
                        break;
                    case "admin":
                        $user_status = 2;
                }
                require __DIR__ . "../../DatabaseClasses/UserDatabase.php";
                require __DIR__ . "../../UserClasses/UserExtendsUserDatabase.php";
                User::updateUserStatus($user_id, $user_status);
            }
         /***Update user email***/
            if (empty($first_name) && empty($last_name) && empty($user_status) && !empty($email)) {
            //Calling in the trait method to fetch user names and emails already in Database.
            $this->selectUserAndEmail();
             if (in_array($_POST['email'], $_SESSION['emails'])) {
                unset ($_SESSION['emails']);
                die("Email already taken! Please choose another email.");
            }
               $email=$this->emailCleaning();
                require __DIR__ . "../../DatabaseClasses/UserDatabase.php";
                require __DIR__ . "../../UserClasses/UserExtendsUserDatabase.php";
                User::updateUserEmail($user_id, $email);
            }

            /***Full update of all input fields***/
            if (!empty($first_name) && !empty($last_name) && !empty($user_status_raw) && !empty($email)) {
            //Calling in the trait method to fetch user names and emails already in Database.
            $this->selectUserAndEmail();
             if (in_array($_POST['email'], $_SESSION['emails'])) {
               unset ($_SESSION['emails']);
                die("Email already taken! Please choose another email.");
            }
               $email=$this->emailCleaning();
                switch ($user_status_raw) {
                    case "user":
                        $user_status = 3;
                        break;
                    case "admin":
                        $user_status = 2;
                }
                require __DIR__ . "../../DatabaseClasses/UserDatabase.php";
                require __DIR__ . "../../UserClasses/UserExtendsUserDatabase.php";
                $objekat = new User($user_id, $first_name, $last_name, null, $email, null, $user_status);
                $objekat->update_user();
                if ($objekat) {
                    die("User updated successfully!");
                }
            }
        }
    }

    /***UPDATE ONLY BOOK CATEGORY VARIABLES SETTING AND CHECK***/
    public static function categoryUpdate():void
    {
        if (isset($_POST['category']) && strlen($_POST['category'])!=0) {
            $book_id = $_SESSION['update_key'];
            $book_category = $_POST['category'];
            require __DIR__ . "../../DatabaseClasses/Database.php";
            require __DIR__ . "../../BookClasses/BookstoreExtendsDatabase.php";
            Bookstore::update_category($book_category, $book_id); //Update category
            echo "<br>";
            die();
        }else if (isset($_POST['category']) && strlen($_POST['category'])==0) {

            echo "Please chose a category first.";
            die();
    }
       }
    /***Slider position Variable setting and insert in chosen position***/
    public static function insertSlider():void
    {
        if (isset($_POST['sliderPosition']) && strlen($_POST['sliderPosition'])!=0) {
            $book_id = $_SESSION['update_key'];
            $position = $_POST['sliderPosition'];
            require __DIR__ . "../../DatabaseClasses/Slider.php";
            Slider::insertToSlider($position, $book_id); //Insert into slider
            echo "<br>";
            die();
        }else if (isset($_POST['sliderPosition']) && strlen($_POST['sliderPosition'])==0){
            echo "Please chose a slider position first.";
            die();
        }
    }

    /***DELETE CHECKED QUESTIONS***/
    public static function delQuestionsAdmin():void
    {
        if (isset($_POST['question']) && isset($_POST['question'])) {
            $questions_id = ($_POST['question']);

            Questiondatabase::delQuestions($questions_id);
        }
    }
    /***UPDATE CHECKED QUESTIONS AS MARKED AS READ***/
    public static function updQuestionsAdmin():void
    {

        $questions_id = ($_POST['question']);

        require_once "DatabaseClasses/QuestionDatabase.php";
        Questiondatabase::updQuestions($questions_id);
    }

    /***Variable setting for transaction search panel***/
    public function varSearchSettingTrans():void
    {

        if (isset($_POST['transSearch'])) {
            $user_input = $this->transCleaning();
            $_SESSION['userInput'] = $user_input;
            TransactionSelectDb::selectSearchTransactions($user_input);
        }
    }

    /***Variable setting for customer search panel***/
    public function varSearchSettingCust():void
    {

        if (isset($_POST['custSearch'])) {
            $user_input = $this->custCleaning();
            $_SESSION['userInput'] = $user_input;
            $objekat = new CustomerSelectDatabase;
            $objekat->selectSearchCustomers($user_input);
        }
    }
      /***Variable setting for comment search panel***/
    public function varSearchSettingComment():void
    {

        if (isset($_POST['commSearch'])) {
            $user_input = $this->commCleaning();
            $_SESSION['userInput'] = $user_input;
            $objekat = new CommentSelectDatabase;
            $objekat->selectFilterCommentsAdmin($user_input);
        }
    }
}

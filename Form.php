<?php
declare(strict_types=1);
class Form
{ //CLASS USED MOSTLY FOR QUICK RENDER OF UPDATES AND DELETE FORMS OF BOOKS OR USERS (SOME WITH AJAX CALLS)

    private $action;
    private $method;
    private $enctype;
    protected $controls;

    const ENC1 = "application/x-www-form-urlencoded";
    const ENC2 = "multipart/form-data";
    const ENC3 = "text/plain";

    function __construct($action = "Controllers/updateController", $method = "POST", $enctype = "multipart/form-data")
    {
        $this->action = $action;
        $this->method = $method;
        $this->enctype = $enctype;
    }
    /***HTML CONTROLS FOR BOOK UPDATE***/
    public static function addInput()
    {
        $input = array(
            "book_title" => '<input class="bookUpd" type="text" name="title" autocomplete="on"  placeholder="New book title...">',
            "book_author" => '<input class="bookUpd" type="text" name="author" autocomplete="on" placeholder="New book author...">',
            "book_price" => '<input class="bookUpd" id="price"  type="number" name="price" min="0" step="0.01" placeholder="New book price...ex:15.45">',
            "book_discount" => '<input class="bookUpd" id="discount" type="number" min="0" name="discount" step="0.01" placeholder="Add discount (%)">',
            "book_year" => '<input class="bookUpd" type="number" name="year" min="0" placeholder="New publish year...">',
            "book_publisher" => '<input class="bookUpd" type="text" name="publisher" placeholder="New publisher..."><br>',
            "labelPic" => '<label for="img">Select book image (allowed extentions: jpg, png, jpeg):</label><br>',
            "book_picture" => '<input class="bookUpd" type="file" id="img" name="img" accept=".jpg, .png, .jpeg"><br>',
            "quantity" => '<input class="bookUpd" type="number" name="quantity" min="0" placeholder="Update book quantity..."></br>',
            "textarea" => '<textarea class="bookUpd" name="description" rows="10" cols="80" placeholder="Update book synopsis..."></textarea><br>',
            "submit" => '<input id="submitUpdFull" type=submit value="Update data">'
        );
        foreach ($input as $array) {
            echo $array . "<br>";
        }
        unset($input);
    }

    /***HTML CONTROLS FOR CATEGORY ONLY UPDATE***/

    public static function addCategory()
    {
        require_once __DIR__ . "/Interfaces/UserBookSelectInterface.php";
        require_once __DIR__ . "/DatabaseClasses/BooksDatabase.php";
        require_once __DIR__ . "/config.php";
        echo "<form>";
        BooksDatabase::userSelectCategory();
        echo "<br>";
        echo "<input id='submitCategory' type='submit' value='Update Category'>";
        echo "</form>";
    }

    public static function addToSlider()
    {

        require_once __DIR__ . "/DatabaseClasses/Slider.php";
      require_once __DIR__ . "/config.php";
        echo "<form>";
        Slider::sliderPositionSelect();
        echo "<br>";
        echo "<input id='submitSlider' type='submit' value='Insert in slider'>";
        echo "</form>";
    }

    /***Form for user registration mail verification***/
    public static function mailRegister()
    {
        $regMail = array(
            "labelMail" => '<label for="passDigit">Please enter your unique number recieved in mail:</label>',
            "regMail" => '<input type="number" id="mail3" name="regDigits" placeholder="enter numbers here...">',
            "submitMail" => '<input id="submitRegMail" type=submit value="Verify numbers">'
        );
        foreach ($regMail as $array) {
            echo $array . "<br>";
        }
        unset($regMail);
    }
    /***RENDER OF FINAL BOOK UPDATE FORM WITH METHODS***/
    function render()
    {
        echo "<div class='bookWrapper'>";
        echo "<div class='UploadContainer'>";
        echo "<form action='process/file-upload' method={$this->method} enctype={$this->enctype}>";
        $this->addInput();
        echo "<br>";
        echo "</form>";
        echo "</div>";
        echo "</div>";
    }


    /***ROWS DELETE CONFIRMATION METHOD FOR BOOKS***/
    public static function confirmationRadio()
    {
        $radioConf = array(
            "labelA" => '<label for=submit1>Confirm?</label><br><br>',
            "submit1" => '<input class="deleteSmall" type=submit name="yes" value="Yes" onclick="delFinalisation(this)"></input>',
            "submit2" => '<input class="deleteSmall" id="styleId" type=submit name="no" value="No" onclick="delFinalisation(this)"></input>'
        );

        foreach ($radioConf as $array) {

            echo $array;
        }
    }

    /***ROWS DELETE CONFIRMATION METHOD FOR CATEGORIES***/
    public static function confirmationDelCategory()
    {
        $radioConf = array(
            "labelA" => '<label for=submit1>Confirm?</label><br><br>',
            "submit1" => '<input class="deleteCat" type=submit name="yesCat" value="Yes" onclick="delCategoryFinalisation(this)">',
            "submit2" => '<input class="deleteCat" type=submit name="noCat" value="No" onclick="delCategoryFinalisation(this)">'
        );

        foreach ($radioConf as $array) {

            echo $array;
        }
    }
          /***ROWS DELETE CONFIRMATION METHOD FOR COMMENTS***/

        public static function confirmationCommentCategory()
        {
            $radioConf = array(
                "labelA" => '<label for=submit1>Are you sure you want to remove your comment?</label><br><br>',
                "submit1" => '<input class="deleteCat" type=submit name="yesComm" value="Yes" onclick="delCommentFinalisation(this)">',
                "submit2" => '<input class="deleteCat" id="styleId" type=submit name="noComm" value="No" onclick="delCommentFinalisation(this)">'
            );
    
            foreach ($radioConf as $array) {
    
                echo $array;
            }
        }
    /***ROWS DELETE CONFIRMATION METHOD FOR USERS***/
    public static function confirmationRadioUser()
    {
        $radioConf = array(
            "labelA" => '<label for=submit1>Confirm?</label><br><br>',
            "submit1" => '<input class="deleteSmall" type=submit name="yesUser" value="Yes" onclick="delFinalisationUsers(this)"></input>',
            "submit2" => '<input class="deleteSmall" id="styleId" type=submit name="noUser" value="No" onclick="delFinalisationUsers(this)"></input>'
        );

        foreach ($radioConf as $array) {

            echo $array;
        }
    }

    /***HTML CONTROLS FOR USER DATA UPDATE BY ADMIN***/
    public static function addInputUser()
    {
        $input = array(

            "first_name" => '<input class="userUpd" type="text" name="first_name" autocomplete="on"  placeholder="Change first name..."><br>',
            "last_name" => '<input class="userUpd" type="text" name="last_name" autocomplete="on" placeholder="Change last name..."><br>',
         	"email" => '<input class="userUpd" type="text" name="email" autocomplete="on"  placeholder="Change user email..."><br>',
            "label" => '<label for="users">Choose a user status:</label><br>',
            "status" => '<select class="userUpd" name="userStatus" id="users"><br>',
         	"blank"=>  '<option disabled selected value> -- select an option -- </option><br>',
            "userOption" => '<option value="user">User</option><br>',
            "adminOption" => '<option value="admin">Admin</option><br>',
            "selectEnd" => '</select><br>',
            "submit" => '<input id="updUserAdmin" type=submit value="Update">'
        );
        foreach ($input as $array) {
            echo $array . "<br>";
        }
        unset($input);
    }

    /***HTML CONTROLS FOR USER DATA UPDATE BY USER***/

    public static function updateUser()
    {
        $input = array(
            "label" => '<label class="label" for="first_name">Change your  first and last name:</label><br>',
            "first_name" => '<input class="userUpdate" type="text" name="first_name" placeholder="Change first name..."><br>',
            "last_name" => '<input class="userUpdate" type="text" name="last_name" placeholder="Change last name..."><br>',
            "submit" => '<input id="updateUser" type=submit name="updateUser" value="Update">'
        );
        foreach ($input as $array) {
            echo $array . "<br>";
        }
        unset($input);
    }
    /***RENDER FOR USER UPDATE FORM WITHOUT STATUS (initiated by user)***/
    public function renderUserNoStatus()
    {
        echo "<div class='userUpdateUser'>";
        echo "<div class='updateContainerUser'>";
        echo "<form>";
        $this->updateUser();
        echo "<br>";
        echo "</form>";
        echo "</div>";
        echo "</div>";
    }

    /***RENDER OF MAIL REGISTRATION VERIFICATION FORM***/

    public function renderMailReg()
    {
        echo '<form id="regMailAnchor" class="regMail">';
        $this->mailRegister();
        echo "</form>";
    }

    /***RENDER FOR USER UPDATE FORM***/
    public function renderUser()
    {
        echo "<div class='userUpdateAdmin'>";
        echo "<div class='updateContainerUser'>";
        echo "<form>";
        $this->addInputUser();
        echo "<br>";
        echo "</form>";
        echo "</div>";
        echo "</div>";
    }
    /***FORM FOR NEW PASSWORD USER WILL TYPE AFTER***/
    public function newPassForm()
    {
        echo "<div id='finalStep'>";
        echo "<h2>Welcome back " . $_SESSION['username'] . "</h2><br><p>Please type your new password in the field below:</p><br>";
        echo "<h2>Step 3:</h2>";
        echo "<form action={$this->action} method={$this->method} enctype={$this->enctype}>";
        echo "<input type='password' id='passVal' name='password' placeholder='Min. 8 characters...' onkeyup='checkPass(this.value)'><br><br>";
        echo "<input id='submitUser' type=submit value='Change password'></input>";
        echo "<hr>";
        echo "<hr>";
        echo "</form>";
        echo "</div>";
    }

    /***RENDER FOR FIRST PAGE SEARCH FORM***/
    public function firstPageSearchForm()
    {
        $input = array(
            "labelTitle" => '<label for="title">Search by title...</label>',
            "title" => '<input type="text" name="title" id="title">',
            "labelAuthor" => '<label for="author">Search by author...</label>',
            "author" => '<input type="text" name="author" id="author">',
            "labelNumber1" => '<label type="number" for="number1">Search by minimum price...</label>',
            "number1" => '<input type="number" name="number1" id="number1">',
            "labelNumber2" => '<label for="number2"> Search by maximum price...</label>',
            "number2" => '<input type="number" name="number2" id="number2">',
            "submit" => '<input type="image" src="Methods/img/search(1).webp" alt="Submit" width="55" height="55">',

        );
        foreach ($input as $array) {
            echo $array . "<br>";
        }
        unset($input);
    }

    /***USER QUESTION FORM***/
    public function userQuestion()
    {
        $input = array(
        "labelUsername" => '<label for="userName">Your name</label>',
            "userName" => '<input class="msgInsert" type="text" name="questionUserName" id="userName">',
            "labelBody" => '<label for="questionBody">Your question(650 characters max)</label>',
            "questionBody" => '<textarea class="msgInsert" name="questionBody" rows="5" cols="40" id="questionBody"></textarea>',
            "labelEmail" => '<label for="questionEmail">Your email</label>',
            "questionEmail" => '<input class="msgInsert" type="text" name="questionEmail" id="questionEmail">',
            "recaptcha" => '<input type="hidden" class="msgInsert" id="recaptchaResponse" name="recaptchaResponse">',
            "questionSubmit" => '<button id="questionSubmit" class="g-recaptcha" name="questionSubmit" width="55" height="55"> <img src="Methods/img/customer-support.webp"alt="Submit" width="55" height="55"</button>'
        );
        foreach ($input as $array) {
            echo $array . "<br>";
        }
        unset($input);
    }

    /***Admin answer form***/

    public function adminAnswer()
    {
        $input = array(
            "labelBody" => '<label for="questionBody">Your Answer:</label>',
            "questionBody" => '<textarea class="adminAnswer" name="questionBody" rows="5" cols="40" id="questionBody"></textarea>',
            "submitAnswer" => '<input class="submitAnswer" type=button name="answer" value="Send" onclick="answerFinalisation(this)"></input>'

        );
        foreach ($input as $array) {
            echo $array . "<br>";
        }
        unset($input);
    }


    /***RENDER FOR USER QUESTION FORM***/

    public function userQuestionRender()
    {

        echo "<form>";
        $this->userQuestion();
        echo "<br>";
        echo "</form>";
    }
    public function adminAnswerRender()
    {

        echo "<form>";
        $this->adminAnswer();
        echo "<br>";
        echo "</form>";
    }

    /***RENDER FOR FIRST PAGE SEARCH FORM***/
    public function renderfirstPageSearch()
    {
        echo "<div class=firstPageSearchContainer>";
        echo "<form action='index#searchAnchor' method='POST' >";
        $this->firstPageSearchForm();
        echo "<br>";
        echo "</form>";
        echo "</div>";
    }
      public function commentForm()
    {
        $input = array(
            "labelComment" => '<label for="commentId">Liked the book? Leave a comment or review!</label>',
            "comment" => '<textarea class="commentBody" id="commentId" name="comment" rows="10" cols="80"></textarea><br>',
            "submit" => '<input type="submit" id="submitComment" value="Publish">'

        );
        foreach ($input as $array) {
            echo $array . "<br>";
        }
        unset($input);
    }
    public function commentFormRender(){
        echo "<div class='commentContainer'>";
        echo "<form action='preview' method='POST'>";
        $this->commentForm();
        echo "<br>";
        echo "</form>";
        echo "</div>";
    }
}
/***THE END***/

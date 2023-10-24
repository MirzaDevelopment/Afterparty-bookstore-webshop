<?php
declare(strict_types=1);
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Register in our webshop">
    <link  rel="preload" href="https://fonts.googleapis.com/css2?family=EB+Garamond:wght@500&display=swap" as="style">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=EB+Garamond:wght@500&display=swap">
    <link rel="stylesheet" href="../style.css">
    <script src="validation.js"></script>
    <link rel="icon" href="data:;base64,=">
    <script>
        function onSubmit(token) {
            document.getElementById("demo-form").submit(); //Recaptcha submit function

        }
    </script>
      <script src="https://www.google.com/recaptcha/api.js?render=6LcFkIIgAAAAABbMMGAJpI5vXUgGIA_vGR-GAjhu" async="false"></script>
    <title>Bookstore user registration</title>
</head>

<body onload="regFunction()" class="userInsert">
    <h1 class="mainTitle">Afterparty book store</h2>
        <div class="allRegWrapper">
            <!--WRAPPER FOR IMAGE AND FORM-->
            <div class="register-wrapper-user">
                <div class="registerContainerUser">
                    <h2>User registration</h2>
                    <form id="demo-form" action="register#regMailAnchor" method="POST">
                        <!--INPUT FIELDS-->
                        <label for="first_name">First name</label>
                        <input type="text" id="first_name" name="first_name" value="<?php echo $_POST['first_name'] ?? '' ?>">
                        <label for="last_name">Last name </label>
                        <input type="text" id="last_name" name="last_name" value="<?php echo $_POST['last_name'] ?? '' ?>">
                        <!--INPUT FIELD FOR USER NAME-->
                        <!--CHECKING IF USERNAME ALREADY EXISTS IN DATABASE-->
                        <label for="user_name">User name </label>
                        <input type="text" id="user_name" name="user_name" onkeyup="checkUserName(this.value);getFocus()">
                        <div id="porukaUser"></div>  <!--Messages for user name, password and mail validations-->
                        <!--INPUT FIELD FOR EMAIL-->
                        <!--EMAIL ADRESS COMPARED WITH REGEX PATTERN-->
                        <!--CHECKING IF EMAIL ALREADY EXISTS IN DATABASE-->
                        <label for="mailVal">Email adress </label>
                        <input type="text" id="mailVal" name="email" onkeyup="checkMail(this.value);checkEmail(this.value);getFocus()" value="<?php echo $_POST['email'] ?? '' ?>">
                        <div id="porukaMail"></div> <!--Messages for user name, password and mail validations-->
                        <div id="poruka"></div>  <!--Messages for user name, password and mail validations-->
                        <!--INPUT FIELD FOR PASSWORD-->
                        <!--PASSWORD INPUT WITH JS FUNCTION FOR PASSWORD REGEX VALIDATION-->
                        <label for="passVal">Password </label>
                        <input type="password" id="passVal" name="password" placeholder="Min. 8 characters..." onkeyup="checkPass(this.value);getFocus()">
                        <div id="porukaPassword"></div> <!--Messages for user name, password and mail validations-->
                        <!--ACCEPT TERMS AND CONDITIONS-->
                        <input type="checkbox" id="acceptTerms" name="terms">
                        <label class="acceptTerms" for="acceptTerms">I Accept <a href="../policy.html">Terms and conditions</a></label>
                        <button class="g-recaptcha" data-sitekey="6LcFkIIgAAAAABbMMGAJpI5vXUgGIA_vGR-GAjhu" data-callback='onSubmit' data-action='submit'>Submit</button>
                        <!--SUBMIT BUTTON-->
                    </form>
                </div>
            </div>
        </div>
        <!--Go back button-->
        <div class="goBackMsgUserRegister">
            <a href="../loginPage"><img src="img/previous.png" alt="back-to-previous-page" width="35" height="35"></a>
        </div>
       <br>
        <div id="porukaReg"></div>
        <br> 
</body>
</html>
  <?php
if (isset($_POST['g-recaptcha-response'])) {
    require __DIR__ ."../../vendor/autoload.php";//Required for config.php
    require __DIR__ . "../../config.php";
    $responseKey = $_POST['g-recaptcha-response'];
    $secretKey = $_ENV['RECAPTCHA_KEY'];
    $url = "https://www.google.com/recaptcha/api/siteverify?secret=$secretKey&response=$responseKey";
    $response = file_get_contents($url);
    $response = json_decode($response);
    if ($response->success) {
        /***VARIABLE SETTING WITH CORRESPONDING TRAITS***/
        require __DIR__ . "../../Traits/PasswordResetTrait.php";
        require __DIR__ . "../../Traits/PreventDuplicateTrait.php";
        require __DIR__ . "../../Traits/CleaningLadyTrait.php";
      	require __DIR__ . "../../Traits/SelectUserTrait.php";
        require __DIR__ . "../../GeneralClasses/SetUser.php";
        require __DIR__ . "../../Interfaces/UsersInterface.php";
     	require __DIR__ ."../../vendor/autoload.php";//Required for config.php
		require __DIR__ . "../../config.php";
        $setObjekat = new SetUser();
        $setObjekat->varSettingUsers();
    } else {
        echo "Recaptcha encountered an error, please close your browser and try again";
    }
}
?>

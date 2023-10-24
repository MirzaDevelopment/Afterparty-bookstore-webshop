<?php
declare(strict_types=1);
 /***Google recaptcha validation logic and question insert***/
 if (isset($_POST['recaptchaResponse'])) {
    require __DIR__ . "../../../config.php";
    $responseKey = $_POST['recaptchaResponse'];
    $secretKey = $_ENV['RECAPTCHA_KEY'];
    $url = "https://www.google.com/recaptcha/api/siteverify?secret=$secretKey&response=$responseKey";
    $response = file_get_contents($url);
    $response = json_decode($response);
    if ($response->success) {
        /***If verification is successful - insert question***/
        require_once __DIR__ . "../../../Interfaces/QuestionInterface.php";
        require_once __DIR__ . "../../../Traits/PreventDuplicateTrait.php";
        require_once __DIR__ . "../../../Traits/PasswordResetTrait.php"; //Password reset trait
        require_once __DIR__ . "../../../Traits/CleaningLadyTrait.php";
      	require_once __DIR__ . "../../../Traits/SelectUserTrait.php";
        require_once __DIR__ . "../../../GeneralClasses/SetUser.php";
        $obj = new SetUser();
        //Logic for question DB insert
        $obj->questionInsertSetting();
    } else {
        echo "Recaptcha encountered an error, please close your browser and try again";
    }
}
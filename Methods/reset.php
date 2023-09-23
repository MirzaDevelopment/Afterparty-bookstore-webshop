<?php
declare(strict_types=1);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Reset your password with mail used on registration">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=EB+Garamond:wght@500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../style.css">
    <script src="validation.js"></script>
    <link rel="icon" href="data:;base64,=">
    <title>Reset password system</title>
</head>
<body onload="mailReset()"><!--Java script function in validation.js file-->
    <!--Password reset form in 3 steps-->
    <!--Third step is in server.php-->
  <div class="generalResetCont"><!--General container for image and forms-->
    <div class="firstResetCont"><!--First container for image-->
    <section class="iconReset">
    <img src="img/iconReset.png" alt="icon-listening">
    </section>
    </div>
    <div class="SecondResetCont"><!--Second container for forms-->
    <div class="step1Wrapper">
    <h1>Password reset forms</h1>
        <!--first step-->
        <h2>Step 1:</h2>
        <!--User types his mail-->
        <form>
            <label for="passReset">Please enter your email you used for your registration and click "Reset":</label>
            <br>
            <br>
            <input type="text" id="mail" name="passReset" placeholder="enter mail here...">
            <br>
            <br>
            <input id="reset" type="submit" value="Reset">
        </form>
        <!--AJAX response tag-->
        <p id="outputMail" style='color:dodgerblue'></p>
        <hr>
        <hr>
    </div> <!--End of step 1 div-->
   <!--Second step-->
    <div id="step2">
        <h2>Step 2:</h2>
        <!--Second step (4-digit code input)-->
        <form>
            <label for="passDigit">Please enter your 4-digit number recieved in mail:</label>
            <br>
            <br>
            <input type="number" id="mail2" name="passDigits" placeholder="enter numbers here...">
            <br>
            <br>
            <input id="submitNum" type="submit" value="Verify numbers">
            <hr>
            <hr>
        </form>
    </div><!--End of step 2 div-->
    <p id="outputMail2" style='color:crimson; text-align:center;'></p>
   <!--Password validation message-->
    <div id="porukaPassword"></div>
    <!--Going back to index.php page (HTML)-->
     </div>
    </div>
<div class="goBackMsgReset">
    <a href="../loginPage"><img src="img/previous.png" alt="back-to-previous-page" width="35" height="35"></a>
</div>
<!--END of "goBackMsgReset" class div-->
</body>
</html>


<?php
declare(strict_types=1);
session_start();                  
if (empty($_SESSION['cart'])) { 
//Allow access to this page only if sesssion is not empty (there is item in cart) 
header("Location:../index.php");
exit();

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Provide customer information to complete purchase">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=EB+Garamond:wght@500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../style.css">
    <script src="script.js"></script>
    <script src="validation.js"></script>
    <link rel="icon" href="data:;base64,=">
    <title>Customer registration page</title>
</head>

<body class="userInsertCheckout">
    <!--Animated background start-->
    <div class="area">
        <ul class="circles">
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
        </ul>
        <div class="customerContainer">
            <img src="img/pexels-cottonbro-4855475(1).webp" alt="girl-in-library">
            <main>
                <h2>Please fill in the registration form below to complete your purchase</h2>
                <div class="register-wrapper-user">
                    <div class="registerContainerUser">
                        <section>
                            <h2>Customer information</h2>
                            <form action="checkout" method="POST">
                                <!--INPUT FIELDS-->
                                <label for="first_name">First name</label>
                                <input type="text" id="first_name" name="first_name" value="<?php echo $_POST['first_name'] ?? '' ?>">
                                <label for="last_name">Last name </label>
                                <input type="text" id="last_name" name="last_name" value="<?php echo $_POST['last_name'] ?? '' ?>">
                                <!--EMAIL ADRESS COMPARED WITH REGEX PATTERN-->
                                <label for="mailVal">Insert email adress </label>
                                <input type="text" id="mailVal" name="email" onkeyup="checkMail(this.value);scrollIntoView()" value="<?php echo $_POST['email'] ?? '' ?>">
                                <div id="poruka"></div>
                                <label for="adress">Adress </label>
                                <input type="text" id="adress" name="adress" value="<?php echo $_POST['adress'] ?? '' ?>">
                                <label for="city">City</label>
                                <input type="text" id="city" name="city" value="<?php echo $_POST['city'] ?? '' ?>">
                                <!--SELECT FORM FOR ADM UNITS-->
                                <?php
                                /***Rendering adm units from json file***/
                                $adm_units = json_decode(file_get_contents("Data.json"), true);
                                echo '<label for="adm_units">Administrative units</label>';
                                echo '<select name="adm_units" id="adm_units">';
                                foreach ($adm_units as $key => $value) {
                                    foreach ($value as $key_2 => $value_2) {
                                        if ($key == "adm_units") {
                                            echo "<option value=$key_2>" . $value_2 . "</option>";
                                        }
                                    }
                                }
                                echo '</select>';
                                ?>
                                <label for="postalCode">Postal code</label>
                                <input type="number" id="postalCode" name="postalCode" min="0" value="<?php echo $_POST['postalCode'] ?? '' ?>">
                                <label for="phone">Phone </label>
                                <input type="number" id="phone" name="phone" min="0" placeholder="00387********" value="<?php echo $_POST['phone'] ?? '' ?>">
                                <input type="checkbox" id="terms" name="terms">
                                <!--ACCEPT TERMS AND CONDITIONS-->
                                <label id="acceptTerms" for="terms">I Accept <a href="../termsandconditions.html">Terms and conditions</a></label><br>
                                <span class="goBackCustomer">
                                    <a href="../cart">Go back</a>
                                    <input class="submitRegCustomer" type="submit" value="Checkout">
                                    <!--Customer registration form submit-->
                                </span>
                            </form>
                        </section>
                        <br>
                        <section class="outputsCart">
                            <!--Output mesages regarding mail validation-->
                            <div id="porukaUser"></div>
                            <div id="porukaMail"></div>
                            <div id="porukaPassword"></div>
                        </section>
                    </div>
                </div>
        </div>
        <footer class="frontPage">
            <div class="footerContainer">
                <section class="policies">
                    <a href="../policy.html">Policy</a>
                    <a href="../termsandconditions.html">Terms and conditions</a>
                    <a href="index">Web shop</a>
                </section>
                <section class="generalData">
         		<p>Afterparty Bookstore e-commerce website</p>
                <p>Developed by Mirza Mehagić</p>
                <p>Copyright © 2023 Mirza Mehagić All rights reserved</p>
                <p>This is personal and non-commercial product</p>
                <p>Contact: mirza.mehagic@hotmail.com (or via page contact form)</p>
                </section>
                <section class="socials">
                    <a href="https://www.facebook.com/mirza.mehagic" aria-label="facebook icon" class="fa fa-facebook"></a>
                </section>
            </div>
        </footer>
        </main>
    </div>
    <!--Animated background End-->
</body>

</html>
<?php
declare(strict_types=1);
header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
header("Pragma: no-cache"); // HTTP 1.0.
header("Expires: 0"); // Proxies.
session_start();
if (empty($_SESSION['cart'])){
 $_SESSION['cart'] = array(); //Declaring general session variable to hold cart items to show on first page
}
require __DIR__ . "/Traits/PreventDuplicateTrait.php"; //User name and email duplication prevention trait
require __DIR__ . "/Traits/CleaningLadyTrait.php"; //Sanitation and valiation trait
require __DIR__ . "/Traits/PasswordResetTrait.php"; //Password reset trait
require __DIR__ . "/Traits/SelectUserTrait.php";
require __DIR__ . "/GeneralClasses/SetUser.php";
require __DIR__ . "/Interfaces/UserBookSelectInterface.php";
require __DIR__ . "/Interfaces/QuestionInterface.php"; //Interface for question form
require __DIR__ . "/DatabaseClasses/BooksDatabase.php"; //Required for categories
require __DIR__ . "/DatabaseClasses/Slider.php"; //Required for Slider
require __DIR__ . "/Form.php";
require __DIR__ . "/config.php";

?>
<!DOCTYPE html>
<html lang="en">
<head>
 <!-- Cookies consent-->
    <script id="Cookiebot" async src="https://consent.cookiebot.com/uc.js" data-cbid="aaaa6e6a-b768-4688-bb80-ae1fd29ce1d9" data-blockingmode="auto" type="text/javascript"></script>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
  	<meta name="description" content="Shop online and turn your dreams into reality, one click at a time.">
    <!--Removing favicon icon console error-->
    <link rel="icon" href="data:;base64,=">
     <!-- General JS app script-->
    <script async src="Methods/script.js"></script>
    <script>
        function onSubmit(token) {
            document.getElementById("demo-form").submit(); //Recaptcha submit function

        }
    </script>
    <title>Bookstore webshop</title>
    <link  rel="preload" href="https://fonts.googleapis.com/css2?family=EB+Garamond:wght@500&display=swap" as="style">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=EB+Garamond:wght@500&display=swap">
    <link rel="preload" href="https://fonts.googleapis.com/css2?family=Caveat:wght@500&display=swap" as="style">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Caveat:wght@500&display=swap">
    <script async src="https://kit.fontawesome.com/cba05393c5.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style.css">
    <link rel="preload" fetchpriority="high" as="image" href="Methods/img/dark-haired-woman.webp" type="image/webp">
    <link rel="preload" fetchpriority="high" as="image" href="Methods/img/pexels-1.webp" type="image/webp">
  <!-- Google recaptcha script. -->
    <script src="https://www.google.com/recaptcha/api.js?render=6LcFkIIgAAAAABbMMGAJpI5vXUgGIA_vGR-GAjhu" defer></script>
</head>
<body onload="firstFunction()">
    <div class="headerStuff">
        <span id='cartNum'><?php print_r(count($_SESSION['cart'])) ?></span>
        <!--Number of items in cart-->
        <a class='cartIcon' href="cart"><img class='cartMain' src='Methods/img/shopping-cart.webp' alt='shopping-cart-icon' width='35' height='35'></a>
        <!--Cart icon-->
        <a class='loginIcon' href="loginPage?raw=login"><img class="icon" src="Methods/img/userFront.webp" alt="user-icon" width="35" height="35"></a>
        <!--Login/register page-->
        <a href="loginPage?raw=login">Login/Register</a>
    </div>
    <header>
        <!--Header start-->
        <section>
            <nav>
                <section class="frontSection">
                    <h1 class="mainTitle">Afterparty book store</h1>
                 <picture>
                    <img class="wrapImage"
                    srcset="Methods/img/dark-haired-woman320x180.webp 320w, Methods/img/dark-haired-woman480x270.webp 480w, Methods/img/dark-haired-woman576x324.webp 576w, Methods/img/dark-haired-woman768x432.webp 768w, Methods/img/dark-haired-woman992x558.webp 992w, Methods/img/dark-haired-woman1200x675.webp 1200w, Methods/img/dark-haired-woman1400x788.webp 1400w, Methods/img/dark-haired-woman1920x1080.webp 1920w"
                    src="Methods/img/dark-haired-woman.webp"
                    alt="dark-haired-woman" width="1920" height="1080"/>
                    </picture>
                    <?php
                    //Render of "category words" on first page
                    $adm_units = json_decode(file_get_contents("Methods/Data.json"), true);
                    echo '<div class="wordsContainer">';
                    echo '<ul class="words">';
                    foreach ($adm_units as $key => $value) {
                        foreach ($value as $key_2 => $value_2) {
                            if ($key == "front_data") {
                                echo '<li class="grid-item1">' . $value_2 . '</li></a>';
                              
                            }
                        }
                        
                    }
                    echo '<li class="grid-item1"><a href="#contact">Contact us!</a></li>';
                    echo '</ul>';
                    echo '</div>';
                    ?>
                </section>
                <!--Category and search anchors-->
                <p id="categories"></p>
                <p id="search"></p>

                <?php
                /***BOOKS DISTRIBUTED BY CHOSEN KATEGORY***/
                //General categories
                echo "<div class='selectWrap'>";
                BooksDatabase::userSelectCategory();
                //General categories that show discounted items only
                BooksDatabase::userSelectDiscount();
                echo "</div>";
                ?>
                <p id="outputCategory"></p>
                <?php
                /***Render of first page search form***/
                $objekat = new Form();
                $objekat->renderfirstPageSearch();
                ?>
            </nav>
        </section>
    </header>
    <!--Header End-->
    <main>
        <!--Main start-->
        <section id="funPart">
            <?php
            echo "<p id='searchAnchor'></p>";
            /***Render of first page search results***/
            $obj = new SetUser();
            $obj->userVarSearchSettingBooks();
            /***Slider***/
            echo "<p id='featured'>";
            echo "<div class='slideshow-container'>";
            /***Fancy waves code***/
            echo '<div class="custom-shape-divider-top-1668023651">
            <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
                <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z" class="shape-fill"></path>
            </svg>
        </div>';

            Slider::sliderRenderPosition1();
            Slider::sliderRenderPosition2();
            Slider::sliderRenderPosition3();
            echo "<br>";
            echo "</div>";
            /***Bottom dots(square shaped)***/
            echo "<div class='dotContainer'>";
            echo "<span class='dotSlider' onclick='currentSlide(1)'></span>";
            echo "<span class='dotSlider' onclick='currentSlide(2)'></span>";
            echo "<span class='dotSlider' onclick='currentSlide(3)'></span>";
            echo "</div>";
            /***Slider end***/
            echo "<div class='cuteImage'>";
            echo "<p>Shop online and turn your dreams into reality, one click at a time.</p>";
            echo "</div>";
            /***BOOKS DISTRIBUTED BY LATEST UPLOAD IN DB WITH PAGINATION (5 PER PAGE)***/
            echo '<p id="latest"></p>'; //Latest edition anchor
            Booksdatabase::selectAllFront();
            /***Render End***/
            ?>
            <p id="outputCategory"></p>
            <p id="cartConfirm"></p>
            <?php
            ?>
            </div>
        </section>
        <!--Book reviews RSS feed-->
        <article class="bookReviews">
            <p id="bookReviews"></p>
            <!--Book reviews anchor-->
            <h3 class="topRws">Top reviews:</h3>
            <?php
            //Book rievews in form of article from rss feed PHP Part
            $xml = new DOMDocument();
            $xml->load("https://kirkusreviews.com/feeds/rss");

            $news = $xml->getElementsByTagName("item");
            foreach ($news as $article) {

                $title = $article->getElementsByTagName("title")->item(0)->nodeValue;
                $link = $article->getElementsByTagName("link")->item(0)->nodeValue;
                $description = $article->getElementsByTagName("description")->item(0)->nodeValue;

                echo "<div class='reviews'>";
                echo $title . "<br>";
                echo $description . "<br>";
                echo "<a href='{$link}'>Read more...</a><br>";
                echo "</div>";
            }
            ?>
        </article>

        <!--Fancy waves part-->
        <section class=quoteNdQuestion>
            <div class="custom-shape-divider-top-1668022447">
                <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
                    <path d="M985.66,92.83C906.67,72,823.78,31,743.84,14.19c-82.26-17.34-168.06-16.33-250.45.39-57.84,11.73-114,31.07-172,41.86A600.21,600.21,0,0,1,0,27.35V120H1200V95.8C1132.19,118.92,1055.71,111.31,985.66,92.83Z" class="shape-fill"></path>
                </svg>
            </div>
            <div class="custom-shape-divider-bottom-1668022563">
                <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
                    <path d="M985.66,92.83C906.67,72,823.78,31,743.84,14.19c-82.26-17.34-168.06-16.33-250.45.39-57.84,11.73-114,31.07-172,41.86A600.21,600.21,0,0,1,0,27.35V120H1200V95.8C1132.19,118.92,1055.71,111.31,985.66,92.83Z" class="shape-fill"></path>
                </svg>
            </div>
            </div>
            <!--Fancy waves part END-->
            <div class="quote">
                <img class="questionPortrait" src="Methods/img/portraitStock.webp" alt="woman-stock-portrait" width="320" height="214">
                <span>"Fairy tales are more than true: not because they tell us that dragons exist, but because they tell us that dragons can be beaten."<strong>G.K. Chesterton.</strong></span>
            </div>
            <hr class='hrClass2'>
            <!--QUESTION FORM FOR USER-->
  			<p id="contact"></p>
            <div class="questionaire">
               
                <h2>Have thoughts or questions? Let us know!</h2>
                <?php
                //User questions form render
                $objekat->userQuestionRender();
                ?>
            </div>
        </section>
        <section>
            <!--Google maps embed-->
            <p id="location"></p>
            <!--Google maps anchor-->
            <aside>
                <h2>Join us for cup of coffee!</h2>
                <div class="mapouter">
                    <div class="gmap_canvas"><iframe width="1080" height="500" id="gmap_canvas" src="https://maps.google.com/maps?q=Cazinskih%20brigada%20&t=k&z=19&ie=UTF8&iwloc=&output=embed" title="Bookstore location on google maps" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>
        </section>
    </main>
    <!--Main end-->
    <!--Footer beginning-->
    <footer class="frontPage">
        <div class="footerContainer">
            <section class="policies">
                <h3><a href="policy.html">Policy</a></h3>
                <h3><a href="termsandconditions.html">Terms and conditions</a></h3>
            </section>
            <section class="generalData">
                <p>Afterparty Bookstore e-commerce website</p>
                <p>Developed by Mirza Mehagić</p>
                <p>Copyright © 2023 Mirza Mehagić All rights reserved</p>
                <p>This is personal and non-commercial product</p>
                <p>Contact: mirza.mehagic@hotmail.com (or via page contact form)</p>
            </section>
            <section class="socials">
                <a href="https://www.facebook.com/mirza.mehagic" class="fa fa-facebook"></a>
            </section>
        </div>
    </footer>
</body>
</html>


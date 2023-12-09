<?php

/***Class that holds method to insert into, update or delete books from first page slider***/
class Slider
{

    //Rendering slider position numbers
    public static function sliderPositionSelect():void
    {	  
        require "ConnectPdoAdmin.php";
        try {
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = $connection->query("SELECT position FROM {$_ENV['DATABASE_NAME']}.slider");
            echo "<label>";
            echo "Chose position in slider";
            echo "<select id='mySelectSlider' name='sliderPosition'>";
            echo "<option value='' selected>Slider position</option>";
            while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
                echo "<option value='{$row['position']}'>" . $row['position'] . "</option>";
            }
            echo "</select>";
            echo "</label>";
        } catch (PDOException $e) {
          date_default_timezone_set('Europe/Sarajevo');
            $error = $e->getMessage() . " " . date("F j, Y, g:i a");
            error_log($error . PHP_EOL, 3, "../Logs/logs.txt");
            echo "Failed to comply. Check log for more detail!";
        }
        $connection = null;
    }
    //Rendering Book insert in slider position method
    public static function insertToSlider($position, $book_id):void
    {
        require "ConnectPdoAdmin.php";
        try {
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = $connection->prepare("Call updateSlider(?,?)");
            $sql->bindParam(1, $position, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 4000);
            $sql->bindParam(2, $book_id, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 6000);
            $sql->execute();
            echo "Book inserted in slider successfully!";
        } catch (PDOException $e) {
          date_default_timezone_set('Europe/Sarajevo');
            $error = $e->getMessage() . " " . date("F j, Y, g:i a");
            error_log($error . PHP_EOL, 3, "../Logs/logs.txt");
            echo "Failed to comply. Check log for more detail!";
        }
    }

    //Rendering slider images for admin
    public static function sliderRender():void
    {
        require "ConnectPdoAdmin.php";
        try {
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = $connection->query("SELECT * FROM {$_ENV['DATABASE_NAME']}.slider");
            echo "<div class='sliderContainer'>";
            while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {

                if ($row['book_pic'] > 0) {
                    echo "<span class='position'>" . $row['position'] . "</span>";
                    echo $row['book_pic'];
                    echo "<input class='delSlider' type='image'  src='../../Methods/img/delete.png' width='55' height='55' alt='submit' name='{$row['book_id']}' value='Slider' onclick='delSlider(this)'></input>";
                }
            }
            echo "</div>";
        } catch (PDOException $e) {
          date_default_timezone_set('Europe/Sarajevo');
            $error = $e->getMessage() . " " . date("F j, Y, g:i a");
            error_log($error . PHP_EOL, 3, "../Logs/logs.txt");
            echo "Failed to comply. Check log for more detail!";
        }
        $connection = null;
    }
    //Rendering image for slider on position 1
    public static function sliderRenderPosition1():void
    {
        require "ConnectPdoAdmin.php";
        try {
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = $connection->query("SELECT books.book_title, slider.book_pic, slider.book_id, book_description, books.book_author, pricing.book_price, pricing.discounted_price, pricing.discount, slider.position FROM {$_ENV['DATABASE_NAME']}.slider JOIN {$_ENV['DATABASE_NAME']}.books ON books.book_id=slider.book_id JOIN pricing ON books.book_id=pricing.book_id WHERE position='1'");
            while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
                echo "<div class='mySlides fade'>";
                if ($row['book_pic'] > 0) {
                    echo "<div class='titleFeatured'>Featured deals!</div>";
                    /***Right and left arrows on slider***/
                    echo "<div class='prevNextContainer'>";
                    echo "<p class='prev' onclick='plusSlides(+1)'>&#10094;</p>";
                    echo "<p class='next' onclick='plusSlides(0)'>&#10095;</p>";
                    echo "</div>";
                    if ($row['discounted_price'] > 0) {
                     	echo "<div class='discountContainer'>";
                        echo "<div class='discIcon'><img class='discountIconSlider' src='Methods/img/discount-icon.webp' width='65' height='71' alt='discount-icon'></div>";
                        echo "<div class='discountSlider'>" . $row['discount'] . "%" . "</div>";
                        echo "</div>";
                        echo "<div class='titlePriceDisc'>Only for!</div>";
                        echo "<div class='newPriceSlider'>" . $row['discounted_price'] . "$" . "</div>";
                    } else {
                        echo "<div class='titlePrice'>Only for!</div>";
                        echo "<div class='priceSlide'>" . $row['book_price'] . "$" . "</div>";
                    }
                    $newPic = str_replace("../", "Methods/", $row['book_pic']);
                 	$newPic = str_replace("alt='book image'", "alt='book image' loading='lazy'", $newPic);
                    echo "<a href='preview.php?id={$row['book_id']}'aria-label='book-details'><div class='shroudCont'><div class='shroud'><p class='inception'>Preview</p></div></div>$newPic </a>";
                    echo "<span>".substr($row['book_description'],0, 350)."..."."<a href='preview.php?id={$row['book_id']}'aria-label='Details, rating and comments'>Details, rating and comments</a></span>";
                    echo "<input class='cartFrontSlider' type='image' src='Methods/img/shopping-cart.webp' width='35' height='35' alt='submit' name='{$row['book_id']}' value='Add-to-cart'>";
                    echo "<div class='sliderCartCont'>";
                    echo "</div>";
                }
                echo "</div>";
            }
        } catch (PDOException $e) {
          date_default_timezone_set('Europe/Sarajevo');
            $error = $e->getMessage() . " " . date("F j, Y, g:i a");
            error_log($error . PHP_EOL, 3, "Methods/Logs/logs.txt");
            echo "Failed to comply. Check log for more detail!";
        }
        $connection = null;
    }
    //Rendering image for slider on position 2
    public static function sliderRenderPosition2():void
    {
        require "NamespaceAdmin3.php";
        try {
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = $connection->query("SELECT books.book_title, slider.book_pic, slider.book_id, book_description, books.book_author, pricing.book_price, pricing.discounted_price, pricing.discount, slider.position FROM {$_ENV['DATABASE_NAME']}.slider JOIN {$_ENV['DATABASE_NAME']}.books ON books.book_id=slider.book_id JOIN pricing ON books.book_id=pricing.book_id  WHERE position='2'");
            while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
                echo "<div class='mySlides fade'>";
                if ($row['book_pic'] > 0) {
                    echo "<div class='titleFeatured'>Featured deals!</div>";
                    /***Right and left arrows on slider***/
                    echo "<div class='prevNextContainer'>";
                    echo "<p class='prev' onclick='plusSlides(+1)'>&#10094;</p>";
                    echo "<p class='next' onclick='plusSlides(0)'>&#10095;</p>";
                    echo "</div>";
                    if ($row['discounted_price'] > 0) {
                        echo "<div class='discountContainer'>";
                        echo "<div class='discIcon'><img class='discountIconSlider' src='Methods/img/discount-icon.webp' width='65' height='71' alt='discount-icon'></div>";
                        echo "<div class='discountSlider'>" . $row['discount'] . "%" . "</div>";
                     	echo "</div>";
                        echo "<div class='titlePriceDisc'>Only for!</div>";
                        echo "<div class='newPriceSlider'>" . $row['discounted_price'] . "$" . "</div>";
                    } else {
                        echo "<div class='titlePrice'>Only for!</div>";
                        echo "<div class='priceSlide'>" . $row['book_price'] . "$" . "</div>";
                    }
                    $newPic = str_replace("../", "Methods/", $row['book_pic']);
                 	$newPic = str_replace("alt='book image'", "alt='book image' loading='lazy'", $newPic);
 					echo "<a href='preview.php?id={$row['book_id']}'aria-label='book-details'><div class='shroudCont'><div class='shroud'><p class='inception'>Preview</p></div></div>$newPic </a>";
                    echo "<span>".substr($row['book_description'],0, 350)."..."."<a href='preview.php?id={$row['book_id']}'aria-label='Details, rating and comments'>Details, rating and comments</a></span>";
                    echo "<input class='cartFrontSlider' type='image' src='Methods/img/shopping-cart.webp' width='35' height='35' alt='submit' name='{$row['book_id']}' value='Add-to-cart'>";
                    echo "<div class='sliderCartCont'>";
                    echo "</div>";
                }
                echo "</div>";
            }
        } catch (PDOException $e) {
          date_default_timezone_set('Europe/Sarajevo');
            $error = $e->getMessage() . " " . date("F j, Y, g:i a");
            error_log($error . PHP_EOL, 3, "Methods/Logs/logs.txt");
            echo "Failed to comply. Check log for more detail!";
        }
        $connection = null;
    }
    //Rendering image for slider on position 3
    public static function sliderRenderPosition3():void
    {

        require "NamespaceAdmin4.php";
        try {
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = $connection->query("SELECT books.book_title, slider.book_pic, slider.book_pic, slider.book_id, book_description, books.book_author, pricing.book_price, pricing.discounted_price, pricing.discount, slider.position FROM {$_ENV['DATABASE_NAME']}.slider JOIN {$_ENV['DATABASE_NAME']}.books ON books.book_id=slider.book_id JOIN pricing ON books.book_id=pricing.book_id WHERE position='3'");
            while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
                echo "<div class='mySlides fade'>";
                if ($row['book_pic'] > 0) {
                    echo "<div class='titleFeatured'>Featured deals!</div>";
                    /***Right and left arrows on slider***/
                    echo "<div class='prevNextContainer'>";
                    echo "<p class='prev' onclick='plusSlides(+1)'>&#10094;</p>";
                    echo "<p class='next' onclick='plusSlides(0)'>&#10095;</p>";
                    echo "</div>";
                    if ($row['discounted_price'] > 0) {
                      echo "<div class='discountContainer'>";
                        echo "<div class='discIcon'><img class='discountIconSlider' src='Methods/img/discount-icon.webp' width='65' height='71' alt='discount-icon'></div>";
                        echo "<div class='discountSlider'>" . $row['discount'] . "%" . "</div>";
                      echo "</div>";
                        echo "<div class='titlePriceDisc'>Only for!</div>";
                        echo "<div class='newPriceSlider'>" . $row['discounted_price'] . "$" . "</div>";
                    } else {
                        echo "<div class='titlePrice'>Only for!</div>";
                        echo "<div class='priceSlide'>" . $row['book_price'] . "$" . "</div>";
                    }
                    $newPic = str_replace("../", "Methods/", $row['book_pic']);
                  	$newPic = str_replace("alt='book image'", "alt='book image' loading='lazy'", $newPic);
                    echo "<a href='preview.php?id={$row['book_id']}'aria-label='book-details'><div class='shroudCont'><div class='shroud'><p class='inception'>Preview</p></div></div>$newPic </a>";
                    echo "<span>".substr($row['book_description'],0, 350)."..."."<a href='preview.php?id={$row['book_id']}'aria-label='Details, rating and comments'>Details, rating and comments</a></span>";
                    echo "<input class='cartFrontSlider' type='image' src='Methods/img/shopping-cart.webp' width='35' height='35' alt='submit' name='{$row['book_id']}' value='Add-to-cart'>";
                    echo "<div class='sliderCartCont'>";
                    echo "</div>";
                }
                echo "</div>";
            }
        } catch (PDOException $e) {
          date_default_timezone_set('Europe/Sarajevo');
            $error = $e->getMessage() . " " . date("F j, Y, g:i a");
            error_log($error . PHP_EOL, 3, "Methods/Logs/logs.txt");
            echo "Failed to comply. Check log for more detail!";
        }
        $connection = null;
    }
    //Delete chosen slider
    public static function sliderDelete($book_id):void
    {
        require "ConnectPdoAdmin.php";
        try {
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = $connection->prepare("Call deleteSlider(?)");
            $sql->bindParam(1, $book_id, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 6000);
            $sql->execute();
            echo "<p id='updateDiscount'>Slider item deleted successfully! Refreshing page...</p>";
        } catch (PDOException $e) {
          date_default_timezone_set('Europe/Sarajevo');
            $error = $e->getMessage() . " " . date("F j, Y, g:i a");
            error_log($error . PHP_EOL, 3, "../Logs/logs.txt");
            echo "Failed to comply. Check log for more detail!";
        }
        $connection = null;
    }
}

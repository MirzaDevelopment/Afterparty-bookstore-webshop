<?php
declare(strict_types=1);
session_start();
if (empty($_SESSION['cart'])) {
    header('Location: index.php'); //If user refreshes after transaction is finalised, return him to front page.
    exit();
} else if (empty($_SESSION['first_name'])) { //If user continues without registration, redirect him to cart
    header('Location: ../cart.php');
    exit();
}
echo '<link rel="icon" href="data:;base64,=">';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=EB+Garamond:wght@500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../style.css">
    <title>Transaction successfull</title>
</head>
<?php
/**Logic to redirect user regarding its action and session content***/
session_start();
if (empty($_SESSION['cart'])) {
    header('Location: index.php'); //If user refreshes after transaction is finalised, return him to front page.
    exit();
} else if (empty($_SESSION['first_name'])) { //If user continues without registration, redirect him to cart
    header('Location: ../cart.php');
    exit();
}
echo '<link rel="icon" href="data:;base64,=">';
?>
<body>
    <main class="finalMain">
        <section class="finalImage">
            <img src="img/finalisationImage.webp" alt="package-prepared"></a>
        </section>
        <?php
        /***Transaction finalisation***/
        //user and book insert in transaction table with email confirmation sent to user mail
        /***Customer insert in customer table***/
        require __DIR__."../../Interfaces/CustomersInterface.php";
        require __DIR__."../../Traits/CleaningLadyTrait.php";
        require __DIR__."../../Traits/AdmUnitsTrait.php";
        require __DIR__."../../DatabaseClasses/CustomerDatabase.php";
        require __DIR__."../../GeneralClasses/SetCustomer.php";
 		require __DIR__ ."../../vendor/autoload.php";//Required for config.php
 		require __DIR__."../../config.php";
        $objekatSet = new SetCustomer;
        $objekatSet->varSettingCustomers();

        if ($objekatSet) {
            /***Transaction insert after customer in transaction table***/
            require __DIR__."../../Interfaces/TransactionInterface.php";
            require __DIR__."../../BookClasses/Books.php";
            require __DIR__."../../BookClasses/BookstoreExtendsBooks.php";
            require __DIR__."../../DatabaseClasses/TransactionDatabase.php";
            require __DIR__ ."../../vendor/autoload.php";//Required for config.php
        	require __DIR__."../../config.php";
            $objekat = new TransactionDatabase();
            $objekat->completeTransaction();
            //Final messages
            echo "<span class='finalMsg'>";
            echo "<span class='finalThx'>Thank you, your order is complete!</span><br>";
            echo "<span class='finalMail'>Mail will be sent with details about your order!</span>";
            echo "</span>";
            //Calling method which will send details to user mail
            $objekat->renderTransaction();
        } else {
            die("Transaction failed, please try again or contact us on first page!");
        }

        //Unsetting variables
        unset($_SESSION['cart']);
        session_destroy(); 
        ?>
    </main>
    <footer class="finalNav">
        <!--Bottom navigation -->
        <nav class="goBackCartCheckout">
            <a href="index">Web shop</a>
            <!--Going back to front page -->
        </nav>
    </footer>
</body>

</html>

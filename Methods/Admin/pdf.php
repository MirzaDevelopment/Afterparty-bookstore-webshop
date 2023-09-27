<?php
declare(strict_types=1);
/***DB data conversion to PDF file***/
session_start();
foreach ($_POST as $key => $value) {
    $kljuc = trim($key, "_y");
}
require __DIR__ . "../../../config.php";
require __DIR__ . "../../../DatabaseClasses/ConnectPdoAdmin.php";

try { //Getting data to be presented in pdf invoice for admins
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = $connection->query("SELECT books.book_title, books.book_author, pricing.book_price, pricing.discounted_price, transactions.book_quantity, transactions.transaction_date, users_customers.adress, users_customers.first_name, users_customers.last_name, users_customers.city, users_customers.postal_code, users_customers.phone_number, users_customers.email FROM {$_ENV['DATABASE_NAME']}.transactions JOIN {$_ENV['DATABASE_NAME']}.books ON books.book_id=transactions.book_id JOIN users_customers ON transactions.customer_id=users_customers.customer_id JOIN pricing ON books.book_id=pricing.book_id WHERE transactions.transaction_id=$kljuc");
    while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
        require('../../PDFConverterUTF8/tfpdf.php');
        $pdf = new tFPDF(); //PDF converter class include
        $pdf->AddPage();
        $pdf->AddFont('DejaVu', '', 'DejaVuSansCondensed.ttf', true);
        $pdf->SetFont('DejaVu', '', 14);
        $pdf->Cell(40, 10,  "Oder id: " . $kljuc, 0, 1);
        $pdf->Cell(40, 10,  "Title: " . $row['book_title'], 0, 1);
        $pdf->Cell(40, 10,  "Author: " . $row['book_author'], 0, 1);
        $pdf->Cell(40, 10,  "Ordered quantity: " . $row['book_quantity'], 0, 1);
        $pdf->Cell(40, 10,  "Date of order: " . $row['transaction_date'], 0, 1);
        $pdf->Cell(40, 10,  "-----------", 0, 1);
        $pdf->Cell(40, 10,  "Customer data:", 0, 1);
        $pdf->Cell(40, 10,  "Name: " . $row['first_name'] . " " . $row['last_name'], 0, 1);
        $pdf->Cell(40, 10,  "Adress: " . $row['adress'], 0, 1);
        $pdf->Cell(40, 10,  "City: " . $row['city'] . " " . $row['postal_code'], 0, 1);
        $pdf->Cell(40, 10,  "Phone: " . $row['phone_number'], 0, 1);
        $pdf->Cell(40, 10,  "_______________________________________________", 0, 1);
        $pdf->Output();
    }
} catch (PDOException $e) {
  date_default_timezone_set('Europe/Sarajevo');
    $error = $e->getMessage() . " " . date("F j, Y, g:i a");
    error_log($error . PHP_EOL, 3, "../Logs/logs.txt");
    echo "Failed to comply. Check log for more detail!";
}

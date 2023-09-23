<?php
require __DIR__ ."../../vendor/autoload.php";//Required for config.php
require __DIR__ . "../../config.php"; //Variable setting class include
require "vendor/braintree/braintree_php/lib/Braintree.php";
  $gateway = new Braintree\Gateway([
    'environment' => $_ENV['ENVIRONMENT'],
    'merchantId' => $_ENV['MERCHANT_ID'],
    'publicKey' => $_ENV['PUBLIC_KEY'],
    'privateKey' => $_ENV['PRIVATE_KEY']
]);
$clientToken = $gateway->clientToken()->generate()

?>

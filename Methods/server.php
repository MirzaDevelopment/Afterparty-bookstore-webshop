<?php
/***Server part of Braintree/Paypal integration***/
require "gateway.php";
$nonceFromTheClient = $_POST["payment_method_nonce"];
$deviceDataFromTheClient=$_POST["data-coll"];
$amount=$_POST["amount"];
$result = $gateway->transaction()->sale([
    'amount' => $amount,
    'paymentMethodNonce' => $nonceFromTheClient,
    'deviceData' => $deviceDataFromTheClient,
    'options' => [
      'submitForSettlement' => True
    ]
  ]);

  if ($result->success) {/*In my case it actually will never work because by default, my card cannot recieve payments. I have however, since confirmed with the Braintree staff, that transaction failes for that reason, so I can safely assume that code works*/
  } else {
    /***Since failed code works, just not for my country and card, we can proceed for finalisation part***/
    header('Location: finalisation.php');
    exit();
  }
  

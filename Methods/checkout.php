<?php

declare(strict_types=1);
session_start();
require "gateway.php"; //Paypal integration component
require __DIR__ . "../../Traits/CleaningLadyTrait.php";
require __DIR__ . "../../Traits/AdmUnitsTrait.php";
require __DIR__ . "../../GeneralClasses/SetCustomer.php";
require __DIR__ . "../../DatabaseClasses/AbstractCart.php";
require __DIR__ . "../../DatabaseClasses/CartUserExtendsAbstractCart.php";
require __DIR__ ."../../vendor/autoload.php";//Required for config.php
require __DIR__ . "../../config.php";
if (empty($_SESSION['sum']) && empty($_SESSION['sumDown'])) { //Making sure if user refreshes page that its on cart so he can modify quantity again

  header('Location: ../cart.php');
  exit();
}
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
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="../style.css">
  <script src="script.js"></script>
  <script src="validation.js"></script>
  <link rel="icon" href="data:;base64,=">
  <!-- Paypal integration scripts -->
  <!-- Load the client component. -->
  <script src="https://js.braintreegateway.com/web/3.92.1/js/client.min.js"></script>
  <script src="https://js.braintreegateway.com/web/3.92.1/js/data-collector.min.js"></script>
  <!-- Load the PayPal Checkout component. -->
  <script src="https://js.braintreegateway.com/web/3.92.1/js/paypal-checkout.min.js"></script>
  <title>Checkout</title>
</head>
<body onload="paymentFinal()">
  <main>
    <section class="orderData">
      <h2 class="productSpec">Order specification</h2>
       <!-- Container for grid stilisation. -->
      <div class="checkoutContainer">
      <?php
      /***Showing chosen books***/
      session_start();
       CartUser::showCartConfirmation();
         echo "</div>";
         echo !empty($_SESSION['sumDown']) ? "<p>Total price: " . $_SESSION['sumDown'] . "</p>" : "<p>Total price: " . $_SESSION['sum'] . "</p>"; //Calculating total price regarding the chosen quantity of product
      ?>
    </section>

    <section class="customerData">
      <h2 class="productSpec">Personal information and shipping adress</h2>
      <div class="personalInfo">
        <?php
        /***Preparing customer data/variables for final insert in customer db***/
        $objekat = new SetCustomer();
        $objekat->checkOutRenderUser();
        /***Unsetting sessions so if user goes back, it will reset prices to default***/
        $_SESSION['totalPrice'] = $_SESSION['sum']; //Getting value for email
        unset($_SESSION['sum']);
        unset($_SESSION['sumDown']);
        ?>
      </div>
    </section>
    <!-- PAYPAL INTEGRATION CODE -->
    <form id="payment-form" action="server" method="POST">
      <input type="hidden" id="nonce" name="payment_method_nonce" />
      <input type="hidden" id="dataCollection" name="data-coll" />
      <input type="hidden" id="amount" name="amount" value="<?php echo $_SESSION['totalPrice'] ?>" />
    </form>
    <div id="paypalContainer">
      <div id="paypal-button"></div>
    </div>
    <script>
      var amount = document.getElementById('amount').value;
      var form = document.querySelector('#payment-form');
      var amountNew = amount.replace(",", ".");
      var clientToken = <?php echo json_encode($clientToken); ?>;
      // Create a client.
      braintree.client.create({
        authorization: clientToken
      }, function(clientErr, clientInstance) {
        braintree.dataCollector.create({
          client: clientInstance
        }, function(err, dataCollectorInstance) {
          if (err) {
            // Handle error in creation of data collector
            return;
          }
          // At this point, you should access the dataCollectorInstance.deviceData value and provide it
          // to your server, e.g. by injecting it into your form as a hidden input.
          var deviceData = dataCollectorInstance.deviceData;
          document.getElementById('dataCollection').value = deviceData;
          console.log(deviceData);
        });

        if (clientErr) {
          console.error('Error creating client:', clientErr);
          return;
        }
        // Create a PayPal Checkout component.
        braintree.paypalCheckout.create({
          client: clientInstance
        }, function(paypalCheckoutErr, paypalCheckoutInstance) {

          // Stop if there was a problem creating PayPal Checkout.
          // This could happen if there was a network error or if it's incorrectly
          // configured.
          if (paypalCheckoutErr) {
            console.error('Error creating PayPal Checkout:', paypalCheckoutErr);
            return;
          }

          paypalCheckoutInstance.loadPayPalSDK({

          }, function() {
            paypal.Buttons({
              fundingSource: paypal.FUNDING.PAYPAL,
              createOrder: function() {
                return paypalCheckoutInstance.createPayment({
                  flow: 'checkout', // Required
                  amount: amountNew, // Required
                  currency: 'USD'
                });
              },
              onApprove: function(data, actions) {
                return paypalCheckoutInstance.tokenizePayment(data, function(err, payload) {
                  // Submit `payload.nonce` to your server
                  document.querySelector('input[name="payment_method_nonce"]').value = payload.nonce;
                  form.submit()
                });
              },

              onCancel: function(data) {
                console.log('PayPal payment cancelled', JSON.stringify(data, 0, 2));
              },
              onError: function(err) {
                console.error('PayPal error', err);
              }
            }).render('#paypal-button').then(function() {
              // The PayPal button will be rendered in an html element with the ID
            });
          });
        });

      });
    </script>
    <!-- PAYPAL INTEGRATION END -->
  </main>
  <nav class="goBackCartCheckout">
    <a href="../cart">Go back</a>
    <a href="finalisation">Confirm</a>
  </nav>
  <!-- GENERAL FOOTER DATA -->
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
        <a href="https://www.facebook.com/mirza.mehagic" class="fa fa-facebook"></a>
      </section>
    </div>
  </footer>
</body>

</html>
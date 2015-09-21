<?php
require_once '../lib/Braintree.php';
Braintree_Configuration::environment('sandbox');
Braintree_Configuration::merchantId('9bdq363phkqhg8c9');
Braintree_Configuration::publicKey('n75g6jwpftxstgcf');
Braintree_Configuration::privateKey('1d98d4be75967791d6cfbb8346889eb4');

$clientToken = Braintree_ClientToken::generate();
echo "Client Token: " . $clientToken;
?>

<form id="checkout" action="" method="post">
    <div id="number"></div>
    <div id="expiration-date"></div>
    <input type="submit" id="submit" value="Pay">
</form>

<script src="https://js.braintreegateway.com/js/beta/braintree-hosted-fields-beta.18.js"></script>
<script src="https://js.braintreegateway.com/js/beta/braintree-hosted-fields-beta.18.min.js"></script>

<script>
    braintree.setup(<?php echo $clientToken; ?>, "custom", {
        id: "checkout",
        hostedFields: {
            number: {
                selector: "#number"
            },
            expirationDate: {
                selector: "#expiration-date"
            }
        }
    });
</script>
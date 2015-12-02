<?php

include_once('./lib/Braintree.php');

Braintree_Configuration::environment('');
Braintree_Configuration::merchantId('');
Braintree_Configuration::publicKey('');
Braintree_Configuration::privateKey('');

$clientToken = Braintree_ClientToken::generate();
echo "Client Token: " . $clientToken;

?>

<form id="checkout" method="post" action="checkout.php">
    <div id="dropin"></div>
    <input type="submit" value="   Pay $50   ">
</form>

<script type="text/javascript">
    function setupBT() {
        braintree.setup("<?php echo $clientToken; ?>", 'dropin', {
            container: 'dropin'
        });
    }
    if (window.addEventListener)
        window.addEventListener("load", setupBT, false);
    else if (window.attachEvent)
        window.attachEvent("onload", setupBT);
    else window.onload = setupBT;
</script>
<script type="text/javascript" src="https://js.braintreegateway.com/v2/braintree.js"></script>

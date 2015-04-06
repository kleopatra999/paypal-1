<?php
$page_title = "PayPal Payments Pro";
include_once("../header.php");
include_once("../sidebar.php");

if(!empty($_POST)) {
    echo "hello world";
}
else {
    ?>

    <div class="col-md-9">
        <div class="container">
            <div>
                <h1>PayPal Payments Pro</h1>
                <!-- User Input Form -->
                <form action="" method="post" id="user-input">

                    <div class="billing-info col-sm-5">
                        <h3>Billing Information</h3>
                        <div class="form-group">
                            <label for="fname">First Name</label>
                            <input type="text" class="form-control" name="fname" value="Johnny"/>
                        </div>
                        <div class="form-group">
                            <label for="lname">Last Name</label>
                            <input type="text" class="form-control" name="lname" value="Walker"/>
                        </div>
                        <div class="form-group">
                            <label for="street">Street</label>
                            <input type="text" class="form-control" name="street" value="927 N Palm Drive"/>
                        </div>
                        <div class="form-group">
                            <label for="city">City</label>
                            <input type="text" class="form-control" name="city" value="Scottsdale"/>
                        </div>
                        <div class="form-group">
                            <label for="state">State</label>
                            <input type="text" class="form-control" name="state" value="Arizona"/>
                        </div>
                        <div class="form-group">
                            <label for="zip">Zip</label>
                            <input type="text" class="form-control" name="zip" value="85251"/>
                        </div>
                    </div>
                    <div class="payment-info col-sm-5">
                        <h3>Payment Information</h3>
                        <div class="form-group">
                            <label for="ctype">Card Type</label>
                            <input type="text" class="form-control" name="ctype" value="MasterCard"/>
                        </div>
                        <div class="form-group">
                            <label for="cardnum">Card Number</label>
                            <input type="text" class="form-control" name="cardnum" value="5581588172358878"/>
                        </div>
                        <div class="form-group">
                            <label for="expmonth">Expiration Month</label>
                            <input type="text" class="form-control" name="expmonth" value="08"/>
                        </div>
                        <div class="form-group">
                            <label for="expyear">Expiration Year</label>
                            <input type="text" class="form-control" name="expyear" value="2016"/>
                        </div>
                        <div class="form-group">
                            <label for="cvv">CVV</label>
                            <input type="text" class="form-control" name="cvv" value="324"/>
                        </div>
                    </div>
                    <div class="submit-button center col-sm-12">
                        <input type="submit" class="form-control" value="Submit" />
                    </div>
                </form>
            </div>
        </div>
    </div>


<?php }
include_once("../footer.php");
?>
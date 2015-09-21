<?php

$page_title = "Braintree Create & Store Customer";
include_once("../../header.php");
include_once("../../sidebar.php");

require_once '../lib/Braintree.php';
require_once '../credentials.php';

?>

<div class="col-md-9">
    <h1>Braintree Create Customer & Charge Subscription</h1>
    <form action="customer.php" method="post">
        <div class="customer-info col-md-6">
            <div class="form-group">
                <label for="fname">First Name</label>
                <input type="text" class="form-control" name="fname">
            </div>
            <div class="form-group">
                <label for="lname">Last Name</label>
                <input type="text" class="form-control" name="lname">
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="text" class="form-control" name="email">
            </div>
            <div class="form-group">
                <label for="phone">Phone</label>
                <input type="text" class="form-control" name="phone">
            </div>
        </div>
        <div class="customer-info col-md-6">
            <div class="form-group">
                <label for="cardnum">Card Number</label>
                <input type="text" class="form-control" name="cardnum">
            </div>
            <div class="form-group col-md-6">
                <label for="expmonth">Expiration Month</label>
                <input type="text" class="form-control" name="expmonth">
            </div>
            <div class="form-group col-md-6">
                <label for="expyear">Expiration Year</label>
                <input type="text" class="form-control" name="expyear">
            </div>
            <div class="form-group">
                <label for="cvv">CVV</label>
                <input type="text" class="form-control" name="cvv">
            </div>
            <div class="form-group">
                <label for="zip">Zip Code</label>
                <input type="text" class="form-control" name="zip">
            </div>
            <input type="submit" class="form-control" value="Submit" />
        </div>


    </form>
</div>
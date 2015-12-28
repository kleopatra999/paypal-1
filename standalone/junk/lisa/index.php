<form action="iframe.php" method="post">
    <h3>Sales Information</h3>
    <div class="form-item">
        Please select your service:
        <select name="service">
            <option value="option1">Option 1</option>
            <option value="option2">Option 2</option>
            <option value="option3">Option 3</option>
        </select>
    </div>
    <div class="form-item">
        Type of service:
        <select name="service_type">
            <option value="option1">Option 1</option>
            <option value="option2">Option 2</option>
            <option value="option3">Option 3</option>
        </select>
    </div>
    <div class="form-item">
        Name of Sales Rep
        <select name="sales_rep">
            <option value="option1">Option 1</option>
            <option value="option2">Option 2</option>
            <option value="option3">Option 3</option>
        </select>
    </div>

    <h3>Billing Information</h3>
    <div class="form-item">
        First Name: <input type="text" name="first_name" value="John"/>
    </div>
    <div class="form-item">
        Last Name: <input type="text" name="last_name" value="Doe"/>
    </div>
    <div class="form-item">
        Address: <input type="text" name="street" value="123 Doe Street"/>
    </div>
    <div class="form-item">
        City: <input type="text" name="city" value="Doeville"/>
    </div>
    <div class="form-item">
        State: <input type="text" name="state" value="Iowa"/>
    </div>
    <div class="form-item">
        Country: <input type="text" name="country" value="USA"/>
    </div>
    <div class="form-item">
        Zip: <input type="text" name="zip" value="54741"/>
    </div>
    <div class="form-item">
        Email: <input type="text" name="email" value="johndoe@doefarms.com"/>
    </div>
    <div class="form-item">
        Phone: <input type="text" name="phone" value="457-874-5544"/>
    </div>
    <div class="form-item">
        Mobile: <input type="text" name="mobile" value="458-874-4411"/>
    </div>

    <h3>Payment</h3>
    <div class="form-item">
        Amount to Pay: <input type="text" name="amount" value="10.00"/>
    </div>
    </br>
    <div class="form-item submit">
        <input type="submit" value="submit" />
    </div>
</form>
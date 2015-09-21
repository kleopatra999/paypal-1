<?php
    if(!empty($_POST)) {
        $endpoint = "https://pilot-payflowpro.paypal.com";
        $securetokenid = time();
        // Set API Request Parameters
        $api_request_params = array (
            // API Data
            // Get and test your crerdentials at http://manager.paypal.com
            'PARTNER' => 'PayPal',
            'VENDOR' => '',
            'USER' => '',
            'PWD' => '',
            'TRXTYPE' => 'S',
            'AMT' => $_POST['amount'],
            'CREATESECURETOKEN' => 'Y',
            'SECURETOKENID' => $securetokenid,
        );

        /// Convert API Params to NVP String
        $nvp = toNVP($api_request_params);

        // Run cURL on endpoint & NVP string
        $result = runCurl($endpoint, $nvp);

        // Parse API response to NVP
        $result_array = nvpConvert($result);

        $securetoken = $result_array['SECURETOKEN'];
        ?>

        <iframe src="https://payflowlink.paypal.com?MODE=TEST&SECURETOKENID=<?php echo $securetokenid; ?>&SECURETOKEN=<?php echo $securetoken; ?>" name="test_iframe" scrolling="no" width="570px" height="540px"></iframe>

        <?
    }
    else {
        ?>
    <form action="" method="post">
        <div class="form-item">
            <label>Amount to Charge</label>
            <input type="text" name="amount" value="10.00"/>
        </div>
        <input type="submit" value="submit"/>
    </form>
    <?php
    }

    // Helper functions

    // cURL function
    function runCurl($api_endpoint, $nvp) {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_VERBOSE, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);
        curl_setopt($curl, CURLOPT_URL, $api_endpoint);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $nvp);
        $result = curl_exec($curl);

        return $result;
    }

    // Convert Parameters Array to NVP
    function toNVP($array) {
        $i = 0;
        $nvp = "";
        foreach($array as $key => $val) {
            if($i != 0) {
                $nvp .= "&";
            }
            $nvp .= $key . '=' . $val;
            $i++;
        }
        return $nvp;
    }

    function nvpConvert($myString) {
        $ppResponse = array();
        parse_str($myString, $ppResponse);
        return $ppResponse;
    }

    // Print Array in Preformat
    function printVars($array) {
        echo "<pre>";
        print_r($array);
        echo "</pre>";
    }
?>
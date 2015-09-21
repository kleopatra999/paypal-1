<?php
    $page_title = "PayPal Advanced";
    include_once("../header.php");
    include_once("../sidebar.php");

    $endpoint = $config['payflow']['endpoint'];
    $securetokenid = time();
    // Set API Request Parameters
    $api_request_params = array (
        // API Data
        'PARTNER' => $config['payflow']['partner'],
        'VENDOR' => $config['payflow']['vendor'],
        'PWD' => $config['payflow']['pwd'],
        'USER' => $config['payflow']['user'],
        'TRXTYPE' => 'S',
        'AMT' => '40.00',
        'CREATESECURETOKEN' => 'Y',
        'SECURETOKENID' => $securetokenid,
    );

    // Convert API Params to NVP String
    $nvp = toNVP($api_request_params);
    echo "<h3>Data sent</h3>";
    printVars($nvp);

    // Run cURL on endpoint & NVP string
    $result = runCurl($endpoint, $nvp);

    // Parse API response to NVP
    $result_array = nvpConvert($result);
    echo "<h3>Response</h3>";
    printVars($result_array);

    $securetoken = $result_array['SECURETOKEN'];
?>

    <html>
    <head>
        <title></title>
    </head>
    <body>
    <p>This is a test HTML file.</p>

    <iframe src="https://payflowlink.paypal.com?MODE=TEST&SECURETOKENID=<?php echo $securetokenid; ?>&SECURETOKEN=<?php echo $securetoken; ?>"
            name="test_iframe" scrolling="no" width="570px" height="540px"></iframe>

    </body>
    </html>

<?php
    include_once("../footer.php");
?>
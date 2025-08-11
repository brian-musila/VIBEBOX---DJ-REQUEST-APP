<?php
// mpesa.php
date_default_timezone_set('Africa/Nairobi');

// Sandbox Credentials (replace with live when ready)
$consumerKey = 'YOUR_CONSUMER_KEY';
$consumerSecret = 'YOUR_CONSUMER_SECRET';
$BusinessShortCode = '174379'; // Test Shortcode
$Passkey = 'YOUR_PASSKEY';
$callbackURL = 'https://yourdomain.com/callback.php';

// Generate Access Token
function generateAccessToken() {
    global $consumerKey, $consumerSecret;
    $credentials = base64_encode("$consumerKey:$consumerSecret");

    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL => 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials',
        CURLOPT_HTTPHEADER => ["Authorization: Basic $credentials"],
        CURLOPT_RETURNTRANSFER => true
    ]);

    $response = curl_exec($curl);
    curl_close($curl);

    $json = json_decode($response);
    return $json->access_token ?? null;
}
?>

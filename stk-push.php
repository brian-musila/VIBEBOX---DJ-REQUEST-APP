<?php
date_default_timezone_set('Africa/Nairobi');

// 1. Variables
$amount = $_POST['amount'];
$phone = $_POST['phone'];
$phone = preg_replace('/^0/', '254', $phone); // Convert 07xx to 2547xx

// 2. M-PESA credentials (Sandbox values)
$consumerKey = 'YOUR_CONSUMER_KEY';
$consumerSecret = 'YOUR_CONSUMER_SECRET';
$BusinessShortCode = '174379'; // Sandbox shortcode
$Passkey = 'YOUR_PASSKEY';
$callbackUrl = 'https://yourdomain.com/vibebox/mpesa-callback.php';
$TransactionDesc = 'VibeBox DJ Tip';

// 3. Generate access token
$credentials = base64_encode("$consumerKey:$consumerSecret");
$url = 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_HTTPHEADER, ["Authorization: Basic $credentials"]);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
$access_token = json_decode($response)->access_token;
curl_close($ch);

// 4. Prepare STK Push
$Timestamp = date('YmdHis');
$password = base64_encode($BusinessShortCode . $Passkey . $Timestamp);

$stkUrl = 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest';
$headers = [
    'Content-Type: application/json',
    "Authorization: Bearer $access_token"
];

$data = [
    "BusinessShortCode" => $BusinessShortCode,
    "Password" => $password,
    "Timestamp" => $Timestamp,
    "TransactionType" => "CustomerPayBillOnline",
    "Amount" => $amount,
    "PartyA" => $phone,
    "PartyB" => $BusinessShortCode,
    "PhoneNumber" => $phone,
    "CallBackURL" => $callbackUrl,
    "AccountReference" => "VibeBox",
    "TransactionDesc" => $TransactionDesc
];

$ch = curl_init($stkUrl);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
$response = curl_exec($ch);
curl_close($ch);

// Show result
$result = json_decode($response);
if (isset($result->ResponseCode) && $result->ResponseCode == "0") {
    echo "✅ STK Push sent to $phone for KES $amount.<br><br><a href='index.php'>⬅️ Back</a>";
} else {
    echo "❌ Failed to send STK Push. Reason: " . $result->errorMessage;
}
?>

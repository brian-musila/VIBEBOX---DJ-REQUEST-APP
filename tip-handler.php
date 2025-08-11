<?php
include 'mpesa.php';

$phone = $_POST['phone'];
$amount = $_POST['amount'];
$token = generateAccessToken();

if (!$token) {
    die("❌ Failed to generate M-PESA access token.");
}

$timestamp = date('YmdHis');
$password = base64_encode($BusinessShortCode . $Passkey . $timestamp);

$payload = [
    "BusinessShortCode" => $BusinessShortCode,
    "Password" => $password,
    "Timestamp" => $timestamp,
    "TransactionType" => "CustomerPayBillOnline",
    "Amount" => $amount,
    "PartyA" => $phone,
    "PartyB" => $BusinessShortCode,
    "PhoneNumber" => $phone,
    "CallBackURL" => $callbackURL,
    "AccountReference" => "VibeBox",
    "TransactionDesc" => "Tip the DJ"
];

$curl = curl_init();
curl_setopt_array($curl, [
    CURLOPT_URL => 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest',
    CURLOPT_HTTPHEADER => [
        "Authorization: Bearer $token",
        "Content-Type: application/json"
    ],
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => json_encode($payload)
]);

$response = curl_exec($curl);
curl_close($curl);

$res = json_decode($response, true);

if (isset($res['ResponseCode']) && $res['ResponseCode'] == "0") {
    echo "✅ Tip request sent. Check your phone to complete M-PESA payment.<br><br><a href='index.php'>⬅️ Back</a>";
} else {
    echo "❌ Failed to initiate payment. Try again later.<br><br><a href='tip.php'>⬅️ Back</a>";
}
?>

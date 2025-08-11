<?php
// Set proper headers
header("Content-Type: application/json");

// Read raw POST data
$data = file_get_contents('php://input');
$logFile = "mpesa-callback-log.txt"; // Simple flat file logging

// Decode JSON into PHP array
$mpesaResponse = json_decode($data, true);

// Log raw JSON (optional for dev)
file_put_contents($logFile, $data . PHP_EOL, FILE_APPEND);

// Pull useful data (if transaction is successful)
if (isset($mpesaResponse['Body']['stkCallback']['ResultCode']) &&
    $mpesaResponse['Body']['stkCallback']['ResultCode'] == 0) {

    $callback = $mpesaResponse['Body']['stkCallback'];
    $mpesaCode = $callback['CallbackMetadata']['Item'][1]['Value'] ?? 'NO_CODE';
    $amount = $callback['CallbackMetadata']['Item'][0]['Value'] ?? 0;
    $phone = $callback['CallbackMetadata']['Item'][4]['Value'] ?? 'NO_PHONE';
    $transTime = $callback['CallbackMetadata']['Item'][3]['Value'] ?? 'NO_TIME';

    // You can also save to DB here

    $logEntry = "✔️ PAID | Amount: $amount | Code: $mpesaCode | Phone: $phone | Time: $transTime";
    file_put_contents($logFile, $logEntry . PHP_EOL, FILE_APPEND);
} else {
    $logEntry = "❌ FAILED | " . date('Y-m-d H:i:s');
    file_put_contents($logFile, $logEntry . PHP_EOL, FILE_APPEND);
}

// Send 200 OK to Safaricom to stop retries
echo json_encode(["ResultCode" => 0, "ResultDesc" => "STK Callback received successfully"]);
?>

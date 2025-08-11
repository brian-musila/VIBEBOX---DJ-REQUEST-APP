<?php
$data = file_get_contents("php://input");
file_put_contents("logs/tips.txt", date('Y-m-d H:i:s') . " — " . $data . PHP_EOL, FILE_APPEND);

// Optionally parse and store to DB
$decoded = json_decode($data, true);
if (isset($decoded['Body']['stkCallback']['ResultCode']) && $decoded['Body']['stkCallback']['ResultCode'] == 0) {
    $amount = $decoded['Body']['stkCallback']['CallbackMetadata']['Item'][0]['Value'];
    $phone  = $decoded['Body']['stkCallback']['CallbackMetadata']['Item'][4]['Value'];

    // Log confirmed tip
    file_put_contents("logs/tips.txt", "✅ CONFIRMED: $phone tipped KES $amount\n", FILE_APPEND);
}

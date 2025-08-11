<?php
if ($_FILES['audio']) {
    $filePath = $_FILES['audio']['tmp_name'];
    $audio = curl_file_create($filePath, 'audio/webm');
    $data = [
        'api_token' => 'YOUR_AUDD_API_KEY',
        'return' => 'spotify,apple_music',
        'file' => $audio
    ];
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://api.audd.io/");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    $res = curl_exec($ch);
    curl_close($ch);
    echo $res;
}
?>

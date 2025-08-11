<?php
// whatsplaying-handler.php

$api_token = ''; // Replace with your real AudD API key

if (!isset($_FILES['audio'])) {
    echo json_encode(['success' => false, 'error' => 'No audio uploaded']);
    exit;
}

$audio_path = $_FILES['audio']['tmp_name'];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://api.audd.io/');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, [
    'file' => new CURLFile($audio_path),
    'return' => 'lyrics,apple_music,spotify,youtube',
    'api_token' => $api_token
]);

$response = curl_exec($ch);
$error = curl_error($ch);
curl_close($ch);

if ($error) {
    echo json_encode(['success' => false, 'error' => $error]);
    exit;
}

$data = json_decode($response, true);

if (!isset($data['result']) || !$data['result']) {
    echo json_encode(['success' => false, 'error' => 'Song not recognized']);
    exit;
}

$result = $data['result'];
$title = $result['title'] ?? 'Unknown';
$artist = $result['artist'] ?? 'Unknown';
$lyrics = $result['lyrics']['lyrics'] ?? 'Lyrics not available';
$youtube_url = $result['youtube']['url'] ?? '';

// Extract YouTube Video ID from URL
parse_str(parse_url($youtube_url, PHP_URL_QUERY), $yt_query);
$youtube_id = $yt_query['v'] ?? '';

echo json_encode([
    'success' => true,
    'title' => $title,
    'artist' => $artist,
    'lyrics' => $lyrics,
    'youtube_id' => $youtube_id
]);

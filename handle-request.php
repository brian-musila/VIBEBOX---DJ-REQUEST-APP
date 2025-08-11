<?php
session_start();
include 'db.php';

if (isset($_SESSION['last_request_time']) && time() - $_SESSION['last_request_time'] < 60) {
    die("⏳ Please wait a moment before sending another request.");
}

$song_name = trim(mysqli_real_escape_string($conn, $_POST['song_name']));
$artist = trim(mysqli_real_escape_string($conn, $_POST['artist']));
$nickname = trim(mysqli_real_escape_string($conn, $_POST['nickname']));
$mood = trim(mysqli_real_escape_string($conn, $_POST['mood']));
$message = trim(mysqli_real_escape_string($conn, $_POST['message']));
$user_ip = $_SERVER['REMOTE_ADDR'];

if (empty($song_name) || empty($mood)) {
    die("⚠️ Required fields are missing.");
}

$sql = "INSERT INTO requests (song_name, artist, nickname, mood, message, ip_address, request_time) 
        VALUES (?, ?, ?, ?, ?, ?, NOW())";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssss", $song_name, $artist, $nickname, $mood, $message, $user_ip);

if ($stmt->execute()) {
    $_SESSION['last_request_time'] = time();
    echo "✅ Request submitted successfully!<br><br><a href='index.php'>⬅️ Back to Home</a>";
} else {
    echo "❌ Error submitting your request.";
}

$stmt->close();
$conn->close();
?>
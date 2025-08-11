<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin-login.php");
    exit();
}

include 'db.php';

// 1. Create backup file
$filename = 'vibebox_backup_' . date('Ymd_His') . '.txt';
$fp = fopen($filename, 'w');
$result = $conn->query("SELECT * FROM requests");

while ($row = $result->fetch_assoc()) {
    $entry = "🎵 {$row['song_name']} by {$row['artist']}\n";
    $entry .= "🙋 Nickname: {$row['nickname']} | Mood: {$row['mood']}\n";
    $entry .= "📝 Message: {$row['message']}\n";
    $entry .= "🕒 Time: {$row['request_time']}\n";
    $entry .= "-----------------------------\n";
    fwrite($fp, $entry);
}
fclose($fp);

// 2. Delete from DB
$conn->query("DELETE FROM requests");

// 3. Force download
header('Content-Type: text/plain');
header("Content-Disposition: attachment; filename=\"$filename\"");
readfile($filename);

// 4. Delete backup file from server
unlink($filename);
exit();
?>

<?php
include 'db.php';
header('Content-Type: text/plain');
header('Content-Disposition: attachment; filename="vibebox_requests.txt"');

$result = $conn->query("SELECT * FROM requests ORDER BY request_time DESC");
echo "🎧 VibeBox Requests Log\n=======================\n\n";

while ($row = $result->fetch_assoc()) {
    echo "🎵 " . $row['song_name'] . " by " . $row['artist'] . "\n";
    echo "🙋 Nickname: " . $row['nickname'] . " | Mood: " . $row['mood'] . "\n";
    echo "📝 Message: " . $row['message'] . "\n";
    echo "🕒 Time: " . $row['request_time'] . "\n";
    echo "-----------------------------\n";
}
?>

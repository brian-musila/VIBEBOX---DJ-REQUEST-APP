<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['vote'])) {
  $_SESSION['voted'] = true;
  $mood = $_POST['vote'];
  $conn->query("INSERT INTO poll_votes (mood, voted_at) VALUES ('$mood', NOW())");
  header("Location: poll.php");
  exit();
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>🎤 Crowd Poll</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="form-container">
  <h1>🗳️ Vote the Vibe</h1>

  <?php if (!isset($_SESSION['voted'])): ?>
    <form method="POST">
      <select name="vote" required>
        <option value="">-- Select Your Mood --</option>
        <option value="🔥 OLD SCHOOL HIPHOP/RNB">🔥 OLD SCHOOL HIPHOP/RNB</option>
        <option value="💃 AFROBEATS">💃 AFROBEATS</option>
        <option value="🛌 REGGAE">🛌 REGGAE</option>
        <option value="🎤 ARBANTONE/MAGENGE">🎤 ARBANTONE/MAGENGE</option>
      </select>
      <button class="btn-submit">Vote</button>
    </form>
  <?php else: ?>
    <h3>✅ Thanks for voting!</h3>
    <p>Only the DJ can view live poll results in the Admin Panel.</p>
  <?php endif; ?>

  <div class="back-link"><a href="index.php">⬅️ Back</a></div>
</div>
</body>
</html>

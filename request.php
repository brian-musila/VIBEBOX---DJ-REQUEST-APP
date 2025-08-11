<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Request a Song | VibeBox</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <div class="form-container">
    <h1>🎵 Song Request</h1>
    <p>Drop your request and help shape the vibe!</p>
    <form action="handle-request.php" method="POST">
      <input type="text" name="song_name" placeholder="Song Name *" required>
      <input type="text" name="artist" placeholder="Artist (Optional)">
      <input type="text" name="nickname" placeholder="Your Nickname (Optional)">
      <select name="mood" required>
        <option value="" disabled selected>🎭 Select Genre</option>
        <option value="🔥 POP/RNBs">🔥 POP/RNBs </option>
        <option value="😎 HIPHOP/TRAP"> 😎 HIPHOP/TRAP</option>
        <option value="💃 REGGEA/DANCEHALL">💃 REGGEA/DANCEHALL</option>
        <option value="🎤 ARBANTONE/GENGE">🎤 ARBANTONE/GENGE</option>
        <option value="🌀 AFROBEATS/AMAPIANO">🌀 AFROBEATS/AMAPIANO</option>
      </select>
      <textarea name="message" rows="3" placeholder="Message for the DJ (Optional)"></textarea>
      <button type="submit" class="btn-submit">Submit Request</button>
    </form>
    <div class="back-link">
      <a href="index.php">⬅️ Back to Home</a>
    </div>
  </div>
</body>
</html>
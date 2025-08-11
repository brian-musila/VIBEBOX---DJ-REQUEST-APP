<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>VibeBox – Request. React. Repeat.</title>
  <link rel="stylesheet" href="css/style.css">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>

  <!-- 🔐 Admin Access -->
  <div class="admin-link">
    <a href="admin-login.php" class="glow-btn">🎧 DJ Panel</a>


  </div>

  <!-- 🧠 Main Content -->
  <div class="container">
    <div class="center-content">
      <h1 class="logo-text">VibeBox</h1>
      <p class="motto">Request. React. Repeat.</p>

      <div class="btn-group">
        <a href="whatsplaying.php" class="btn-request alt">🎧 What's Playing?</a>
        <a href="request.php" class="btn-request">🎵 Make a Request</a>
        <a href="poll.php" class="btn-request">📊 Vote the Vibe</a>
        <a href="tip.php" class="btn-request">💰 Tip the DJ</a>
      </div>
    </div>
  </div>

  <!-- ⚡ Footer Credit -->
  <footer style="position: fixed; bottom: 10px; width: 100%; text-align: center; color: #00f0ff; font-size: 0.9rem; z-index: 1;">
    Developed by Dev.Brian Musila || Built by a DJ for a DJ 😎 || 2025
  </footer>

  <!-- 🐦 Social Media Links -->

</body>
</html>

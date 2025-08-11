<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin-login.php");
    exit();
}
include 'db.php';

// Queries
$top_songs = $conn->query("SELECT song_name, COUNT(*) as count FROM requests GROUP BY song_name ORDER BY count DESC LIMIT 5");
$moods = $conn->query("SELECT mood, COUNT(*) as count FROM requests GROUP BY mood");
$all = $conn->query("SELECT * FROM requests ORDER BY request_time DESC");
$tips = $conn->query("SELECT * FROM tips ORDER BY tip_time DESC");

?>
<!DOCTYPE html>
<html>
<head>
  <title>Admin Dashboard | VibeBox</title>
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <link rel="stylesheet" href="css/style.css">
  <style>
    body {
      padding: 30px;
      background: #0b0b0b;
      color: #fff;
      font-family: 'Segoe UI', sans-serif;
    }

    h1 { margin-bottom: 10px; }

    table {
      width: 100%;
      margin-top: 30px;
      border-collapse: collapse;
      background: #111;
    }

    th, td {
      padding: 10px;
      border: 1px solid #222;
    }

    th {
      background: #00f0ff;
      color: #000;
    }

    .charts {
      display: flex;
      gap: 30px;
      flex-wrap: wrap;
    }

    .charts > div {
      flex: 1;
      min-width: 300px;
    }

    a.logout {
      position: absolute;
      top: 20px;
      right: 30px;
      color: #00f0ff;
      text-decoration: none;
      font-weight: bold;
    }

    .btn-bar {
      margin: 20px 0;
    }

    .btn-submit {
      display: inline-block;
      background: #00f0ff;
      color: #000;
      padding: 10px 18px;
      border-radius: 6px;
      font-weight: bold;
      text-decoration: none;
      margin-right: 10px;
      transition: 0.3s;
    }

    .btn-submit:hover {
      background: #00cdd2;
    }

    .crowd-button {
      position: fixed;
      bottom: 20px;
      right: 20px;
      background: #00f0ff;
      color: #000;
      padding: 10px 14px;
      border-radius: 8px;
      font-size: 14px;
      font-weight: bold;
      text-decoration: none;
      box-shadow: 0 0 10px #00f0ff, 0 0 20px #00f0ff66;
      transition: all 0.3s ease-in-out;
    }

    .crowd-button:hover {
      background: #000;
      color: #00f0ff;
      box-shadow: 0 0 10px #00f0ff, 0 0 25px #00f0ff99;
    }

    .crowd-note {
      position: fixed;
      bottom: 10px;
      right: 250px;
      width: 250px;
      font-size: 13px;
      color: #00f0ff;
      background: rgba(0, 0, 0, 0.7);
      padding: 10px;
      border-radius: 10px;
      text-align: left;
      font-style: italic;
      box-shadow: 0 0 10px #00f0ff22;
      z-index: 100;
    }
  </style>

  <script>
    google.charts.load("current", {packages:["corechart"]});
    google.charts.setOnLoadCallback(drawCharts);
    function drawCharts() {
      var songData = google.visualization.arrayToDataTable([
        ['Song', 'Requests'],
        <?php while ($r = $top_songs->fetch_assoc()) echo "['".addslashes($r['song_name'])."', ".$r['count']."],"; ?>
      ]);

      var moodData = google.visualization.arrayToDataTable([
        ['Mood', 'Count'],
        <?php while ($r = $moods->fetch_assoc()) echo "['".addslashes($r['mood'])."', ".$r['count']."],"; ?>
      ]);

      new google.visualization.PieChart(document.getElementById('songChart')).draw(songData, {
        title: 'Top Requested Songs',
        pieHole: 0.4,
        backgroundColor: 'transparent',
        titleTextStyle: {color: '#fff'},
        legend: {textStyle: {color: '#fff'}}
      });

      new google.visualization.ColumnChart(document.getElementById('moodChart')).draw(moodData, {
        title: 'Crowd Mood Summary',
        backgroundColor: 'transparent',
        titleTextStyle: {color: '#fff'},
        legend: {textStyle: {color: '#fff'}}
      });
    }

    function confirmClear() {
      return confirm("⚠️ Are you sure you want to clear all requests?\nA backup .txt will be downloaded.");
    }
  </script>
</head>
<body>
<a class="logout" href="logout.php">Logout</a>
<h1>🎛️ DJ Admin Dashboard</h1>

<div class="charts">
  <div id="songChart" style="height: 300px;"></div>
  <div id="moodChart" style="height: 300px;"></div>
</div>

<h2>📋 All Requests</h2>

<div class="btn-bar">
  <a href="download-requests.php" class="btn-submit">💾 Export as .txt</a>
  <a href="clear-requests.php" class="btn-submit" onclick="return confirmClear()">🗑️ Clear All Requests</a>
</div>

<table>
  <tr><th>Song</th><th>Artist</th><th>Nickname</th><th>Mood</th><th>Message</th><th>Time</th></tr>
  <?php while ($r = $all->fetch_assoc()): ?>
  <tr>
    <td><?= htmlspecialchars($r['song_name']) ?></td>
    <td><?= htmlspecialchars($r['artist']) ?></td>
    <td><?= htmlspecialchars($r['nickname']) ?></td>
    <td><?= htmlspecialchars($r['mood']) ?></td>
    <td><?= htmlspecialchars($r['message']) ?></td>
    <td><?= $r['request_time'] ?></td>
  </tr>
  <?php endwhile; ?>
</table>

<h2 style="margin-top: 40px;">💸Tips Received Today💸</h2>
<table>
  <tr><th>Phone</th><th>Amount (KES)</th><th>Time</th></tr>
  <?php while ($t = $tips->fetch_assoc()): ?>
  <tr>
    <td><?= htmlspecialchars($t['phone']) ?></td>
    <td><?= number_format($t['amount'], 2) ?></td>
    <td><?= $t['tip_time'] ?></td>
  </tr>
  <?php endwhile; ?>
</table>


<div class="crowd-note">
  🎧 Hey DJ,unlock your secret weapon here!!👀👉👉👉👉👉👉
</div>

<a href="poll-results.php" class="crowd-button">📊 Read your Crowd's Energy</a>

<footer style="margin-top: 30px; text-align: center; color: #00f0ff; font-size: 0.9rem;">
  Developed by Dev.Brian Musila || Built by a DJ for a DJ 😎 || 2025
</footer>
</body>
</html>

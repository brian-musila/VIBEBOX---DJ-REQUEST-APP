<?php
session_start();
include 'db.php';


if (!isset($_SESSION['admin_logged_in'])) {
  header('Location: ../admin-login.php');
  exit();
}

$votes = $conn->query("SELECT mood, COUNT(*) as total FROM poll_votes GROUP BY mood");
$moods = [];
$totals = [];

while ($row = $votes->fetch_assoc()) {
  $moods[] = $row['mood'];
  $totals[] = $row['total'];
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>📊YOUR CROWD's ENERGY REQUESTS</title>
  <link rel="stylesheet" href="../css/style.css">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
    body {
      background: #0a0a0a;
      color: #fff;
      font-family: 'Segoe UI', sans-serif;
      padding: 30px;
      text-align: center;
    }

    canvas {
      max-width: 90%;
      max-height: 300px;
      margin: 0 auto;
    }

    .form-container {
      background: rgba(0, 0, 0, 0.7);
      padding: 20px;
      border-radius: 12px;
      box-shadow: 0 0 20px #00f0ff44;
      max-width: 600px;
      margin: 0 auto;
    }

    .back-link a {
      color: #00f0ff;
      text-decoration: none;
      margin-top: 20px;
      display: inline-block;
      font-weight: bold;
    }
  </style>
</head>
<body>
  <div class="form-container">
    <h1>💃🔥WHAT DOES YOUR CROWD WANT?🕺🎶</h1>
    <canvas id="pollChart"></canvas>
    <div class="back-link"><a href="admin.php">⬅️ Back to Dashboard</a></div>
  </div>

  <script>
    const ctx = document.getElementById('pollChart').getContext('2d');
    const pollChart = new Chart(ctx, {
      type: 'bar',
      data: {
        labels: <?= json_encode($moods) ?>,
        datasets: [{
          label: 'Votes',
          data: <?= json_encode($totals) ?>,
          backgroundColor: ['#00f0ff', '#ff00ff', '#00ffaa', '#ffaa00'],
          borderRadius: 8
        }]
      },
      options: {
        responsive: true,
        scales: {
          y: {
            beginAtZero: true,
            ticks: { stepSize: 1 }
          }
        },
        plugins: {
          legend: { display: false }
        }
      }
    });
  </script>
</body>
</html>

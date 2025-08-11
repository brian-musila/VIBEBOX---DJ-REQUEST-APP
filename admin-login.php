z<?php
session_start();
$correct_username = "";
$correct_password = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST['username'];
    $pass = $_POST['password'];

    if ($user === $correct_username && $pass === $correct_password) {
        $_SESSION['admin_logged_in'] = true;
        header("Location: admin.php");
        exit();
    } else {
        $error = "Invalid login. Try again.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>DJ Login | VibeBox</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="form-container">
    <h1>🎛️ DJ/Admin Login</h1>
    <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
    <form method="POST">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button class="btn-submit">Login</button>
    </form>
    <div class="back-link"><a href="index.php">⬅️ Back</a></div>
</div>
</body>
</html>
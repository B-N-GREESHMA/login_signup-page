<?php
include "config.php";
session_start();
$msg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $identifier = trim($_POST["identifier"]);
    $password = $_POST["password"];

    $stmt = $conn->prepare("SELECT * FROM users WHERE username=? OR email=?");
    $stmt->bind_param("ss", $identifier, $identifier);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION["user"] = $user['username'];
        header("Location: dashboard.php");
    } else {
        $msg = "Incorrect username/email or password.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Login</h2>
        <form method="POST">
            <input type="text" name="identifier" placeholder="Username or Email"><br>
            <input type="password" name="password" placeholder="Password"><br>
            <button type="submit">Login</button>
        </form>
        <p class="msg"><?php echo $msg; ?></p>
        <p>Don't have an account? <a href="signup.php">Sign up here</a></p>
        <div style="margin-top: 20px;">
    <a href="index.html" style="display: inline-block; padding: 8px 16px; background: #ddd; color: #333; border-radius: 6px; text-decoration: none; font-size: 14px;">
        ← Back to Home
    </a>
</div>




</body>
</html>

<?php
include "config.php";
session_start();
$msg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $email = trim($_POST["email"]);
    $password = $_POST["password"];
    $confirm = $_POST["confirm"];

    if (empty($username) || empty($email) || empty($password) || empty($confirm)) {
        $msg = "All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $msg = "Invalid email format.";
    } elseif ($password !== $confirm) {
        $msg = "Passwords do not match.";
    } else {
        $check = $conn->prepare("SELECT * FROM users WHERE username=? OR email=?");
        $check->bind_param("ss", $username, $email);
        $check->execute();
        $result = $check->get_result();

        if ($result->num_rows > 0) {
            $msg = "Username or Email already exists.";
        } else {
            $hashed = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $username, $email, $hashed);
            $stmt->execute();
            $msg = "Signup successful. You can now <a href='login.php'>login</a>.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Signup</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Signup</h2>
        <form method="POST">
            <input type="text" name="username" placeholder="Username"><br>
            <input type="email" name="email" placeholder="Email"><br>
            <input type="password" name="password" placeholder="Password"><br>
            <input type="password" name="confirm" placeholder="Confirm Password"><br>
            <button type="submit">Signup</button>
        </form>
        <p class="msg"><?php echo $msg; ?></p>
        <p>Already have an account? <a href="login.php">Login here</a></p>
        <div style="margin-top: 20px;">
    <a href="index.html" style="display: inline-block; padding: 8px 16px; background: #ddd; color: #333; border-radius: 6px; text-decoration: none; font-size: 14px;">
        ← Back to Home
    </a>
</div>



</body>
</html>

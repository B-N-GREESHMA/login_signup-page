<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Welcome, <?php echo $_SESSION["user"]; ?> 🎉</h2>
        <p>You’re now logged in!</p>
        <a href="logout.php"><button>Logout</button></a>
    </div>
    
</body>
</html>

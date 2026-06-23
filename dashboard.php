<?php
session_start();

// checks if user is logged in, if not redirect to login page
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

// gets user's name from session to display on dashboard
$name = $_SESSION["name"];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
    <h2>Dashboard</h2>

    <p>Welcome, <strong><?php echo htmlspecialchars($name); ?></strong>!</p>
    <img src="image/kuromi_witch.webp" alt="Kuromi Image" class="dashboard-img">
    <p>You have successfully logged in.</p>

    <a href="logout.php" class="logout-btn">Logout</a>
</div>

</body>
</html>
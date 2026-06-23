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
<body class="dashboard-body">

<nav class="dashboard-navbar">
    <h2>Dashboard</h2>
    <a href="logout.php" class="nav-logout">Logout</a>
</nav>

<div class="dashboard-content">
    <div class="dashboard-card">
        <h1>Welcome, <strong><?php echo htmlspecialchars($name); ?></strong>!</h1>

        <img src="image/kuromi_witch.webp" alt="Kuromi Image" class="dashboard-img">

        <p>You have successfully logged in.</p>
    </div>
</div>

</body>
</html>
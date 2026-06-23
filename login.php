<?php
session_start();
include "db.php";

// stores error and success messages
$error = "";
$success = "";

// if newly registered, show success message on login page
if (isset($_GET["registered"])) {
    $success = "Registration successful. You may now login.";
}

// checks if form is submitted & validate input fields
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $password = $_POST["password"];

// chekcs if email and password fields are empty
    if (empty($email) || empty($password)) {
        $error = "Email and password are required.";
    } else {
        // search for user in the database by email
        $stmt = $conn->prepare("SELECT id, name, password FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();

        $result = $stmt->get_result();

        // checks if user exists
        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();

        // verifies password against hashed passsword
            if (password_verify($password, $user["password"])) {
                session_regenerate_id(true);

                $_SESSION["user_id"] = $user["id"];
                $_SESSION["name"] = $user["name"];

            // redirects user to dashboard after login
                header("Location: dashboard.php");
                exit();
            } else {
                $error = "Invalid email or password.";
            }
        } else {
            $error = "Invalid email or password.";
        }

        $stmt->close();
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

    <?php if (!empty($success)): ?>
        <p class="success"><?php echo htmlspecialchars($success); ?></p>
    <?php endif; ?>

    <?php if (!empty($error)): ?>
        <p class="error"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <form method="POST" action="">
        <input type="email" name="email" placeholder="Email Address" required>
        <input type="password" name="password" placeholder="Password" required>

        <button type="submit">Login</button>
    </form>

    <p>No account yet? <a href="register.php">Register here</a></p>
</div>

</body>
</html>
<?php
session_start();
include "db.php";

// stores error messages
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

// gets user input from form and trims whitespace
    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    // validate input field

    // checks if any of the field are empty
    if (empty($name) || empty($email) || empty($password)) {
        $error = "All fields are required.";

    // checks if email in in valid format
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format.";

    // checks if password is at least 6 characters long
    } elseif (strlen($password) < 6) {
        $error = "Password must be at least 6 characters.";
    } else {
        // checks if email is already registered
        $check = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $check->bind_param("s", $email);
        $check->execute();
        $check->store_result();

        // error for when email is already registered
        if ($check->num_rows > 0) {
            $error = "Email is already registered.";
        // password is hashed before saving to the database
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // inserts new user info into the database 
            $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $name, $email, $hashed_password);

        // redirects to login page after successful registration
            if ($stmt->execute()) {
                header("Location: login.php?registered=1");
                exit();
            } else {
                $error = "Registration failed. Please try again.";
            }

            $stmt->close();
        }

        $check->close();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
    <h2>Register</h2>

    <?php if (!empty($error)): ?>
        <p class="error"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <form method="POST" action="">
        <input type="text" name="name" placeholder="Full Name" required>
        <input type="email" name="email" placeholder="Email Address" required>
        <input type="password" name="password" placeholder="Password" required>

        <button type="submit">Register</button>
    </form>

    <p>Already have an account? <a href="login.php">Login here</a></p>
</div>

</body>
</html>
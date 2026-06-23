<?php
session_start();

// clears all session data 
$_SESSION = array();

// destroys current session
session_destroy();

// redirects user back to login page after logout
header("Location: login.php");
exit();
?>
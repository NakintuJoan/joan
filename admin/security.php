<?php
// Start the session
session_start();

// Check if the username session variable is set and is not empty
if (!isset($_SESSION["username"]) || empty($_SESSION["username"])) {
    // Redirect to the login page if the session is not set or is empty
    header("Location: login.php");
    exit(); // Ensure no further code is executed after the redirect
}

// Optionally, you could sanitize the session variable to prevent unexpected behavior
$username = htmlspecialchars($_SESSION["username"], ENT_QUOTES, 'UTF-8');

// Now you can use $username safely
?>

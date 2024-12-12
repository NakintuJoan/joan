<?php
session_start();
require 'db_connect.php';

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['email'], $_POST['password'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Query to check email and password
    $query = "SELECT * FROM register WHERE email = '$email' AND password = '$password'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        // Fetch user details
        $user = mysqli_fetch_assoc($result);
        $_SESSION['admin'] = $user;

        // Redirect to dashboard
        header("Location: index.php");
        exit();
    } else {
        echo "Invalid username or password.";
    }
} else {
    echo "Please submit the login form.";
}
?>

<!-- Login Form -->
<form action="login.php" method="POST">
    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required>
    <br>
    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required>
    <br>
    <button type="submit">Login</button>
</form>

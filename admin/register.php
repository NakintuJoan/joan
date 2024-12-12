<?php
session_start();
require 'db_connect.php';

// Redirect if not logged in
if (!isset($_SESSION['admin'])) {
    header("Location: ../index.php"); // Redirect to the blog page outside the admin folder
    exit;
}

// Handle new admin addition
$successMessage = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_admin'])) {
    $newUsername = $_POST['username'];
    $newPassword = $_POST['password'];
    $newEmail = $_POST['email'];
    $newRole = isset($_POST['role']) ? $_POST['role'] : 'admin'; // Default to 'admin' if 'role' is not set

    // Insert new admin into the database
    $stmt = $conn->prepare("INSERT INTO register (username, password, email, role) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $newUsername, $newPassword, $newEmail, $newRole);
    if ($stmt->execute()) {
        // Success message
        $successMessage = "New admin added successfully!";
    } else {
        // Error message if insert fails
        $successMessage = "Failed to add new admin. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Admin</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome for icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .sidebar {
            width: 250px;
            background: linear-gradient(to bottom, #006400, darkgreen); /* Gradient background */
            color: #fff;
            height: 100vh;
            position: fixed;
            padding: 20px;
        }
        .sidebar a {
            color: #fff;
            display: block;
            margin: 15px 0;
            text-decoration: none;
            font-size: 18px;
        }
        .sidebar a:hover {
            color: #ddd;
        }
        .content {
            margin-left: 270px;
            padding: 30px;
        }
        .success-message {
            color: green;
            margin-bottom: 20px;
        }
        .error-message {
            color: red;
            margin-bottom: 20px;
        }
        .welcome-message {
            font-size: 16px;
            font-weight: bold;
        }
        .welcome-icon {
            margin-right: 10px;
        }
    </style>
</head>
<body>
   <!-- Sidebar -->
<div class="sidebar">
    <div class="brand-name">Shillo NileStar</div>
    <a href="index.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
    <a href="register.php"><i class="fas fa-user-plus"></i> Add New Admin</a>
    <a href="pages.php"><i class="fas fa-file-alt"></i> Pages</a> <!-- New Pages Link -->
    <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
</div>

    <div class="content">
        <!-- Navbar with Welcome Message -->
        <nav class="navbar navbar-expand-lg navbar-light">
            <div class="container-fluid">
                <span class="navbar-brand mb-0 h1" >Add New Admin</span>
                <div class="ms-auto">
                    <span class="welcome-message">
                        <i class="fas fa-user-circle welcome-icon"></i> Welcome, <?php echo $_SESSION['admin']['username']; ?>
                    </span>
                </div>
            </div>
        </nav>

        <!-- Success/Error Messages -->
        <?php if ($successMessage != ""): ?>
            <p class="success-message"><?php echo $successMessage; ?></p>
        <?php endif; ?>

        <!-- Form to add a new admin -->
        <form method="POST" class="mt-4">
            <div class="mb-3">
                <label for="username" class="form-label">Username:</label>
                <input type="text" name="username" id="username" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password:</label>
                <input type="password" name="password" id="password" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" name="email" id="email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="role" class="form-label">Role:</label>
                <select name="role" id="role" class="form-select" required>
                    <option value="admin">Admin</option>
                    <option value="superadmin">Super Admin</option>
                </select>
            </div>
            <button type="submit" name="add_admin" class="btn btn-success">Add Admin</button>
        </form>
    </div>

    <!-- Bootstrap JS and FontAwesome -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

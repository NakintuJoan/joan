<?php
session_start();
require 'db_connect.php';

// Redirect if not logged in
if (!isset($_SESSION['admin'])) {
    header("Location: ../index.php"); // Redirect to the blog page outside the admin folder
    exit;
}

// Fetch admin details for editing
if (isset($_GET['edit_id'])) {
    $editId = $_GET['edit_id'];

    // Fetch the admin's current details
    $stmt = $conn->prepare("SELECT * FROM register WHERE id = ?");
    $stmt->bind_param("i", $editId);
    $stmt->execute();
    $result = $stmt->get_result();
    $admin = $result->fetch_assoc();

    if (!$admin) {
        // Redirect if admin not found
        header("Location: index.php");
        exit;
    }
}

// Handle admin update
$successMessage = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_admin'])) {
    $newUsername = $_POST['username'];
    $newPassword = $_POST['password'];
    $newEmail = $_POST['email'];
    $newRole = isset($_POST['role']) ? $_POST['role'] : 'admin'; // Default to 'admin' if 'role' is not set

    // Update the admin in the database
    $stmt = $conn->prepare("UPDATE register SET username = ?, password = ?, email = ?, role = ? WHERE id = ?");
    $stmt->bind_param("ssssi", $newUsername, $newPassword, $newEmail, $newRole, $editId);
    if ($stmt->execute()) {
        // Success message
        $successMessage = "Admin details updated successfully!";
        // Redirect to the admin dashboard after update
        header("Location: index.php");
        exit;
    } else {
        // Error message if update fails
        $successMessage = "Failed to update admin details. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Admin</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
        }

        .sidebar {
            width: 250px;
            background: linear-gradient(to bottom, darkgreen, #006400); /* Gradient from darkgreen to a deeper green */
            color: #fff;
            height: 100vh;
            padding: 20px;
            position: fixed;
        }

        .sidebar a {
            color: white;
            display: block;
            margin: 10px 0;
            text-decoration: none;
            font-size: 18px;
        }

        .sidebar a:hover {
            background-color: #575757;
            border-radius: 5px;
        }

        .content {
            margin-left: 270px;
            padding: 20px;
        }

        .success-message {
            color: green;
            margin-bottom: 20px;
        }

        .error-message {
            color: red;
            margin-bottom: 20px;
        }

        .navbar {
            background-color: #343a40;
        }

        .navbar .navbar-nav .nav-link {
            color: white !important;
        }

        .navbar .navbar-nav .nav-link:hover {
            background-color: #575757;
        }

        .welcome-icon {
            font-size: 20px;
            margin-right: 10px;
        }

        .welcome-message {
            font-size: 18px;
        }

        .brand-name {
            font-size: 22px;
            font-weight: bold;
        }

        nav.navbar {
            background-color: #f8f9fa; /* Light background */
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
        <h2>Edit Admin: <?php echo $admin['username']; ?></h2>

        <?php if ($successMessage != ""): ?>
            <p class="success-message"><?php echo $successMessage; ?></p>
        <?php endif; ?>

        <form method="POST">
            <label>Username:</label>
            <input type="text" name="username" value="<?php echo $admin['username']; ?>" required><br>
            <label>Password:</label>
            <input type="password" name="password" value="<?php echo $admin['password']; ?>" required><br>
            <label>Email:</label>
            <input type="email" name="email" value="<?php echo $admin['email']; ?>" required><br>
            <label>Role:</label>
            <select name="role" required>
                <option value="admin" <?php echo $admin['role'] == 'admin' ? 'selected' : ''; ?>>Admin</option>
                <option value="superadmin" <?php echo $admin['role'] == 'superadmin' ? 'selected' : ''; ?>>Super Admin</option>
            </select><br>
            <button type="submit" name="update_admin">Update Admin</button>
        </form>
    </div>
</body>
</html>

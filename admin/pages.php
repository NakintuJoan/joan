<?php
session_start();
require 'db_connect.php';  // Database connection

// Redirect if not logged in
if (!isset($_SESSION['admin'])) {
    header("Location: ../index.php");
    exit;
}

$successMessage = "";
$errorMessage = "";

// Handle Create Operation
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['create'])) {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $url = $_POST['url'];

    // Handle image upload
    $image = $_FILES['image']['name'];
    $targetDir = "uploads/";
    $targetFile = $targetDir . basename($image);
    move_uploaded_file($_FILES['image']['tmp_name'], $targetFile);

    $stmt = $conn->prepare("INSERT INTO pages (title, content, url, image, created_at, updated_at) VALUES (?, ?, ?, ?, NOW(), NOW())");
    $stmt->bind_param("ssss", $title, $content, $url, $targetFile);
    if ($stmt->execute()) {
        $successMessage = "Page created successfully!";
        header("Location: pages.php");
        exit;
    } else {
        $errorMessage = "Failed to create page: " . $stmt->error;
    }
}

// Handle Read Operation
$pages = $conn->query("SELECT id, title, content, url, image, created_at, updated_at FROM pages");
if (!$pages) {
    die("Query failed: " . $conn->error);
}

// Handle Update Operation
if (isset($_GET['edit_id'])) {
    $editId = intval($_GET['edit_id']);
    $page = $conn->query("SELECT * FROM pages WHERE id = $editId")->fetch_assoc();
}

// Handle Update Submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
    $editId = $_POST['id'];
    $title = $_POST['title'];
    $content = $_POST['content'];
    $url = $_POST['url'];

    // Handle image upload if changed
    if ($_FILES['image']['name']) {
        $image = $_FILES['image']['name'];
        $targetFile = "uploads/" . basename($image);
        move_uploaded_file($_FILES['image']['tmp_name'], $targetFile);
    } else {
        $targetFile = $_POST['existing_image']; // Retain existing image if none uploaded
    }

    $stmt = $conn->prepare("UPDATE pages SET title = ?, content = ?, url = ?, image = ?, updated_at = NOW() WHERE id = ?");
    $stmt->bind_param("ssssi", $title, $content, $url, $targetFile, $editId);
    if ($stmt->execute()) {
        $successMessage = "Page updated successfully!";
        header("Location: pages.php");
        exit;
    } else {
        $errorMessage = "Failed to update page: " . $stmt->error;
    }
}

// Handle Delete Operation
if (isset($_GET['delete_id'])) {
    $deleteId = intval($_GET['delete_id']);
    $stmt = $conn->prepare("DELETE FROM pages WHERE id = ?");
    $stmt->bind_param("i", $deleteId);
    if ($stmt->execute()) {
        $successMessage = "Page deleted successfully!";
        header("Location: pages.php");
        exit;
    } else {
        $errorMessage = "Failed to delete page: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Pages</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
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


<!-- Content -->
<div class="content">
    <h1>Manage Pages</h1>

    <!-- Success/Error Messages -->
    <?php if ($successMessage): ?>
        <div class="alert alert-success"><?php echo $successMessage; ?></div>
    <?php endif; ?>
    <?php if ($errorMessage): ?>
        <div class="alert alert-danger"><?php echo $errorMessage; ?></div>
    <?php endif; ?>

    <!-- Create Page Form -->
    <h2>Create New Page</h2>
    <form method="POST" action="" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" name="title" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="content" class="form-label">Content</label>
            <textarea name="content" class="form-control" rows="5" required></textarea>
        </div>
        <div class="mb-3">
            <label for="url" class="form-label">URL</label>
            <input type="text" name="url" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Image</label>
            <input type="file" name="image" class="form-control">
        </div>
        <button type="submit" name="create" class="btn btn-primary">Create Page</button>
    </form>

    <!-- Edit Page Form -->
    <?php if (isset($page)): ?>
        <h2>Edit Page</h2>
        <form method="POST" action="" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $page['id']; ?>">
            <input type="hidden" name="existing_image" value="<?php echo $page['image']; ?>">
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" name="title" class="form-control" value="<?php echo htmlspecialchars($page['title']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="content" class="form-label">Content</label>
                <textarea name="content" class="form-control" rows="5" required><?php echo htmlspecialchars($page['content']); ?></textarea>
            </div>
            <div class="mb-3">
                <label for="url" class="form-label">URL</label>
                <input type="text" name="url" class="form-control" value="<?php echo htmlspecialchars($page['url']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Image</label>
                <input type="file" name="image" class="form-control">
                <small>Existing Image: <img src="<?php echo $page['image']; ?>" width="100"></small>
            </div>
            <button type="submit" name="update" class="btn btn-success">Update Page</button>
        </form>
    <?php endif; ?>

    <!-- Pages List -->
    <h2>Existing Pages</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Content</th>
                <th>URL</th>
                <th>Image</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $pages->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo htmlspecialchars($row['title']); ?></td>
                    <td><?php echo htmlspecialchars($row['content']); ?></td>
                    <td><?php echo htmlspecialchars($row['url']); ?></td>
                    <td><img src="<?php echo $row['image']; ?>" width="100"></td>
                    <td>
                        <a href="?edit_id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="?delete_id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this page?');">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

</body>
</html>

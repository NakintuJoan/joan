
<?php
session_start();

// Use the correct path to include the database connection file
require_once __DIR__ . '/admin/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize input
    $studentName = htmlspecialchars(trim($_POST['student_name']));
    $parentName = htmlspecialchars(trim($_POST['parent_name']));
    $age = intval($_POST['age']); // Ensure age is an integer
    $gender = htmlspecialchars(trim($_POST['gender']));
    $address = htmlspecialchars(trim($_POST['address']));
    $contactNumber = htmlspecialchars(trim($_POST['contact_number']));
    $email = htmlspecialchars(trim($_POST['email']));
    $admissionClass = htmlspecialchars(trim($_POST['admission_class']));

    try {
        // Insert application into the database
        $stmt = $conn->prepare("INSERT INTO admissions (student_name, parent_name, age, gender, address, contact_number, email, admission_class, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())");
        $stmt->bind_param("ssisssss", $studentName, $parentName, $age, $gender, $address, $contactNumber, $email, $admissionClass);

        if ($stmt->execute()) {
            // Redirect to home page with a success message
            $_SESSION['success_message'] = "Application submitted successfully!";
            header("Location: blog.php");
            exit();
        } else {
            throw new Exception("Failed to submit the application.");
        }
    } catch (Exception $e) {
        $errorMessage = $e->getMessage();
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admissions - Shillo Nile Star Primary School</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <h2 class="text-center my-4">Admissions Form</h2>
    <?php if (isset($errorMessage)): ?>
        <div class="alert alert-danger text-center"><?php echo $errorMessage; ?></div>
    <?php endif; ?>
    <form method="POST" action="">
        <div class="mb-3">
            <label for="student_name" class="form-label">Student Name</label>
            <input type="text" class="form-control" id="student_name" name="student_name" required>
        </div>
        <div class="mb-3">
            <label for="parent_name" class="form-label">Parent Name</label>
            <input type="text" class="form-control" id="parent_name" name="parent_name" required>
        </div>
        <div class="mb-3">
            <label for="age" class="form-label">Age</label>
            <input type="number" class="form-control" id="age" name="age" required>
        </div>
        <div class="mb-3">
            <label for="gender" class="form-label">Gender</label>
            <select class="form-control" id="gender" name="gender" required>
                <option value="">Select Gender</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
                <option value="Other">Other</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="address" class="form-label">Address</label>
            <textarea class="form-control" id="address" name="address" rows="3" required></textarea>
        </div>
        <div class="mb-3">
            <label for="contact_number" class="form-label">Contact Number</label>
            <input type="text" class="form-control" id="contact_number" name="contact_number" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="mb-3">
            <label for="admission_class" class="form-label">Admission Class</label>
            <input type="text" class="form-control" id="admission_class" name="admission_class" required>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
</body>
</html>

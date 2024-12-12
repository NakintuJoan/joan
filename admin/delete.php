<?php
include_once 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];

    // Prepare and execute the delete statement
    $stmt = $conn->prepare("DELETE FROM admissions WHERE id = ?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        echo "Applicant deleted successfully.";
    } else {
        echo "Error deleting applicant.";
    }
    $stmt->close();
}

$conn->close();
?>
<?php
session_start();
require 'db_connect.php';

// Redirect if not logged in
if (!isset($_SESSION['admin'])) {
    header("Location: ../index.php"); // Redirect to the blog page outside the admin folder
    exit;
}

// Initialize the success message variable
$successMessage = "";

// Fetch total admins
$totalAdmins = $conn->query("SELECT COUNT(*) as total FROM register")->fetch_assoc()['total'];

// Fetch total applications
$totalApplications = $conn->query("SELECT COUNT(*) as total FROM admissions")->fetch_assoc()['total'];

// Fetch registered admins
$admins = $conn->query("SELECT * FROM register");

// Fetch applications
$applications = $conn->query("SELECT * FROM admissions");

// Handle delete admin
if (isset($_GET['delete_id'])) {
    $deleteId = intval($_GET['delete_id']); // Ensure ID is an integer

    // Delete the admin with the given ID
    $deleteStmt = $conn->prepare("DELETE FROM register WHERE id = ?");
    $deleteStmt->bind_param("i", $deleteId);
    if ($deleteStmt->execute()) {
        // Set success message after deletion
        $_SESSION['success_message'] = "Admin deleted successfully.";
        // Redirect after deletion
        header("Location: index.php");
        exit;
    } else {
        $_SESSION['error_message'] = "Failed to delete the admin. Please try again.";
    }
}

// Handle delete application
if (isset($_GET['delete_application_id'])) {
    $deleteAppId = intval($_GET['delete_application_id']); // Ensure ID is an integer

    // Delete the application with the given ID
    $deleteAppStmt = $conn->prepare("DELETE FROM admissions WHERE id = ?");
    $deleteAppStmt->bind_param("i", $deleteAppId);
    if ($deleteAppStmt->execute()) {
        // Set success message after deletion
        $_SESSION['success_message'] = "Application deleted successfully.";
        // Redirect after deletion
        header("Location: index.php");
        exit;
    } else {
        $_SESSION['error_message'] = "Failed to delete the application. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
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
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <div class="ms-auto">
                <span class="welcome-message">
                    <i class="fas fa-user-circle welcome-icon"></i> Welcome, <?php echo $_SESSION['admin']['username']; ?>
                </span>
            </div>
        </div>
    </nav>

    <!-- Success/Error Messages -->
    <?php if ($successMessage): ?>
        <div class="alert alert-info">
            <?php echo $successMessage; ?>
        </div>
    <?php endif; ?>

    <!-- Cards for Total Registered Admins and Applications -->
    <div class="card mb-4">
        <div class="card-body">
            <h3>Registered Admins</h3>
            <p>Total Registered Admins: <?php echo $totalAdmins; ?></p>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <h3>Applications</h3>
            <p>Total Applications: <?php echo $totalApplications; ?></p>
        </div>
    </div>

    <!-- Table for Registered Admins -->
    <h4>Registered Admins List</h4>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Email</th>
                <th>Created At</th>
                <th>Role</th>
                <th>Password</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($admin = $admins->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $admin['id']; ?></td>
                    <td><?php echo $admin['username']; ?></td>
                    <td><?php echo $admin['email']; ?></td>
                    <td><?php echo $admin['createdat']; ?></td>
                    <td><?php echo $admin['role']; ?></td>
                    <td><?php echo $admin['password']; ?></td>
                    <td>
                        <a href="edit.php?edit_id=<?php echo $admin['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="index.php?delete_id=<?php echo $admin['id']; ?>" onclick="return confirmDelete('<?php echo $admin['username']; ?>')" class="btn btn-danger btn-sm">Delete</a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    <div class="container mt-5">
    <h1 class="text-center">Applicant Information</h1>
    
    <table class="table table-bordered table-hover mt-4">
        <thead class="thead-dark">
            <tr>
                <th>ID</th>
                <th>Applicant Name</th>
                <th>Date of Birth</th>
                <th>Gender</th>
                <th>Day/Boarding</th>
                <th>Religion</th>
                <th>Former School</th>
                <th>Nationality</th>
                <th>Passport Number</th>
                <th>Intended Class</th>
                <th>Father's Name</th>
                <th>Father's NIN</th>
                <th>Father's Contact</th>
                <th>Father's Email</th>
                <th>Mother's Name</th>
                <th>Mother's Contact</th>
                <th>Mother's Email</th>
                <th>Additional Info</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            include_once 'db_connect.php';

            $sql = "SELECT id, applicant_name, dob, gender, day_boarding, religion, former_school, nationality, passport_number, intended_class, father_name, father_nin, father_contact, father_email, mother_name, mother_contact, mother_email, additional_info FROM admissions";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                        <td>" . htmlspecialchars($row['id']) . "</td>
                        <td>" . htmlspecialchars($row['applicant_name']) . "</td>
                        <td>" . htmlspecialchars($row['dob']) . "</td>
                        <td>" . htmlspecialchars($row['gender']) . "</td>
                        <td>" . htmlspecialchars($row['day_boarding']) . "</td>
                        <td>" . htmlspecialchars($row['religion']) . "</td>
                        <td>" . htmlspecialchars($row['former_school']) . "</td>
                        <td>" . htmlspecialchars($row['nationality']) . "</td>
                        <td>" . htmlspecialchars($row['passport_number']) . "</td>
                        <td>" . htmlspecialchars($row['intended_class']) . "</td>
                        <td>" . htmlspecialchars($row['father_name']) . "</td>
                        <td>" . htmlspecialchars($row['father_nin']) . "</td>
                        <td>" . htmlspecialchars($row['father_contact']) . "</td>
                        <td>" . htmlspecialchars($row['father_email']) . "</td>
                        <td>" . htmlspecialchars($row['mother_name']) . "</td>
                        <td>" . htmlspecialchars($row['mother_contact']) . "</td>
                        <td>" . htmlspecialchars($row['mother_email']) . "</td>
                        <td>" . htmlspecialchars($row['additional_info']) . "</td>
                        <td>
                            <button class='btn btn-info btn-sm' data-toggle='modal' data-target='#viewModal' data-id='" . htmlspecialchars($row['id']) . "' data-name='" . htmlspecialchars($row['applicant_name']) . "'>View</button>
                            <button class='btn btn-danger btn-sm delete-btn' data-id='" . htmlspecialchars($row['id']) . "'>Delete</button>
                        </td>
                    </tr>";
                }
            } else {
                echo "<tr><td colspan='18' class='text-center'>No applicants found.</td></tr>";
            }

            $conn->close();
            ?>
        </tbody>
    </table>
</div>

<!-- View Modal -->
<div class="modal fade" id="viewModal" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewModalLabel">Applicant Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss ="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p><strong>ID:</strong> <span id="applicantId"></span></p>
                <p><strong>Name:</strong> <span id="applicantName"></span></p>
                <p><strong>Date of Birth:</strong> <span id="applicantDob"></span></p>
                <p><strong>Gender:</strong> <span id="applicantGender"></span></p>
                <p><strong>Day/Boarding:</strong> <span id="applicantDayBoarding"></span></p>
                <p><strong>Religion:</strong> <span id="applicantReligion"></span></p>
                <p><strong>Former School:</strong> <span id="applicantFormerSchool"></span></p>
                <p><strong>Nationality:</strong> <span id="applicantNationality"></span></p>
                <p><strong>Passport Number:</strong> <span id="applicantPassportNumber"></span></p>
                <p><strong>Intended Class:</strong> <span id="applicantIntendedClass"></span></p>
                <p><strong>Father's Name:</strong> <span id="applicantFatherName"></span></p>
                <p><strong>Father's NIN:</strong> <span id="applicantFatherNin"></span></p>
                <p><strong>Father's Contact:</strong> <span id="applicantFatherContact"></span></p>
                <p><strong>Father's Email:</strong> <span id="applicantFatherEmail"></span></p>
                <p><strong>Mother's Name:</strong> <span id="applicantMotherName"></span></p>
                <p><strong>Mother's Contact:</strong> <span id="applicantMotherContact"></span></p>
                <p><strong>Mother's Email:</strong> <span id="applicantMotherEmail"></span></p>
                <p><strong>Additional Info:</strong> <span id="applicantAdditionalInfo"></span></p>
            </div>
        </div>
    </div>
</div>

<script>
    // Handle the View button click
    $('#viewModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Button that triggered the modal
        var id = button.data('id');
        var name = button.data('name');
        // You can add more data attributes as needed

        // Update the modal's content
        var modal = $(this);
        modal.find('#applicantId').text(id);
        modal.find('#applicantName').text(name);
        // Set other fields similarly
    });

    // Handle the Delete button click
    $('.delete-btn').on('click', function () {
        var applicantId = $(this).data('id');
        if (confirm('Are you sure you want to delete this applicant?')) {
            // Make an AJAX call to delete the applicant
            $.ajax({
                url: 'delete_applicant.php', // Your delete script
                type: 'POST',
                data: { id: applicantId },
                success: function (response) {
                    // Reload the page or remove the row from the table
                    location.reload(); // Reload the page to see the changes
                },
                error: function () {
                    alert('Error deleting applicant.');
                }
            });
        }
    });
</script>
<!-- Include jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Include Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

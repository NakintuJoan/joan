<?php
session_start();
require_once 'admin/db_connect.php'; // Include database connection

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Fetch form data
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $passwordInput = isset($_POST['password']) ? $_POST['password'] : '';

    // Query to fetch the admin user from the database
    $stmt = $conn->prepare("SELECT * FROM register WHERE email = ?");
    $stmt->bind_param("s", $email); // Bind the email
    $stmt->execute();
    $result = $stmt->get_result();
    
    // Check if the user exists
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verify the password (you should hash passwords in production)
        if ($passwordInput === $user['password']) {
            // Authentication successful, store session and redirect
            $_SESSION['admin'] = $user;
            header('Location: admin/index.php'); // Redirect to admin dashboard
            exit();
        } else {
            // Password is incorrect
            $error = "Invalid password. Please try again.";
        }
    } else {
        // Email not found in database
        $error = "Invalid email. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>School Website</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .login-form {
            max-width: 400px;
            margin: 50px auto;
            padding: 20px;
            background: white;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .card {
            margin: 15px 0;
        }
        .section-title {
            text-align: center;
            margin: 40px 0;
            font-size: 2rem;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <a class="navbar-brand" href="#">School Name</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="aboutus.php">About Us</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="admissions.php">Admissions</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="academics.php">Academics</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="contact.php">Contact</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#loginModal">Admin Login</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Admin Login Modal -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="loginModalLabel">Admin Login</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?php if (isset($error)): ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $error; ?>
                    </div>
                <?php endif; ?>
                <form method="POST" action="">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email address</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Login</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Welcome Section -->
<section class="text-center py-5">
    <h1>Welcome to Our School</h1>
    <p>Providing quality education and a nurturing environment for students to excel in life.</p>
</section>

<!-- Our School Life Section -->
<section class="container">
    <h2 class="section-title">Our School Life</h2>
    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <img src="https://via.placeholder.com/300" class="card-img-top" alt="School Life Image">
                <div class="card-body">
                    <h5 class="card-title">Sports Activities</h5>
                    <p class="card-text">Engage in various sports to build teamwork and physical fitness.</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <img src="https://via.placeholder.com/300" class="card-img-top" alt="School Life Image">
                <div class="card-body">
                    <h5 class="card-title">Cultural Events</h5>
                    <p class="card-text">Celebrate diverse cultures with performances and exhibitions.</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <img src="https://via.placeholder.com/300" class="card-img-top" alt="School Life Image">
                <div class="card-body">
                    <h5 class="card-title">Community Service</h5>
                    <p class="card-text">Give back to the community through various service projects.</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <img src="https://via.placeholder.com/300" class="card-img-top" alt="School Life Image">
                <div class="card-body">
                    <h5 class="card-title">Creative Arts</h5>
                    <p class="card-text">Foster creativity through music, painting, and theater programs.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Upcoming Events Section -->
<section class="container">
    <h2 class="section-title">Upcoming Events</h2>
    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <img src="https://via.placeholder.com/300" class="card-img-top" alt="Event Image">
                <div class="card-body">
                    <h5 class="card-title">Sports Day</h5>
                    <p class="card-text">Join us for a day of sports and competition.</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <img src="https://via.placeholder.com/300" class="card-img-top" alt="Event Image">
                <div class="card-body">
                    <h5 class="card-title">Annual Cultural Fair</h5>
                    <p class="card-text">Experience the diversity of our school culture.</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <img src="https://via.placeholder.com/300" class="card-img-top" alt="Event Image">
                <div class="card-body">
                    <h5 class="card-title">Parent-Teacher Meeting</h5>
                    <p class="card-text">A great opportunity for parents to meet teachers.</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <img src="https://via.placeholder.com/300" class="card-img-top" alt="Event Image">
                <div class="card-body">
                    <h5 class="card-title">Graduation Ceremony</h5>
                    <p class="card-text">Celebrate the success of our graduating students.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Apply Online Section -->
<section class="text-center py-5 bg-light">
    <h2>Apply Online</h2>
    <p>Submit your application online and become a part of our learning community.</p>
    <a href="admissions.php" class="btn btn-primary">Apply Now</a>
</section>

<footer class="bg-light text-center text-lg-start mt-5">
    <div class="text-center p-3">
        © 2023 School Name. All rights reserved.
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
</body>
</html>

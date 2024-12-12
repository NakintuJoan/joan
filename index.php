
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
  <title>Shilo Nile Star Nursery & Primary School</title>
  <link rel="icon" href="assets/wallpaper-1.jpg" type="image/jpg">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css">
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Baloo+2&family=Poppins&display=swap" rel="stylesheet">
  <style>
    .whatsapp-icon {
    position: fixed;
    bottom: 20px;
    left: 20px;
    z-index: 1000;
    }

    .whatsapp-icon img {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .whatsapp-icon img:hover {
        transform: scale(1.1);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3);
    }
    @media (max-width: 768px) {
    

    .navbar-toggler {
        float: none; /* Reset float */
        display: block; /* Ensure proper alignment */
    }

    .container {
        max-width: 100%; /* Prevent horizontal overflow */
        padding: 0; /* Reset padding for container */
    }
}


  </style>
  <style>
    #backToTop i{
        position: fixed;
        bottom: 20px;
        right: 20px;
        display: none; /* Hidden by default */
        z-index: 1000;
        padding: 10px 15px;
        border: none;
        border-radius: 50%;
        background-color: orange;
        color: white;
        font-size: 18px;
        cursor: pointer;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        transition: opacity 0.3s, visibility 0.3s;
    }
    
    #backToTop i:hover {
        background-color: green;
    }
    </style>
    
    

</head>
<body>
    <section id="topHeader" class="header navbar navbar-expand-lg shadow-sm sticky-top" style="position: fixed; top: 0; width: 100%; z-index: 1030; background: rgba(0, 128, 0, 0.9); padding: 5px; padding-left: 5px;">
        <div class="header navbar navbar-expand-lg shadow-sm sticky-top">
          <div class="container-fluid">
            <!-- Top Row -->
            <div class="d-flex flex-wrap justify-content-between align-items-center">
              <!-- Contact Info -->
              <div class="d-flex flex-column text-center text-md-start mb-2 mb-md-0">
                <span class="d-block"><i class="bi bi-envelope-open me-1"></i>shilo@shilonilestar.com</span>
                <span class="d-block"><i class="bi bi-envelope-open me-1"></i>P.O.Box 1838</span>
                <span class="d-block"><i class="bi bi-telephone-fill me-1"></i> 0394813636 / 0772423201</span>
              </div>
            </div>
            <!-- Links Row -->
            <div class="d-lg-flex justify-content-center mt-3">
              <ul class="list-inline mb-0 text-center text-lg-start">
                <li class="list-inline-item me-3"><a href="#" class="text-light text-decoration-none">Administration</a></li>
                <li class="list-inline-item me-3"><a href="#" class="text-light text-decoration-none">School Circular</a></li>
                <li class="list-inline-item me-3"><a href="#" class="text-light text-decoration-none">School Fees</a></li>
                <li class="list-inline-item me-3"><a href="applyonline.php" class="text-light text-decoration-none">Apply Online</a></li>
              </ul>
            </div>
             <!-- Social Media Icons -->
             <div class=" align-items-center mt-2 mt-md-0" style="color: white; font-size: 17px;">
                <a href="#" class="me-3"><i class="bi bi-envelope-check-fill" style="color: white;"></i></a>
                <a href="#" class="me-3"><i class="bi bi-facebook" style="color: white;"></i></a>
                <a href="#" class="me-3"><i class="bi bi-person-circle" style="color: white;"></i></a>
              </div>
          </div>
        </div>
      </section>
      
      <!-- Navbar -->
    <nav id="mainNavbar" class="navbar navbar-expand-lg navbar-light shadow ml-3 mr-3" style="position: fixed; top: 72px; width: 100%; z-index: 1050; background: white; transition: background-color 0.3s, box-shadow 0.3s;">
      <div class="container">
        <img src="assets/download (1).jpeg" alt="" style="height: 60px; width: 60px;">
        <a class="navbar-brand" href="#" style="font-weight: bold;">Shilo Nile Star <br>  Nursery & Primary School</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
          <ul class="navbar-nav ms-auto">
            <li class="nav-item">
              <a class="nav-link active" href="index.html">Home</a>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="aboutus.html" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                About Us
              </a>
              <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                <li><a class="dropdown-item" href="aboutus.html">Our School</a></li>
                <li><a class="dropdown-item" href="headteacher.html">Head Teacher's Message</a></li>
                <li><a class="dropdown-item" href="administration.html">Administration</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="headofdepartments.html">Head Of Departments</a></li>
                <li><a class="dropdown-item" href="teachers.html">Teachers</a></li>
                <li><a class="dropdown-item" href="schoolanthem.html">School Anthem</a></li>
              </ul>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="admissions.html" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Admissions
              </a>
              <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                <li><a class="dropdown-item" href="applyonline.html">Apply Online</a></li>
                <li><a class="dropdown-item" href="schoolfees.html">School Fees</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="schooluniform.html">School Uniform</a></li>
                <li><a class="dropdown-item" href="eventscalendar.html">Events Calender</a></li>
              </ul>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="academics.html" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Academics
              </a>
              <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                <li><a class="dropdown-item" href="nursery.html">Nursery</a></li>
                <li><a class="dropdown-item" href="primary.html">Primary</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="schoolcircular.html">School Circular</a></li>
                <li><a class="dropdown-item" href="#">Holiday Work</a></li>
              </ul>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="notices.html">Notices</a>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="academics.html" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Students
              </a>
              <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                <li><a class="dropdown-item" href="#">School Life</a></li>
                <li><a class="dropdown-item" href="#">Our Facilities</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="#">Photo Gallery</a></li>
                <li><a class="dropdown-item" href="#">Prefects</a></li>
              </ul>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="contacts.html">Contact Us</a>
              <li class="nav-item">
                    <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#loginModal">Admin Login</a>
                </li>
            </li>
          </ul>
          <a href="applyonline.php" class="btn btn-m m-2 ml-5 ms-3" style="background-color: orange; color: white;">Apply Now</a>
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


  <div class="whatsapp-icon">
    <!-------<a target="_blank" href="https://wa.me/256755087665"><i class="fa fa-whatsapp w3-hover-opacity"></i></a>---->
    <a href="https://wa.me/256755087665?text=Hello!" target="_blank" rel="noopener noreferrer">
        <img src="https://upload.wikimedia.org/wikipedia/commons/6/6b/WhatsApp.svg" alt="WhatsApp" />
    </a>
  </div>

  <!-- Back to Top Button -->
    <button id="backToTop" class="btn" style="color: orange;">
        <i class="bi bi-arrow-up-circle-fill"></i>
    </button>


  

  <section class="hero">
    <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <!-- First Slide -->
            <div class="carousel-item active" style="background-image: url('assets/wallpaper-8.jpg'); background-size: fill; height: 100vh;">
                <div class="carousel-caption" data-aos="flip-down" data-aos-delay="300" data-aos-duration="1000">
                    <h1>Welcome to Shilo Nile Star Nursery & Primary School</h1>
                    <p>Your journey to success starts here.</p>
                    <a href="admissions.html" class="btn  btn-lg mt-3 px-4 py-3" style="background-color: orange; color: #fff;">Apply Now</a>
                </div>
            </div>
            <!-- Second Slide -->
            <div class="carousel-item" style="background-image: url('assets/wallpaper-7.jpg'); background-size: fill; height: 100vh;">
                <div class="carousel-caption" data-aos="flip-down" data-aos-delay="300" data-aos-duration="1000">
                    <h1>Join Our Vibrant Learning Community</h1>
                    <p>Discover excellence in education and growth.</p>
                    <a href="admissions.html" class="btn btn-warning btn-lg mt-3 px-4 py-3" style="color: #fff;">Apply Now</a>
                </div>
            </div>
            <!-- Third Slide -->
            <div class="carousel-item" style="background-image: url('assets/wallpaper-6.jpg'); background-size: fill; height: 100vh;">
                <div class="carousel-caption" data-aos="flip-down" data-aos-delay="300" data-aos-duration="1000">
                    <h1>Explore a World of Opportunities</h1>
                    <p>Preparing students for the future, one step at a time.</p>
                    <a href="admissions.html" class="btn btn-warning btn-lg mt-3 px-4 py-3" style="color: #fff;">Apply Now</a>
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</section>




<section class="features py-5 bg-light" >
    <div class="container">
      <div class="row text-center mb-4">
        <h2 class=" fw-bold" style="color: orange;" data-aos="fade-down" data-aos-delay="200" data-aos-duration="1000">Our Guiding Principles</h2>
        <p style="color: green; font-weight: bold;" data-aos="fade-down" data-aos-delay="200" data-aos-duration="1000">Learn more about what drives and defines us.</p>
      </div>
      <div class="row text-center">
        <!-- School Mission -->
        <div class="col-md-4" data-aos="fade-right" data-aos-delay="200" data-aos-duration="1000">
          <div class="card border-0 shadow">
            <img src="assets/wallpaper-1.jpg" alt="School Mission" class="card-img-top rounded-circle p-3" style="width: 100px; height: 100px; margin: auto;">
            <div class="card-body">
              <h4 class="card-title fw-bold" style="color: orange;">SCHOOL MISSION</h4>
              <p class="card-text" style="color: green; font-weight: bold;">Our programs are designed to bring out the best in every student.</p>
            </div>
          </div>
        </div>
        <!-- School Vision -->
        <div class="col-md-4" data-aos="fade-right" data-aos-delay="200" data-aos-duration="1000">
          <div class="card border-0 shadow">
            <img src="assets/wallpaper-5.jpg" alt="School Vision" class="card-img-top rounded-circle p-3" style="width: 100px; height: 100px; margin: auto;">
            <div class="card-body">
              <h4 class="card-title fw-bold" style="color: orange;">SCHOOL VISION</h4>
              <p class="card-text" style="color: green; font-weight: bold;">State-of-the-art facilities for learning and extracurricular activities.</p>
            </div>
          </div>
        </div>
        <!-- Core Values -->
        <div class="col-md-4" data-aos="fade-right" data-aos-delay="200" data-aos-duration="1000">
          <div class="card border-0 shadow">
            <img src="assets/wallpaper-7.jpg" alt="Core Values" class="card-img-top rounded-circle p-3" style="width: 100px; height: 100px; margin: auto;">
            <div class="card-body">
                <h4 class="card-title fw-bold" style="color: orange;">OUR CORE VALUES</h4>
                <p class="card-text" style="color: green; font-weight: bold;">State-of-the-art facilities for learning and extracurricular activities.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
</section>



<section class="upcoming-events py-5 bg-light">
    <div class="container">
        <div class="row text-center mb-4" data-aos="fade-down-left" data-aos-delay="200" data-aos-duration="1000">
            <h2 class="fw-bold" style="color: orange;">Upcoming Events</h2>
            <p class="" style="color: green; font-weight: bold;">Don't miss out on our upcoming school activities and celebrations.</p>
        </div>
        <div class="row g-4">
            <!-- Event 1 -->
            <div class="col-md-4 text-center" data-aos="fade-left" data-aos-delay="200" data-aos-duration="1000">
                <div class="event-item">
                    <div class="event-image rotate" style="background-image: url('assets/wallpaper-3.jpg');"></div>
                    <h5 class="fw-bold mt-3" style="color: orange;">Sports Day</h5>
                    <p class="" style="color: green; font-weight: bold;">Join us for an exciting day of sports and fun. Bring your school spirit!</p>
                    <p class="text-muted" style="font-size: 20px;"><i class="bi bi-calendar-event" style="color: orange; font-size: 20px;"></i> January 15, 2024</p>
                    <p class="text-muted"><i class="bi bi-clock-fill" style="color: green;"></i> 9:00 AM - 4:00 PM</p>
                    <p class="text-muted"><i class="bi bi-geo-alt-fill" style="color: green;"></i> School Sports Ground</p>
                    <a href="#" class="btn btn-sm" style="background-color: orange; color: white; font-weight: bold;">Learn More</a>
                </div>
            </div>
            <!-- Event 2 -->
            <div class="col-md-4 text-center" data-aos="fade-left" data-aos-delay="200" data-aos-duration="1000">
                <div class="event-item">
                    <div class="event-image rotate" style="background-image: url('assets/download\ \(2\).jpeg');"></div>
                    <h5 class="fw-bold mt-3" style="color: orange;">Science Fair</h5>
                    <p class="" style="color: green; font-weight: bold;">Explore creativity and innovation at our annual Science Fair.</p>
                    <p class="text-muted" style="font-size: 20px;"><i class="bi bi-calendar-event" style="color: orange; font-size: 20px;"></i> February 10, 2024</p>
                    <p class="text-muted"><i class="bi bi-clock-fill" style="color: green;"></i> 9:00 AM - 4:00 PM</p>
                    <p class="text-muted"><i class="bi bi-geo-alt-fill" style="color: green;"></i> School Sports Ground</p>
                    <a href="#" class="btn btn-sm" style="background-color: orange; color: white; font-weight: bold;">Learn More</a>
                </div>
            </div>
            <!-- Event 3 -->
            <div class="col-md-4 text-center" data-aos="fade-left" data-aos-delay="200" data-aos-duration="1000">
                <div class="event-item">
                    <div class="event-image rotate" style="background-image: url('assets/images\ \(2\).jpeg');"></div>
                    <h5 class="fw-bold mt-3" style="color: orange;">Cultural Festival</h5>
                    <p class="" style="color: green; font-weight: bold;">Experience diverse cultures through music, food, and performances.</p>
                    <p class="text-muted" style="font-size: 20px;"><i class="bi bi-calendar-event" style="color: orange; font-size: 20px;"></i> March 5, 2024</p>
                    <p class="text-muted"><i class="bi bi-clock-fill" style="color: green;"></i> 9:00 AM - 4:00 PM</p>
                    <p class="text-muted"><i class="bi bi-geo-alt-fill" style="color: green;"></i> School Sports Ground</p>
                    <a href="#" class="btn btn-sm" style="background-color: orange; color: white; font-weight: bold;">Learn More</a>
                </div>
            </div>
            <!-- Event 3 -->
            <div class="col-md-4 text-center" data-aos="fade-left" data-aos-delay="200" data-aos-duration="1000">
                <div class="event-item">
                    <div class="event-image rotate" style="background-image: url('assets/images\ \(2\).jpeg');"></div>
                    <h5 class="fw-bold mt-3" style="color: orange;">Cultural Festival</h5>
                    <p class="" style="color: green; font-weight: bold;">Experience diverse cultures through music, food, and performances.</p>
                    <p class="text-muted" style="font-size: 20px;"><i class="bi bi-calendar-event" style="color: orange; font-size: 20px;"></i> March 5, 2024</p>
                    <p class="text-muted"><i class="bi bi-clock-fill" style="color: green;"></i> 9:00 AM - 4:00 PM</p>
                    <p class="text-muted"><i class="bi bi-geo-alt-fill" style="color: green;"></i> School Sports Ground</p>
                    <a href="#" class="btn btn-sm" style="background-color: orange; color: white; font-weight: bold;">Learn More</a>
                </div>
            </div>
            <!-- Event 3 -->
            <div class="col-md-4 text-center" data-aos="fade-left" data-aos-delay="200" data-aos-duration="1000">
                <div class="event-item">
                    <div class="event-image rotate" style="background-image: url('assets/images\ \(2\).jpeg');"></div>
                    <h5 class="fw-bold mt-3" style="color: orange;">Cultural Festival</h5>
                    <p class="" style="color: green; font-weight: bold;">Experience diverse cultures through music, food, and performances.</p>
                    <p class="text-muted" style="font-size: 20px;"><i class="bi bi-calendar-event" style="color: orange; font-size: 20px;"></i> March 5, 2024</p>
                    <p class="text-muted"><i class="bi bi-clock-fill" style="color: green;"></i> 9:00 AM - 4:00 PM</p>
                    <p class="text-muted"><i class="bi bi-geo-alt-fill" style="color: green;"></i> School Sports Ground</p>
                    <a href="#" class="btn btn-sm" style="background-color: orange; color: white; font-weight: bold;">Learn More</a>
                </div>
            </div>
            <!-- Event 3 -->
            <div class="col-md-4 text-center" data-aos="fade-left" data-aos-delay="200" data-aos-duration="1000">
                <div class="event-item">
                    <div class="event-image rotate" style="background-image: url('assets/images\ \(2\).jpeg');"></div>
                    <h5 class="fw-bold mt-3" style="color: orange;">Cultural Festival</h5>
                    <p class="" style="color: green; font-weight: bold;">Experience diverse cultures through music, food, and performances.</p>
                    <p class="text-muted" style="font-size: 20px;"><i class="bi bi-calendar-event" style="color: orange; font-size: 20px;"></i> March 5, 2024</p>
                    <p class="text-muted"><i class="bi bi-clock-fill" style="color: green;"></i> 9:00 AM - 4:00 PM</p>
                    <p class="text-muted"><i class="bi bi-geo-alt-fill" style="color: green;"></i> School Sports Ground</p>
                    <a href="#" class="btn btn-sm" style="background-color: orange; color: white; font-weight: bold;">Learn More</a>
                </div>
            </div>
        </div>
    </div>
</section>
  



<style>
    .background-overlay {
    background: url('assets/wallpaper-9.png') no-repeat center center / cover; /* Background image */
    position: relative;
    padding: 80px 0;
    }

    .background-overlay::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(to right, rgba(10, 202, 10, 0.6), rgb(4, 27, 4)); /* Gradient overlay */
        z-index: 1;
        pointer-events: none; /* Ensures the overlay doesn't block interaction with elements inside */
    }

    .content {
        position: relative;
        z-index: 2;
        color: #fff;
        text-align: center;
    }
    .section-header {
        font-size: 2rem;
        margin-bottom: 20px;
    }
    .navbar-links {
        cursor: pointer;
        font-weight: bold;
    }
    .info-section {
        margin-top: 30px;
    }
    .img-left {
        object-fit: cover;
        width: 100%;
        height: 100%;
    }
</style>
 <!-- Hero Section with Image and Text -->
 <div class="background-overlay">
    <div class="container text-center content">
        <div class="row">
            <!-- Image Section (Left) -->
            <div class="col-md-4" data-aos="flip-left"data-aos-easing="ease-out-cubic" data-aos-duration="2000">
                <img src="assets/download (1).jpeg" alt="Best Student" class="img-fluid rounded-start h-100 img-left zoom-in">
            </div>
            <!-- Text Section (Right) -->
            <div class="col-md-8" data-aos="flip-right" data-aos-delay="200" data-aos-duration="1000">
                <h1 class="display-4">Best Student of the Year</h1>
                <p class="lead">Congratulations to Jane Doe for her outstanding academic performance and exemplary leadership.</p>
            </div>
        </div>
    </div>
</div>

<section class="upcoming-events py-5 bg-light">
    <div class="container">
        <div class="row g-4">
            <!-- Event 1 -->
            <div class="col-md-4 text-center" data-aos="fade-left" data-aos-delay="200" data-aos-duration="1000">
                <div class="event-item">
                    <div class="event-image zoom-in" style="background-image: url('assets/wallpaper-5.jpg');"></div>
                    <h5 class="fw-bold mt-3" style="color: orange;">Our Staff</h5>
                    <p class="" style="color: green; font-weight: bold;">Our dedicated staff are committed to providing an exceptional learning environment.</p>
                    <a href="#" class="btn btn-sm" style="background-color: orange; color: white; font-weight: bold;">Learn More</a>
                </div>
            </div>
            <!-- Event 2 -->
            <div class="col-md-4 text-center" data-aos="fade-left" data-aos-delay="200" data-aos-duration="1000">
                <div class="event-item">
                    <div class="event-image zoom-in" style="background-image: url('assets/wallpaper-7.jpg');"></div>
                    <h5 class="fw-bold mt-3" style="color: orange;">Spirituality</h5>
                    <p class="" style="color: green; font-weight: bold;">We foster spiritual growth and moral values to build a wholesome community.</p>
                    <a href="#" class="btn btn-sm" style="background-color: orange; color: white; font-weight: bold;">Learn More</a>
                </div>
            </div>
            <!-- Event 3 -->
            <div class="col-md-4 text-center" data-aos="fade-left" data-aos-delay="200" data-aos-duration="1000">
                <div class="event-item">
                    <div class="event-image zoom-in" style="background-image: url('assets/images\ \(2\).jpeg');"></div>
                    <h5 class="fw-bold mt-3" style="color: orange;">Security</h5>
                    <p class="" style="color: green; font-weight: bold;">Our school maintains a secure and safe environment for all students.</p>
                    <a href="#" class="btn btn-sm" style="background-color: orange; color: white; font-weight: bold;">Learn More</a>
                </div>
            </div>
            <!-- Event 3 -->
            <div class="col-md-4 text-center" data-aos="fade-left" data-aos-delay="200" data-aos-duration="1000">
                <div class="event-item">
                    <div class="event-image zoom-in" style="background-image: url('assets/images\ \(2\).jpeg');"></div>
                    <h5 class="fw-bold mt-3" style="color: orange;">Discipline</h5>
                    <p class="" style="color: green; font-weight: bold;">Discipline is the cornerstone of our success, encouraging responsibility and focus.</p>
                    <a href="#" class="btn btn-sm" style="background-color: orange; color: white; font-weight: bold;">Learn More</a>
                </div>
            </div>
            <!-- Event 3 -->
            <div class="col-md-4 text-center" data-aos="fade-left" data-aos-delay="200" data-aos-duration="1000">
                <div class="event-item">
                    <div class="event-image zoom-in" style="background-image: url('assets/images\ \(2\).jpeg');"></div>
                    <h5 class="fw-bold mt-3" style="color: orange;">Meals</h5>
                    <p class="" style="color: green; font-weight: bold;">Nutritious and balanced meals are provided daily to support student health.</p>
                    <a href="#" class="btn btn-sm" style="background-color: orange; color: white; font-weight: bold;">Learn More</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Video Tour Section -->
<div class="container video-section my-5">
    <div class="row justify-content-center">
        <div class="col-md-8" data-aos="zoom-in-up" data-aos-delay="200" data-aos-duration="1000">
            <!-- Card for Video Embed -->
            <div class="card shadow-lg">
                <div class="card-body">
                    <h5 class="card-title" style="color: orange; font-weight: bold; font-size: 30px;">School Video Tour</h5>
                    <!-- Video Embed -->
                    <div class="video-container">
                        <video controls>
                            <source src="assets/business.mp4" type="video/mp4" >
                            Your browser does not support the video tag.
                        </video>
                        <!-- Play Button Icon -->
                        <i class="bi bi-camera-video-fill"></i>
                    </div>
                    <!-- Caption for the video -->
                    <p class="caption" style="color: green;">
                        Take a tour of our school and explore the various facilities that make us one of the best in education!
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>



<div class="container news-section align-items-center">
    <h2 class="text-center mb-4" style="color: orange; font-weight: bold;" data-aos="fade-down" data-aos-delay="200" data-aos-duration="1000">School News & Updates</h2>

    <div class="row">
        <!-- News Item 1 -->
        <div class="col-md-8" data-aos="fade-right" data-aos-delay="200" data-aos-duration="1000">
            <div class="news-item row align-items-center">
                <!-- Image Section -->
                <div class="col-md-4">
                    <img src="assets/download (1).jpeg" alt="News 1" class="news-image img-fluid zoom-in" style="height: 150px; width: 250px; object-fit: cover;">
                </div>
                <!-- Description Section -->
                <div class="col-md-8">
                    <h3 class="news-title">New Library Opening</h3>
                    <p class="news-date">November 25, 2024</p>
                    <p class="news-description">
                        We’re excited to announce the grand opening of our new library this Friday. Come visit and explore the new collection of books, resources, and study areas. The opening ceremony will take place at 10:00 AM.
                    </p>
                    <a href="#" class="btn-more">Read More</a>
                </div>
            </div>
        </div>

        <!-- News Item 2 -->
        <div class="col-md-8" data-aos="fade-right" data-aos-delay="200" data-aos-duration="1000">
            <div class="news-item row align-items-center">
                <!-- Image Section -->
                <div class="col-md-4">
                    <img src="assets/wallpaper-3.jpg" alt="News 2" class="news-image img-fluid zoom-in" style="object-fit: cover; height: 150px; width: 250px;">
                </div>
                <!-- Description Section -->
                <div class="col-md-8">
                    <h3 class="news-title">Sports Day Results</h3>
                    <p class="news-date">November 24, 2024</p>
                    <p class="news-description">
                        Congratulations to all participants in this year's Sports Day event! Click here to see the results and highlights of the day’s events, including the winning teams and individual champions.
                    </p>
                    <a href="#" class="btn-more">Read More</a>
                </div>
            </div>
        </div>

        <!-- News Item 3 -->
        <div class="col-md-8" data-aos="fade-right" data-aos-delay="200" data-aos-duration="1000">
            <div class="news-item row align-items-center">
                <!-- Image Section -->
                <div class="col-md-4">
                    <img src="assets/images (2).jpeg" alt="News 3" class="news-image img-fluid zoom-in" style="object-fit: cover; height: 150px; width: 250px;">
                </div>
                <!-- Description Section -->
                <div class="col-md-8">
                    <h3 class="news-title">Upcoming Parent-Teacher Meeting</h3>
                    <p class="news-date">November 23, 2024</p>
                    <p class="news-description">
                        The annual Parent-Teacher Meeting is scheduled for December 2nd. Join us to discuss your child’s progress and future goals. All parents are invited to attend and meet the faculty members.
                    </p>
                    <a href="#" class="btn-more">Read More</a>
                </div>
            </div>
        </div>
    </div>
</div>



<!-- Hero Section with Image and Text -->
<div style=" padding: 90px; background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.9)), url(assets/download\ \(1\).jpeg) no-repeat center center / cover;">
    <div class="container text-center content" data-aos="zoom-out-up" data-aos-delay="200" data-aos-duration="1000">
        <div class="row">
            <!-- Text Section (Right) -->
            <div>
                <h1 class="display-4">Apply For Admission</h1>
                <h2 style="font-size: 20px;">Fall 2024 applications are now open</h2>
                <p class="lead">Welcome to the Shilo Nile Star Nursery & Primary School Admissions Office. Shilo Nile Star Nursery & Primary School accepts students from various corners of the world. The environment is of international standard, catering to the students’ different educational and cultural backgrounds. We offer all subjects that lead to the attainment of the Primary Leaving Exams (PLE)</p>
                <br>
                <a href="admissions.html" class="btn  btn-lg mt-3 px-4 py-3" style="background-color: orange; color: #fff;">Apply Now</a>
            </div>
        </div>
    </div>
</div>


<!-- Location Section -->
<section class="location-section" style="color: orange; font-weight: bold;">
    <h2 style="color: orange; font-weight: bold;">Our School Location</h2>

    <!-- Map Container -->
    <div class="map-container">
        <!-- Google Map iframe -->
        <iframe src="https://www.google.com/maps/dir//C5WF%2BXFW,+Njeru/@0.4826268,33.2264769,14z/data=!3m1!4b1!4m8!4m7!1m0!1m5!1m1!1s0x177e7c1b61918141:0x1d07e2d6a1378665!2m2!1d33.1736955!2d0.4474808?entry=ttu&g_ep=EgoyMDI0MTEyNC4xIKXMDSoASAFQAw%3D%3D" 
                allowfullscreen="" loading="lazy"></iframe>
    </div>

    <!-- Directions Button -->
    <a href="https://www.google.com/maps/dir//C5WF%2BXFW,+Njeru/@0.4826268,33.2264769,14z/data=!3m1!4b1!4m8!4m7!1m0!1m5!1m1!1s0x177e7c1b61918141:0x1d07e2d6a1378665!2m2!1d33.1736955!2d0.4474808?entry=ttu&g_ep=EgoyMDI0MTEyNC4xIKXMDSoASAFQAw%3D%3D" 
       class="get-directions-btn" target="_blank">
        Get Directions
    </a>
</section>


<!-- Footer Section -->
<footer class="text-white py-5" style="background: linear-gradient(rgba(0, 0, 0, 0.8), rgba(0, 0, 0, 0.8)), url(assets/wallpaper-1.jpg) no-repeat center center / cover;">
    <div class="container" style="line-height: 30px;">
        <div class="row align-items-center" >
            <!-- Location Details Column -->
             <img src="assets/download (1).jpeg" alt="" style="height: 150px; width: 250px;" class="zoom-in ">
            <div class="col-md-3 text-center">
                <h5 style="font-weight: bold;">Location</h5>
                <p class="text-white" style="font-size: 15px;">123 School Avenue, Education City, Country</p>
                <p class="text-white" style="font-size: 15px;">Phone: 0394813636 / 0772423201</p>
                <p class="text-white" style="font-size: 15px;">Email: shilo@shilonilestar.com</p>
                <ul class="list-inline" style="font-size: 70px;">
                    <li class="list-inline-item">
                        <a href="#" class="text-white social-icon" style="font-size: 15px;">
                            <i class="bi bi-facebook" style="color: white; font-size: 24px;"></i>
                        </a>
                    </li>
                    <li class="list-inline-item">
                        <a href="#" class="text-white social-icon" style="font-size: 15px;">
                            <i class="bi bi-twitter-x" style="color: white; font-size: 24px;"></i>
                        </a>
                    </li>
                    <li class="list-inline-item">
                        <a href="#" class="text-white social-icon" style="font-size: 15px;">
                            <i class="bi bi-instagram" style="color: white; font-size: 24px;"></i>
                        </a>
                    </li class="list-inline-item">
                    <a href="#" class="text-white social-icon" style="font-size: 15px;"><i class="bi bi-envelope-check-fill" style="color: white; font-size: 24px;""></i></a>
                </ul>
            </div>
            <!-- Useful Links Column -->
            <div class="col-md-3 border-start text-center">
                <h5 style="font-weight: bold;">Useful Links</h5>
                <ul class="list-unstyled" style="font-size: 70px;">
                    <li><a href="#" class="text-white"style="font-size: 15px;">Apply Online</a></li>
                    <li><a href="#" class="text-white"style="font-size: 15px;">School Fees</a></li>
                    <li><a href="#" class="text-white"style="font-size: 15px;">School Uniform</a></li>
                    <li><a href="#" class="text-white"style="font-size: 15px;">News And Updates</a></li>
                    <li><a href="#" class="text-white"style="font-size: 15px;">Events Calender</a></li>
                </ul>
            </div>

            <!-- Academics Information Column -->
            <div class="col-md-3 border-start text-center">
                <h5 style="font-weight: bold;">Academics</h5>
                <ul class="list-unstyled" style="font-size: 70px;">
                    <li><a href="#" class="text-white"style="font-size: 15px;">Nursery</a></li>
                    <li><a href="#" class="text-white"style="font-size: 15px;">Primary</a></li>
                    <li><a href="#" class="text-white"style="font-size: 15px;">School Circular</a></li>
                    <li><a href="#" class="text-white"style="font-size: 15px;">Hoilday Work</a></li>
                    <li><a href="#" class="text-white"style="font-size: 15px;">Alumni</a></li>
                    <li><a href="#" class="text-white"style="font-size: 15px;">Administration</a></li>
                </ul>
            </div>
        </div>
    </div>
</footer>
<div class="text-center" style="background-color: orange; padding: 15px; font-weight: bold; color: white;">
    <p>&copy; 2024 Lakeside School. All rights reserved.</p>
</div>
  
  <!-- Footer -->
  <footer class="bg-dark text-white text-center py-3">
    
  </footer>
  <script src="main.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  <script src="https://kit.fontawesome.com/a076d05399.js"></script>
  <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
  <script>
    AOS.init();
  </script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg==" crossorigin="anonymous"></script>
</body>
</html>

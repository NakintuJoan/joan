<?php
// Include database connection
include_once 'admin/db_connect.php';

// Variable to hold success or error messages
$message = "";

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize and get form data
    $applicantName = htmlspecialchars($_POST['applicantName']);
    $dob = htmlspecialchars($_POST['dob']);
    $gender = htmlspecialchars($_POST['gender']);
    $dayBoarding = htmlspecialchars($_POST['dayBoarding']);
    $religion = htmlspecialchars($_POST['religion']);
    $formerSchool = htmlspecialchars($_POST['formerSchool']);
    $nationality = htmlspecialchars($_POST['nationality']);
    $passportNumber = htmlspecialchars($_POST['passportNumber']);
    $intendedClass = htmlspecialchars($_POST['intendedClass']);
    $fatherName = htmlspecialchars($_POST['fatherName']);
    $fatherNIN = htmlspecialchars($_POST['fatherNIN']);
    $fatherContact = htmlspecialchars($_POST['fatherContact']);
    $fatherEmail = htmlspecialchars($_POST['fatherEmail']);
    $motherName = htmlspecialchars($_POST['motherName']);
    $motherContact = htmlspecialchars($_POST['motherContact']);
    $motherEmail = htmlspecialchars($_POST['motherEmail']);
    $additionalInfo = htmlspecialchars($_POST['additionalInfo']);

    // Handle file upload
    $medicalReport = $_FILES['medicalReport'];
    $targetDir = "uploads/";

    // Ensure the uploads directory exists
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0777, true); // Create directory if not exists
    }

    // Generate the file path
    $medicalReportPath = $targetDir . basename($medicalReport["name"]);

    // Check if file was uploaded and move it
    if (move_uploaded_file($medicalReport["tmp_name"], $medicalReportPath)) {
        $fileUploaded = true;
    } else {
        $fileUploaded = false;
        $medicalReportPath = null; // Reset path if file upload fails
        $message = "<p style='color: red;'>Error uploading the medical report. Please try again.</p>";
    }

    // Insert data into database if no upload error
    if ($fileUploaded || !$medicalReport["name"]) { // Check if file uploaded or no file provided
        $stmt = $conn->prepare("INSERT INTO admissions (applicant_name, dob, gender, day_boarding, religion, former_school, nationality, passport_number, intended_class, father_name, father_nin, father_contact, father_email, mother_name, mother_contact, mother_email, medical_report_path, additional_info) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssssssssssssss", $applicantName, $dob, $gender, $dayBoarding, $religion, $formerSchool, $nationality, $passportNumber, $intendedClass, $fatherName, $fatherNIN, $fatherContact, $fatherEmail, $motherName, $motherContact, $motherEmail, $medicalReportPath, $additionalInfo);

        if ($stmt->execute()) {
            $message = "<p style='color: green;'>Application submitted successfully!</p>";
        } else {
            $message = "<p style='color: red;'>Database error: " . htmlspecialchars($stmt->error) . "</p>";
        }

        $stmt->close();
    }
}

$conn->close();
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
          /* Section Header with Background Image */
        .section-header {
            background: url('assets/wallpaper-1.jpg') no-repeat center center / cover;
            padding: 150px 0;
            position: relative;
            margin-bottom: 20px;
        }

        .section-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.7); /* Overlay with 50% opacity */
            z-index: 1;
        }

        .section-title {
            text-align: center;
            font-weight: bold;
            font-size: 45px;
            margin-top: 50px;
            margin-bottom: 30px;
            color: white;
            z-index: 2; /* Ensure text is above overlay */
            position: relative;
        }

        /* Two-column layout */
        .row {
            display: flex;
            flex-wrap: wrap;
            margin-bottom: 40px;
        }

        .col-md-6 {
            flex: 0 0 50%;
            padding: 20px;
        }

        h3 {
            font-size: 24px;
            margin-bottom: 15px;
            color: #2c3e50;
        }


        /* Responsive Design for smaller screens */
        @media (max-width: 768px) {
            .col-md-6 {
                flex: 0 0 100%;
                margin-bottom: 20px;
            }
            .section-title {
                font-size: 28px;
            }
            .section-title {
            text-align: center;
            font-weight: bold;
            font-size: 45px;
            margin-top: 150px;
            margin-bottom: 3px;
            color: white;
            z-index: 2; /* Ensure text is above overlay */
            position: relative;
        }
        }
        .background-overlay {
          background: url('assets/wallpaper-7.jpg') no-repeat center center / cover;
          position: relative;
        }
        .background-overlay::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 128, 0, 0.7); /* Green overlay */
            z-index: 1;
        }
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
             

    </style>
    <style>

        .form-container {
            max-width: 700px;
            margin: 30px auto;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3);
        }

        .form-container h1 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
            color: green;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
        }
        .form-group input:hover,
        .form-group select:hover,
        .form-group textarea:hover {
            width: 100%;
            padding: 10px;
            border: 2px solid orange;
            border-radius: 5px;
            font-size: 14px;
        }

        .form-group input[type="file"] {
            padding: 3px;
        }

        .form-group button {
            background-color: orange;
            color: #fff;
            padding: 10px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            width: 100%;
        }

        .form-group button:hover {
            background-color: green;
            transition: 1s ease-in-out;
        }

        .note {
            font-size: 12px;
            color: green;
            margin-top: 15px;
        }

        .form-control:hover {
            border-color:orange; /* Blue border on hover */
            box-shadow: 0 0 5px rgba(255, 165, 0, 0.3); /* Subtle shadow effect */
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
            <li class="list-inline-item me-3"><a href="#" class="text-light text-decoration-none">Apply Online</a></li>
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
    <a class="navbar-brand" href="#" style="font-weight: bold;">Shilo Nile Star <br> Nursery & Primary School</a>
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
          <a class="nav-link dropdown-toggle" href="admissions.html" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
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
          <a class="nav-link dropdown-toggle" href="academics.html" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
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
          <a class="nav-link dropdown-toggle" href="academics.html" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
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
        </li>
      </ul>
      <a href="applyonline.html" class="btn btn-m m-2 ml-5 ms-3" style="background-color: orange; color: white;">Apply Now</a>
    </div>
  </div>
</nav>
  <div class="whatsapp-icon">
    <a href="https://wa.me/256755087665?text=Hello!" target="_blank" rel="noopener noreferrer">
        <img src="https://upload.wikimedia.org/wikipedia/commons/6/6b/WhatsApp.svg" alt="WhatsApp" />
    </a>
  </div>

  <section id="aboutUs" class="about-us">
    <div class="container-fluid">
      <div class="section-header">
        <h2 class="section-title" data-aos="flip-down" data-aos-delay="300" data-aos-duration="1000">Apply Online</h2>
      </div>
      <div class="row align-items-center" data-aos="fade-right" data-aos-delay="200" data-aos-duration="1000">
        <div class=" col-12 col-md-6 align-items-center">
          <p style="line-height: 1.7; color: green;">Welcome to the online admission form! This form is to be filled in by all applicants wishing to join Lakeside College Luzira! Applicants wishing to join S.I should attach the P.7 pass-slip or Testimonial (in case pass-slip is not available). Likewise applicants wishing to join S.5 should attach the S.4 pass-slip or Testimonial (in case pass-slip is not available).</p>
        </div>
        <div class=" col-12 col-md-6 align-items-center">
          <p style="line-height: 1.7;color: green;">For any other applicants who wish to join the school for either S.2, S.3, S.4 or S.6 should attach their most recent school report from their former school. For successful submission of the form you are advised to fill in all relevant information before submitting it. Please make sure you provide valid contact information to enable us contact you back!</p>
        </div>
      </div>
      <div class="form-container" data-aos="zoom-in" data-aos-delay="200" data-aos-duration="1000">
        
    <h1 style="color: orange; font-weight: bold;">School Admission Form</h1>
    <?php echo $message; ?>
        
    <form action="applyonline.php" method="post" enctype="multipart/form-data">
        <!-- Applicant's Information -->
        <div class="form-group">
            <label for="applicantName">Applicant's Names</label>
            <input type="text" id="applicantName" name="applicantName" placeholder="Enter full name" required>
        </div>

        <div class="form-group">
            <label for="dob">Date of Birth</label>
            <input type="date" id="dob" name="dob" required>
        </div>

        <div class="form-group">
            <label for="gender">Gender</label>
            <select class="form-control"  id="gender" name="gender" required>
                <option value="" disabled selected>Select Gender</option>
                <option value="male">Male</option>
                <option value="female">Female</option>
                <option value="other">Other</option>
            </select>
        </div>

        <div class="form-group">
            <label for="dayBoarding">Day/Boarding</label>
            <select id="dayBoarding" name="dayBoarding" required>
                <option value="" disabled selected>Select Option</option>
                <option value="day">Day</option>
                <option value="boarding">Boarding</option>
            </select>
        </div>

        <div class="form-group">
            <label for="religion">Religion</label>
            <input type="text" id="religion" name="religion" placeholder="Enter religion" required>
        </div>

        <div class="form-group">
            <label for="formerSchool">Former School</label>
            <input type="text" id="formerSchool" name="formerSchool" placeholder="Enter former school">
        </div>

        <div class="form-group">
            <label for="nationality">Nationality</label>
            <select id="nationality" name="nationality" required>
                <option value="" disabled selected>Select Nationality</option>
                <option value="ugandan">Ugandan</option>
                <option value="kenyan">Kenyan</option>
                <option value="tanzanian">Tanzanian</option>
                <option value="rwandan">Rwandan</option>
                <option value="non-african">Other</option>
            </select>
        </div>

        <div class="form-group">
            <label for="passportNumber">D/Passport Nr. (if non-Ugandan)</label>
            <input type="text" id="passportNumber" name="passportNumber" placeholder="Enter passport number">
        </div>

        <div class="form-group">
            <label for="intendedClass">Intended Class to Join</label>
            <input type="text" id="intendedClass" name="intendedClass" placeholder="Enter class name" required>
        </div>

        <!-- Guardian Information -->
        <h3>Guardian Information</h3>
        <div class="form-group">
            <label for="fatherName">Father's/Guardian's Name</label>
            <input type="text" id="fatherName" name="fatherName" placeholder="Enter name" required>
        </div>

        <div class="form-group">
            <label for="fatherNIN">National ID Number (NIN)</label>
            <input type="text" id="fatherNIN" name="fatherNIN" placeholder="Enter NIN" required>
        </div>

        <div class="form-group">
            <label for="fatherContact">Contact Number</label>
            <input type="tel" id="fatherContact" name="fatherContact" placeholder="Enter contact number" required>
        </div>

        <div class="form-group">
            <label for="fatherEmail">E-mail (if available)</label>
            <input type="email" id="fatherEmail" name="fatherEmail" placeholder="Enter email address">
        </div>

        <div class="form-group">
            <label for="motherName">Mother's/Guardian's Name</label>
            <input type="text" id="motherName" name="motherName" placeholder="Enter name">
        </div>

        <div class="form-group">
            <label for="motherContact">Contact Number</label>
            <input type="tel" id="motherContact" name="motherContact" placeholder="Enter contact number">
        </div>

        <div class="form-group">
            <label for="motherEmail">E-mail (if available)</label>
            <input type="email" id="motherEmail" name="motherEmail" placeholder="Enter email address">
        </div>

        <!-- Additional Information -->
        <div class="form-group">
            <label for="medicalReport">Attach General Medical Report</label>
            <input type="file" id="medicalReport" name="medicalReport" accept=".pdf,.doc,.docx,.jpg,.png" required>
        </div>

        <div class="form-group">
            <label for="additionalInfo">Any Other Information (If any)</label>
            <textarea id="additionalInfo" name="additionalInfo" rows="4" placeholder="Enter any additional information"></textarea>
        </div>

        <!-- Submit Button -->
        <div class="form-group">
            <button type="submit">Submit Application</button>
        </div>
    </form>
</div>


    </div>
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
  <script src="https://cdnjs.cloudflare.com/
  
    
</body>
</html>
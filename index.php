<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>CSPrep</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Nunito:wght@600;700;800&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
</head>

<body>
    <!-- Spinner Start -->
    <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <img src="img/CSPREP-removebg-preview.png" alt="Loading..." class="custom-spinner">
    </div>
    <!-- Spinner End -->

    <!-- Navbar Start -->
    <nav class="navbar navbar-expand-lg bg-white navbar-light shadow sticky-top p-0">
        <a href="index.php" class="navbar-brand d-flex align-items-center px-4 px-lg-5">
            <h2 class="m-0 text-dark"><img src="img/CSPREP.png" height="75px">CSPrep</h2>
        </a>
        <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav ms-auto p-4 p-lg-0">
                <a href="index.php" class="nav-item nav-link active">Home</a>
                <a href="quiz.php" class="nav-item nav-link">Quiz</a>
                <a href="roadmaps/roadmap.html" class="nav-item nav-link">ROADMAP</a>
                <a href="resources.php" class="nav-item nav-link">Resources</a>
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Miscellaneous</a>
                    <div class="dropdown-menu fade-down m-0">
                        <a href="videos.php" class="dropdown-item">Videos</a>
                        <a href="blogs.php" class="dropdown-item">Blogs</a>
                        <a href="Resume/resume.html" class="dropdown-item">Resume Builder</a>
                    </div>
                </div>
                <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
                    <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                        <a href="admin_dashboard.php" class="nav-item nav-link">Admin Dashboard</a>
                    <?php else: ?>
                        <a href="user_dashboard.php" class="nav-item nav-link">Dashboard</a>
                    <?php endif; ?>
                    <a href="logout.php" class="nav-item nav-link">Logout (<?php echo htmlspecialchars($_SESSION['name']); ?>)</a>
                <?php else: ?>
                    <a href="#" class="nav-item nav-link" data-bs-toggle="modal" data-bs-target="#loginModal">Login</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>
    <!-- Navbar End -->

    <!-- Carousel Start -->
    <div class="container-fluid p-0 mb-5">
        <div class="owl-carousel header-carousel position-relative">
            <div class="owl-carousel-item position-relative">
                <img class="img-fluid" src="img/A6403876.JPG" alt="">
                <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center" style="background: rgba(24, 29, 56, .7);">
                    <div class="container">
                        <div class="row justify-content-start">
                            <div class="col-sm-10 col-lg-8">
                                <h5 class="text-primary text-uppercase mb-3 animated slideInDown">CSPrep</h5>
                                <h1 class="display-3 text-white animated slideInDown">The Best Online Learning Platform</h1>
                                <p class="fs-5 text-white mb-4 pb-2">A website designed for students to prepare for their placements and higher studies.</p>
                                <a href="" class="btn btn-primary py-md-3 px-md-5 me-3 animated slideInLeft">Read More</a>
                                <a href="" class="btn btn-light py-md-3 px-md-5 animated slideInRight">Explore</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="owl-carousel-item position-relative">
                <img class="img-fluid" src="img/_DSC7107.JPG" alt="">
                <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center" style="background: rgba(24, 29, 56, .7);">
                    <div class="container">
                        <div class="row justify-content-start">
                            <div class="col-sm-10 col-lg-8">
                                <h5 class="text-primary text-uppercase mb-3 animated slideInDown">CSPrep</h5>
                                <h1 class="display-3 text-white animated slideInDown">Prepare with absolute best of the resources.</h1>
                                <p class="fs-5 text-white mb-4 pb-2">CSPrep will help you to get your desired job with the best of the resources and to help you grow individually.</p>
                                <a href="" class="btn btn-primary py-md-3 px-md-5 me-3 animated slideInLeft">Read More</a>
                                <a href="" class="btn btn-light py-md-3 px-md-5 animated slideInRight">Explore</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Carousel End -->

    <!-- About Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s" style="min-height: 400px;">
                    <div class="position-relative h-100">
                        <img class="img-fluid position-absolute w-100 h-100" src="img/CSPREP.png" alt="" style="object-fit: cover;">
                    </div>
                </div>
                <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.3s">
                    <h6 class="section-title bg-white text-start text-primary pe-3">About Us</h6>
                    <h1 class="mb-4">Welcome to CSPrep</h1>
                    <p class="mb-4">This website is your all-in-one online learning platform, designed to help computer science students level up their skills and ace their career goals. Whether you're aiming for your dream job or gearing up for higher studies, CSPrep offers curated resources, hands-on quizzes, and real-world practice sessions to make you stand out. Learn smart, practice hard, and succeed with CSPrep.</p>
                    <p class="mb-4">The website contains various aspects of features to help out an individual.The website offers: </p>
                    <div class="row gy-2 gx-4 mb-4">
                        <div class="col-sm-6">
                            <p class="mb-0"><i class="fa fa-arrow-right text-primary me-2"></i>Study Materials</p>
                        </div>
                        <div class="col-sm-6">
                            <p class="mb-0"><i class="fa fa-arrow-right text-primary me-2"></i>Aptitude Quiz</p>
                        </div>
                        <div class="col-sm-6">
                            <p class="mb-0"><i class="fa fa-arrow-right text-primary me-2"></i>Coding Practice</p>
                        </div>
                        <div class="col-sm-6">
                            <p class="mb-0"><i class="fa fa-arrow-right text-primary me-2"></i>Alumni Stories</p>
                        </div>
                        <div class="col-sm-6">
                            <p class="mb-0"><i class="fa fa-arrow-right text-primary me-2"></i>Useful Tools</p>
                        </div>
                        <div class="col-sm-6">
                            <p class="mb-0"><i class="fa fa-arrow-right text-primary me-2"></i>AI Resume Builder</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- About End -->

    <!-- Features -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                <h6 class="section-title bg-white text-center text-primary px-3">Features</h6>
                <h1 class="mb-5">What We Provide</h1>
            </div>
            <div class="row g-4">
                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="team-item bg-light">
                        <div class="overflow-hidden">
                            <img class="img-fluid" src="img/quiz.png" alt="">
                        </div>
                        <div class="position-relative d-flex justify-content-center">
                            <div class="bg-light d-flex justify-content-center pt-2 px-1">
                            </div>
                        </div>
                        <div class="text-center p-4">
                            <h5 class="mb-0">Quiz</h5>
                            <small>Practice your aptitude skills with our quizzes.</small>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="team-item bg-light">
                        <div class="overflow-hidden">
                            <img class="img-fluid" src="img/web-development.png" alt="">
                        </div>
                        <div class="position-relative d-flex justify-content-center" >
                            <div class="bg-light d-flex justify-content-center pt-2 px-1">
                            </div>
                        </div>
                        <div class="text-center p-4">
                            <h5 class="mb-0">Code</h5>
                            <small>Improve your coding skills with our coding challenges.</small>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="team-item bg-light">
                        <div class="overflow-hidden">
                            <img class="img-fluid" src="img/analysis.png" alt="">
                        </div>
                        <div class="position-relative d-flex justify-content-center">
                            <div class="bg-light d-flex justify-content-center pt-2 px-1">
                            </div>
                        </div>
                        <div class="text-center p-4">
                            <h5 class="mb-0">Resources</h5>
                            <small>Get top notch quality study materials for your preparation.</small>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.7s">
                    <div class="team-item bg-light">
                        <div class="overflow-hidden">
                            <img class="img-fluid" src="img/services.png" alt="">
                        </div>
                        <div class="position-relative d-flex justify-content-center">
                            <div class="bg-light d-flex justify-content-center pt-2 px-1">
                            </div>
                        </div>
                        <div class="text-center p-4">
                            <h5 class="mb-0">Miscallenous</h5>
                            <small>This section is completely exciting. Try it for yourself!</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Team End -->

    <!-- Footer Start -->
    <div class="container-fluid bg-dark text-light footer pt-5 mt-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container py-5">
            <div class="row g-5">
                <div class="col-lg-3 col-md-6">
                    <h4 class="text-white mb-3">Quick Link</h4>
                    <a class="btn btn-link" href="">Quiz</a>
                    <a class="btn btn-link" href="">ROADMAP</a>
                    <a class="btn btn-link" href="">Resources</a>
                    <a class="btn btn-link" href="">Miscellaneous</a>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h4 class="text-white mb-3">Contact</h4>
                    <p class="mb-2"><i class="fa fa-map-marker-alt me-3"></i>CSPrep HQ, Bangalore.</p>
                    <p class="mb-2"><i class="fa fa-phone-alt me-3"></i>+91 1234567890</p>
                    <p class="mb-2"><i class="fa fa-envelope me-3"></i>csprep@gmail.com</p>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h4 class="text-white mb-3">Newsletter</h4>
                    <p>Sign up for weekly newsletter to get latest IT news, tips and tricks to help you achieve your goal.</p>
                    <div class="position-relative mx-auto" style="max-width: 400px;">
                        <input class="form-control border-0 w-100 py-3 ps-4 pe-5" type="text" placeholder="Your email">
                        <button type="button" class="btn btn-primary py-2 position-absolute top-0 end-0 mt-2 me-2">SignUp</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer End -->

    <!-- Login Modal -->
    <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header d-flex justify-content-center">
                    <div class="btn-group" role="group" aria-label="Login type toggle">
                        <button type="button" id="userBtn" class="btn btn-primary active">User</button>
                        <button type="button" id="adminBtn" class="btn btn-outline-secondary">Admin</button>
                    </div>
                    <button type="button" class="btn-close position-absolute end-0 me-2" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="userLoginForm" class="mb-4" action="login.php" method="post">
                        <h6>User Login</h6>
                        <div class="mb-3">
                            <label for="userEmail" class="form-label">Email address</label>
                            <input type="email" class="form-control" id="userEmail" name="email" placeholder="Enter email" required>
                        </div>
                        <div class="mb-3">
                            <label for="userPassword" class="form-label">Password</label>
                            <input type="password" class="form-control" id="userPassword" name="password" placeholder="Password" required>
                        </div>
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="userRememberMe" name="remember_me">
                            <label class="form-check-label" for="userRememberMe">Remember me</label>
                        </div>
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">Login</button>
                            <a href="register.php" class="btn btn-link">Don't have an account? Register</a>
                        </div>
                    </form>
                    <form id="adminLoginForm" style="display:none;" action="login.php" method="post">
                        <h6>Admin Login</h6>
                        <div class="mb-3">
                            <label for="adminEmail" class="form-label">Email address</label>
                            <input type="email" class="form-control" id="adminEmail" name="email" placeholder="Enter email" required>
                        </div>
                        <div class="mb-3">
                            <label for="adminPassword" class="form-label">Password</label>
                            <input type="password" class="form-control" id="adminPassword" name="password" placeholder="Password" required>
                        </div>
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="adminRememberMe" name="remember_me">
                            <label class="form-check-label" for="adminRememberMe">Remember me</label>
                        </div>
                        <button type="submit" class="btn btn-secondary w-100">Login as Admin</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="js/main.js"></script>
    <script>
        // Simple script to toggle between user and admin login forms in the modal
        document.getElementById('userBtn').addEventListener('click', function() {
            document.getElementById('userLoginForm').style.display = 'block';
            document.getElementById('adminLoginForm').style.display = 'none';
            document.getElementById('userBtn').classList.add('active');
            document.getElementById('adminBtn').classList.remove('active');
            document.getElementById('adminBtn').classList.add('btn-outline-secondary');
            document.getElementById('userBtn').classList.remove('btn-outline-secondary');
        });

        document.getElementById('adminBtn').addEventListener('click', function() {
            document.getElementById('userLoginForm').style.display = 'none';
            document.getElementById('adminLoginForm').style.display = 'block';
            document.getElementById('adminBtn').classList.add('active');
            document.getElementById('userBtn').classList.remove('active');
            document.getElementById('userBtn').classList.add('btn-outline-secondary');
            document.getElementById('adminBtn').classList.remove('btn-outline-secondary');
        });
    </script>
</body>
</html> 
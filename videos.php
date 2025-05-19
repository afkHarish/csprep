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

    <style>
    .cursor-pointer {
        cursor: pointer;
        transition: transform 0.3s ease;
        margin-bottom: 15px;
    }
    .cursor-pointer:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    .youtube-link {
        z-index: 2;
        position: relative;
    }
    .youtube-link:hover {
        transform: scale(1.1);
    }
    /* Card and image styles */
    .course-item {
        background: #fff;
        border: 1px solid rgba(0,0,0,0.1);
        border-radius: 5px;
    }
    .course-item .position-relative {
        width: 100%;
        padding-top: 75%; /* 4:3 Aspect Ratio */
        position: relative;
    }
    .course-item .position-relative img {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    /* Card content */
    .course-item .p-4 {
        padding: 1.5rem;
    }
    .course-item .p-4 h5 {
        margin-bottom: 0.5rem;
        font-weight: 600;
    }
    .course-item .p-4 p {
        margin-bottom: 0;
        color: #6c757d;
    }
    /* Modal styles */
    .modal-header {
        border-bottom: 1px solid rgba(0,0,0,0.1);
        padding: 1.5rem;
    }
    .modal-header .modal-title {
        font-size: 1.5rem;
        font-weight: 600;
    }
    .modal-header p {
        font-size: 1rem;
    }
    .modal-body {
        padding: 1.5rem;
    }
    .modal-body .ratio {
        border-radius: 5px;
        overflow: hidden;
        background: #000;
    }
    /* Modern Video Cards Styling */
    .video-card {
        background: #1a1a1a;
        border-radius: 12px;
        overflow: hidden;
        cursor: pointer;
        transition: transform 0.3s ease;
        margin-bottom: 20px;
    }

    .video-card:hover {
        transform: translateY(-5px);
    }

    .thumbnail-container {
        position: relative;
        width: 100%;
        padding-top: 56.25%; /* 16:9 Aspect Ratio */
        background: #000;
    }

    .yt-thumbnail {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .play-button {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 60px;
        height: 60px;
        background: rgba(255, 0, 0, 0.9);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 2;
        transition: all 0.3s ease;
    }

    .play-button i {
        color: #fff;
        font-size: 30px;
    }

    .video-number {
        position: absolute;
        top: 10px;
        left: 10px;
        background: rgba(0, 0, 0, 0.7);
        color: #fff;
        padding: 5px 10px;
        border-radius: 5px;
        font-size: 0.9em;
        z-index: 2;
    }

    .video-info {
        padding: 15px;
        color: #fff;
    }

    .video-title {
        font-size: 1.2em;
        margin: 0;
        font-weight: 600;
    }

    /* Video Modal */
    .video-modal .modal-dialog {
        max-width: 900px;
    }

    .video-modal .modal-content {
        background: #000;
        border: none;
    }

    .video-modal .modal-header {
        border-bottom: none;
    }

    .video-modal .modal-title {
        color: #fff;
    }

    .video-modal .btn-close {
        filter: invert(1);
    }
    </style>
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
                <a href="index.php" class="nav-item nav-link">Home</a>
                <a href="quiz.php" class="nav-item nav-link">Quiz</a>
                <a href="roadmaps/roadmap.html" class="nav-item nav-link">ROADMAP</a>
                <a href="resources.php" class="nav-item nav-link">Resources</a>
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle active" data-bs-toggle="dropdown">Miscellaneous</a>
                    <div class="dropdown-menu fade-down m-0">
                        <a href="videos.php" class="dropdown-item active">Videos</a>
                        <a href="blogs.html" class="dropdown-item">Blogs</a>
                        <a href="/Resume/resume.html" class="dropdown-item">Resume Builder</a>
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

    <!-- Header Start -->
    <div class="container-fluid bg-primary py-5 mb-5 page-header">
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-lg-10 text-center">
                    <h1 class="display-3 text-white animated slideInDown">Videos</h1>
                </div>
            </div>
        </div>
    </div>
    <!-- Header End -->

    <!-- Modern Video Cards Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="row g-4">
                <!-- Video Card 1 -->
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="video-card" data-bs-toggle="modal" data-bs-target="#videoModal" data-video-id="-SKSihRjKQA">
                        <div class="thumbnail-container">
                            <div class="play-button">
                                <i class="fab fa-youtube"></i>
                            </div>
                            <div class="video-number">#1</div>
                            <img src="" class="yt-thumbnail" data-video-id="-SKSihRjKQA" alt="Video Thumbnail">
                        </div>
                        <div class="video-info">
                            <h3 class="video-title">How to Prepare for Product Based Companies | Complete Roadmap 🔥</h3>
                        </div>
                    </div>
                </div>

                <!-- Video Card 2 -->
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="video-card" data-bs-toggle="modal" data-bs-target="#videoModal" data-video-id="pA3KodCLP2o">
                        <div class="thumbnail-container">
                            <div class="play-button">
                                <i class="fab fa-youtube"></i>
                            </div>
                            <div class="video-number">#2</div>
                            <img src="" class="yt-thumbnail" data-video-id="pA3KodCLP2o" alt="Video Thumbnail">
                        </div>
                        <div class="video-info">
                            <h3 class="video-title">How to Crack Product Based Companies | Complete Guide 🎯</h3>
                        </div>
                    </div>
                </div>

                <!-- Video Card 3 -->
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="video-card" data-bs-toggle="modal" data-bs-target="#videoModal" data-video-id="Vk7GW5X7HS4">
                        <div class="thumbnail-container">
                            <div class="play-button">
                                <i class="fab fa-youtube"></i>
                            </div>
                            <div class="video-number">#3</div>
                            <img src="" class="yt-thumbnail" data-video-id="Vk7GW5X7HS4" alt="Video Thumbnail">
                        </div>
                        <div class="video-info">
                            <h3 class="video-title">How to Prepare for Product Based Companies | Complete Roadmap 2024 🔥</h3>
                        </div>
                    </div>
                </div>

                <!-- Video Card 4 -->
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.7s">
                    <div class="video-card" data-bs-toggle="modal" data-bs-target="#videoModal" data-video-id="r_a_mO7Rux4">
                        <div class="thumbnail-container">
                            <div class="play-button">
                                <i class="fab fa-youtube"></i>
                            </div>
                             <div class="video-number">#4</div>
                            <img src="" class="yt-thumbnail" data-video-id="r_a_mO7Rux4" alt="Video Thumbnail">
                        </div>
                        <div class="video-info">
                            <h3 class="video-title">How To Prepare For TCS Digital & TCS Innovator | TCS Digital & Innovator Interview Questions 🔥</h3>
                        </div>
                    </div>
                </div>

                <!-- Video Card 5 -->
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="video-card" data-bs-toggle="modal" data-bs-target="#videoModal" data-video-id="f56xV32_Q7I">
                         <div class="thumbnail-container">
                            <div class="play-button">
                                <i class="fab fa-youtube"></i>
                            </div>
                             <div class="video-number">#5</div>
                            <img src="" class="yt-thumbnail" data-video-id="f56xV32_Q7I" alt="Video Thumbnail">
                        </div>
                        <div class="video-info">
                            <h3 class="video-title">How to Prepare For Infosys | Interview Questions, Pattern, Syllabus | Placement Guide 🔥</h3>
                        </div>
                    </div>
                </div>

                 <!-- Video Card 6 -->
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="video-card" data-bs-toggle="modal" data-bs-target="#videoModal" data-video-id="xHw0gS0r07U">
                         <div class="thumbnail-container">
                            <div class="play-button">
                                <i class="fab fa-youtube"></i>
                            </div>
                             <div class="video-number">#6</div>
                            <img src="" class="yt-thumbnail" data-video-id="xHw0gS0r07U" alt="Video Thumbnail">
                        </div>
                        <div class="video-info">
                            <h3 class="video-title">How To Crack Wipro NLTH | Wipro NLTH Interview Questions, Pattern, Syllabus | Placement Guide 🔥</h3>
                        </div>
                    </div>
                </div>

                 <!-- Video Card 7 -->
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="video-card" data-bs-toggle="modal" data-bs-target="#videoModal" data-video-id="sX9q3y4L_14">
                         <div class="thumbnail-container">
                            <div class="play-button">
                                <i class="fab fa-youtube"></i>
                            </div>
                             <div class="video-number">#7</div>
                            <img src="" class="yt-thumbnail" data-video-id="sX9q3y4L_14" alt="Video Thumbnail">
                        </div>
                        <div class="video-info">
                            <h3 class="video-title">How To Prepare For Capgemini | Capgemini Interview Questions, Pattern, Syllabus | Placement Guide 🔥</h3>
                        </div>
                    </div>
                </div>

                 <!-- Video Card 8 -->
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.7s">
                    <div class="video-card" data-bs-toggle="modal" data-bs-target="#videoModal" data-video-id="o3n5XoT4Z3E">
                         <div class="thumbnail-container">
                            <div class="play-button">
                                <i class="fab fa-youtube"></i>
                            </div>
                             <div class="video-number">#8</div>
                            <img src="" class="yt-thumbnail" data-video-id="o3n5XoT4Z3E" alt="Video Thumbnail">
                        </div>
                        <div class="video-info">
                            <h3 class="video-title">How To Crack Accenture On-Campus Drive | Accenture Interview Questions, Pattern, Syllabus | Placement Guide 🔥</h3>
                        </div>
                    </div>
                </div>

                 <!-- Video Card 9 -->
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="video-card" data-bs-toggle="modal" data-bs-target="#videoModal" data-video-id="aK46Z09Jp2Q">
                         <div class="thumbnail-container">
                            <div class="play-button">
                                <i class="fab fa-youtube"></i>
                            </div>
                             <div class="video-number">#9</div>
                            <img src="" class="yt-thumbnail" data-video-id="aK46Z09Jp2Q" alt="Video Thumbnail">
                        </div>
                        <div class="video-info">
                            <h3 class="video-title">How To Crack Deloitte | Deloitte Interview Questions, Pattern, Syllabus | Placement Guide 🔥</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modern Video Cards End -->

    <!-- Video Modal -->
    <div class="modal fade video-modal" id="videoModal" tabindex="-1" aria-labelledby="videoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="videoModalLabel">Video Playback</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="ratio ratio-16x9">
                        <iframe id="youtubeVideo" src="" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>

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

    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>

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
     <script>
        $(document).ready(function () {
            // Function to get YouTube thumbnail URL
            function getYouTubeThumbnail(videoId) {
                return `https://img.youtube.com/vi/${videoId}/hqdefault.jpg`;
            }

            // Set thumbnail for each video card
            $('.yt-thumbnail').each(function () {
                var videoId = $(this).data('video-id');
                var thumbnailUrl = getYouTubeThumbnail(videoId);
                $(this).attr('src', thumbnailUrl);
            });

            // Handle video card click to open modal
            $('.video-card').on('click', function () {
                var videoId = $(this).data('video-id');
                var videoTitle = $(this).find('.video-title').text();
                var iframeSrc = `https://www.youtube.com/embed/${videoId}?autoplay=1`;

                $('#videoModalLabel').text(videoTitle); // Set modal title
                $('#youtubeVideo').attr('src', iframeSrc); // Set iframe source
            });

            // Stop video when modal is closed
            $('#videoModal').on('hidden.bs.modal', function () {
                $('#youtubeVideo').attr('src', ''); // Clear iframe source
            });
        });
    </script>
</body>

</html> 
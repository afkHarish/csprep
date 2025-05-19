<?php
// user_dashboard.php - User specific page

session_start();

// Check if the user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    // If not logged in, redirect to login page
    header('Location: login.php');
    exit;
}

// If the user is an admin, redirect to admin dashboard
if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
    header('Location: admin_dashboard.php');
    exit;
}

// If the user is logged in and is a regular user, display the user dashboard content below
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Dashboard - CSPrep</title>
    <!-- Include your CSS and other head elements -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <style>
        /* Add any specific styles for the user dashboard here */
        .user-section {
            margin-top: 20px;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .progress-section {
            margin-bottom: 20px;
        }
        .feature-card {
            transition: transform 0.3s;
        }
        .feature-card:hover {
            transform: translateY(-5px);
        }
    </style>
</head>
<body>
    <!-- Navbar Start -->
    <nav class="navbar navbar-expand-lg bg-white navbar-light shadow sticky-top p-0">
        <a href="index.html" class="navbar-brand d-flex align-items-center px-4 px-lg-5">
            <h2 class="m-0 text-dark"><img src="img/CSPREP.png" height="75px">CSPrep</h2>
        </a>
        <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav ms-auto p-4 p-lg-0">
                <a href="index.html" class="nav-item nav-link">Home</a>
                <a href="quiz.html" class="nav-item nav-link">Quiz</a>
                <a href="roadmaps/roadmap.html" class="nav-item nav-link">ROADMAP</a>
                <a href="resources.html" class="nav-item nav-link">Resources</a>
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Miscellaneous</a>
                    <div class="dropdown-menu fade-down m-0">
                        <a href="videos.html" class="dropdown-item">Videos</a>
                        <a href="blogs.html" class="dropdown-item">Blogs</a>
                        <a href="/Resume/resume.html" class="dropdown-item">Resume Builder</a>
                    </div>
                </div>
                <a href="user_dashboard.php" class="nav-item nav-link active">Dashboard</a>
                <a href="logout.php" class="nav-item nav-link">Logout (<?php echo htmlspecialchars($_SESSION['name']); ?>)</a>
            </div>
        </div>
    </nav>
    <!-- Navbar End -->

    <div class="container mt-5">
        <h2 class="text-center mb-4">Welcome to Your Dashboard, <?php echo htmlspecialchars($_SESSION['name']); ?>!</h2>

        <!-- Progress Overview Section -->
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="user-section">
                    <h3>Your Progress Overview</h3>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card text-center mb-3">
                                <div class="card-body">
                                    <h5 class="card-title">Quizzes Completed</h5>
                                    <h2 class="text-primary">0</h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card text-center mb-3">
                                <div class="card-body">
                                    <h5 class="card-title">Roadmaps Started</h5>
                                    <h2 class="text-success">0</h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card text-center mb-3">
                                <div class="card-body">
                                    <h5 class="card-title">Resources Saved</h5>
                                    <h2 class="text-info">0</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Access Section -->
        <div class="row">
            <div class="col-md-6">
                <div class="user-section">
                    <h3>Quick Access</h3>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="card feature-card">
                                <div class="card-body">
                                    <h5 class="card-title">Take a Quiz</h5>
                                    <p class="card-text">Test your knowledge with our interactive quizzes.</p>
                                    <a href="quiz.html" class="btn btn-primary">Start Quiz</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="card feature-card">
                                <div class="card-body">
                                    <h5 class="card-title">View Roadmaps</h5>
                                    <p class="card-text">Follow our structured learning paths.</p>
                                    <a href="roadmaps/roadmap.html" class="btn btn-success">View Roadmaps</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="user-section">
                    <h3>Recent Activity</h3>
                    <div class="list-group">
                        <a href="#" class="list-group-item list-group-item-action">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1">No recent activity</h6>
                                <small>Just now</small>
                            </div>
                            <p class="mb-1">Start exploring our resources to see your activity here.</p>
                        </a>
                    </div>
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
</body>
</html> 
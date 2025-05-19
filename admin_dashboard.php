<?php
// admin_dashboard.php - Admin specific page

session_start();

// Check if the user is logged in and is an admin
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true || !isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    // If not logged in, not fully logged in, or not an admin, redirect to login page or an access denied page
    header('Location: login.php'); // Redirect to login
    exit;
}

// If the user is an admin, display the admin dashboard content below
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard - CSPrep</title>
    <!-- Include your CSS and other head elements -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <style>
        /* Add any specific styles for the admin dashboard here */
        .admin-section {
            margin-top: 20px;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <!-- Include your updated navigation here, similar to index.php -->
    <?php include 'navbar.php'; // Assuming you might create a reusable navbar file later, or copy the navbar HTML/PHP here ?>

    <div class="container mt-5">
        <h2 class="text-center mb-4">Admin Dashboard - Welcome, <?php echo htmlspecialchars($_SESSION['name']); ?>!</h2>

        <div class="admin-section">
            <h3>Manage Users</h3>
            <p>Link to a page to view, edit, or delete users (you'll need to create this page). For example, you could create a `manage_users.php`.</p>
            <!-- Example: <a href="manage_users.php">Manage Users</a> -->
        </div>

         <div class="admin-section">
            <h3>Manage Content</h3>
            <p>Link to pages to manage quizzes, roadmaps, resources, etc. (you'll need to create these pages). For example, `manage_quizzes.php`, `manage_roadmaps.php`.</p>
             <!-- Example: <a href="manage_quizzes.php">Manage Quizzes</a> -->
        </div>

        <!-- Add more admin-specific features here -->

    </div>

    <!-- Include your footer here if needed -->

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="js/main.js"></script>
     <!-- Login Modal (if used in header) -->
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
            <form id="userLoginForm" class="mb-4" action="login.php" method="post"> <!-- Added action and method -->
              <h6>User Login</h6>
              <div class="mb-3">
                <label for="userEmail" class="form-label">Email address</label>
                <input type="email" class="form-control" id="userEmail" name="email" placeholder="Enter email" required> <!-- Added name="email" -->
              </div>
              <div class="mb-3">
                <label for="userPassword" class="form-label">Password</label>
                <input type="password" class="form-control" id="userPassword" name="password" placeholder="Password" required> <!-- Added name="password" -->
              </div>
              <div class="mb-3 form-check"> <!-- Added for remember me -->
                <input type="checkbox" class="form-check-input" id="userRememberMe" name="remember_me"> <!-- Added name="remember_me" -->
                <label class="form-check-label" for="userRememberMe">Remember me</label>
              </div>
              <button type="submit" class="btn btn-primary w-100">Login as User</button>
            </form>
            <form id="adminLoginForm" style="display:none;" action="login.php" method="post"> <!-- Added action and method -->
              <h6>Admin Login</h6>
              <div class="mb-3">
                <label for="adminEmail" class="form-label">Email address</label>
                <input type="email" class="form-control" id="adminEmail" name="email" placeholder="Enter email" required> <!-- Added name="email" -->
              </div>
              <div class="mb-3">
                <label for="adminPassword" class="form-label">Password</label>
                <input type="password" class="form-control" id="adminPassword" name="password" placeholder="Password" required> <!-- Added name="password" -->
              </div>
               <div class="mb-3 form-check"> <!-- Added for remember me -->
                <input type="checkbox" class="form-check-input" id="adminRememberMe" name="remember_me"> <!-- Added name="remember_me" -->
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
     <script>
        // Simple script to toggle between user and admin login forms in the modal
        document.getElementById('userBtn').addEventListener('click', function() {
            document.getElementById('userLoginForm').style.display = 'block';
            document.getElementById('adminLoginForm').style.display = 'none';
            document.getElementById('userBtn').classList.add('active');
            document.getElementById('adminBtn').classList.remove('active');
             document.getElementById('adminBtn').classList.add('btn-outline-secondary'); // Ensure correct class
             document.getElementById('userBtn').classList.remove('btn-outline-secondary'); // Ensure correct class
        });

        document.getElementById('adminBtn').addEventListener('click', function() {
            document.getElementById('userLoginForm').style.display = 'none';
            document.getElementById('adminLoginForm').style.display = 'block';
            document.getElementById('adminBtn').classList.add('active');
            document.getElementById('userBtn').classList.remove('active');
            document.getElementById('userBtn').classList.add('btn-outline-secondary'); // Ensure correct class
             document.getElementById('adminBtn').classList.remove('btn-outline-secondary'); // Ensure correct class

        });
     </script>
</body>
</html> 
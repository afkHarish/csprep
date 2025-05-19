<?php
// login.php - Handles user login

// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "csprep_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize variables and error messages
$email = $password = "";
$email_err = $password_err = $login_err = "";

// Added for remember me
$remember_me = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate email
    if (empty($_POST["email"])) {
        $email_err = "Email is required";
    } else {
        $email = trim($_POST["email"]);
    }

    // Validate password
    if (empty($_POST["password"])) {
        $password_err = "Password is required";
    } else {
        $password = $_POST["password"];
    }

    // If no errors, check credentials
    if (empty($email_err) && empty($password_err)) {
        $stmt = $conn->prepare("SELECT id, name, email, password, role FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows == 1) {
            $stmt->bind_result($id, $name, $email_db, $hashed_password, $role);
            $stmt->fetch();

            if (password_verify($password, $hashed_password)) {
                // Password is correct, start session
                session_start();
                $_SESSION["loggedin"] = true;
                $_SESSION["id"] = $id;
                $_SESSION["name"] = $name;
                $_SESSION["email"] = $email_db;
                $_SESSION["role"] = $role; // Store user role in session

                // Handle remember me
                if (isset($_POST["remember_me"])) {
                    $remember_me = true;
                    // Generate a unique token
                    $token = bin2hex(random_bytes(32));
                    $hashed_token = password_hash($token, PASSWORD_DEFAULT);

                    // Store token in database
                    $update_stmt = $conn->prepare("UPDATE users SET remember_token = ? WHERE id = ?");
                    $update_stmt->bind_param("si", $hashed_token, $id);
                    $update_stmt->execute();
                    $update_stmt->close();

                    // Set cookie (valid for 30 days)
                    setcookie("remember_me", $id . ':' . $token, time() + (86400 * 30), "/");
                }

                // Redirect based on role
                if ($role == 'admin') {
                    header("Location: admin_dashboard.php"); // Redirect admin to admin dashboard
                } else {
                    header("Location: user_dashboard.php"); // Redirect regular users to user dashboard
                }
                exit();
            } else {
                $login_err = "Invalid email or password.";
            }
        } else {
            $login_err = "Invalid email or password.";
        }
        $stmt->close();
    }
}

// Check for remember me cookie if not logged in
if (!isset($_SESSION["loggedin"]) && isset($_COOKIE["remember_me"])) {
    list($user_id, $token) = explode(':', $_COOKIE["remember_me"]);

    $stmt = $conn->prepare("SELECT id, name, email, role, remember_token FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 1) {
        $stmt->bind_result($id, $name, $email_db, $role, $remember_token_hash);
        $stmt->fetch();

        if (password_verify($token, $remember_token_hash)) {
            // Token is valid, log in the user
            session_start();
            $_SESSION["loggedin"] = true;
            $_SESSION["id"] = $id;
            $_SESSION["name"] = $name;
            $_SESSION["email"] = $email_db;
            $_SESSION["role"] = $role; // Store user role in session

            // Redirect based on role
            if ($role == 'admin') {
                header("Location: admin_dashboard.php"); // Redirect admin
            } else {
                header("Location: user_dashboard.php"); // Redirect user
            }
            exit();
        } else {
            // Invalid token, clear cookie
            setcookie("remember_me", "", time() - 3600, "/");
        }
    } else {
         // User not found, clear cookie
        setcookie("remember_me", "", time() - 3600, "/");
    }
    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - CSPrep</title>
    <link href="css\bootstrap.min.css" rel="stylesheet">
    <link href="css\style.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Login</h2>
    <?php
    if (!empty($login_err)) {
        echo '<div class="alert alert-danger">' . $login_err . '</div>';
    }
    ?>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" novalidate>
        <div class="mb-3">
            <label for="email" class="form-label">Email address</label>
            <input type="email" name="email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" id="email" value="<?php echo htmlspecialchars($email); ?>" required>
            <div class="invalid-feedback"><?php echo $email_err; ?></div>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" id="password" required>
            <div class="invalid-feedback"><?php echo $password_err; ?></div>
        </div>
        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="remember_me" name="remember_me">
            <label class="form-check-label" for="remember_me">Remember me</label>
        </div>
        <button type="submit" class="btn btn-primary">Login</button>
        <a href="register.php" class="btn btn-link">Don't have an account? Register</a>
    </form>
</div>
<script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>

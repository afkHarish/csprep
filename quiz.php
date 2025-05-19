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
                <a href="index.php" class="nav-item nav-link">Home</a>
                <a href="quiz.php" class="nav-item nav-link active">Quiz</a>
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
                    <h1 class="display-3 text-white animated slideInDown">Quiz</h1>
                    <nav aria-label="breadcrumb"></nav>
                </div>
            </div>
        </div>
    </div>
    <!-- Header End -->

    <!-- QUIZ CARDS SECTION START -->
    <div class="container my-5">
        <h2 class="text-center mb-4">Choose a Quiz</h2>
        <div class="row" id="quiz-cards">
            <div class="col-md-4 mb-3">
                <div class="card quiz-card" data-api="https://opentdb.com/api.php?amount=10&category=18&difficulty=hard" style="cursor:pointer;">
                    <img src="img/computer.png" class="card-img-top" alt="Quiz 1">
                    <div class="card-body">
                        <h5 class="card-title text-center">Computer Science</h5>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card quiz-card" data-api="https://opentdb.com/api.php?amount=10&category=17&difficulty=hard" style="cursor:pointer;">
                    <img src="img/atom.png" class="card-img-top" alt="Quiz 2">
                    <div class="card-body">
                        <h5 class="card-title text-center">Science</h5>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card quiz-card" data-api="https://opentdb.com/api.php?amount=10&category=19&difficulty=medium" style="cursor:pointer;">
                    <img src="img/math.png" class="card-img-top" alt="Quiz 3">
                    <div class="card-body">
                        <h5 class="card-title text-center">Mathematics</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- QUIZ CARDS SECTION END -->

    <!-- QUIZ SECTION START -->
    <div class="container my-5">
        <div class="bg-white p-4 rounded shadow-sm">
            <h2 class="text-center mb-4">Take a Quick Quiz</h2>
            <div id="quiz-container"></div>
            <div class="results mt-4" id="results"></div>
            <div class="analytics mt-3 p-3 bg-light border rounded" id="analytics"></div>
        </div>
    </div>
    <!-- QUIZ SECTION END -->

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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const quizCards = document.querySelectorAll('.quiz-card');
            const quizContainer = document.getElementById('quiz-container');
            const resultsContainer = document.getElementById('results');
            const analyticsContainer = document.getElementById('analytics');

            let currentQuestion = 0;
            let score = 0;
            let correctCount = 0;
            let incorrectCount = 0;
            let questions = [];
            let startTime = 0;

            function decodeHTML(html) {
                const txt = document.createElement("textarea");
                txt.innerHTML = html;
                return txt.value;
            }

            function shuffle(array) {
                for (let i = array.length - 1; i > 0; i--) {
                    const j = Math.floor(Math.random() * (i + 1));
                    [array[i], array[j]] = [array[j], array[i]];
                }
                return array;
            }

            async function fetchQuestions(apiUrl) {
                try {
                    const res = await fetch(apiUrl);
                    if (!res.ok) {
                        throw new Error(`HTTP error! status: ${res.status}`);
                    }
                    const data = await res.json();
                    questions = data.results.map(q => ({
                        question: decodeHTML(q.question),
                        category: q.category,
                        options: shuffle([q.correct_answer, ...q.incorrect_answers].map(decodeHTML)),
                        answer: decodeHTML(q.correct_answer)
                    }));
                    startTime = performance.now();
                    showQuestion();
                } catch (err) {
                    quizContainer.innerHTML = `<p>Failed to load questions. Please try again later.</p>`;
                    resultsContainer.innerHTML = '';
                    analyticsContainer.innerHTML = '';
                    console.error(err);
                }
            }

            function showQuestion() {
                if (currentQuestion >= questions.length) {
                    showResults();
                    return;
                }

                const q = questions[currentQuestion];
                quizContainer.innerHTML = `
                    <div class="question mb-3"><strong>(${q.category})</strong> ${q.question}</div>
                    <ul class="list-group mb-3">
                        ${q.options.map(option => `
                            <li class="list-group-item">
                                <label><input type="radio" name="option" value="${option}"> ${option}</label>
                            </li>
                        `).join('')}
                    </ul>
                    <button class="btn btn-primary" id="submit-answer-btn">Submit</button>
                `;

                document.getElementById('submit-answer-btn').addEventListener('click', submitAnswer);
            }

            function submitAnswer() {
                const selected = document.querySelector('input[name="option"]:checked');
                if (!selected) return alert("Please select an option!");

                const userAnswer = selected.value;
                const correctAnswer = questions[currentQuestion].answer;

                if (userAnswer === correctAnswer) {
                    score++;
                    correctCount++;
                } else {
                    incorrectCount++;
                }

                currentQuestion++;
                showQuestion();
            }

            function showResults() {
                quizContainer.innerHTML = "";
                resultsContainer.innerHTML = `
                    <h4>Your Score: ${score}/${questions.length}</h4>
                `;

                analyticsContainer.innerHTML = `
                    <h5>Quiz Analytics</h5>
                    <p>Correct Answers: ${correctCount}</p>
                    <p>Incorrect Answers: ${incorrectCount}</p>
                    <p>Percentage: ${(score / questions.length * 100).toFixed(2)}%</p>
                    <p>Time Taken: ${((performance.now() - startTime) / 1000).toFixed(2)} seconds</p>
                `;
            }

            function resetQuiz() {
                currentQuestion = 0;
                score = 0;
                correctCount = 0;
                incorrectCount = 0;
                questions = [];
                resultsContainer.innerHTML = '';
                analyticsContainer.innerHTML = '';
                quizContainer.innerHTML = '<p>Loading quiz...</p>';
            }

            quizCards.forEach(card => {
                card.addEventListener('click', () => {
                    resetQuiz();
                    const apiUrl = card.getAttribute('data-api');
                    fetchQuestions(apiUrl);
                });
            });

            // Example: Load a default quiz on page load (optional)
            // fetchQuestions('https://opentdb.com/api.php?amount=10&category=18&difficulty=hard');
        });
    </script>

</body>

</html> 
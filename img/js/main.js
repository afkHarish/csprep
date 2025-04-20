(function ($) {
    "use strict";

    // Spinner
    window.addEventListener('load', () => {
        const spinner = document.getElementById('spinner');
        spinner.classList.add('hide');
    });

    // Initiate the wowjs
    new WOW().init();

    // Sticky Navbar
    $(window).scroll(function () {
        if ($(this).scrollTop() > 300) {
            $('.sticky-top').css('top', '0px');
        } else {
            $('.sticky-top').css('top', '-100px');
        }
    });

    // Dropdown on mouse hover
    const $dropdown = $(".dropdown");
    const $dropdownToggle = $(".dropdown-toggle");
    const $dropdownMenu = $(".dropdown-menu");
    const showClass = "show";

    $(window).on("load resize", function () {
        if (this.matchMedia("(min-width: 992px)").matches) {
            $dropdown.hover(
                function () {
                    const $this = $(this);
                    $this.addClass(showClass);
                    $this.find($dropdownToggle).attr("aria-expanded", "true");
                    $this.find($dropdownMenu).addClass(showClass);
                },
                function () {
                    const $this = $(this);
                    $this.removeClass(showClass);
                    $this.find($dropdownToggle).attr("aria-expanded", "false");
                    $this.find($dropdownMenu).removeClass(showClass);
                }
            );
        } else {
            $dropdown.off("mouseenter mouseleave");
        }
    });

    // Quiz Logic
    let currentQuestion = 0;
    let score = 0;
    let correctCount = 0;
    let incorrectCount = 0;
    let questions = [];

    const quizContainer = document.getElementById('quiz-container');
    const resultsContainer = document.getElementById('results');
    const analyticsContainer = document.getElementById('analytics');

    async function fetchQuestions() {
        try {
            const res = await fetch("https://opentdb.com/api.php?amount=10&type=multiple");
            const data = await res.json();
            questions = data.results.map(q => ({
                question: decodeHTML(q.question),
                category: q.category,
                options: shuffle([q.correct_answer, ...q.incorrect_answers].map(decodeHTML)),
                answer: decodeHTML(q.correct_answer)
            }));
            showQuestion();
        } catch (err) {
            quizContainer.innerHTML = `<p>Failed to load questions. Please refresh the page.</p>`;
            console.error(err);
        }
    }

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
            <button class="btn btn-primary" onclick="submitAnswer()">Submit</button>
        `;
    }

    window.submitAnswer = function () {
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
    };

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
            <p>Time Taken: ${(performance.now() / 1000).toFixed(2)} seconds</p>
        `;

        openModal(); // Optionally show modal on quiz end
    }

    fetchQuestions();

    // Back to top button
    $(window).scroll(function () {
        if ($(this).scrollTop() > 300) {
            $('.back-to-top').fadeIn('slow');
        } else {
            $('.back-to-top').fadeOut('slow');
        }
    });

    $('.back-to-top').click(function () {
        $('html, body').animate({ scrollTop: 0 }, 1500, 'easeInOutExpo');
        return false;
    });

    // Header carousel
    $(".header-carousel").owlCarousel({
        autoplay: true,
        smartSpeed: 1500,
        items: 1,
        dots: false,
        loop: true,
        nav: true,
        navText: [
            '<i class="bi bi-chevron-left"></i>',
            '<i class="bi bi-chevron-right"></i>'
        ]
    });

    // Testimonials carousel
    $(".testimonial-carousel").owlCarousel({
        autoplay: true,
        smartSpeed: 1000,
        center: true,
        margin: 24,
        dots: true,
        loop: true,
        nav: false,
        responsive: {
            0: {
                items: 1
            },
            768: {
                items: 2
            },
            992: {
                items: 3
            }
        }
    });

    document.addEventListener('DOMContentLoaded', function () {
        const userBtn = document.getElementById('userBtn');
        const adminBtn = document.getElementById('adminBtn');
        const userForm = document.getElementById('userLoginForm');
        const adminForm = document.getElementById('adminLoginForm');
        
        userBtn.addEventListener('click', function () {
        userBtn.classList.add('btn-primary');
        userBtn.classList.remove('btn-outline-secondary');
        userBtn.classList.add('active');
        
        
        adminBtn.classList.remove('btn-primary');
        adminBtn.classList.add('btn-outline-secondary');
        adminBtn.classList.remove('active');
        
        userForm.style.display = 'block';
        adminForm.style.display = 'none';
        });
        
        adminBtn.addEventListener('click', function () {
        adminBtn.classList.add('btn-primary');
        adminBtn.classList.remove('btn-outline-secondary');
        adminBtn.classList.add('active');
        
        
        userBtn.classList.remove('btn-primary');
        userBtn.classList.add('btn-outline-secondary');
        userBtn.classList.remove('active');
        
        adminForm.style.display = 'block';
        userForm.style.display = 'none';
        });
        });
        document.addEventListener('DOMContentLoaded', function () {
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.has('register')) {
              const status = urlParams.get('register');
              if (status === 'success') {
                alert('Registration successful! You can now log in.');
              } else if (status === 'fail') {
                alert('Registration failed. Please try again.');
              }
            }
        
            const isLoggedIn = localStorage.getItem('isLoggedIn');
            const loginLink = document.getElementById('loginLink');
            const profileLink = document.getElementById('profileLink');
            if (isLoggedIn === 'true') {
              loginLink.classList.add('d-none');
              profileLink.classList.remove('d-none');
            } else {
              loginLink.classList.remove('d-none');
              profileLink.classList.add('d-none');
            }
            });

    // Smooth scroll for "Read More" and "Explore" buttons in index.html
    document.addEventListener('DOMContentLoaded', function() {
        // Select the "Read More" buttons by their classes
        const readMoreButtons = document.querySelectorAll('a.btn-primary.py-md-3.px-md-5.me-3');
        // Select the "Explore" buttons by their classes
        const exploreButtons = document.querySelectorAll('a.btn-light.py-md-3.px-md-5');

        // Target sections
        const aboutSection = document.querySelector('.container-xxl.py-5'); // About section container
        const featuresSection = document.querySelectorAll('.container-xxl.py-5')[1]; // Features section container (second .container-xxl.py-5)

        // Scroll to About section on "Read More" click
        readMoreButtons.forEach(button => {
            button.addEventListener('click', function(event) {
                event.preventDefault();
                if (aboutSection) {
                    aboutSection.scrollIntoView({ behavior: 'smooth' });
                }
            });
        });

        // Scroll to Features section on "Explore" click
        exploreButtons.forEach(button => {
            button.addEventListener('click', function(event) {
                event.preventDefault();
                if (featuresSection) {
                    featuresSection.scrollIntoView({ behavior: 'smooth' });
                }
            });
        });
    });

})(jQuery);

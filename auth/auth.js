// Function to handle user registration
async function registerUser(email, password) {
    try {
        // Create user with Firebase Authentication
        const userCredential = await auth.createUserWithEmailAndPassword(email, password);
        const user = userCredential.user;

        // Store additional user data in Firestore
        await db.collection('users').doc(user.uid).set({
            email: user.email,
            createdAt: firebase.firestore.FieldValue.serverTimestamp(),
            lastLogin: firebase.firestore.FieldValue.serverTimestamp(),
            role: 'user'
        });

        return { success: true, message: 'Registration successful' };
    } catch (error) {
        let message = 'Registration failed';
        if (error.code === 'auth/email-already-in-use') {
            message = 'Email already in use';
        } else if (error.code === 'auth/weak-password') {
            message = 'Password is too weak';
        }
        return { success: false, message };
    }
}

// Function to handle user login
async function loginUser(email, password) {
    try {
        const userCredential = await auth.signInWithEmailAndPassword(email, password);
        const user = userCredential.user;

        // Update last login timestamp
        await db.collection('users').doc(user.uid).update({
            lastLogin: firebase.firestore.FieldValue.serverTimestamp()
        });

        return { success: true, message: 'Login successful' };
    } catch (error) {
        let message = 'Login failed';
        if (error.code === 'auth/user-not-found' || error.code === 'auth/wrong-password') {
            message = 'Invalid email or password';
        }
        return { success: false, message };
    }
}

// Function to handle user logout
async function logoutUser() {
    try {
        await auth.signOut();
        return { success: true, message: 'Logout successful' };
    } catch (error) {
        return { success: false, message: 'Logout failed' };
    }
}

// Function to check if user is logged in
function isLoggedIn() {
    return auth.currentUser !== null;
}

// Function to get current user
function getCurrentUser() {
    return auth.currentUser;
}

// Function to update UI based on login status
function updateAuthUI() {
    const loginBtn = document.getElementById('loginBtn');
    const profileDropdownContainer = document.getElementById('profileDropdownContainer');
    const profileEmail = document.getElementById('profileEmail');

    if (isLoggedIn()) {
        const user = getCurrentUser();
        if (loginBtn) loginBtn.style.display = 'none';
        if (profileDropdownContainer) profileDropdownContainer.style.display = 'block';
        if (profileEmail && user) profileEmail.textContent = user.email;
    } else {
        if (loginBtn) loginBtn.style.display = 'block';
        if (profileDropdownContainer) profileDropdownContainer.style.display = 'none';
        if (profileEmail) profileEmail.textContent = '';
    }
}

// Add event listeners when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    // Login form submission
    const loginForm = document.getElementById('loginForm');
    if (loginForm) {
        loginForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            const email = document.getElementById('loginEmail').value;
            const password = document.getElementById('loginPassword').value;
            
            const result = await loginUser(email, password);
            
            if (result.success) {
                alert(result.message);
                window.location.reload();
            } else {
                alert(result.message);
            }
        });
    }

    // Register form submission
    const registerForm = document.getElementById('registerForm');
    if (registerForm) {
        registerForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            const email = document.getElementById('registerEmail').value;
            const password = document.getElementById('registerPassword').value;
            const confirmPassword = document.getElementById('confirmPassword').value;

            if (password !== confirmPassword) {
                alert('Passwords do not match');
                return;
            }

            const result = await registerUser(email, password);
            
            if (result.success) {
                alert(result.message);
                // Switch to login form
                document.getElementById('loginTab').click();
            } else {
                alert(result.message);
            }
        });
    }

    // Logout button in profile dropdown
    const profileLogout = document.getElementById('profileLogout');
    if (profileLogout) {
        profileLogout.addEventListener('click', async function(e) {
            e.preventDefault();
            const result = await logoutUser();
            if (result.success) {
                window.location.reload();
            } else {
                alert(result.message);
            }
        });
    }

    // Listen for auth state changes
    auth.onAuthStateChanged(function(user) {
        updateAuthUI();
    });
});

// Listen for storage changes (login/logout in other tabs)
window.addEventListener('storage', function(event) {
    updateAuthUI();
}); 
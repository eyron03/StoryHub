// Get references to the input fields and toggle buttons
const passwordInput = document.getElementById('password');
const confirmPasswordInput = document.getElementById('password_confirmation');

const togglePasswordButton = document.getElementById('togglePassword');
const toggleConfirmPasswordButton = document.getElementById('toggleConfirmNewPassword');

// Variables to track the visibility state of the passwords
let isPasswordVisible = false;
let isConfirmPasswordVisible = false;

// Toggle visibility for Password
togglePasswordButton.addEventListener('click', function () {
    if (isPasswordVisible) {
        passwordInput.type = 'password'; // Hide password
        togglePasswordButton.textContent = '📗'; // Closed book emoji
    } else {
        passwordInput.type = 'text'; // Show password
        togglePasswordButton.textContent = '📖'; // Open book emoji
    }
    isPasswordVisible = !isPasswordVisible; // Toggle the visibility state
});

// Toggle visibility for Confirm Password
toggleConfirmPasswordButton.addEventListener('click', function () {
    if (isConfirmPasswordVisible) {
        confirmPasswordInput.type = 'password'; // Hide confirm password
        toggleConfirmPasswordButton.textContent = '📗'; // Closed book emoji
    } else {
        confirmPasswordInput.type = 'text'; // Show confirm password
        toggleConfirmPasswordButton.textContent = '📖'; // Open book emoji
    }
    isConfirmPasswordVisible = !isConfirmPasswordVisible; // Toggle the visibility state
});

// Optional: Validate if passwords match
function validatePasswords() {
    const errorMessage = document.getElementById('password-match-error');
    if (passwordInput.value !== confirmPasswordInput.value) {
        errorMessage.style.display = 'block'; // Show error message if passwords don't match
    } else {
        errorMessage.style.display = 'none'; // Hide error message if they match
    }
}

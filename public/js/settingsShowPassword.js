// Get references to the input fields and toggle buttons
const currentPasswordInput = document.getElementById('current_password');
const newPasswordInput = document.getElementById('new_password');
const confirmNewPasswordInput = document.getElementById('new_password_confirmation');

const toggleCurrentPasswordButton = document.getElementById('toggleCurrentPassword');
const toggleNewPasswordButton = document.getElementById('toggleNewPassword');
const toggleConfirmNewPasswordButton = document.getElementById('toggleConfirmNewPassword');

// Variables to track the visibility state of the passwords
let isCurrentPasswordVisible = false;
let isNewPasswordVisible = false;
let isConfirmNewPasswordVisible = false;

// Toggle visibility for Current Password
toggleCurrentPasswordButton.addEventListener('click', function () {
    if (isCurrentPasswordVisible) {
        currentPasswordInput.type = 'password'; // Hide current password
        toggleCurrentPasswordButton.textContent = '📗'; // Closed book emoji
    } else {
        currentPasswordInput.type = 'text'; // Show current password
        toggleCurrentPasswordButton.textContent = '📖'; // Open book emoji
    }
    isCurrentPasswordVisible = !isCurrentPasswordVisible; // Toggle the visibility state
});

// Toggle visibility for New Password
toggleNewPasswordButton.addEventListener('click', function () {
    if (isNewPasswordVisible) {
        newPasswordInput.type = 'password'; // Hide new password
        toggleNewPasswordButton.textContent = '📗'; // Closed book emoji
    } else {
        newPasswordInput.type = 'text'; // Show new password
        toggleNewPasswordButton.textContent = '📖'; // Open book emoji
    }
    isNewPasswordVisible = !isNewPasswordVisible; // Toggle the visibility state
});

// Toggle visibility for Confirm New Password
toggleConfirmNewPasswordButton.addEventListener('click', function () {
    if (isConfirmNewPasswordVisible) {
        confirmNewPasswordInput.type = 'password'; // Hide confirm new password
        toggleConfirmNewPasswordButton.textContent = '📗'; // Closed book emoji
    } else {
        confirmNewPasswordInput.type = 'text'; // Show confirm new password
        toggleConfirmNewPasswordButton.textContent = '📖'; // Open book emoji
    }
    isConfirmNewPasswordVisible = !isConfirmNewPasswordVisible; // Toggle the visibility state
});

// Optional: Validate if new password and confirmation match
function validatePasswords() {
    const errorMessage = document.getElementById('password-match-error');
    if (newPasswordInput.value !== confirmNewPasswordInput.value) {
        errorMessage.style.display = 'block'; // Show error message if passwords don't match
    } else {
        errorMessage.style.display = 'none'; // Hide error message if they match
    }
}

// Add input event listeners for real-time validation
newPasswordInput.addEventListener('input', validatePasswords);
confirmNewPasswordInput.addEventListener('input', validatePasswords);

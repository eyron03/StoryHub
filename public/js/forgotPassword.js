document.getElementById('forgotPasswordLink').addEventListener('click', function() {
    document.querySelector('.flip-container').classList.add('flipped');
});

document.getElementById('loginLink').addEventListener('click', function() {
    document.querySelector('.flip-container').classList.remove('flipped');
});

// Optional: Flip back to Login when closing the Forgot Password modal
document.querySelectorAll('.btn-close').forEach(function(btnClose) {
    btnClose.addEventListener('click', function() {
        document.querySelector('.flip-container').classList.remove('flipped');
    });
});

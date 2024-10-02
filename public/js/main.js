(function ($) {
    "use strict";

    // Initiate the wowjs
    new WOW().init();


    // Spinner
    var spinner = function () {
        setTimeout(function () {
            if ($('#spinner').length > 0) {
                $('#spinner').removeClass('show');
            }
        }, 1);
    };
    spinner();


    // Sticky Navbar
    $(window).scroll(function () {
        if ($(this).scrollTop() > 300) {
            $('.sticky-top').addClass('shadow-sm').css('top', '0px');
        } else {
            $('.sticky-top').removeClass('shadow-sm').css('top', '-100px');
        }
    });


    // Back to top button
    $(window).scroll(function () {
        if ($(this).scrollTop() > 300) {
            $('.back-to-top').fadeIn('slow');
        } else {
            $('.back-to-top').fadeOut('slow');
        }
    });
    $('.back-to-top').click(function () {
        $('html, body').animate({scrollTop: 0}, 1500, 'easeInOutExpo');
        return false;
    });


    // Header carousel
    $(".header-carousel").owlCarousel({
        autoplay: true,
        smartSpeed: 1500,
        items: 1,
        dots: true,
        loop: true,
        nav : true,
        navText : [
            '<i class="bi bi-chevron-left"></i>',
            '<i class="bi bi-chevron-right"></i>'
        ]
    });


    // Testimonials carousel
    $(".testimonial-carousel").owlCarousel({
        autoplay: true,
        smartSpeed: 1000,
        margin: 24,
        dots: false,
        loop: true,
        nav : true,
        navText : [
            '<i class="bi bi-arrow-left"></i>',
            '<i class="bi bi-arrow-right"></i>'
        ],
        responsive: {
            0:{
                items:1
            },
            992:{
                items:2
            }
        }
    });

})(jQuery);

document.addEventListener("DOMContentLoaded", function() {
    // JavaScript to handle opening modal when clicking on the "Existing Account" dropdown item
    document.getElementById("existingAccount").addEventListener("click", function(event) {
        event.preventDefault();
        $('#loginModal').modal('show');
    });

    // JavaScript to handle opening modal when clicking on the "Create Account" dropdown item
    // document.getElementById("createAccount").addEventListener("click", function(event) {
    //     event.preventDefault();
    //     $('#createAccountModal').modal('show');
    // });
});

function registerSuccess() {
    Swal.fire({
        icon: 'success',
        title: 'Successfully Registered!',
        text: 'You have successfully registered your account.',
        showConfirmButton: true, // Show the OK button
        timer: 2000, // Auto close after 2 seconds
        timerProgressBar: true, // Enable progress bar
        allowOutsideClick: false // Prevent closing by clicking outside the modal
    }).then((result) => {
        if (result.isConfirmed || result.dismiss === Swal.DismissReason.timer) {
            // Reload the page
            location.reload();
        }
    });
}

document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('#createAccountModal form');
    form.addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent the default form submission

        // Perform client-side validation
        const inputs = form.querySelectorAll('input, select');
        let isValid = true;
        inputs.forEach(input => {
            if (!input.checkValidity()) {
                isValid = false;
                input.classList.add('is-invalid');
            } else {
                input.classList.remove('is-invalid');
            }
        });

        // Check if passwords match
        const password = form.querySelector('#password').value;
        const confirmPassword = form.querySelector('#password_confirmation').value;
        if (password !== confirmPassword) {
            isValid = false;
            const confirmPasswordInput = form.querySelector('#password_confirmation');
            confirmPasswordInput.classList.add('is-invalid');
            Swal.fire({
                icon: 'error',
                title: 'Passwords Do Not Match',
                text: 'Please make sure the passwords match.'
            });
        }

        if (!isValid) {
            return;
        }

        const formData = new FormData(form);

        fetch(form.getAttribute('action'), {
            method: 'POST',
            body: formData
        })
        .then(response => {
            if (response.ok) {
                Swal.fire({
                    icon: 'success',
                    title: 'Successfully Registered!',
                    text: 'You have successfully registered your account.',
                    showConfirmButton: true, // Show the OK button
                    timer: 2000, // Auto close after 2 seconds
                    timerProgressBar: true, // Enable progress bar
                    allowOutsideClick: false // Prevent closing by clicking outside the modal
                }).then((result) => {
                    if (result.isConfirmed || result.dismiss === Swal.DismissReason.timer) {
                        // Reload the page
                        location.reload();
                    }
                });
                form.reset(); // Optionally reset the form after successful submission
            } else {
                throw new Error('Registration failed');
            }
        })
        .catch(error => {
            Swal.fire({
                icon: 'error',
                title: 'Registration Failed',
                text: error.message || 'An error occurred during registration.'
            });
        });
    });
});


(function () {
    'use strict';

    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    var forms = document.querySelectorAll('.needs-validation');

    // Loop over them and prevent submission
    Array.prototype.slice.call(forms)
        .forEach(function (form) {
            form.addEventListener('submit', function (event) {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }

                form.classList.add('was-validated');
            }, false);
        });
})();

document.addEventListener("DOMContentLoaded", function () {
    // Get the Learn Now button by its ID
    var learnNowBtn = document.getElementById("learnNowBtn");

    // Add a click event listener to the Learn Now button
    learnNowBtn.addEventListener("click", function (event) {
        // Prevent the default behavior of the anchor tag
        event.preventDefault();

        // Trigger the modal by its ID
        $('#loginModal').modal('show');
    });
});

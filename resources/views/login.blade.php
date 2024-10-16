<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Storyhub</title>
    <link rel="icon" href="{{ asset('book/icon.png') }}" type="image/png">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Links -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script&family=Dosis&family=Gajraj+One&family=Madimi+One&family=Roboto:wght@300&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Fjalla+One&family=Hammersmith+One&display=swap" rel="stylesheet">

    <link href="img/favicon.ico" rel="icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/parents.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/table.css') }}" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
 
    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Inter:wght@600&family=Lobster+Two:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>

<style>
    .d-none {
        display: none;
    }

    .login-container {
        margin-top: 100px;
        perspective: 1000px;
        height: auto;
    }

    .flip-card {
        position: relative;
        width: 100%;
        max-width: 400px;
        transform-style: preserve-3d;
        transition: transform 0.6s ease;
    }

    .flipped {
        transform: rotateY(180deg);
    }

    .card {
        width: 100%;
        height: auto;
        backface-visibility: hidden;
    }

    .forgot-password-form {
        position: absolute;
        top: 0;
        left: 0;
        backface-visibility: hidden;
        transform: rotateY(180deg);
    }
</style>

<body>
    @Include('sweetalert::alert')

    <div id="spinner" class="show position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>

    <div class="all">
        <div class="header d-flex justify-content-between align-items-center fixed-top">
            <a href="{{ route('index') }}" style="text-decoration: none;" class="d-flex align-items-center">
                <h1 class="m-0 text-primary text-orange"><i class="fa fa-book-reader me-3"></i>StoryHub</h1>
            </a>
        </div>

        <div class="content">
            <div class="container login-container">
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <div class="flip-card" id="flip-card">
                            <!-- Login Form -->
                            <div class="card">
                                <div class="text-center card-header">
                                    <h3>Login</h3>
                                </div>
                                <div class="card-body">
                                    <form id="login-form" method="POST" action="{{ route('LoginIndex') }}" class="needs-validation" novalidate>
                                        @csrf
                                        <div class="mb-3">
                                            <label for="email" class="form-label">Email</label>
                                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" required>
                                            <div class="invalid-feedback">Please enter a valid email address.</div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="password" class="form-label">Password</label>
                                            <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                                            <div class="invalid-feedback">Please enter your password.</div>
                                        </div>
                                        
                                        <div class="d-grid">
                                            <button type="submit" class="btn btn-primary">Login</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="text-center card-footer">
                                    <a href="#" id="forgot-link">Forgot your password?</a>
                                </div>
                            </div>

                            <!-- Forgot Password Form -->
                            <div class="card forgot-password-form">
                                <div class="text-center card-header">
                                    <h3>Forgot Password</h3>
                                </div>
                                <div class="card-body">
                                    <form id="forgot-password-form" method="POST" action="{{ route('password.email') }}" class="needs-validation" novalidate>
                                        @csrf
                                                                            
                                    <div id="gifLoader" class="mb-3 text-center d-none justify-content-center min-vh-100 ">
                                        <img src="{{ asset('book/bookloader.gif') }}" alt="Loading..." class="img-fluid">
                                    </div> 
                                        <div class="mb-3">
                                            <label for="forgot-email" class="form-label">Email address</label>
                                            <input type="email" class="form-control" id="forgot-email" name="email" placeholder="Enter email" required>
                                            <div class="invalid-feedback">Please enter your email address to reset the password.</div>
                                        </div>
                                        <div class="d-grid">
                                            <button type="submit" class="btn btn-primary">Send Reset Link</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="text-center card-footer">
                                    <a href="#" id="back-to-login-link">Back to login</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <!-- Bootstrap JS and dependencies -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var spinner = document.getElementById("spinner");
            spinner.classList.add("d-none");
        
            var flipCard = document.getElementById('flip-card');
            var forgotLink = document.getElementById('forgot-link');
            var backToLoginLink = document.getElementById('back-to-login-link');
            var loader = document.getElementById('gifLoader'); // The GIF loader element
        
            // Show forgot password form
            forgotLink.addEventListener('click', function(e) {
                e.preventDefault();
                flipCard.classList.add('flipped');
            });
        
            // Show login form again
            backToLoginLink.addEventListener('click', function(e) {
                e.preventDefault();
                flipCard.classList.remove('flipped');
            });
        
            // Form validation and loader functionality with AJAX submission
            var forgotPasswordForm = document.getElementById('forgot-password-form');
            forgotPasswordForm.addEventListener('submit', function(event) {
                event.preventDefault(); // Prevent the form from being submitted traditionally
        
                if (forgotPasswordForm.checkValidity()) {
                    // Show the GIF loader while keeping the form visible
                    loader.classList.remove('d-none');
        
                    // Perform AJAX request to submit the form
                    var formData = new FormData(forgotPasswordForm);
        
                    fetch('{{ route('password.email') }}', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        }
                    })
                    .then(response => {
                        loader.classList.add('d-none'); // Hide loader after response
                        
                        if (response.ok) {
                            // Server responded with a success status
                            return response.json();
                        } else {
                            // If the server returned an error, handle it here
                            throw new Error('Something went wrong with the request');
                        }
                    })
                    .then(data => {
                        // Handle successful response
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: 'Password reset email sent successfully!',
                            confirmButtonText: 'OK'
                        });
                    })
                    .catch(error => {
                        loader.classList.add('d-none'); // Hide loader in case of error
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'An error occurred. Please try again later.',
                            confirmButtonText: 'OK'
                        });
                    });
                } else {
                    forgotPasswordForm.classList.add('was-validated');
                }
            });
        });
        
    </script>
    
</body>

</html>

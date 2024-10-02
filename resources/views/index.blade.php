<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>StoryHub</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Favicon -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Include SweetAlert CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <link rel="icon" href="{{ asset('book\icon.png') }}" type="image/png">

    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/animate.min.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/preloader.css') }}" rel="stylesheet">
    <link href="{{ asset('css/forgotPassword.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/animate.min.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/owl.carousel.min.css') }}" rel="stylesheet">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Inter:wght@600&family=Lobster+Two:wght@700&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/animate.min.css" rel="stylesheet">
    <link href="lib/owl.carousel.min.css" rel="stylesheet">


    <!-- Customized Bootstrap Stylesheet -->
    {{--  <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">  --}}
    <style>
        .rounded-content {
            border-radius: 15px;
        }
        .rounded-input {
            border-radius: 10px;
        }
        .nav-link.active {
            /* Add your styles for active link here */
            font-weight: bold;
            color: #ff0000; /* Change color as desired */
        }
    </style>
</head>

<body>
    @Include('sweetalert::alert')
    <div class="p-0 bg-white container-xxl">
        <!-- Spinner Start -->
        <div id="spinner" class="bg-white show position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->
<div id="index"></div>

        <!-- Navbar Start -->
        <nav class="px-4 bg-white navbar navbar-expand-lg navbar-light sticky-top px-lg-5 py-lg-0">
            <a href="index" class="navbar-brand">
                <h1  class="m-0 text-primary"><i class="fa fa-book-reader me-3"></i>StoryHub</h1>
            </a>
            <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div   class="collapse navbar-collapse" id="navbarCollapse">
                <div class="mx-auto navbar-nav">
                    <a  href="#index" class="nav-item nav-link ">Home</a>
                    <a href="#about" class="nav-item nav-link">About Us</a>
                    <a href="#contactus" class="nav-item nav-link">Contact Us</a>
                    <a href="#"  id="existingAccount" class="nav-item nav-link">Login</a>
                    {{--  <div class="nav-item dropdown">
                        <a href="#"  id="existingAccount" class="nav-link dropdown-toggle" id="loginDropdown" data-bs-toggle="dropdown">Login/Register</a>
                        <div class="m-0 border-0 shadow-sm dropdown-menu rounded-0 rounded-bottom">
                            <a href="#" class="dropdown-item" id="existingAccount">Existing Account</a>
                            <a href="#" class="dropdown-item" id="createAccount">Create Account</a>
                        </div>
                    </div  --}}
<div></div>
                </div>
                <a href="" id="learnNowBtn" class="px-3 btn btn-primary rounded-pill d-none d-lg-block">Learn Now<i class="fa fa-arrow-right ms-3"></i></a>
            </div>
        </nav>
       


<div class="container">
    <div id="loginModal" class="modal fade">
        <div class="modal-dialog modal-dialog-centered flip-container">
            <div class="modal-content rounded-content flip-content">
                <!-- Front: Login Modal -->
                <div class="modal-front">
                    <!-- Modal Header -->
                    <div class="text-center modal-header">
                        <h5 class="modal-title">Login</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <!-- Modal Body -->
                    <div class="modal-body">
                        <!-- Your login form goes here -->
                        <form id="loginForm" method="POST" action="{{ route('login') }}" class="needs-validation" novalidate>
                            @csrf
                            <div class="form-group">
                                <label for="email" class="form-label">Email:</label>
                                <input type="email" class="form-control rounded-input" id="email" name="email" placeholder="Email" required>
                                <div class="invalid-feedback">Please provide a valid email.</div>
                            </div>
                            <div class="form-group">
                                <label for="password" class="form-label">Password:</label>
                                <div class="input-group">
                                    <input type="password" class="form-control rounded-input" id="password" name="password" placeholder="Password" required>
                                    <button type="button" class="btn btn-outline-secondary" id="togglePassword" style="cursor: pointer;">📗</button>
                                </div>
                                <div class="invalid-feedback">Please provide a password.</div>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Login</button>
                        </form>
                        <br>
                        <div class="text-center">
                            <a href="#" class="forgot-password-link" id="forgotPasswordLink">Forgot Password?</a>
                        </div>
                    </div>
                </div>
    
                <!-- Back: Forgot Password Modal -->
                <div class="modal-back">
                    <div class="modal-header">
                        <h5 class="modal-title">Forgot Password</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Success Text -->
                        <div id="successText" class="alert alert-success d-none">
                            <span id="successMessage"></span>
                        </div>
    
                        <!-- Error Text -->
                        <div id="errorText" class="alert alert-danger d-none">
                            <span id="errorMessage"></span>
                        </div>
    
                        <div id="gifLoader" class="text-center mb-3 d-none">
                            <img src="{{ asset('book/preloader.gif') }}" alt="Loading..." class="img-fluid">
                        </div>
    
                        <form id="forgotPasswordForm" method="POST" action="{{ route('password.email') }}">
                            @csrf
                            <div class="form-group">
                                <label for="forgot-email" class="form-label">Email:</label>
                                <input type="email" class="form-control" id="forgot-email" name="email" placeholder="Enter your email" required>
                                <div class="invalid-feedback">Please provide a valid email.</div>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Send Reset Link</button>
                        </form>
                        <br>
                        <div class="text-center">
                            <a href="#" class="loginLink" id="loginLink">Back to Login</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Error message for invalid credentials -->
    @if (session('loginError'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '{{ session('loginError') }}',
            });
        </script>
    @endif
    
    
{{--
        <div id="createAccountModal" class="modal fade">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content rounded-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h5 class="modal-title">Create Account</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="overflow-auto modal-body" style="max-height: 80vh;"> <!-- Set maximum height and enable overflow scrolling -->
                    <!-- Modal Body -->
                    <div class="modal-body">
                        <!-- Your create account form goes here -->
                        <form  method="POST" action="{{ route('parents.register.submit') }}" class="needs-validation" novalidate>

                            @csrf
                            <input type="hidden" id="usertype"name="usertype" value="parent">
                            <div class="mb-3">
                                <label for="pFname" class="form-label">First Name:</label>
                                <input type="text" class="form-control rounded-input" id="pFname" name="pFname" required>
                                <div class="invalid-feedback">Please provide a first name.</div>
                            </div>
                            <div class="mb-3">
                                <label for="pLname" class="form-label">Last Name:</label>
                                <input type="text" class="form-control rounded-input" id="pLname" name="pLname" required>
                                <div class="invalid-feedback">Please provide a last name.</div>
                            </div>
                            <div class="mb-3">
                                <label for="pAge" class="form-label">Age:</label>
                                <input type="number" class="form-control rounded-input" id="pAge" name="pAge" required>
                                <div class="invalid-feedback">Please provide an age.</div>
                            </div>
                            <div class="mb-3">
                                <label for="pDob" class="form-label">Date of Birth:</label>
                                <input type="date" class="form-control rounded-input" id="pDob" name="pDob" required>
                                <div class="invalid-feedback">Please provide a date of birth.</div>
                            </div>
                            <div class="mb-3">
                                <label for="pAddress" class="form-label">Address:</label>
                                <input type="text" class="form-control rounded-input" id="pAddress" name="pAddress" required>
                                <div class="invalid-feedback">Please provide an address.</div>
                            </div>
                            <div class="mb-3">
                                <label for="pGender" class="form-label">Gender:</label>
                                <select class="form-select rounded-input" id="pGender" name="pGender" required>
                                    <option value="">Select gender...</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                    <option value="other">Other</option>
                                </select>
                                <div class="invalid-feedback">Please select a gender.</div>
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email:</label>
                                <input type="email" class="form-control rounded-input" id="email" name="email" required>
                                <div class="invalid-feedback">Please provide a valid email.</div>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password:</label>
                                <input type="password" class="form-control rounded-input" id="password" name="password" required>
                                <div class="invalid-feedback">Please provide a password.</div>
                            </div>
                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">Confirm Password:</label>
                                <input type="password" class="form-control rounded-input" id="password_confirmation" name="password_confirmation" required>
                                <div class="invalid-feedback">Please confirm your password.</div>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Register</button>
                        </form>
                    </div>
                </div>
            </div>
            </div>
        </div>  --}}


        <!-- Carousel Start -->
        <div class="p-0 mb-5 container-fluid">
            <div class="owl-carousel header-carousel position-relative">
                <div class="owl-carousel-item position-relative">
                    <img class="img-fluid" src="img/carousel-1.jpg" alt="">
                    <div class="top-0 position-absolute start-0 w-100 h-100 d-flex align-items-center" style="background: rgba(0, 0, 0, .2);">
                        <div class="container">
                            <div class="row justify-content-start">
                                <div class="col-10 col-lg-8">
                                    <h1 class="mb-4 text-white display-2 animated slideInDown"></h1>
                                    <p class="pb-2 mb-4 text-white fs-5 fw-medium"></p>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="owl-carousel-item position-relative">
                    <img class="img-fluid" src="img/carousel-2.jpg" alt="">
                    <div class="top-0 position-absolute start-0 w-100 h-100 d-flex align-items-center" style="background: rgba(0, 0, 0, .2);">
                        <div class="container">
                            <div class="row justify-content-start">
                                <div class="col-10 col-lg-8">
                                    <h1 class="mb-4 text-white display-2 animated slideInDown"></h1>
                                    <p class="pb-2 mb-4 text-white fs-5 fw-medium"></p>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Carousel End -->


        <!-- Facilities Start -->
        <div id= "about"class="py-5 container-xxl">
            <div class="container">
                <div class="mx-auto mb-5 text-center wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
                    <h1 class="mb-3">School Facilities</h1>
                    <p>At Dinalaoan Elementary School, each facilities are designed and constructed with different purpose, some are to promote the academic excellence, some are for physical health, and some are for general growth and development of the students.</p>
                </div>
                <div class="row justify-content-center">

                    <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.3s">
                        <div class="facility-item">
                            <div class="facility-icon bg-success">
                                <span class="bg-success"></span>
                                <i class="fa fa-futbol fa-3x text-success"></i>
                                <span class="bg-success"></span>
                            </div>
                            <div class="facility-text bg-success">
                                <h3 class="mb-3 text-success">Playground</h3>
                                <p class="mb-0">The playground where children are chasing around each other and swinging under the tree, where you can see the joy on their faces as students.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.5s">
                        <div class="facility-item">
                            <div class="facility-icon bg-warning">
                                <span class="bg-warning"></span>
                                <i class="fa fa-home fa-3x text-warning"></i>
                                <span class="bg-warning"></span>
                            </div>
                            <div class="facility-text bg-warning">
                                <h3 class="mb-3 text-warning">Healthy Canteen</h3>
                                <p class="mb-0">It is hard to study with an empty stomach, good thing the canteen offers healthy and nutritious foods for students to snack on.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.7s">
                        <div class="facility-item">
                            <div class="facility-icon bg-info">
                                <span class="bg-info"></span>
                                <i class="fa fa-chalkboard-teacher fa-3x text-info"></i>
                                <span class="bg-info"></span>
                            </div>
                            <div class="facility-text bg-info">
                                <h3 class="mb-3 text-info">Positive Learning</h3>
                                <p class="mb-0">If based on a fairy tale, the school would be the kingdom of knowledge. A place where learning is always fun and exciting.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Facilities End -->


        <!-- About Start -->
        <div class="py-5 container-xxl">
            <div class="container">
                <div class="row g-5 align-items-center">
                    <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s">
                        <h1 class="mb-4">About Us</h1>
                        <p>Tempor erat elitr rebum at clita. Diam dolor diam ipsum sit. Aliqu diam amet diam et eos. Clita erat ipsum et lorem et sit, sed stet lorem sit clita duo justo magna dolore erat amet</p>
                        <p class="mb-4">Stet no et lorem dolor et diam, amet duo ut dolore vero eos. No stet est diam rebum amet diam ipsum. Clita clita labore, dolor duo nonumy clita sit at, sed sit sanctus dolor eos, ipsum labore duo duo sit no sea diam. Et dolor et kasd ea. Eirmod diam at dolor est vero nonumy magna.</p>
                        <div class="row g-4 align-items-center">

                        </div>
                    </div>
                    <div class="col-lg-6 about-img wow fadeInUp" data-wow-delay="0.5s">
                        <div class="row">
                            <div class="text-center col-12">
                                <img class="p-3 img-fluid w-75 rounded-circle bg-light" src="img/about-1.jpg" alt="">
                            </div>
                            <div class="col-6 text-start" style="margin-top: -150px;">
                                <img class="p-3 img-fluid w-100 rounded-circle bg-light" src="img/about-2.jpg" alt="">
                            </div>
                            <div class="col-6 text-end" style="margin-top: -150px;">
                                <img class="p-3 img-fluid w-100 rounded-circle bg-light" src="img/about-3.jpg" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- About End -->




        <!-- Footer Start -->
        <div id="contactus" class="pt-5 mt-5 container-fluid bg-dark text-white-50 footer wow fadeIn" data-wow-delay="0.1s">
            <div class="container py-5">
                <div class="row justify-content-center">
                    <div class="col-lg-3 col-md-6">
                        <h3 class="mb-4 text-white">Get In Touch</h3>
                        <p class="mb-2"><i class="fa fa-map-marker-alt me-3"></i>Dinalaoan Centro, Calasiao, Pangasinan</p>
                        <p class="mb-2"><i class="fa fa-phone-alt me-3"></i>+63925 719 6748</p>
                        <p class="mb-2"><i class="fa fa-envelope me-3"></i>dinalaoanes101430@gmail.com</p>
                      
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <h3 class="mb-4 text-white">Quick Links</h3>
                        <a class="btn btn-link text-white-50" href="">About Us</a>
                        <a class="btn btn-link text-white-50" href="">Contact Us</a>
                        <a class="btn btn-link text-white-50" href="">Our Services</a>
                       
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <h3 class="mb-4 text-white">Photo Gallery</h3>
                        <div class="pt-2 row g-2">
                            <div class="col-4">
                                <img class="p-1 rounded img-fluid bg-light" src="img/classes-1.jpg" alt="">
                            </div>
                            <div class="col-4">
                                <img class="p-1 rounded img-fluid bg-light" src="img/classes-2.jpg" alt="">
                            </div>
                            <div class="col-4">
                                <img class="p-1 rounded img-fluid bg-light" src="img/classes-3.jpg" alt="">
                            </div>
                            <div class="col-4">
                                <img class="p-1 rounded img-fluid bg-light" src="img/classes-4.jpg" alt="">
                            </div>
                            <div class="col-4">
                                <img class="p-1 rounded img-fluid bg-light" src="img/classes-5.jpg" alt="">
                            </div>
                            <div class="col-4">
                                <img class="p-1 rounded img-fluid bg-light" src="img/classes-6.jpg" alt="">
                            </div>
                        </div>
                    </div>

                </div>
            </div>


        </div>
        <!-- Footer End -->


        <!-- Back to Top -->
        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    {{--  <script src="lib/wow/wow.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>  --}}

    <script src="{{ asset('lib/wow.js') }}"></script>
    <script src="{{ asset('lib/wow.min.js') }}"></script>
    <script src="{{ asset('lib/owl.carousel.js') }}"></script>
    <script src="{{ asset('lib/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('lib/easing.min.js') }}"></script>
    <script src="{{ asset('lib/easing.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>
    <script src="{{ asset('js/showPassword.js') }}"></script>
    <script src="{{ asset('js/forgotPassword.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<!-- Include SweetAlert JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script>
    $(document).ready(function() {
        // Function to handle click on nav links
        $('nav .nav-link').on('click', function() {
            // Remove 'active' class from all nav links
            $('nav .nav-link').removeClass('active');
            // Add 'active' class to the clicked nav link
            $(this).addClass('active');
        });
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('forgotPasswordForm');
        const gifLoader = document.getElementById('gifLoader');
        const successText = document.getElementById('successText');
        const successMessage = document.getElementById('successMessage');
        const errorText = document.getElementById('errorText');
        const errorMessage = document.getElementById('errorMessage');
    
        form.addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent default form submission
    
            const formData = new FormData(form);
    
            // Show GIF loader and hide success/error text
            gifLoader.classList.remove('d-none');
            successText.classList.add('d-none');
            errorText.classList.add('d-none');
            successMessage.textContent = '';
            errorMessage.textContent = '';
    
            fetch(form.action, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': formData.get('_token') // Ensure CSRF token is sent
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                // Hide GIF loader
                gifLoader.classList.add('d-none');
    
                if (data.success) {
                    // Show success message
                    successMessage.textContent = data.message;
                    successText.classList.remove('d-none');
                    
                    // Optionally reset the form
                    form.reset();
    
                    // Show SweetAlert success notification
                    Swal.fire({
                        title: 'Success!',
                        text: data.message,
                        icon: 'success',
                        confirmButtonText: 'OK'
                    });
                } else {
                    // Show error message
                    errorMessage.textContent = data.message;
                    errorText.classList.remove('d-none');
    
                    // Show SweetAlert error notification
                    Swal.fire({
                        title: 'Error!',
                        text: data.message,
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            })
            .catch(error => {
                // Hide GIF loader
                gifLoader.classList.add('d-none');
                
                // Show SweetAlert error notification
                Swal.fire({
                    title: 'Error!',
                    text: 'Something went wrong. Please try again.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            });
        });
    });
    
</script>

</body>

</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Storyhub</title>
    <link rel="icon" href="{{ asset('book\icon.png') }}" type="image/png">


    <!--Links -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script&family=Dosis&family=Gajraj+One&family=Madimi+One&family=Roboto:wght@300&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Fjalla+One&family=Hammersmith+One&display=swap" rel="stylesheet">

    <link href="img/favicon.ico" rel="icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/parents.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/table.css') }}" rel="stylesheet">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Inter:wght@600&family=Lobster+Two:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <style>

        .dashboard-items {
            border: 1px solid black; /* Add a black border */
            border-radius: 5px; /* Optional: Add rounded corners */
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Optional: Add a shadow for better visual separation */

        }
        .dashboard-icons {
            margin-left: 16px; /* Adjust this value to move the icon to the right */
        }

.filter-container {
    background-image: url('{{ asset('book/background1.jpg') }}');
    background-size: cover; /* Ensures the background covers the whole div */
    background-repeat: no-repeat;
    border: 3px solid orange;
    width: 100%;
    height: auto; /* Allow height to adjust automatically */
    padding: 20px; /* Padding for inner content */
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    display: flex;
    justify-content: center;
    align-items: center;
    color: white; /* Change text color */
    text-shadow: 4px 4px 6px black; /* Add black text shadow */
}

.text-center {
    text-align: center; /* Center align text for all screen sizes */
}

.welcome-text {
    color: white; /* Change text color to white */
    text-shadow: 4px 4px 6px black; /* Add black text shadow */
}

    /* Responsive styling for all screen sizes */
    @media only screen and (max-width: 768px) {
        .filter-container {
            padding: 15px; /* Adjust padding for smaller screens */
        }

        .filter-container h3,
        .filter-container h1,
        .filter-container p {
            font-size: 16px; /* Adjust font size for smaller screens */
            text-align: center; /* Center-align text for smaller screens */
        }
    }

    @media only screen and (max-width: 576px) {
        .filter-container {
            padding: 10px; /* Further reduce padding on extra small screens */
        }

        .filter-container h3 {
            font-size: 14px; /* Smaller heading size */
        }

        .filter-container h1 {
            font-size: 16px; /* Smaller title */
        }

        .filter-container p {
            font-size: 14px; /* Smaller paragraph text */
            line-height: 1.3; /* Reduced line height to fit more text */
        }
    }

    </style>

</head>
<body>
    <div id="spinner" class=" show position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    @Include('sweetalert::alert')
<div class="all">
    <div class="header d-flex justify-content-between align-items-center fixed-top">
        <a href="#" style="text-decoration: none;"class="d-flex align-items-center">

          <h1 class="m-0 text-primary text-orange"><i class="fa fa-book-reader me-3"></i>StoryHub</h1>
        </a>
        <div class="dropdown-center">
            <div class="dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                @foreach ($teachers as $teacherName)
                    {{ $teacherName }}
                @endforeach



            </div>
            <ul class="dropdown-menu">
                <li class="text-center"><a class="dropdown-item" href="settings" style="text-decoration: none; color:black;">Account Settings</a></li>
                <li class="text-center"><hr class="dropdown-divider"></li>

                <li class="text-center">
                    <form id="logout-form" action="{{ route('teacher.logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>

                    <a href="{{ route('teacher.logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Logout
                    </a>
                </li>
            </ul>
        </div>
    </div>


    <div class="sidebar">



        <a class="sidebarimage img-fluid" href="dashboard" style="background-color: #fcfbe8;">
            <i class="fas fa-tachometer-alt icon-space"></i> Dashboard
        </a>
        <a class="sidebarimage img-fluid" href="books">
            <i class="fas fa-book icon-space"></i> Books
        </a>
        <a class="sidebarimage img-fluid" href="parent">
            <i class="fas fa-user-friends icon-space"></i> Parents
        </a>
        <a class="sidebarimage img-fluid" href="pupils">
            <i class="fas fa-users icon-space"></i> Pupils
        </a>
        <a class="sidebarimage img-fluid" href="reports">
            <i class="fas fa-file-alt icon-space"></i> Reports
        </a>
        <a class="sidebarimage img-fluid" href="progressReports">
            <i class="fas fa-chart-line icon-space"></i> Progress
        </a>
    </div>


    <div class="content">

<div class="container mt-4">
    <div class="row">
        <div class="col d-flex justify-content-end align-items-center">
            <div class="d-flex flex-column align-items-end">
                <p style="font-size: 14px; color: rgb(119, 119, 119); margin-bottom: 0; font-weight: bold;">Today's Date</p>
                <p class="heading-sub12 bold-text" style="margin-bottom: 0;">{{ $today }}</p>
            </div>
            <i class="fa fa-calendar" style="font-size: 24px; margin-left: 10px;"></i>
        </div>
    </div>
</div>

<center>
<div class="filter-container d-flex justify-content-center align-items-center">
    <div class="p-4 content col-12 col-md-10 col-lg-8">

        <tr>
            <td style="padding: 20px; ">
                <h3 class="welcome-text">Welcome!</h3>
                <h1 class="welcome-text">{{ $teacherName }}</h1>
                <p>
                    As a teacher, you can effectively manage the learning environment:
                </p>
                <p>
                    - <strong>View Books:</strong> Access available resources in the StoryHub.
                </p>
                 <p>
                    - <strong>Manage Pupils:</strong> Easily oversee and manage your pupils’ profiles, including adding new pupils and updating their information.
                </p>
                <p>
                    - <strong>View and Edit Parents:</strong> Access and update parent information.
                </p>
                <p>
                    - <strong>Monitor Reports:</strong> Track pupil progress to identify improvements.
                </p>
            </td>
        </tr>

</center>


<div class="mt-5 dash-body">
    <div class="row">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <div class="status-title">
                <h3>Status</h3>
            </div>
        </div>
    </div>
    <div class="mt-4 row">
        <div class="mb-4 col-lg-3 col-md-6 col-12">
            <div class="p-3 dashboard-items d-flex align-items-center justify-content-between" style="border: 3px solid orange;">
                <div class="dashboard-text me-3">
                    <div class="h1-dashboard">{{ $teachersCount }}</div>
                    <div class="h3-dashboard">All Teachers</div>
                </div>
                <div class="dashboard-icons">
                    <i class="fas fa-chalkboard-teacher fa-2x"></i>
                </div>
            </div>
        </div>
        <div class="mb-4 col-lg-3 col-md-6 col-12">
            <div class="p-3 dashboard-items d-flex align-items-center justify-content-between" style="border: 3px solid orange;">
                <div class="dashboard-text me-3">
                    <div class="h1-dashboard">{{ $parentsCount }}</div>
                    <div class="h3-dashboard">Kid's Parents</div>
                </div>
                <div class="dashboard-icons">
                    <i class="fas fa-user-friends fa-2x"></i>
                </div>
            </div>
        </div>
        <div class="mb-4 col-lg-3 col-md-6 col-12">
            <div class="p-3 dashboard-items d-flex align-items-center justify-content-between" style="border: 3px solid orange;">
                <div class="dashboard-text me-3">
                    <div class="h1-dashboard">{{ $assignedChildrenCount }}</div>
                    <div class="h3-dashboard">My Pupils</div>
                </div>
                <div class="dashboard-icons">
                    <i class="fas fa-users fa-2x"></i>
                </div>
            </div>
        </div>
        <div class="mb-4 col-lg-3 col-md-6 col-12">
            <div class="p-3 dashboard-items d-flex align-items-center justify-content-between" style="border: 3px solid orange;">
                <div class="dashboard-text me-3">
                    <div class="h1-dashboard">{{ $booksCount }}</div>
                    <div class="h3-dashboard">All Books</div>
                </div>
                <div class="dashboard-icons">
                    <i class="fas fa-book fa-2x"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS and dependencies -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var spinner = document.getElementById("spinner");
        spinner.classList.add("d-none");
      });
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<script>
    // Example of using SweetAlert
    // This will trigger a simple success alert
    @if(Session::has('showLoginAlert'))
        // Show the SweetAlert
        Swal.fire({
            icon: 'success',
            title: 'Login Successfully',
            text: 'Welcome {{ $teacherName }}',
            showConfirmButton: false,
            timer: 1500
        });

        // Unset the session variable to prevent showing the alert again on subsequent page loads
        @php
            Session::forget('showLoginAlert');
        @endphp
    @endif
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>
</html>

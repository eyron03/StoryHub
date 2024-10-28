<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Storyhub</title>
    <link rel="icon" href="{{ asset('book\icon.png') }}" type="image/png">

    <!--Links -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link
        href="https://fonts.googleapis.com/css2?family=Dancing+Script&family=Dosis&family=Gajraj+One&family=Madimi+One&family=Roboto:wght@300&display=swap"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Fjalla+One&family=Hammersmith+One&display=swap"
        rel="stylesheet">

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
    <link
        href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Inter:wght@600&family=Lobster+Two:wght@700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        .chart-container {
            padding: 20px;
            border: 2px solid orange;
            border-radius: 8px;
            background-color: #f9f9f9;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
    
        /* Responsive adjustments */
        @media (max-width: 768px) {
            .chart-container canvas {
                max-width: 100% !important;
            }
        }
    
        /* Chart Title Styling */
        .chart-title {
            text-align: center;
            font-weight: bold;
            color: #333;
            margin-bottom: 10px;
        }
    </style>
    
</head>

<body>


    @Include('sweetalert::alert')
    <div id="spinner"
        class=" show position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <div class="all">
        <div class="header d-flex justify-content-between align-items-center fixed-top">
            <a href="{{ route('admin.dashboard') }}" style="text-decoration: none;" class="d-flex align-items-center">
                <h1 class="m-0 text-primary text-orange"><i class="fa fa-book-reader me-3"></i>StoryHub</h1>
            </a>
            <div class="dropdown-center">
                <div class="dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <span style="font-weight:bold;" class="name">Admin</span>
                </div>
                <ul class="dropdown-menu">
                    <li class="text-center"><a class="dropdown-item" href="settings"
                            style="text-decoration: none; color:black;">Account Settings</a></li>
                    <li class="text-center">
                        <hr class="dropdown-divider">
                    </li>
                    <li class="text-center">
                        <form id="logout-form" action="{{ route('admin.logout') }}" method="POST"
                            style="display: none;">
                            @csrf
                        </form>
                        <a href="{{ route('admin.logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="sidebar">
            <a class="sidebarimage img-fluid" href="dashboard" style="background-color: #fcfbe8;">
                <i class="fas fa-tachometer-alt icon-space"></i> Dashboard
            </a>
            <a class="sidebarimage img-fluid" href="books">
                <i class="fas {{ Request::is('books') ? 'fa-book-open' : 'fa-book' }} icon-space"></i>Books
            </a>
            <a class="sidebarimage img-fluid" href="teacher">
                <i
                    class="fas {{ Request::is('teacher') ? 'fa-chalkboard-teacher-open' : 'fa-chalkboard-teacher' }} icon-space"></i>Teachers
            </a>
            <a class="sidebarimage img-fluid" href="parent">
                <i
                    class="fas {{ Request::is('parent') ? 'fa-user-friends-open' : 'fa-user-friends' }} icon-space"></i>Parents
            </a>
            <a class="sidebarimage img-fluid" href="children">
                <i class="fas fa-users icon-space"></i>Childrens
            </a>
            <a class="sidebarimage img-fluid" href="reports">
                <i class="fas {{ Request::is('reports') ? 'fa-file-alt-open' : 'fa-file-alt' }} icon-space"></i>Reports
            </a>
            <a class="sidebarimage img-fluid" href="progress">
                <i
                    class="fas {{ Request::is('progress') ? 'fa-chart-line-open' : 'fa-chart-line' }} icon-space"></i>Progress
            </a>
            <a class="sidebarimage img-fluid" href="logs">
                <i class="fas {{ Request::is('logs') ? 'fa-clipboard-list' : 'fa-clipboard' }} icon-space"></i> Logs
            </a>


        </div>

        <div class="content">
            <div class="container mt-5">
                <div class="row">
                    <!-- Chart 1 -->
                    <div class="col-lg-4 col-md-6 col-12">
                        <div class="chart-container">
                            <h5 class="chart-title">Quiz Taken Data</h5>
                            <canvas id="quizTakenChart"></canvas>
                        </div>
                    </div>
        
                    <!-- Chart 2 -->
                    <div class="col-lg-4 col-md-6 col-12">
                        <div class="chart-container">
                            <h5 class="chart-title">Reports Data</h5>
                            <canvas id="reportsChart"></canvas>
                        </div>
                    </div>
        
                    <!-- Chart 3 -->
                    <div class="col-lg-4 col-md-6 col-12">
                        <div class="chart-container">
                            <h5 class="chart-title">Progress Data</h5>
                            <canvas id="progressChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        
            <!-- Chart.js CDN -->
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        
            <!-- JavaScript for Chart.js -->
            <script>
         const quizTakenChart = new Chart(document.getElementById('quizTakenChart').getContext('2d'), {
    type: 'bar',
    data: {
        labels: @json($initialQuizTakenData->pluck('gradeLevel')),
        datasets: [{
            label: 'Number of Children Who Took the Quiz',
            data: @json($initialQuizTakenData->pluck('childrenCount')), // Access the children count
            backgroundColor: 'rgba(75, 192, 192, 0.6)',
            borderColor: 'rgba(75, 192, 192, 1)',
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true,
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});


const reportsChart = new Chart(document.getElementById('reportsChart').getContext('2d'), {
    type: 'line',
    data: {
        labels: @json($initialReportsData->pluck('gradeLevel')),
        datasets: [{
            label: 'Total Scores in Reports Generated',
            data: @json($initialReportsData->pluck('totalScore')), // Access the total scores
            backgroundColor: 'rgba(255, 99, 132, 0.6)',
            borderColor: 'rgba(255, 99, 132, 1)',
            borderWidth: 1,
            fill: true
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true,
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});

const progressChart = new Chart(document.getElementById('progressChart').getContext('2d'), {
    type: 'pie',
    data: {
        labels: @json($initialProgressData->pluck('gradeLevel')),
        datasets: [{
            label: 'Total Scores by Grade Level',
            data: @json($initialProgressData->pluck('totalScore')), // Access the total scores
            backgroundColor: [
                'rgba(54, 162, 235, 0.6)',
                'rgba(255, 206, 86, 0.6)',
                'rgba(75, 192, 192, 0.6)',
                'rgba(153, 102, 255, 0.6)',
                'rgba(255, 159, 64, 0.6)'
            ],
            borderColor: [
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true
    }
});

            </script>
            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    var spinner = document.getElementById("spinner");
                    spinner.classList.add("d-none");
                });
            </script>
</body>

</html>

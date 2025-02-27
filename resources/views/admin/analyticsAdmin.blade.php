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
    @vite(['resources/css/app.css'])
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


    .flipbook-image {
        max-width: 100%;
        max-height: 300px;
        object-fit: cover;
        aspect-ratio: 3/4; /* Portrait aspect ratio */
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);



    }

    /* Responsive adjustments */
    @media (max-width: 767px) {
        .flipbook-info {
            flex-direction: column;
            align-items: center;
        }
    }.container-center {
    display: flex;
    flex-direction: column;

    height: 100vh; /* Full viewport height */
    gap: 20px; /* Optional: Adds spacing between the sections */
}

.text-center {
    width: 100%; /* Ensures content spans the width */
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
            <a class="sidebarimage img-fluid" href="dashboard" >
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
            <a class="sidebarimage img-fluid" href="analytics" style="background-color: #fcfbe8;">
                <i class="fas {{ Request::is('analytics') ? 'fa-chart-bar' : 'fa-bar-chart' }} icon-space"></i> Analytics
            </a>

            <a class="sidebarimage img-fluid" href="logs">
                <i class="fas {{ Request::is('logs') ? 'fa-clipboard-list' : 'fa-clipboard' }} icon-space"></i> Logs
            </a>


        </div>

        <div class="content">
            {{-- THIS WEEK --}}

            <select id="timeFilter" class="form-select w-auto">
                <option value="week">This Week</option>
                <option value="last_week">Last Week</option>
                <option value="month">This Month</option>
                <option value="last_month">Last Month</option>
                <option value="year">This Year</option>
                <option value="last_year">Last Year</option>
            </select>




            <div class="container mt-5">
                <h1 style="text-align: center;">AnalyticS Reports</h1>
                <br>
                <div class="row mb-4">
                    <!-- Quiz Taken Data Chart -->
                    <div class="col-lg-8 col-md-12 mb-4">
                        <div class="chart-container bg-white p-3 shadow-sm rounded">
                            <h5 class="text-center font-weight-bold text-gray-700 mb-4">Quiz Taken Data</h5>
                            <canvas id="quizTakenChart" ></canvas> <!-- Set height -->
                        </div>
                    </div>

                    <!-- Progress Data Chart -->
                    <div class="col-lg-4 col-md-12 mb-4">
                        <div style="height: 465px;" class="chart-container bg-white p-3 shadow-sm rounded">
                            <h5 class="text-center font-weight-bold text-gray-700 mb-4">Progress Data</h5>
                            <canvas id="progressChart" style="height: 600px;"></canvas> <!-- Set height -->
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>
    <div class="container mt-5">
        <div class="d-flex justify-content-center align-items-start" style="margin-left: 250px;">
            <div class="text-center ms-3" style="margin-left: 200px;">
                <h3 class="mb-6">Most Used Flipbook: {{ $mostUsedBook->book_name ?? 'No Data' }}</h3>
                <p>Usage Count: {{ $mostUsedCount }}</p>

                @if($mostUsedBookImage)
                    <img src="{{ asset($mostUsedBookImage) }}" alt="Most Used Book Image" class="flipbook-image img-fluid">
                @else
                    <p>No image available</p>
                @endif
            </div>

            <div class="text-center mx-3">
                <h3>Least Used Flipbook: {{ $leastUsedBook->book_name ?? 'No Data' }}</h3>
                <p>Usage Count: {{ $leastUsedCount }}</p>
                @if($leastUsedBookImage)
                    <img src="{{ asset($leastUsedBookImage) }}" alt="Least Used Book Image" class="flipbook-image img-fluid">
                @else
                    <p>No image available</p>
                @endif
            </div>
        </div>
    </div>

<br><br><br><br>


    <script>
        // Fetch data function
        function fetchData(period) {
            var spinner = document.getElementById("spinner");
            spinner.classList.remove("d-none"); // Show spinner while fetching data

            fetch(`/admin/analytics?period=${period}`, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(response => response.json())
            .then(data => {
                updateCharts(data.quizTakenData, data.progressData);
                spinner.classList.add("d-none"); // Hide spinner after data is updated
            })
            .catch(error => {
                console.error('Error fetching data:', error);
                spinner.classList.add("d-none"); // Hide spinner in case of error
            });
        }

        // Chart update function
        function updateCharts(quizData, progressData) {
            // Update quiz chart
            quizTakenChart.data.labels = quizData.map(item => item.gradeLevel);
            quizTakenChart.data.datasets[0].data = quizData.map(item => item.childrenCount);
            quizTakenChart.update();

            // Update progress chart
            progressChart.data.labels = progressData.map(item => item.gradeLevel);
            progressChart.data.datasets[0].data = progressData.map(item => item.totalScore);
            progressChart.update();
        }

        // Initialize default charts with 'this week' data
        document.addEventListener("DOMContentLoaded", function() {
            fetchData('thisWeek'); // Fetch 'this week' data on page load
        });

        // Set up event listener for dropdown filter
        document.getElementById('timeFilter').addEventListener('change', function() {
            fetchData(this.value);
        });

        // Chart.js initial configuration for both charts
        const quizTakenChart = new Chart(document.getElementById('quizTakenChart').getContext('2d'), {
            type: 'bar',
            data: {
                labels: [],
                datasets: [{
                    label: 'Children Who Took Quiz',
                    data: [],
                    backgroundColor: 'rgba(75, 192, 192, 0.6)'
                }]
            },
            options: { responsive: true, scales: { y: { beginAtZero: true } } }
        });

        const progressChart = new Chart(document.getElementById('progressChart').getContext('2d'), {
            type: 'pie',
            data: {
                labels: [],
                datasets: [{
                    label: 'Total Scores by Grade Level',
                    data: [],
                    backgroundColor: ['rgba(54, 162, 235, 0.6)', 'rgba(255, 206, 86, 0.6)', 'rgba(75, 192, 192, 0.6)']
                }]
            },
            options: { responsive: true }
        });
    </script>

    <!-- Spinner visibility control -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var spinner = document.getElementById("spinner");
            spinner.classList.add("d-none"); // Ensure spinner is hidden on initial load
        });
    </script>

</body>

</html>

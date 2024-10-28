<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Storyhub</title>
    <link rel="icon" href="/image/logo.png" type="image/x-icon">

    <!--Links -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="icon" href="{{ asset('book\icon.png') }}" type="image/png">

    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/parents.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/table.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Inter:wght@600&family=Lobster+Two:wght@700&display=swap" rel="stylesheet">
    <style>
        /* Pagination Container */
        .pagination-wrapper {
         display: flex;
         justify-content: center;
         margin: 20px 0;
     }

     /* Pagination List */
     .pagination {
         display: flex;
         list-style: none;
         padding: 0;
         margin: 0;
     }

     /* Pagination Items */
     .pagination li {
         margin: 0 5px;
     }

     /* Pagination Links */
     .pagination a, .pagination span {
         display: block;
         padding: 10px 15px;
         font-size: 16px;
         color: #007bff; /* Bootstrap primary color */
         text-decoration: none;
         border: 1px solid #dee2e6; /* Bootstrap border color */
         border-radius: 5px;
         transition: background-color 0.2s ease, color 0.2s ease;
     }

     /* Active Pagination Link */
     .pagination .active span {
         background-color: #007bff;
         color: #fff;
         border-color: #007bff;
     }

     /* Hover Effect */
     .pagination a:hover {
         background-color: #e9ecef; /* Light gray background */
         color: #0056b3; /* Darker blue for better contrast */
     }

     /* Disabled Links */
     .pagination .disabled span {
         color: #6c757d; /* Bootstrap secondary color */
         cursor: not-allowed;
         background-color: #f8f9fa; /* Light background for disabled state */
         border-color: #dee2e6;
     }

</style>


</head>
<body>
    @Include('sweetalert::alert')
<div class="all">
    <div id="spinner" class=" show position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <div class="header d-flex justify-content-between align-items-center fixed-top">
        <a href="{{ route('admin.reports') }}" style="text-decoration: none;"class="d-flex align-items-center">

          <h1 class="m-0 text-primary text-orange"><i class="fa fa-book-reader me-3"></i>StoryHub</h1>
        </a>
        <div class="dropdown-center">
            <div class="dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">

                <span style="font-weight:bold;" class="name">Admin</span>

            </div>
            <ul class="dropdown-menu">
                <li class="text-center"><a class="dropdown-item" href="settings" style="text-decoration: none; color:black;">Account Settings</a></li>
                <li class="text-center"><hr class="dropdown-divider"></li>

                <li class="text-center">
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>

                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Logout
                    </a>
                </li>
            </ul>
        </div>
    </div>


    <div class="sidebar">
        <a class="sidebarimage img-fluid" href="dashboard" >
            <i class="fas fa-tachometer-alt icon-space"></i> Dashboard
        </a>
        <a class="sidebarimage img-fluid" href="books">
            <i class="fas {{ Request::is('books') ? 'fa-book-open' : 'fa-book' }} icon-space"></i> Books
        </a>
        <a class="sidebarimage img-fluid" href="teacher">
            <i class="fas {{ Request::is('teacher') ? 'fa-chalkboard-teacher-open' : 'fa-chalkboard-teacher' }} icon-space"></i> Teachers
        </a>
        <a class="sidebarimage img-fluid" href="parent" >
            <i class="fas {{ Request::is('parent') ? 'fa-user-friends-open' : 'fa-user-friends' }} icon-space"></i> Parents
        </a>
        <a class="sidebarimage img-fluid" href="children" >
             <i class="fas fa-users icon-space"></i>  Childrens
        </a>
        <a class="sidebarimage img-fluid" href="reports" style="background-color: #fcfbe8;">
            <i class="fas {{ Request::is('reports') ? 'fa-file-alt-open' : 'fa-file-alt' }} icon-space"></i> Reports
        </a>
        <a class="sidebarimage img-fluid" href="progress" >
            <i class="fas {{ Request::is('progress') ? 'fa-chart-line-open' : 'fa-chart-line' }} icon-space"></i> Progress
        </a>
        <a class="sidebarimage img-fluid" href="analytics">
            <i class="fas {{ Request::is('analytics') ? 'fa-chart-bar' : 'fa-bar-chart' }} icon-space"></i> Analytics
        </a>

        <a class="sidebarimage img-fluid" href="logs">
            <i class="fas {{ Request::is('logs') ? 'fa-clipboard-list' : 'fa-clipboard' }} icon-space"></i> Logs
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


             <br>
                <h1 style="text-align: center;">All Children Reports</h1>
                 <br>
          <form action="{{ route('admin.reports') }}" method="GET">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="mb-3 input-group">
                <input type="text" class="form-control" id="searchInput" name="search" placeholder="Search All Reports..." value="{{ request()->input('search') }}">
                <button class="btn btn-primary" type="submit">Search</button>
            </div>
        </div>
    </div>
</form>

            <div class="table-responsive">
                <table class="table table-striped table-bordered" id="reportsTable">
                    <thead class="thead-dark">
                        <tr>
                            <th>Parent Name</th>
                            <th>Child Name</th>
                            <th>Book Title</th>
                            <th>Total Score</th>
                            <th>Grade Level</th>
                            <th>Teacher Name</th>
                            <th>Date Taken</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($reports) > 0)
                            @foreach ($reports as $report)
                                <tr>
                                    <td>{{ $report->parentName }}</td>
                                    <td>{{ $report->childFirstName }}</td>
                                    <td>{{ $report->book_name }}</td>
                                    <td>{{ $report->total_score }}</td>
                                    <td>{{ $report->gradeLevel ?? 'N/A' }}</td>
                                    <td>
                                        @if($report->teacherName || $report->teacherLastName)
                                            {{ $report->teacherName ?? '' }} {{ $report->teacherLastName ?? '' }}
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td>{{ $report->date_taken }}</td>
                                </tr>
                            @endforeach

                        @else
                            <tr>
                                <td colspan="7" class="text-center">No data found</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
                   <!-- Pagination links -->
        <div class="d-flex justify-content-center">
             {{ $reports->appends(['search' => $search])->links() }}
        </div>
            </div>

        </div>

    </div>

</div>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var spinner = document.getElementById("spinner");
        spinner.classList.add("d-none");
      });
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<!-- Bootstrap JS and dependencies -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>



</body>
</html>

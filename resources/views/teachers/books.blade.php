<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Storyhub</title>
    <link rel="icon" href="{{ asset('book\icon.png') }}" type="image/png">
    <!-- Bootstrap core CSS -->


    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="{{ asset('css/ie10-viewport-bug-workaround.css') }}" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="{{ asset('css/starter-template.css') }}" rel="stylesheet">
    
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
    <link href="{{ asset('css/pagination.css') }}" rel="stylesheet">
    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Inter:wght@600&family=Lobster+Two:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">


    <style>
        .book-desc {
            display: none;
        }
        .show-more {
            cursor: pointer;
            color: blue;
        }

        /* Media queries for responsiveness */
        @media (max-width: 768px) {
            .btn-general {
                font-size: 1rem; /* Smaller font size */
                padding: 8px 16px; /* Smaller padding */
            }
            .book img {
                max-width: 150px; /* Smaller image */
            }
            .book span {
                font-size: 1rem; /* Smaller book name */
            }
            .book p {
                font-size: 0.875rem; /* Smaller description */
            }
        }

        @media (max-width: 360px) {
            .btn-general {
                font-size: 0.875rem; /* Even smaller font size */
                padding: 2px 4px;
                width: 20px; /* Even smaller padding */
            }
            .book img {
                max-width: 200px; /* Even smaller image */
            }
            .book span {
                font-size: 12px; /* Even smaller book name */
            }
            .book p {
                font-size: 2px; /* Even smaller description */
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

                <  <form id="logout-form" action="{{ route('teacher.logout') }}" method="POST" style="display: none;">
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
        <a class="sidebarimage img-fluid" href="dashboard">
            <i class="fas fa-tachometer-alt icon-space"></i> Dashboard
        </a>
        <a class="sidebarimage img-fluid" href="books"  style="background-color: #fcfbe8;">
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


        <div class="container">
            <div  class="mt-3 mr-4 d-flex justify-content-end ">
                
            </div>

          
      

  
        
          <form action="{{ route('teacher.books') }}" method="GET">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="mb-3 input-group">
                <input type="text" class="form-control" id="searchInput" name="search" placeholder="Search by Book Title..." value="{{ request()->input('search') }}">
                <button class="btn btn-primary" type="submit">Search</button>
            </div>
        </div>
    </div>
</form>


        <div class="text-center starter-template">
            <h1>View All Books</h1>
        </div>

    <div class="container">
    <!-- Filter Dropdown -->
  

<!-- Books Listing -->
<div class="row" id="bookList">
    @foreach($flipbooks as $fb)
      

       
        <div class="text-center col-6 col-sm-4 col-md-3 col-lg-2 book gif-item">
            <a href="{{ route('showbook', $fb->id) }}" style="float: left; clear: both;">
                <img class="img-thumbnail" alt="200x200" style="width: 100%; max-width: 150px; height: 200px;margin-left: 10px;" src="{{ asset(explode(',', $fb->images)[0]) }}" data-holder-rendered="true">
            </a>
            <br><br><br><br><br><br><br><br><br>
            <span style="font-size: 13px; font-weight: bold; color: #333;">{{ $fb->book_name }}</span>
            <p style="font-size: 11px; color: #666;">
                <span class="short-desc">{{ Str::limit($fb->desc, 50, '...') }}</span>
                <span class="full-desc book-desc" style="display: none;">{{ $fb->desc }}</span>
                <span class="show-more" style="cursor: pointer; color: blue;">Read more</span>
            </p>
            <a href="{{ route('editbook', $fb->id) }}" class="mt-2 w-100 d-block">
                <button id="add_files" class="btn btn-warning btn-medium btn-general input-block-level fs-5 w-100" type="submit">Edit</button>
            </a>
        </div>
     
    @endforeach
</div>

              <div class="d-flex justify-content-center">
          {{ $flipbooks->appends(['search' => $search])->links() }}
        </div>
          </div>
      </div>
      <script>
          document.addEventListener('DOMContentLoaded', function () {
              document.querySelectorAll('.show-more').forEach(function (element) {
                  element.addEventListener('click', function () {
                      const shortDesc = this.previousElementSibling.previousElementSibling;
                      const fullDesc = this.previousElementSibling;
                      
                      if (fullDesc.style.display === 'none') {
                          fullDesc.style.display = 'inline'; // Show full description
                          shortDesc.style.display = 'none'; // Hide short description
                          this.textContent = 'Read less';
                      } else {
                          fullDesc.style.display = 'none'; // Hide full description
                          shortDesc.style.display = 'inline'; // Show short description
                          this.textContent = 'Read more';
                      }
                  });
              });
          });
        

      </script>
      
      
      <!-- Bootstrap JS and dependencies -->
      <script src="{{ asset('js/jquery.min.js') }}"></script>
      <script src="{{ asset('css/js/search.js') }}"></script>
      <script>window.jQuery || document.write('<script src="{{ asset('js/jquery.min.js') }}"><\/script>')</script>
      <script src="{{ asset('js/bootstrap.min.js') }}"></script>
      <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
      <script src="{{ asset('js/ie10-viewport-bug-workaround.js') }}"></script>
      
      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
      <!-- Bootstrap JS and dependencies -->
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
 <script>
    document.addEventListener("DOMContentLoaded", function() {
        var spinner = document.getElementById("spinner");
        spinner.classList.add("d-none");
      });
</script>
      </body>
      </html>
      
      
      
      
      
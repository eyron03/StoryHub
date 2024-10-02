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

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="img/favicon.ico" rel="icon">
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/parents.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/pagination.css') }}" rel="stylesheet">
    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Inter:wght@600&family=Lobster+Two:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
       
            .search-bar-container {
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                z-index: 1000; 
                background-color: #fff; 
                padding: 10px 0; 
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            }

        #search-input {
            padding: 10px;
            width: 300px; /* Adjust the width as needed */
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        #search-button {
            padding: 10px 20px;
            background-color: #007bff; /* Example color, adjust as needed */
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        #search-button:hover {
            background-color: #0056b3; /* Example color, adjust as needed */
        }

        
            .input-group {
                display: flex;
                flex-wrap: nowrap;
            }
            #search-input {
                flex: 1 1 auto;
            }
            #search-button {
                flex: 0 1 auto;
            }
          
            
       
    </style>

</head>
<body>
<div class="all">
    <div class="header d-flex justify-content-between align-items-center fixed-top">
        <div class="header d-flex justify-content-between align-items-center fixed-top">
            <a href="{{ route('parent.storytime') }}" style="text-decoration: none;" class="d-flex align-items-center">
                <h1 class="m-0 text-primary text-orange"><i class="fa fa-book-reader me-3"></i>StoryHub</h1>
            </a>
            @if(isset($childId))
            <div>
              <b>Hello {{ $childId->childFirstName }}</b>
    
            </div>
        @endif
        </div>
      

        </div>
    </div>
    <div style="font-weight: bold;" class="sidebar">
        <a class="sidebarimage img-fluid" href="{{ route('parents.dashboard') }}" >
            <i class="fas fa-tachometer-alt icon-space"></i> Dashboard
        </a>
        <a class="sidebarimage img-fluid" href="{{ route('parent.MyKids') }}">
            <i class="fas fa-child icon-space"></i> My Kids
        </a>
        <a class="sidebarimage img-fluid" href="{{ route('parent.storytime') }}">
            <i class="fas fa-book-open icon-space"></i> StoryTime
        </a>
        <a class="sidebarimage img-fluid" href="{{ route('parent.reports') }}">
            <i class="fas fa-file-alt icon-space"></i> Reports
        </a>
        <a class="sidebarimage img-fluid" href="{{ route('parent.progress') }}" >
            <i class="fas fa-chart-line icon-space" ></i> Progress
        </a>
    </div>
    <div class="content">
        
        <div class="container">
         
    
            <br>
            <br>
            <br>
            <form action="{{ route('parent.storybook',['childId' => $childId]) }}" method="GET">
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
                <h1 style="margin-left:-60px;">Read and Learn</h1>
                <p  style="margin-left:-60px;" class="lead">Enjoy Reading! 😊</p>
            </div>
    
            <div class="row" id="bookList">
                <!-- Book elements -->
                @foreach($flipbooks as $fb)
                    <div class="text-center col-6 col-sm-4 col-md-3 col-lg-2 book" >
                        <a href="{{ route('parent.bookshow', ['id' => $fb->id, 'childId' => $childId]) }}" class="book-thumbnail" data-book-id="{{ $fb->id }}" data-child-id="{{ $childId }}">
                            <img class="img-thumbnail" alt="200x200" style="width: 100%; max-width: 150px; height: 200px; margin-left:-15px; " src="{{ asset(explode(',', $fb->images)[0]) }}" data-holder-rendered="true">
                         
                            
                        </a>
                        <br><br>
                        <span style="font-size: 13px; font-weight: bold; color: #333;  margin-left:-20px;">{{ $fb->book_name }}</span>
              
                        <p style="font-size: 12px; color: #666; text-align: left; margin-left: 0px;">
                            <span class="short-desc">{{ Str::limit($fb->desc, 50, '...') }}</span>
                            <span class="full-desc book-desc" style="display: none;">{{ $fb->desc }}</span>
                            <span class="show-more" style="cursor: pointer; color: blue;">Read more</span>
                        </p>
                        
                        
                        
                    </div>
                @endforeach
            </div>
            <div class="mt-4 pagination-wrapper d-flex justify-content-center">
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

</body>
</html>





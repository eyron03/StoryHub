<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Storyhub</title>
    <link rel="icon" href="{{ asset('book\icon.png') }}" type="image/png">

    <!-- Links -->
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
    <link href="{{ asset('css/pagesButton.css') }}" rel="stylesheet">
    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Inter:wght@600&family=Lobster+Two:wght@700&display=swap" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="{{ asset('extras/modernizr.2.5.3.min.js') }}"></script>

    <style>
        body, html {
            overflow: hidden; /* Disable scrolling */
            height: 100%; /* Full height to ensure no scrolling */
        }
        @media (max-width: 576px) {
            body, html {
                overflow: hidden; /* No scrolling on small screens */
            }

            .content {
                overflow: hidden;
                height: 100vh; /* Ensure content takes full height without scroll */
            }
        }

        .all {
            height: 100%; /* Full height for the main container */
            display: flex;
            flex-direction: column;
        }

        .header {
            flex: 0 0 auto; /* Keep header height fixed */
        }

        #quizButton {
            display: none;
            position: fixed;
            bottom: -5px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 999;
        }

        @media (max-width: 768px) {
            #quizButton {
                bottom: auto;
                top: 520px;
                left: 170px;
            }
            .questions-section {
                display: none;
                margin-top: 20px;
            }
        }
     
        .page-1-background {
            background-image: url('{{ asset('book/front1.png') }}');
            background-size: 530px 610px; 
             background-position: 50% 74.5%;
            background-repeat: no-repeat;
            margin-top: 800px;
            margin-left:800px
        }

   
        .page-last-background {
            background-image: url('{{ asset('book/back1.png') }}');
            background-size: 530px 610px; /* Width and height in pixels */
            background-position: 52% 74.5%; /* Move the background 20% from the left */
            background-repeat: no-repeat;
            margin-top: 800px;
            margin-left:800px
          
        }

        .page-2-background {
            background-image: url('{{ asset('book/pages1.png') }}');
            background-size: 1010px 665px; /* Width and height in pixels */
            background-position: 52% 95%; /* Move the background 20% from the left */
            background-repeat: no-repeat;
            margin-top: 800px;
        }
        
        @media (max-width: 992px) {
            .page-2-background {
                background-size: 800px 520px; /* Adjust size for medium screens */
                margin-top: 500px; /* Adjust margin for medium screens */
            }
        }
        
        /* Small screens (phones) */
        @media (max-width: 768px) {
            .page-2-background {
                background-size: 600px 390px; /* Adjust size for small screens */
                margin-top: 790px; /* Adjust margin for small screens */
            }
        }
        
        /* Extra small screens (small phones) */
        @media (max-width: 576px) {
            .page-2-background {
                background-size: 358px 235px; /* Adjust size for extra small screens */
                background-position: 10% 51%;
            }
            .page-1-background 
            {
                background-size: 190px 210px; /* Adjust size for extra small screens */
                background-position: 45% 51%;
                
            }
            .page-last-background
            {
                background-size: 190px 210px; /* Adjust size for extra small screens */
                background-position: 50% 51%;
                
            }
          
        }

        
    </style>
</head>
<body style="overflow-auto; max-height: 1vh;">

<div class="all">
    <div class="header d-flex justify-content-between align-items-center fixed-top">
        <a href="#" style="text-decoration: none;" class="d-flex align-items-center">
            <h1 class="m-0 text-primary text-orange"><i class="fa fa-book-reader me-3"></i>StoryHub</h1>
        </a>
    </div>

    <div class="content">
        <a href="javascript:history.back()" class="btn btn-primary" style="position: fixed; top: 90px; left: 20px;"><i class="fa fa-arrow-left"></i> Back</a>
        <div class="flipbook-viewport">
            <div class="container">
                <div class="flipbook">
                    @foreach($images as $page)
                        <div style="background-image:url({{ asset($page) }})"></div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-between">
            <button class="btn btn-primary" id="prevPage"  ><i class="fa fa-arrow-left"> </button>
            <button class="btn btn-primary" id="nextPage"  > <i class="fa fa-arrow-right"></button>
        </div>
        <a href="{{ route('showquiz', ['id' => $flipbooks->id]) }}" class="btn btn-primary" id="quizButton">Next</a>
    </div>
</div>

<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-1.11.0.min.js"></script>
<script src="https://www.turnjs.com/lib/turn.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<script>
    function loadApp() {
        function calculateDimensions() {
            var windowWidth = $(window).width();
            var windowHeight = $(window).height();
            var bookWidth, bookHeight;
    
            if (windowWidth >= 992) {
                bookWidth = 922;
                bookHeight = 600;
            } else {
                bookWidth = windowWidth * 0.9;
                bookHeight = bookWidth * (600 / 922);
            }
    
            return {
                width: Math.floor(bookWidth),
                height: Math.floor(bookHeight)
            };
        }
    
        // Set the initial background to page-1-background
        $('body').addClass('page-1-background');
    
        $('.flipbook').turn({
            width: calculateDimensions().width,
            height: calculateDimensions().height,
            elevation: 50,
            gradients: true,
            autoCenter: true,
            duration: 1000,
            when: {
                turning: function (e, page, view) {
                    var totalPages = $('.flipbook').turn('pages');
                    var secondToLastPage = totalPages - 1;
    
                    $('body').removeClass('page-1-background page-last-background');
    
                    if (page === 1) {
                        $('body').addClass('page-1-background');
                        $('body').removeClass('page-2-background');
                        $('#prevPage').hide(); // Hide Previous button on the first page
                    } else if (page === totalPages) {
                        $('body').addClass('page-last-background');
                        $('body').removeClass('page-2-background');
                        $('#nextPage').hide(); // Hide Next button on the last page
                    } else if (page >= 2 && page <= secondToLastPage) {
                        $('body').addClass('page-2-background');
                        $('#prevPage, #nextPage').show(); // Show both buttons on other pages
                    }
                },
                turned: function (e, page, view) {
                    currentPage = page;
                    var totalPages = $('.flipbook').turn('pages');
    
                    if (page === totalPages) {
                        $('#quizButton').show();
                        $('#nextPage').hide(); // Hide Next button on the last page
                    } else if (page === 1) {
                        $('#prevPage').hide(); // Hide Previous button on the first page
                    } else {
                        $('#quizButton').hide();
                        $('#prevPage, #nextPage').show(); // Show both buttons on other pages
                    }
                }
            }
        });
    
        // Event listeners for Next and Previous buttons
        $('#nextPage').click(function() {
            $('.flipbook').turn('next');
        });

        $('#prevPage').click(function() {
            $('.flipbook').turn('previous');
        });
    
        $(window).on('resize', function () {
            var dimensions = calculateDimensions();
            $('.flipbook').turn('size', dimensions.width, dimensions.height);
        });
    }

    yepnope({
        test: Modernizr.csstransforms,
        yep: ['{{ asset('lib/turn.js') }}'],
        nope: ['{{ asset('lib/turn.html4.min.js') }}'],
        both: ['{{ asset('css/basic.css') }}'],
        complete: loadApp
    });
</script>
<script>
    window.onload = function() {
        // Show the nextPage button when the page is fully loaded
        document.getElementById('nextPage').style.display = 'block';
    };
</script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>

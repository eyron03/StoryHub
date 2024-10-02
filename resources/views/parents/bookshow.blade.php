<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Storyhub</title>
    <link rel="icon" href="{{ asset('book\icon.png') }}" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script&family=Dosis&family=Gajraj+One&family=Madimi+One&family=Roboto:wght@300&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Fjalla+One&family=Hammersmith+One&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="img/favicon.ico" rel="icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/parents.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/overlay.css') }}" rel="stylesheet">
    <link href="{{ asset('css/pagesButton.css') }}" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Inter:wght@600&family=Lobster+Two:wght@700&display=swap" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="{{ asset('extras/modernizr.2.5.3.min.js') }}"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/basic.css') }}">
    <style>
     
        @media (max-width: 768px) {
            #quizButton {
                bottom: auto;
                top: 530px; /* Adjust this value as needed */
                left: 170px; /* Adjust this value as needed */
            }
        }

         /* Background for the first page */
         .page-1-background {
            background-image: url('{{ asset('book/front1.png') }}');
            background-size: 530px 610px; /* Width and height in pixels */
             background-position: 50% 74.5%;
            background-repeat: no-repeat;
            margin-top: 800px;
            margin-left:800px
        }

        /* Background for the last page */
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

       
        #overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.8); /* Semi-transparent black background */
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1000; /* Make sure it's above other content */
            overflow: hidden; /* Prevent scrolling */
        }
        
        .overlay-message {
            color: white;
            font-size: 24px;
            text-align: center;
            padding: 20px;
            background: rgba(0, 0, 0, 0.5); /* Semi-transparent black background */
            border-radius: 10px;
        }
        
        /* Medium screens (tablets) */
        @media (max-width: 992px) {
            .overlay-message {
                font-size: 20px;
                margin-left: 40px; /* Adjust margin for medium screens */
              
            }
        }
        
        /* Small screens (phones) */
        @media (max-width: 768px) {
            .overlay-message {
                font-size: 18px;
                margin-left: 100px; /* Adjust margin for small screens */
               
            }
        }
        
        /* Extra small screens (small phones) */
        @media (max-width: 576px) {
            .overlay-message {
                font-size: 14px;
                margin-left: -80px;
                margin-top:-140px; /* Adjust margin for extra small screens */
                
            }
        }
        
    </style>
</head>
<body>
    <audio autoplay loop hidden>
        <source src="{{ asset('audio/backgroundMusic.mp3') }}" type="audio/mpeg">
        Your browser does not support the audio element.
    </audio>
    <div class="all">
        <div class="header d-flex justify-content-between align-items-center fixed-top">
            <a href="{{ route('parent.storybook', [ 'childId' => $childId]) }}" style="text-decoration: none;" class="d-flex align-items-center">
                <h1 class="m-0 text-primary text-orange"><i class="fa fa-book-reader me-3"></i>StoryHub</h1>
            </a>
            @if(isset($childId))
            <div>
              <b>Hello {{ $childId->childFirstName }}</b>
            </div>
            @endif
        </div>
        <a href="{{ route('parent.storybook', [ 'childId' => $childId]) }}" class="btn btn-primary" style="position: fixed; top:90px; left: 20px;">  <i class="fa fa-arrow-left"></i> Back       </a>
        
        <div class="content">
            <div class="flipbook-viewport">
                <div class="container">
                    <div class="flipbook">
                        @foreach($images as $page)
                        <div class="flipbook-page" style="background-image: url({{ asset($page) }});"></div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-between">
            <button class="btn btn-primary" id="prevPage"  ><i class="fa fa-arrow-left"> </button>
            <button class="btn btn-primary" id="nextPage"  > <i class="fa fa-arrow-right"></button>
        </div>
        <div class="button-container">
            <a href="#" class="btn btn-primary" id="quizButton">Quiz now?</a>
        </div>
    </div>
    <div id="overlay" onclick="off()">
        <div class="overlay-message">
            <span class="arrow-left">&#8592;</span>
            Swipe Left or Right to Navigate
            <span class="arrow-right">&#8594;</span>
        </div>
    </div>
    
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <script>
        $(document).ready(function() {
            var currentPage = 0;
            var childId = "{{ $childId }}";
            var flipbookId = "{{ $flipbook->id }}";
    
            function storeReadingProgress() {
                localStorage.setItem('readingProgress_' + childId + '_' + flipbookId, currentPage);
            }
    
            function loadReadingProgress() {
                if (typeof(Storage) !== "undefined") {
                    var readingProgress = localStorage.getItem('readingProgress_' + childId + '_' + flipbookId);
                    if (readingProgress && parseInt(readingProgress) !==1) {
                        Swal.fire({
                            title: 'Continue Reading?',
                            text: 'You left off at page ' + readingProgress + '. Do you want to continue from where you left off?',
                            icon: 'info',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Yes, continue!',
                            cancelButtonText: 'No, start from the beginning',
                            customClass: {
                                popup: 'responsive-swal-dialog'
                            }
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $('.flipbook').turn('page', parseInt(readingProgress));
                            } else {
                                console.log("Start from the beginning");
                            }
                        });
                    }
                } else {
                    console.log("error.");
                }
            }
    
            window.addEventListener('beforeunload', function() {
                storeReadingProgress();
            });
    
            $('body').addClass('page-1-background');
    
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
                            } else if (page === totalPages) {
                                $('body').addClass('page-last-background');
                                $('body').removeClass('page-2-background'); 
                            } else if (page >= 2 && page <= secondToLastPage) {
                                $('body').addClass('page-2-background');
                            }
    
                            // Update navigation buttons on page turn
                            updateNavigationButtons(page, totalPages);
                        },
                        turned: function (e, page, view) {
                            currentPage = page;
                            var totalPages = $('.flipbook').turn('pages');
    
                            if (page === totalPages) {
                                $('#quizButton').show();
                            } else {
                                $('#quizButton').hide();
                            }
                        }
                    }
                });
    
                $(window).on('resize', function () {
                    var dimensions = calculateDimensions();
                    $('.flipbook').turn('size', dimensions.width, dimensions.height);
                });
    
                var totalPages = $('.flipbook').turn('pages');
                updateNavigationButtons(currentPage, totalPages);
    
                $('#overlay').show();
            }
    
            yepnope({
                test: Modernizr.csstransforms,
                yep: ['{{ asset('lib/turn.js') }}'],
                nope: ['{{ asset('lib/turn.html4.min.js') }}'],
                both: ['{{ asset('css/basic.css') }}'],
                complete: loadApp
            });
    
            loadReadingProgress();
    
            $('#quizButton').on('click', function () {
                Swal.fire({
                    title: 'Quiz Now?',
                    text: 'Do you want to start the quiz now?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, start now!',
                    cancelButtonText: 'Later',
                    customClass: {
                        popup: 'responsive-swal-dialog'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "{{ route('parent.quizshow', ['id' => $flipbook->id, 'childId' => $childId]) }}";
                    } else {
                        window.location.href = "{{ route('parent.storybook', ['childId' => $childId]) }}";
                    }
                });
            });
    
            $('#overlay').on('click', function () {
                off();
            });
    
            function off() {
                $('#overlay').hide();
            }
    
           
            $('#nextPage').on('click', function() {
                $('.flipbook').turn('next');
            });
    
            $('#prevPage').on('click', function() {
                $('.flipbook').turn('previous');
            });
    
            function updateNavigationButtons(page, totalPages) {
                if (page === 1) {
                    $('#prevPage').hide();
                } else {
                    $('#prevPage').show();
                }
    
                if (page === totalPages) {
                    $('#nextPage').hide();
                } else {
                    $('#nextPage').show();
                }
            }
        });
    </script>
    
    <script>
        $(document).ready(function() {
            
            const audio = document.getElementById('background-audio');

            
            const isPlaying = localStorage.getItem('isAudioPlaying') === 'true';
            if (isPlaying) {
                const savedTime = localStorage.getItem('audioCurrentTime');
                if (savedTime) {
                    audio.currentTime = parseFloat(savedTime);
                }
                audio.play();
            } else {
                audio.pause();
            }

           
            setInterval(() => {
                localStorage.setItem('audioCurrentTime', audio.currentTime);
            }, 1000);


            window.addEventListener('beforeunload', () => {
                localStorage.setItem('audioCurrentTime', audio.currentTime);
                localStorage.setItem('isAudioPlaying', !audio.paused);
            });

           
            audio.addEventListener('ended', () => {
                localStorage.setItem('isAudioPlaying', 'false');
            });
        });
    </script>
</body>
</html>

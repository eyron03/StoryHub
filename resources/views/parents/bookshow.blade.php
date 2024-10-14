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

    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/parents.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/pagesButton.css') }}" rel="stylesheet">
    <link href="{{ asset('css/mediaQuery.css') }}" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Inter:wght@600&family=Lobster+Two:wght@700&display=swap" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="{{ asset('extras/modernizr.2.5.3.min.js') }}"></script>
    @vite(['resources/css/app.css'])
    <style>
     
      
        body, html {
            height: 100%;
            overflow: hidden; /* Disable scrolling */
            margin: 0; /* Remove default margins */
            position: relative;
        }
        
        #background {
            position: absolute;
            top: 9%; /* Align to the top */
            left: 0; /* Align to the left */
            width: 100%;
            height: 90%; /* Changed to full height */
            background-size: contain; /* Ensure the background image is contained */
            background-position: center; /* Center the background image */
            background-repeat: no-repeat; /* Avoid repeating */
            z-index: -1; /* Position it behind other elements */
            transition: background-image 0.5s ease;
        }
        
        .flipbook-viewport {
            position: relative; /* Ensure the viewport is positioned above the background */
            z-index: 1;
            display: flex; /* Center the flipbook */
            justify-content: center;
            align-items: center;
            top: -6.3%;
            height: 100vh; /* Ensure full height for viewport */
        }
        
        .flipbook {
            max-width: 100%; /* Prevent overflow */
            max-height: 100%; /* Prevent overflow */
        }
        
        .flipbook div {
            background-size: contain; /* Change this to fit the content appropriately */
            background-position: center;
            background-repeat: no-repeat;
            width: 100%; /* Make flipbook pages fill the parent */
            height: 100%; /* Make flipbook pages fill the parent */
        }
        /* Extra small screens (small phones) */
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
    <div id="spinner" class="bg-white show position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
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
            <a href="javascript:history.back()" class="btn btn-primary" style="position: fixed; top: 90px; left: 20px;">
                <i class="fa fa-arrow-left"></i> Back
            </a>
            <div id="background" class="absolute inset-0 z-0 bg-center bg-cover">
                <div class="flex items-center justify-center h-screen flipbook-viewport">
                    <div class="flex items-center justify-center w-full h-full">
                        <div class="flex items-center justify-center flipbook">
                            @foreach($images as $page)
                                <div class="flex items-center justify-center w-full h-full" style="background-image: url({{ asset($page) }}); background-size: contain; background-position: center; background-repeat: no-repeat;">
                                    <img src="{{ asset($page) }}" alt="Page Image" class="object-cover w-full h-full" />
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
    
            <div class="d-flex">
                <button class="btn btn-primary" id="prevPage"><i class="fa fa-arrow-left"></i></button>
                <button class="btn btn-primary" id="nextPage"><i class="fa fa-arrow-right"></i></button>
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
            var childId = "{{ $childId }}";
            var flipbookId = "{{ $flipbook->id }}";
            var currentPage = 1; // Start on page 1
    
            function storeReadingProgress() {
                localStorage.setItem('readingProgress_' + childId + '_' + flipbookId, currentPage);
            }
    
            function loadReadingProgress() {
                if (typeof(Storage) !== "undefined") {
                    var readingProgress = localStorage.getItem('readingProgress_' + childId + '_' + flipbookId);
                    if (readingProgress && parseInt(readingProgress) !== 1) {
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
                    console.log("Error: Local storage is not supported.");
                }
            }
    
            window.addEventListener('beforeunload', function() {
                storeReadingProgress();
            });
    
            function calculateDimensions() {
                const windowWidth = $(window).width();
                const windowHeight = $(window).height();
                let bookWidth, bookHeight;
    
                if (windowWidth >= 992) {
                    bookWidth = 922; // Desktop size
                    bookHeight = 600;
                } else {
                    bookWidth = windowWidth * 0.9; // Scale down for smaller screens
                    bookHeight = bookWidth * (600 / 922); // Maintain aspect ratio
                }
    
                return { width: Math.floor(bookWidth), height: Math.floor(bookHeight) };
            }
    
            function loadApp() {
                const flipbook = $('.flipbook');
    
                flipbook.turn({
                    width: calculateDimensions().width,
                    height: calculateDimensions().height,
                    elevation: 50,
                    gradients: true,
                    autoCenter: true,
                    duration: 1000,
                    when: {
                        turning: function(event, page) {
                            currentPage = page; // Update current page
                            const totalPages = flipbook.turn('pages');
                            let backgroundImage;
    
                            // Ensure the same sizing and aspect ratio for all images
                            if (page === 1) {
                                // backgroundImage = '{{ asset('book/front1.png') }}';
                            } else if (page === totalPages) {
                                // backgroundImage = '{{ asset('book/back1.png') }}';
                            } else {
                                backgroundImage = '{{ asset('book/pages1.png') }}';
                            }
    
                            // Set background uniformly
                            $('#background').css({
                                'background-image': `url(${backgroundImage})`,
                                'background-size': 'contain',
                                'background-position': 'center',
                                'background-repeat': 'no-repeat'
                            });
                        },
                        turned: function(event, page) {
                            currentPage = page; // Update current page on turn
                            const totalPages = flipbook.turn('pages');
                            $('#quizButton').toggle(page === totalPages);
                            $('#prevPage').toggle(page !== 1);
                            $('#nextPage').toggle(page !== totalPages);
                        }
                    }
                });
    
                $('#nextPage').on('click', () => flipbook.turn('next'));
                $('#prevPage').on('click', () => flipbook.turn('previous'));
    
                $(window).on('resize', () => {
                    const { width, height } = calculateDimensions();
                    flipbook.turn('size', width, height);
                });
    
                // Ensure overlay is hidden on click
                $('#overlay').on('click', function() {
                    off();
                });
            }
    
            function off() {
                $('#overlay').hide(); // Hides the overlay
            }
    
            yepnope({
                test: Modernizr.csstransforms,
                yep: ['{{ asset('lib/turn.js') }}'],
                nope: ['{{ asset('lib/turn.html4.min.js') }}'],
                complete: loadApp
            });
    
            loadReadingProgress();
    
            $('#quizButton').on('click', function() {
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
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var spinner = document.getElementById("spinner");
            spinner.classList.add("d-none");
          });
    </script>
</body>
</html>

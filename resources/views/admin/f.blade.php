@vite(['resources/css/app.css'])



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Storyhub</title>
    <link rel="icon" href="{{ asset('book/icon.png') }}" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/parents.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/pagesButton.css') }}" rel="stylesheet">
    <link href="{{ asset('css/mediaQuery.css') }}" rel="stylesheet">
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
        top: -5%;
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
    
</style>  
</head>
<body>

    <div class="all">
        <div class="header d-flex justify-content-between align-items-center fixed-top">
            <a href="#" style="text-decoration: none;" class="d-flex align-items-center">
                <h1 class="m-0 text-primary text-orange"><i class="fa fa-book-reader me-3"></i>StoryHub</h1>
            </a>
        </div>
    
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
    
            <a href="{{ route('showquiz', ['id' => $flipbooks->id]) }}" class="btn btn-primary" id="quizButton">Next</a>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-1.11.0.min.js"></script>
    <script src="https://www.turnjs.com/lib/turn.min.js"></script>
    <script>
        function loadApp() {
            const flipbook = $('.flipbook');
    
            // Function to update the background image based on the current page
            function updateBackground(page, totalPages) {
                let backgroundImage, backgroundSize, backgroundPosition;
    
                // Conditional background and positioning for front and back pages
                if (page === 1) {
                    backgroundImage = '{{ asset('book/front1.png') }}';
                    backgroundSize = ($(window).width() < 576) ? '70%' : '40%'; // Adjust size for small screens
                    backgroundPosition = ($(window).width() < 576) ? '100%' : '60%'; 
                } else if (page === totalPages) {
                    backgroundImage = '{{ asset('book/back1.png') }}';
                    backgroundSize = ($(window).width() < 576) ? '60%' : '40%'; // Adjust size for small screens
                    backgroundPosition = ($(window).width() < 576) ? '40%' : '40%'; 
                } else {
                    backgroundImage = '{{ asset('book/pages1.png') }}';
                    backgroundSize = 'contain'; // Keep other pages the same
                    backgroundPosition = 'center'; // Keep other pages centered
                }
    
                // Set the background with dynamic size and position
                $('#background').css({
                    'background-image': `url(${backgroundImage})`,
                    'background-size': backgroundSize, // Apply size based on screen width
                    'background-position': backgroundPosition, // Adjust position for front/back
                    'background-repeat': 'no-repeat'
                });
            }
    
            // Function to calculate dimensions for the flipbook
            function calculateDimensions() {
                const windowWidth = $(window).width();
                const windowHeight = $(window).height();
                let bookWidth, bookHeight;
    
                if (windowWidth >= 992) {
                    bookWidth = 922; // Larger size for desktops
                    bookHeight = 600;
                } else {
                    bookWidth = windowWidth * 0.9; // Scale down for smaller screens
                    bookHeight = bookWidth * (600 / 922); // Maintain the aspect ratio
                }
    
                return { width: Math.floor(bookWidth), height: Math.floor(bookHeight) };
            }
    
            // Initialize flipbook with responsive size
            flipbook.turn({
                width: calculateDimensions().width,
                height: calculateDimensions().height,
                elevation: 50,
                gradients: true,
                autoCenter: true,
                duration: 1000,
                when: {
                    turning: function (event, page) {
                        const totalPages = flipbook.turn('pages');
                        updateBackground(page, totalPages); // Update background when turning
                    },
                    turned: function (event, page) {
                        const totalPages = flipbook.turn('pages');
                        $('#quizButton').toggle(page === totalPages); // Show quiz button on last page
                        $('#prevPage').toggle(page !== 1); // Hide prev button on first page
                        $('#nextPage').toggle(page !== totalPages); // Hide next button on last page
                    }
                }
            });
    
            // Set background on initial load (front page)
            const totalPages = flipbook.turn('pages');
            updateBackground(1, totalPages);
    
            // Next and Previous button handlers
            $('#nextPage').on('click', () => flipbook.turn('next'));
            $('#prevPage').on('click', () => flipbook.turn('previous'));
    
            // Resize flipbook dynamically when window is resized
            $(window).on('resize', () => {
                const { width, height } = calculateDimensions();
                flipbook.turn('size', width, height);
                updateBackground(flipbook.turn('page'), totalPages); // Update background on resize
            });
        }
    
        // Load the turn.js library and initialize the app
        yepnope({
            test: Modernizr.csstransforms,
            yep: ['{{ asset('lib/turn.js') }}'],
            nope: ['{{ asset('lib/turn.html4.min.js') }}'],
            complete: loadApp
        });
    </script>
    

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>


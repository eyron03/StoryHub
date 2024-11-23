<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Storyhub</title>
    <link rel="icon" href="{{ asset('book\icon.png') }}" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link
        href="https://fonts.googleapis.com/css2?family=Dancing+Script&family=Dosis&family=Gajraj+One&family=Madimi+One&family=Roboto:wght@300&display=swap"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Fjalla+One&family=Hammersmith+One&display=swap"
        rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="img/favicon.ico" rel="icon">

    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/parents.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/pagesButton.css') }}" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Inter:wght@600&family=Lobster+Two:wght@700&display=swap"
        rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="{{ asset('extras/modernizr.2.5.3.min.js') }}"></script>
    @vite(['resources/css/app.css'])
    <style>
        body,
        html {
            height: 100%;
            overflow: hidden;
            /* Disable scrolling */
            margin: 0;
            /* Remove default margins */
            position: relative;
        }

        #background {
            position: absolute;
            top: 9%;
            /* Align to the top */
            left: 0;
            /* Align to the left */
            width: 100%;
            height: 90%;
            /* Changed to full height */
            background-size: contain;
            /* Ensure the background image is contained */
            background-position: center;
            /* Center the background image */
            background-repeat: no-repeat;
            /* Avoid repeating */
            z-index: -1;
            /* Position it behind other elements */
            transition: background-image 0.5s ease;
        }

        .flipbook-viewport {
            position: relative;
            /* Ensure the viewport is positioned above the background */
            z-index: 1;
            display: flex;
            /* Center the flipbook */
            justify-content: center;
            align-items: center;
            top: -6.3%;
            height: 100vh;
            /* Ensure full height for viewport */
        }

        .flipbook {
            max-width: 100%;
            /* Prevent overflow */
            max-height: 100%;
            /* Prevent overflow */
        }

        .flipbook div {
            background-size: contain;
            /* Change this to fit the content appropriately */
            background-position: center;
            background-repeat: no-repeat;
            width: 100%;
            /* Make flipbook pages fill the parent */
            height: 100%;
            /* Make flipbook pages fill the parent */
        }
    </style>
</head>

<body>
    <div id="spinner"
        class="bg-white show position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <div class="all">
        <div class="header d-flex justify-content-between align-items-center fixed-top">
            <a href="{{ route('teacher.books') }}" style="text-decoration: none;" class="d-flex align-items-center">
                <h1 class="m-0 text-primary text-orange"><i class="fa fa-book-reader me-3"></i>StoryHub</h1>
            </a>
        </div>

        <div class="content">

            <div id="background" class="absolute inset-0 z-0 bg-center bg-cover">
                <div class="flex items-center justify-center h-screen flipbook-viewport">
                    <div class="flex items-center justify-center w-full h-full">
                        <div class="flex items-center justify-center flipbook">
                            @foreach ($images as $index => $page)
                                @if ($index === 0)
                                    <!-- First page -->
                                    <div class="flex items-center justify-center w-full h-full hard"
                                        style="background-image: url({{ asset($page) }}); background-size: contain; background-position: center; background-repeat: no-repeat;">
                                        <img src="{{ asset($page) }}" alt="Page Image"
                                            class="object-cover w-full h-full" />
                                    </div>
                                @elseif($index === count($images) - 1)
                                    <!-- Last page -->
                                    <div class="flex items-center justify-center w-full h-full hard"
                                        style="background-image: url({{ asset($page) }}); background-size: contain; background-position: center; background-repeat: no-repeat;">
                                        <img src="{{ asset($page) }}" alt="Page Image"
                                            class="object-cover w-full h-full" />
                                    </div>
                                @else
                                    <!-- Middle pages -->
                                    <div class="flex items-center justify-center w-full h-full"
                                        style="background-image: url({{ asset($page) }}); background-size: contain; background-position: center; background-repeat: no-repeat;">
                                        <img src="{{ asset($page) }}" alt="Page Image"
                                            class="object-cover w-full h-full" />
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-between">
                <button class="btn btn-primary" id="prevPage"><i class="fa fa-arrow-left"></i></button>
                <button class="btn btn-primary" id="nextPage"><i class="fa fa-arrow-right"></i></button>
            </div>

            <a href="{{ route('teacher.showquiz', ['id' => $flipbooks->id]) }}" class="btn btn-primary"
                id="quizButton">Next</a>
        </div>
    </div>

    <!-- JavaScript for Flipbook and Responsiveness -->
    <script src="https://code.jquery.com/jquery-1.11.0.min.js"></script>
    <script src="https://www.turnjs.com/lib/turn.min.js"></script>
    <script>
        function loadApp() {
            const flipbook = $('.flipbook');

            // Set the initial background image
            // $('#background').css('background-image', `url('{{ asset('book/front1.png') }}')`);

            function calculateDimensions() {
                const windowWidth = $(window).width();
                const windowHeight = $(window).height();
                let bookWidth, bookHeight;

                if (windowWidth >= 992) {
                    bookWidth = 940; // Larger size for desktops
                    bookHeight = 600;
                } else {
                    bookWidth = windowWidth * 0.9; // Scale down for smaller screens
                    bookHeight = bookWidth * (600 / 922); // Maintain the aspect ratio
                }

                return {
                    width: Math.floor(bookWidth),
                    height: Math.floor(bookHeight)
                };
            }


            flipbook.turn({
                width: calculateDimensions().width,
                height: calculateDimensions().height,
                elevation: 50,
                gradients: true,
                autoCenter: true,
                duration: 1000,
                when: {
                    turning: function(event, page) {
                        const totalPages = flipbook.turn('pages');
                        let backgroundImage;


                        if (page === 1) {
                            //  backgroundImage = '{{ asset('book/front1.png') }}';
                        } else if (page === totalPages) {
                            //  backgroundImage = '{{ asset('book/back1.png') }}';
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
                const {
                    width,
                    height
                } = calculateDimensions();
                flipbook.turn('size', width, height);
            });
        }

        yepnope({
            test: Modernizr.csstransforms,
            yep: ['{{ asset('lib/turn.js') }}'],
            nope: ['{{ asset('lib/turn.html4.min.js') }}'],

            complete: loadApp
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var spinner = document.getElementById("spinner");
            spinner.classList.add("d-none");
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>

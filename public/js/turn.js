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
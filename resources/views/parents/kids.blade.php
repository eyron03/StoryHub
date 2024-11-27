<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Storyhub</title>
    <link rel="icon" href="/image/logo.png" type="image/x-icon">

    <!--Links -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link
        href="https://fonts.googleapis.com/css2?family=Dancing+Script&family=Dosis&family=Gajraj+One&family=Madimi+One&family=Roboto:wght@300&display=swap"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Fjalla+One&family=Hammersmith+One&display=swap"
        rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="icon" href="{{ asset('book\icon.png') }}" type="image/png">

    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/parents.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/table.css') }}" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Inter:wght@600&family=Lobster+Two:wght@700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <style>

    </style>
</head>

<body>
    <div id="spinner"
        class=" show position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <div class="all">
        <div class="header d-flex justify-content-between align-items-center fixed-top">
            <a href="dashboard" style="text-decoration: none;"class="d-flex align-items-center">
                <h1 class="m-0 text-primary text-orange"><i class="fa fa-book-reader me-3"></i>StoryHub</h1>

            </a>
            <div class="dropdown-center">
                <div class="dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">

                    @foreach ($parents as $pFname)
                        {{ $pFname }}
                    @endforeach
                </div>
                <ul class="dropdown-menu">
                    <li class="text-center"><a class="dropdown-item" href="settings"
                            style="text-decoration: none; color:black;">Account Settings</a></li>
                    <li class="text-center">
                        <hr class="dropdown-divider">
                    </li>
                    <li class="text-center">
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>

                        <a href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            Logout
                        </a>
                    </li>
                </ul>
            </div>
        </div>



        <div class="sidebar">
            <a class="sidebarimage img-fluid" href="dashboard">
                <i class="fas fa-tachometer-alt icon-space"></i>Dashboard
            </a>
            <a class="sidebarimage img-fluid" href="kids" style="background-color: #fcfbe8;">
                <i class="fas fa-child icon-space"></i>My Kids
            </a>
            <a class="sidebarimage img-fluid" href="storytime">
                <i class="fas fa-book-open icon-space"></i>StoryTime
            </a>
            <a class="sidebarimage img-fluid" href="reports">
                <i class="fas fa-file-alt icon-space"></i>Reports
            </a>
            <a class="sidebarimage img-fluid" href="progress">
                <i class="fas fa-chart-line icon-space"></i>Progress
            </a>
        </div>

        <div class="content">

            <div class="container mt-4">
                <div class="row">
                    <div class="col d-flex justify-content-end align-items-center">
                        <div class="d-flex flex-column align-items-end">
                            <p style="font-size: 14px; color: rgb(119, 119, 119); margin-bottom: 0; font-weight: bold;">
                                Today's Date</p>
                            <p class="heading-sub12 bold-text" style="margin-bottom: 0;">{{ $today }}</p>
                        </div>
                        <i class="fa fa-calendar" style="font-size: 24px; margin-left: 10px;"></i>
                    </div>
                </div>
            </div>



            <br>
            <h1 style="text-align: center;">My Children Information</h1>

            <br>
            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                data-bs-target="#addChildModal">Add Child</button>
            <br> <br>
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">First Name</th>
                            <th scope="col">Last Name</th>
                            <th scope="col">Age</th>
                            <th scope="col">Date of Birth</th>
                            <th scope="col">Address</th>
                            <th scope="col">Gender</th>
                            <th scope="col">Grade Level</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($children as $child)
                            <tr>
                                <td>{{ $child->custom_id }}</td>
                                <td>{{ $child->childFirstName }}</td>
                                <td>{{ $child->childLastName }}</td>
                                <td>{{ $child->childAge }}</td>
                                <td>{{ $child->childDob }}</td>
                                <td>{{ $child->childAddress }}</td>
                                <td>{{ $child->childGender }}</td>
                                <td>
                                    @php
                                        $childGradeLevel = $gradeLevels->firstWhere('pivot_child_id', $child->id);
                                    @endphp
                                    @if ($childGradeLevel)
                                        {{ $childGradeLevel->GradeLvl }}
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-sm btn-primary me-1"
                                            onclick="editChild({{ $child->id }})">Edit</button>
                                        <button type="button" class="btn btn-sm btn-danger"
                                            onclick="confirmDelete('{{ route('children.destroy', $child->id) }}')">Delete</button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8">No children found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>


        </div>

        <!-- Edit Child Modal -->
        <div class="modal fade" id="editChildModal" tabindex="-1" aria-labelledby="editChildModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editChildModalLabel">Edit Child</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Child information editing form will be loaded here -->
                        <form id="editChildForm" action="/children/update" method="post">
                            @csrf
                            <input type="hidden" name="id" id="editChildId">
                            <div class="mb-3">
                                <label for="childFirstName" class="form-label">First Name:</label>
                                <input type="text" class="form-control" id="childFirstName"
                                    name="childFirstName">
                            </div>
                            <div class="mb-3">
                                <label for="childLastName" class="form-label">Last Name:</label>
                                <input type="text" class="form-control" id="childLastName" name="childLastName">
                            </div>

                            <div class="mb-3">
                                <label for="childDob" class="form-label">Date of Birth:</label>
                                <input type="date" class="form-control" id="childDob" name="childDob">
                            </div>

                            <div class="mb-3">
                                <label for="childAddress" class="form-label">Address:</label>
                                <input type="text" class="form-control" id="childAddress" name="childAddress">
                            </div>
                            <div class="mb-3">
                                <label for="childGender" class="form-label">Gender:</label>
                                <select class="form-select" id="childGender" name="childGender">
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>

                                </select>
                            </div>

                            <!-- Include other input fields for editing child information -->
                            <!-- Add more input fields as needed -->
                            <button type="submit" class="btn btn-primary">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="addChildModal" tabindex="-1" aria-labelledby="addChildModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addChildModalLabel">Add Child</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Child registration form -->
                    <form action="{{ route('children.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="parent_id">
                        <div class="form-group">
                            <label for="childFirstName" class="form-label">First Name:</label>
                            <input type="text" class="form-control" id="childFirstName" name="childFirstName"
                                placeholder="Enter First Name" required>
                        </div>
                        <div class="form-group">
                            <label for="childLastName" class="form-label">Last Name:</label>
                            <input type="text" class="form-control" id="childLastName" name="childLastName"
                                placeholder="Enter Last Name" required>
                        </div>

                        <div class="form-group">
                            <label for="childDob" class="form-label">Date of Birth:</label>
                            <input type="date" class="form-control" id="childDob" name="childDob" required>
                        </div>
                        <div class="form-group">
                            <label for="childAddress" class="form-label">Address:</label>
                            <input type="text" class="form-control" id="childAddress" name="childAddress"
                                placeholder="Enter Address" required>
                        </div>
                        <div class="form-group">
                            <label for="childGender" class="form-label">Gender:</label>
                            <select class="form-select" id="childGender" name="childGender" required>
                                <option value="" disabled selected>Select Gender</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                            </select>
                        </div>
                        <br>
                        <!-- Submit button -->
                        <button type="submit" class="btn btn-primary">Add Child</button>
                    </form>


                </div>
            </div>

        </div>
    </div>

    </div>

    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script>
        $(document).ready(function() {
            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: '{{ session('success') }}',
                    showConfirmButton: true,
                    confirmButtonText: 'OK'
                });
            @endif
        });
    </script>


    <script>
        function confirmDelete(url) {
            // Show a custom confirmation dialog
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // If user confirms, submit the form with AJAX
                    $.ajax({
                        url: url,
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            // If deletion is successful, reload the page or update the table as needed
                            window.location.reload();
                        },
                        error: function(xhr, status, error) {
                            // Handle errors if necessary
                            console.error(xhr.responseText);
                        }
                    });
                }
            });
        }
    </script>
    <script>
        function editChild(childId) {
            console.log("Edit Child triggered for ID:", childId); // Debugging log

            // Use AJAX to fetch child data
            $.ajax({
                url: `/admin/child/${childId}/edit`, // Make sure this route exists
                type: 'GET',
                success: function(response) {
                    // Populate modal fields with the fetched data
                    $('#editChildId').val(response.id);
                    $('#childFirstName').val(response.first_name);
                    $('#childLastName').val(response.last_name);
                    $('#childDob').val(response.dob);
                    $('#childAddress').val(response.address);
                    $('#childGender').val(response.gender);

                    // Show the modal
                    $('#editChildModal').modal('show');
                },
                error: function(xhr) {
                    console.error("Error fetching child data:", xhr.responseText);
                    alert("Failed to fetch child data. Please try again.");
                }
            });
        }
    </script>

    <script>
        $(document).ready(function() {
            $('#editChildForm').submit(function(event) {
                // Prevent the default form submission
                event.preventDefault();

                // Serialize form data
                var formData = $(this).serialize();

                // Submit the form via AJAX
                $.ajax({
                    url: $(this).attr('action'),
                    type: $(this).attr('method'),
                    data: formData,
                    success: function(response) {
                        // Close the modal
                        $('#editChildModal').modal('hide');

                        // Show success message with "OK" button
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: 'Child information has been updated successfully.',
                            showConfirmButton: true, // Show the "OK" button
                            confirmButtonText: 'OK', // Change the "OK" button text
                        }).then((result) => {
                            // Reload the page after clicking "OK"
                            if (result.isConfirmed) {
                                window.location.reload(); // Reload the page
                            }
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error('Error updating child:', error);
                    }
                });
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

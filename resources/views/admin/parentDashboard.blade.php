<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Storyhub</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" href="{{ asset('book\icon.png') }}" type="image/png">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!--Links -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="img/favicon.ico" rel="icon">

    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/parents.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/table.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Inter:wght@600&family=Lobster+Two:wght@700&display=swap"
        rel="stylesheet">
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
            <a href="{{ route('admin.parentDashboard') }}" style="text-decoration: none;"
                class="d-flex align-items-center">
                <h1 class="m-0 text-primary text-orange"><i class="fa fa-book-reader me-3"></i>StoryHub</h1>
            </a>
            <div class="dropdown-center">
                <div class="dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <span style="font-weight:bold;" class="name">Admin</span>
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
                <i class="fas fa-tachometer-alt icon-space"></i> Dashboard
            </a>
            <a class="sidebarimage img-fluid" href="books">
                <i class="fas {{ Request::is('books') ? 'fa-book-open' : 'fa-book' }} icon-space"></i> Books
            </a>
            <a class="sidebarimage img-fluid" href="teacher">
                <i
                    class="fas {{ Request::is('teacher') ? 'fa-chalkboard-teacher-open' : 'fa-chalkboard-teacher' }} icon-space"></i>
                Teachers
            </a>
            <a class="sidebarimage img-fluid" href="parent" style="background-color: #fcfbe8;">
                <i class="fas {{ Request::is('parent') ? 'fa-user-friends-open' : 'fa-user-friends' }} icon-space"></i>
                Parents
            </a>
            <a class="sidebarimage img-fluid" href="children">
                <i class="fas fa-users icon-space"></i> Childrens
            </a>
            <a class="sidebarimage img-fluid" href="reports">
                <i class="fas {{ Request::is('reports') ? 'fa-file-alt-open' : 'fa-file-alt' }} icon-space"></i>
                Reports
            </a>
            <a class="sidebarimage img-fluid" href="progress">
                <i class="fas {{ Request::is('progress') ? 'fa-chart-line-open' : 'fa-chart-line' }} icon-space"></i>
                Progress
            </a>
            <a class="sidebarimage img-fluid" href="analytics">
                <i class="fas {{ Request::is('analytics') ? 'fa-chart-bar' : 'fa-bar-chart' }} icon-space"></i>
                Analytics
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
                            <p style="font-size: 14px; color: rgb(119, 119, 119); margin-bottom: 0; font-weight: bold;">
                                Today's Date</p>
                            <p class="heading-sub12 bold-text" style="margin-bottom: 0;">{{ $today }}</p>
                        </div>
                        <i class="fa fa-calendar" style="font-size: 24px; margin-left: 10px;"></i>
                    </div>
                </div>
            </div>



            <br>
            <h1 style="text-align: center;">All Parents Information</h1>
            <br>
            <button class="btn btn-primary btn-sm" onclick="openAddParentModal()">Add Parent</button>
            <br>
            <div class="row justify-content-center">

                <div class="col-md-6">
                    <br> <br>

                    <form action="{{ route('admin.parentDashboard') }}" method="GET">
                        <div class="mb-3 input-group">
                            <input type="text" class="form-control" id="searchInput" name="search"
                                placeholder="Search by Parent name..." value="{{ request()->input('search') }}">
                            <button class="btn btn-primary" type="submit">Search</button>
                        </div>
                </div>
            </div>
            </form>
            <div class="table-responsive">
                <table id="parentTable" class="table table-striped table-bordered">

                    <thead class="thead-dark">
                        <tr>
                            <th class="d-sm-table-cell">ID</th>
                            <th class="d-sm-table-cell">First Name</th>
                            <th class="d-sm-table-cell">Last Name</th>
                            <th class="d-sm-table-cell">Age</th>
                            <th class="d-sm-table-cell">Date of Birth</th>
                            <th class="d-sm-table-cell">Address</th>
                            <th class="d-sm-table-cell">Gender</th>
                            <th class="d-sm-table-cell">Email</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($parents) > 0)
                            @foreach ($parents as $parent)
                                <tr>
                                    <td class="d-sm-table-cell">{{ $parent->id }}</td>
                                    <td class="d-sm-table-cell">{{ $parent->pFname }}</td>
                                    <td class="d-sm-table-cell">{{ $parent->pLname }}</td>
                                    <td class="d-sm-table-cell">{{ $parent->pAge }}</td>
                                    <td class="d-sm-table-cell">{{ $parent->pDob }}</td>
                                    <td class="d-sm-table-cell">{{ $parent->pAddress }}</td>
                                    <td class="d-sm-table-cell">{{ $parent->pGender }}</td>
                                    <td class="d-sm-table-cell">{{ $parent->email }}</td>
                                    <td class="d-sm-table-cell">
                                        <div class="btn-group" role="group">
                                            <button type="button" class="btn btn-primary btn-sm me-1"
                                                onclick="viewParent({{ $parent->id }})">View</button>
                                            <button type="button" class="btn btn-primary btn-sm me-1"
                                                onclick="editParent({{ $parent->id }})">Edit</button>

                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="10" class="text-center">No data found</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
            <br>
            <div class="pagination justify-content-center">
                {{ $parents->appends(['search' => $search])->links() }}
            </div>


            <div class="modal fade" id="viewParentModal" tabindex="-1" aria-labelledby="viewParentModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="viewParentModalLabel">View Parent</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <!-- Parent information will be loaded here -->
                            <div class="row">
                                <div class="col-md-6">
                                    <h6>First Name:</h6>
                                    <p id="viewParentFname"></p>
                                </div>
                                <div class="col-md-6">
                                    <h6>Last Name:</h6>
                                    <p id="viewParentLname"></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <h6>Age:</h6>
                                    <p id="viewParentAge"></p>
                                </div>
                                <div class="col-md-6">
                                    <h6>Date of Birth:</h6>
                                    <p id="viewParentDob"></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <h6>Address:</h6>
                                    <p id="viewParentAddress"></p>
                                </div>
                                <div class="col-md-6">
                                    <h6>Gender:</h6>
                                    <p id="viewParentGender"></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <h6>Email:</h6>
                                    <p id="viewParentEmail"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Edit Parent Modal -->
            <div class="modal fade" id="editParentModal" tabindex="-1" aria-labelledby="editParentModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editParentModalLabel">Edit Parent</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            @if (count($parents) > 0)
                                <div class="alert alert-danger"></div>
                                    <strong>Error:</strong> Parent not found.
                                </div>

                                <form method="POST" id="editParentForm"
                                action="{{ route('parent.update', $parent->id) }}">
                                @csrf
                                @method('PUT')

                                <div class="mb-3">
                                    <label for="pFname" class="form-label">First Name:</label>
                                    <input type="text" class="form-control" id="pFname" name="pFname"
                                        required>
                                </div>
                                <div class="mb-3">
                                    <label for="pLname" class="form-label">Last Name:</label>
                                    <input type="text" class="form-control" id="pLname" name="pLname"
                                        required>
                                </div>
                                <div class="mb-3">
                                    <label for="pDob" class="form-label">Date of Birth:</label>
                                    <input type="date" class="form-control" id="pDob" name="pDob"
                                        required>
                                </div>
                                <div class="mb-3">
                                    <label for="pAddress" class="form-label">Address:</label>
                                    <input type="text" class="form-control" id="pAddress" name="pAddress">
                                </div>
                                <div class="mb-3">
                                    <label for="pGender" class="form-label">Gender:</label>
                                    <select class="form-select" id="pGender" name="pGender" required>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email:</label>
                                    <input type="email" class="form-control" id="email" name="email"
                                        required>
                                </div>

                                <button type="submit" class="btn btn-primary">Save Changes</button>
                            </form>
                            @else
                            <p>Parents information not available.</p>
                            @endif

                        </div>
                    </div>
                </div>
            </div>

            <!-- Add Parent Modal -->
            <div class="modal fade" id="addParentModal" tabindex="-1" aria-labelledby="addParentModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addParentModalLabel">Add Parent</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="overflow-auto modal-body" style="max-height: 80vh;">
                            <form id="parentRegistrationForm" method="POST"
                                action="{{ route('parents.register.submit') }}" class="needs-validation" novalidate>
                                @csrf
                                <input type="hidden" id="usertype" name="usertype" value="parent">

                                <div class="form-group">
                                    <label for="pFname" class="form-label">First Name:</label>
                                    <input type="text" class="form-control rounded-input" id="pFname"
                                        name="pFname" placeholder="Enter First Name" required>
                                    <div class="invalid-feedback">Please provide a first name.</div>
                                </div>

                                <div class="form-group">
                                    <label for="pLname" class="form-label">Last Name:</label>
                                    <input type="text" class="form-control rounded-input" id="pLname"
                                        name="pLname" placeholder="Enter Last Name" required>
                                    <div class="invalid-feedback">Please provide a last name.</div>
                                </div>

                                <div class="form-group">
                                    <label for="pDob" class="form-label">Date of Birth:</label>
                                    <input type="date" class="form-control rounded-input" id="pDob"
                                        name="pDob" required>
                                    <div class="invalid-feedback">Please provide a date of birth.</div>
                                </div>

                                <div class="form-group">
                                    <label for="pAddress" class="form-label">Address:</label>
                                    <input type="text" class="form-control rounded-input" id="pAddress"
                                        name="pAddress" placeholder="Enter Address" required>
                                    <div class="invalid-feedback">Please provide an address.</div>
                                </div>

                                <div class="form-group">
                                    <label for="pGender" class="form-label">Gender:</label>
                                    <select class="form-select rounded-input" id="pGender" name="pGender" required>
                                        <option value="" disabled selected>Select gender...</option>
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                        <option value="other">Other</option>
                                    </select>
                                    <div class="invalid-feedback">Please select a gender.</div>
                                </div>

                                <div class="form-group">
                                    <label for="email" class="form-label">Email:</label>
                                    <input type="email" class="form-control rounded-input" id="email"
                                        name="email" placeholder="Enter Email" required>
                                    <div class="invalid-feedback">Please provide a valid email.</div>
                                </div>

                                <!-- Password Field with Show/Hide Button -->
                                <div class="form-group">
                                    <label for="password" class="form-label">Password:</label>
                                    <div class="input-group">
                                        <input type="password" class="form-control rounded-input" id="password"
                                            name="password" placeholder="Enter Password" required>
                                        <button type="button" class="btn btn-outline-secondary" id="togglePassword"
                                            style="cursor: pointer;">📗</button>
                                    </div>
                                    <div class="invalid-feedback">Please provide a password.</div>
                                </div>
                                <div class="form-group">
                                    <label for="password_confirmation" class="form-label">Confirm Password:</label>
                                    <div class="input-group">
                                        <input type="password" class="form-control" id="password_confirmation"
                                            name="password_confirmation" placeholder="Confirm Password" required>
                                        <button type="button" class="btn btn-outline-secondary"
                                            id="toggleConfirmNewPassword" style="cursor: pointer;">📗</button>
                                    </div>
                                    <div class="invalid-feedback" id="password-match-error">Passwords do not match.
                                    </div>
                                </div>

                                <br>
                                <button type="submit" class="btn btn-primary btn-block">Add Parent</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>


            <script src="{{ asset('js/parent.js') }}"></script>
            <script src="{{ asset('js/showPassword.js') }}"></script>
            <!-- SweetAlert CDN -->
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <script src="js/bootstrap.bundle.min.js"></script>
            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    var spinner = document.getElementById("spinner");
                    spinner.classList.add("d-none");
                });
            </script>

            <!-- Bootstrap JS and dependencies -->
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
                integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
            </script>
            <script>
                function openAddParentModal() {
                    $('#addParentModal').modal('show');
                }

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
            @if (session('success'))
                <script>
                    // Display the success message using SweetAlert
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: '{{ session('success') }}'
                    });
                </script>
            @endif

            <script>
                $('#editParentForm').on('submit', function(e) {
                    e.preventDefault();

                    const actionUrl = $(this).attr('action');
                    const formData = $(this).serialize();

                    $.ajax({
                        url: actionUrl,
                        type: 'PUT',
                        data: formData,
                        success: function(response) {
                            // Close the modal
                            $('#editParentModal').modal('hide');

                            // Display SweetAlert success message
                            Swal.fire({
                                title: 'Success!',
                                text: response.message, // Use the response message
                                icon: 'success',
                                confirmButtonText: 'OK'
                            }).then(() => {
                                // Optionally refresh the page or update table data
                                location.reload();
                            });
                        },
                        error: function(xhr) {
                            // Display SweetAlert error message
                            Swal.fire({
                                title: 'Error!',
                                text: xhr.responseJSON.message || 'An error occurred.',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        }
                    });
                });
            </script>
</body>

</html>

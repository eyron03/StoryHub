<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Storyhub</title>
    <link rel="icon" href="/image/logo.png" type="image/x-icon">

    <!--Links -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="icon" href="{{ asset('book\icon.png') }}" type="image/png">

    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/parents.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/table.css') }}" rel="stylesheet">
    <link href="{{ asset('css/pagination.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Inter:wght@600&family=Lobster+Two:wght@700&display=swap" rel="stylesheet">
    

</head>
<body>
    @Include('sweetalert::alert')
    <div id="spinner" class=" show position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
<div class="all">
    <div class="header d-flex justify-content-between align-items-center fixed-top">
        <a href="{{ route('admin.childrenDashboard') }}" style="text-decoration: none;"class="d-flex align-items-center">

          <h1 class="m-0 text-primary text-orange"><i class="fa fa-book-reader me-3"></i>StoryHub</h1>
        </a>
        <div class="dropdown-center">
            <div class="dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">

                <span style="font-weight:bold;" class="name">Admin</span>

            </div>
            <ul class="dropdown-menu">
                <li class="text-center"><a class="dropdown-item" href="settings" style="text-decoration: none; color:black;">Account Settings</a></li>
                <li class="text-center"><hr class="dropdown-divider"></li>

                <li class="text-center">
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>

                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Logout
                    </a>
                </li>
            </ul>
        </div>
    </div>


  
    <div class="sidebar">
        <a class="sidebarimage img-fluid" href="dashboard" >
            <i class="fas fa-tachometer-alt icon-space"></i> Dashboard
        </a>
        <a class="sidebarimage img-fluid" href="books">
            <i class="fas {{ Request::is('books') ? 'fa-book-open' : 'fa-book' }} icon-space"></i> Books
        </a>
        <a class="sidebarimage img-fluid" href="teacher">
            <i class="fas {{ Request::is('teacher') ? 'fa-chalkboard-teacher-open' : 'fa-chalkboard-teacher' }} icon-space"></i> Teachers
        </a>
        <a class="sidebarimage img-fluid" href="parent" >
            <i class="fas {{ Request::is('parent') ? 'fa-user-friends-open' : 'fa-user-friends' }} icon-space"></i> Parents
        </a>
        <a class="sidebarimage img-fluid" href="children" style="background-color: #fcfbe8;">
            <i class="fas fa-users icon-space"></i>  Childrens
        </a>
        <a class="sidebarimage img-fluid" href="reports">
            <i class="fas {{ Request::is('reports') ? 'fa-file-alt-open' : 'fa-file-alt' }} icon-space"></i> Reports
        </a>
        <a class="sidebarimage img-fluid" href="progress">
            <i class="fas {{ Request::is('progress') ? 'fa-chart-line-open' : 'fa-chart-line' }} icon-space"></i> Progress
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
                <p style="font-size: 14px; color: rgb(119, 119, 119); margin-bottom: 0; font-weight: bold;">Today's Date</p>
                <p class="heading-sub12 bold-text" style="margin-bottom: 0;">{{ $today }}</p>
            </div>
            <i class="fa fa-calendar" style="font-size: 24px; margin-left: 10px;"></i>
        </div>
    </div>
</div>


             <br>
                <h1 style="text-align: center;">All Children Information</h1>
                 <br>
      
             <form action="{{ route('admin.childrenDashboard') }}" method="GET">
             <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="mb-3 input-group">
                <input type="text" class="form-control" id="searchInput" name="search" placeholder="Search by Children name..." value="{{ request()->input('search') }}">
                <button class="btn btn-primary" type="submit">Search</button>
            </div>
        </div>
    </div>
</form>
     <div class="table-responsive">
    <table id="childTable" class="table table-striped table-bordered">
        <thead class="thead-dark">
            <tr>
                <th class="d-sm-table-cell">ID</th>
                <th class="d-sm-table-cell">First Name</th>
                <th class="d-sm-table-cell">Last Name</th>
                <th class="d-sm-table-cell">Age</th>
                <th class="d-sm-table-cell">Date of Birth</th>
                <th class="d-sm-table-cell">Address</th>
                <th class="d-sm-table-cell">Gender</th>
                <th class="d-sm-table-cell">Parent Name</th>
                <th class="d-sm-table-cell">Teacher Name</th>
                <th class="d-sm-table-cell">Grade Level</th>
                <th class="d-sm-table-cell">Action</th>
            </tr>
        </thead>
        <tbody>
            @php
                $hasVisibleRows = false;
            @endphp

            @foreach($childrens as $child)
                @if ($child->grade_level && $child->grade_level !== 'N/A' && ($child->teacher_first_name || $child->teacher_last_name))
                    @php
                        $hasVisibleRows = true;
                    @endphp
                    <tr>
                        <td class="d-sm-table-cell">{{ $child->custom_id }}</td>
                        <td class="d-sm-table-cell">{{ $child->childFirstName }}</td>
                        <td class="d-sm-table-cell">{{ $child->childLastName }}</td>
                        <td class="d-sm-table-cell">{{ $child->childAge }}</td>
                        <td class="d-sm-table-cell">{{ $child->childDob }}</td>
                        <td class="d-sm-table-cell">{{ $child->childAddress }}</td>
                        <td class="d-sm-table-cell">{{ $child->childGender }}</td>
                        <td class="d-sm-table-cell">{{ $child->parent_fname }}</td>
                        <td class="d-sm-table-cell">
                            @if ($child->teacher_first_name && $child->teacher_last_name)
                                {{ $child->teacher_first_name }} {{ $child->teacher_last_name }}
                            @else
                                N/A
                            @endif
                        </td>
                        <td class="d-sm-table-cell">
                            @if ($child->grade_level && $child->grade_level !== 'N/A')
                                {{ $child->grade_level }}
                            @else
                                N/A
                            @endif
                        </td>
                        <td class="d-sm-table-cell">
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-primary btn-sm me-1" onclick="viewChild({{ $child->id }})" data-bs-toggle="modal" data-bs-target="#viewChildModal">View</button>
                                <button type="button" class="btn btn-primary btn-sm me-1" onclick="editChild({{ $child->id }})" data-bs-toggle="modal" data-bs-target="#editChildModal">Edit</button>
                            </div>
                        </td>
                    </tr>
                @endif
            @endforeach

            @if (!$hasVisibleRows)
                <tr>
                    <td colspan="11" class="text-center">No data found</td>
                </tr>
            @endif
        </tbody>
    </table>
</div>
  <!-- Pagination controls -->
        <div class="pagination justify-content-center">
            {{ $childrens->appends(['search' => $search])->links() }}
        </div>
            <div class="modal fade" id="viewChildModal" tabindex="-1" aria-labelledby="viewChildModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="viewChildModalLabel">View Child</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <!-- Child information will be loaded here -->
                            <div class="row">
                                <div class="col-md-6">
                                    <h6>First Name:</h6>
                                    <p id="viewChildFirstName"></p>
                                </div>
                                <div class="col-md-6">
                                    <h6>Last Name:</h6>
                                    <p id="viewChildLastName"></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <h6>Age:</h6>
                                    <p id="viewChildAge"></p>
                                </div>
                                <div class="col-md-6">
                                    <h6>Date of Birth:</h6>
                                    <p id="viewChildDob"></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <h6>Address:</h6>
                                    <p id="viewChildAddress"></p>
                                </div>
                                <div class="col-md-6">
                                    <h6>Gender:</h6>
                                    <p id="viewChildGender"></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <h6>Parent Name:</h6>
                                    <p id="viewChildParentName"></p>
                                </div>
                            </div>
                            <!-- Add more child information fields as needed -->
                        </div>
                    </div>
                </div>
            </div>

            <!-- Edit Child Modal -->
            <div class="modal fade" id="editChildModal" tabindex="-1" aria-labelledby="editChildModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editChildModalLabel">Edit Child</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
            <div class="modal-body">
                <!-- Child information editing form will be loaded here -->
                 <form id="editChildForm" action="/children/update" method="post">
                    @csrf
                    <input type="hidden" name="id" id="editChildId">
                    <div class="mb-3">
                        <label for="childFirstName" class="form-label">First Name:</label>
                        <input type="text" class="form-control" id="childFirstName" name="childFirstName">
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
                        <select class="form-select" id="childGender" name="childGender" required>
                            <option value="" disabled selected>Select Gender</option>
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<!-- Bootstrap JS and dependencies -->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
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
    function viewChild(childId) {
        $.ajax({
            url: '/admin/child/' + childId,
            type: 'GET',
            success: function(response) {
                // Update the modal content with the received child information
                $('#viewChildFirstName').text(response.childFirstName);
                $('#viewChildLastName').text(response.childLastName);
                $('#viewChildAge').text(response.childAge);
                $('#viewChildDob').text(response.childDob);
                $('#viewChildAddress').text(response.childAddress);
                $('#viewChildGender').text(response.childGender);

                // Fetch and append parent information
                $.ajax({
                    url: '/admin/parent/' + response.parent_id,
                    type: 'GET',
                    success: function(parentResponse) {
                        $('#viewChildParentName').text(parentResponse.pFname + ' ' + parentResponse.pLname);
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });

                // Show the modal
                $('#viewChildModal').modal('show');
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    }

    function editChild(childId) {
        $.ajax({
            url: '/admin/child/' + childId + '/edit',
            type: 'GET',
            success: function(response) {
                // Update modal content with child data
                $('#editChildId').val(response.id);
                $('#childFirstName').val(response.childFirstName);
                $('#childLastName').val(response.childLastName);
                $('#childAge').val(response.childAge);
                $('#childDob').val(response.childDob);
                $('#childAddress').val(response.childAddress);
                   $('#childGender option').each(function() {
                if ($(this).val().toLowerCase() == response.childGender.toLowerCase()) {
                    $(this).prop('selected', true);
                } else {
                    $(this).prop('selected', false);
                }
            });
                // Show the modal
                $('#editChildModal').modal('show');
            },
            error: function(xhr, status, error) {
                console.error('Error fetching edit child modal:', error);
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

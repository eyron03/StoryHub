<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Storyhub</title>
    <link rel="icon" href="{{ asset('book\icon.png') }}" type="image/png">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!--Links -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script&family=Dosis&family=Gajraj+One&family=Madimi+One&family=Roboto:wght@300&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Fjalla+One&family=Hammersmith+One&display=swap" rel="stylesheet">

    <link href="img/favicon.ico" rel="icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/parents.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/table.css') }}" rel="stylesheet">
    <link href="{{ asset('css/paginate.css') }}" rel="stylesheet">
    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Inter:wght@600&family=Lobster+Two:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">


<body>
    <div id="spinner" class=" show position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
<div class="all">
    <div class="header d-flex justify-content-between align-items-center fixed-top">
        <a href="#" style="text-decoration: none;" class="d-flex align-items-center">
            <h1 class="m-0 text-primary text-orange"><i class="fa fa-book-reader me-3"></i>StoryHub</h1>
        </a>
        <div class="dropdown-center">
            <div class="dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                @foreach ($teachers as $teacherName)
                {{ $teacherName }}
            @endforeach
       
            </div>
            <ul class="dropdown-menu">
                <li class="text-center"><a class="dropdown-item" href="settings" style="text-decoration: none; color:black;">Account Settings</a></li>
                <li class="text-center"><hr class="dropdown-divider"></li>
                <li class="text-center">
                    <form id="logout-form" action="{{ route('teacher.logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>

                    <a href="{{ route('teacher.logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
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
        <a class="sidebarimage img-fluid" href="books"  >
            <i class="fas fa-book icon-space"></i> Books
        </a>
        <a class="sidebarimage img-fluid" href="parent" style="background-color: #fcfbe8;">
            <i class="fas fa-user-friends icon-space"></i> Parents
        </a>
        <a class="sidebarimage img-fluid" href="pupils">
            <i class="fas fa-users icon-space"></i> Pupils
        </a>
        <a class="sidebarimage img-fluid" href="reports">
            <i class="fas fa-file-alt icon-space"></i> Reports
        </a>
        <a class="sidebarimage img-fluid" href="progressReports">
            <i class="fas fa-chart-line icon-space"></i> Progress
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
                <h1 style="text-align: center;">Parents Information</h1>
                 <br>
      <form method="GET" action="{{ route('teachers.parent') }}" >
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="mb-3 input-group">
                  <input type="text" name="search" class="form-control" id="searchInput" placeholder="Search Parent ID or Parent name..." value="{{ request('search') }}">
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
                        <th class="d-sm-table-cell">Children Name</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if(count($parents) > 0)
                    @foreach($parents as $parent)
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
                            {{ implode(' / ', $parent->childrenNames->toArray()) }}
                        </td>
                     
                        <td class="d-sm-table-cell">
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-primary btn-sm me-1" onclick="viewParent({{ $parent->id }})">View</button>
                                <button type="button" class="btn btn-primary btn-sm me-1" onclick="editParent({{ $parent->id }})">Edit</button>

                        </td>
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td colspan="9" class="text-center">No data found</td>
                    </tr>
                @endif
                </tbody>
            </table>
        </div>
         <div class="d-flex justify-content-center">
        {{ $parents->appends(['search' => $search])->links() }}
        </div>
        <div id="notFoundMessage" class="alert alert-info" style="display: none;">
            No matching results found.
        </div>

        <div class="modal fade" id="viewParentModal" tabindex="-1" aria-labelledby="viewParentModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="viewParentModalLabel">View Parent</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
                        <div class="row">
                            <div class="col-md-12">
                                <h6>Children Name:</h6>
                                <p id="viewChildrenName"></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        

        <!-- Edit Parent Modal -->
        <div  class="modal fade" id="editParentModal" tabindex="-1" aria-labelledby="editParentModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div id="editParentForm" class="modal-header">
                        <h5 class="modal-title" id="editParentModalLabel">Edit Parent</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div  class="modal-body">
                        <!-- Parent information editing form will be loaded here -->

                      <form action="{{ route('teacher.parent.update', $parent->id) }}" method="post">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="id" id="editParentId">
                            <div class="mb-3">
                                <label for="pFname" class="form-label">First Name:</label>
                                <input type="text" class="form-control" id="pFname" name="pFname">
                            </div>
                            <div class="mb-3">
                                <label for="pLname" class="form-label">Last Name:</label>
                                <input type="text" class="form-control" id="pLname" name="pLname">
                            </div>
                           
                            <div class="mb-3">
                                <label for="pDob" class="form-label">Date of Birth:</label>
                                <input type="date" class="form-control" id="pDob" name="pDob">
                            </div>
                            <div class="mb-3">
                                <label for="pAddress" class="form-label">Address:</label>
                                <input type="text" class="form-control" id="pAddress" name="pAddress">
                            </div>
                            <div class="mb-3">
                                <label for="pGender" class="form-label">Gender:</label>
                                <select class="form-control" id="pGender" name="pGender">
                                    <option value="Male" {{ $parent->pGender == 'Male' ? 'selected' : '' }}>Male</option>
                                    <option value="Female" {{ $parent->pGender == 'Female' ? 'selected' : '' }}>Female</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email:</label>
                                <input type="text" class="form-control" id="email" name="email">
                            </div>
                            <!-- Include other input fields for editing parent information -->
                            <!-- Add more input fields as needed -->
                            <button type="submit" class="btn btn-primary">Update</button>

                        </form>

                    </div>
                </div>
            </div>
        </div>
 
</div>


        <!-- SweetAlert CDN -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="js/bootstrap.bundle.min.js"></script>
    
        <script src="{{ asset('js/parent.js') }}"></script>
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
@if(session('success'))
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
    $(document).ready(function() {
        $('#editParentForm').submit(function(e) {
            e.preventDefault(); // Prevent the default form submission
            var formData = $(this).serialize(); // Get form data
    
            // Get the route URL for updating the parent data
            var routeUrl = $(this).attr('action');
    
            // Make an AJAX request to update the parent data
            $.ajax({
                url: routeUrl,
                type: 'POST',
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: 'Updated successfully',
                        });
                    }
                },
                error: function(xhr) {
                    // Display errors if validation fails
                    var errors = xhr.responseJSON.errors;
                    var errorMessage = '';
    
                    if (errors) {
                        $.each(errors, function(key, value) {
                            errorMessage += value[0] + "\n"; // Append each error message
                        });
                    }
    
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: errorMessage || 'An error occurred.',
                    });
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

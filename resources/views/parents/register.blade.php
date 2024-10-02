<!-- resources/views/parents/register.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parent Registration Form</title>
    <link href="{{ asset('css/register.css') }}" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h2>Parent Registration Form</h2>
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form method="POST" action="{{ route('parents.register.submit') }}">
            @csrf
            <div class="form-group">
                <label for="pFname">First Name:</label>
                <input type="text" class="form-control" id="pFname" name="pFname" required>
            </div>
            <div class="form-group">
                <label for="pLname">Last Name:</label>
                <input type="text" class="form-control" id="pLname" name="pLname" required>
            </div>
            <div class="form-group">
                <label for="pAge">Age:</label>
                <input type="number" class="form-control" id="pAge" name="pAge" required>
            </div>
            <div class="form-group">
                <label for="pDob">Date of Birth:</label>
                <input type="date" class="form-control" id="pDob" name="pDob" required>
            </div>
            <div class="form-group">
                <label for="pAddress">Address:</label>
                <input type="text" class="form-control" id="pAddress" name="pAddress" required>
            </div>
            <div class="form-group">
                <label for="pGender">Gender:</label>
                <select class="form-control" id="pGender" name="pGender" required>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                    <option value="other">Other</option>
                </select>
            </div>
            <div class="form-group">
                <label for="pKname">Username:</label>
                <input type="text" class="form-control" id="pKname" name="pKname" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="password_confirmation">Confirm Password:</label>
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Register</button>
        </form>
    </div>
</body>
</html>

<!-- resources/views/register.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>
</head>
<body>
    <h2>User Registration Form</h2>
    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif
    <form method="POST" action="{{ route('register.submit') }}">
        @csrf
        <div>
            <label for="kFname">First Name:</label><br>
            <input type="text" id="kFname" name="kFname" required><br>
        </div>
        <div>
            <label for="kLname">Last Name:</label><br>
            <input type="text" id="kLname" name="kLname" required><br>
        </div>
        <div>
            <label for="kAge">Age:</label><br>
            <input type="number" id="kAge" name="kAge" required><br>
        </div>
        <div>
            <label for="kDob">Date of Birth:</label><br>
            <input type="date" id="kDob" name="kDob" required><br>
        </div>
        <div>
            <label for="kAddress">Address:</label><br>
            <input type="text" id="kAddress" name="kAddress" required><br>
        </div>
        <div>
            <label for="kGender">Gender:</label><br>
            <select id="kGender" name="kGender" required>
                <option value="male">Male</option>
                <option value="female">Female</option>
                <option value="other">Other</option>
            </select><br>
        </div>
        <div>
            <label for="kEmail">Email:</label><br>
            <input type="email" id="kEmail" name="kEmail" required><br>
        </div>
        <div>
            <label for="kPassword">Password:</label><br>
            <input type="password" id="kPassword" name="kPassword" required><br>
        </div>
        <button type="submit">Register</button>
    </form>
</body>
</html>

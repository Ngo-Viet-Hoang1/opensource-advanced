<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>
    <link href="css/style.css" rel="stylesheet">
</head>

<body>
    <form action='/sign-in' method='post'>
        @csrf
        <div>
            <label for="username">Username:</label>
            <input type="text" name="username">
        </div>
        <div>
            <label for="student_id">Student id:</label>
            <input type="text" name="student_id">
        </div>
        <div>
            <label for="class_name">Class name:</label>
            <input type="text" name="class_name">
        </div>
        <div>
            <div>Gender:</div>
            <input type="radio" checked id="male" name="gender" value="male">
            <label for="male">Male</label><br>
            <input type="radio" id="female" name="gender" value="female">
            <label for="female">Female</label>
        </div>
        <div>
            <label for="password">Password:</label>
            <input type="password" name="password">
        </div>
        <div>
            <label for="password_confirmation">Password Confirmation:</label>
            <input type="password" name="password_confirmation">
        </div>

        <input type="submit">
    </form>
</body>

</html>

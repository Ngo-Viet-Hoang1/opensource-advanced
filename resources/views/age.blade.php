<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Nhập tuổi</title>
</head>

<body>
    <form action="/save-age" method="POST">
        @csrf
        <label for="age">Your age:</label>
        <input type="number" id="age" name="age" value="{{ session('age') }}" min="1" max="150"
            required placeholder="Age">

        @error('age')
            {{ $message }}
            </div>
        @enderror

        <button type="submit">Xác nhận</button>
    </form>
</body>

</html>

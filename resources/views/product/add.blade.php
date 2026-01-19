<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title></title>
        <link href="css/style.css" rel="stylesheet">
    </head>
    <body>
        <p>Create new product</p>
        <form>
            <div>
                <label for="name">Name:</label>
                <input type="text" name="name" value="">
            </div>
            <div>
                <label for="price">Price:</label>
                <input type="number" name="price">
            </div>

            <input type="submit" >
        </form>
        <a href="{{ route('product') }}">Back to products</a>
    </body>
</html>

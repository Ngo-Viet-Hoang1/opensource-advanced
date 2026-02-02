<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>
    <link href="css/style.css" rel="stylesheet">
</head>

<body>
    <p>Edit product</p>
    <form action='/product/{{ $product->id }}' method='post'>
        @csrf
        @method('patch')
        <div>
            <label for="name">Name:</label>
            <input type="text" value='{{ $product->name }}' name="name">
        </div>
        <div>
            <label for="price">Price:</label>
            <input type="number" value='{{ $product->price }}' step='any' name="price">
        </div>
        <div>
            <label for="stock">Stock:</label>
            <input type="number" value='{{ $product->stock }}' name="stock">
        </div>

        <input type="submit">
    </form>
    <a href="{{ route('product') }}">Back to products</a>
</body>

</html>

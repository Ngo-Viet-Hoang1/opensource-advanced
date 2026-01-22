<!DOCTYPE html>
<html lang="">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }}</title>
</head>

<body>
    <p>Products</p>

    <table border='1'>
        <tr>
            <th>Id</th>
            <th>Name</th>
            <th>Price</th>
            <<th>Actions</th>
        </tr>

        @foreach ($products as $product)
            <tr>
                <td>{{ $product['id'] }}</td>
                <td>{{ $product['name'] }}</td>
                <td>{{ $product['price'] }}</td>
                <td @style('display: flex')>
                    <div>
                        Edit
                    </div>
                    <div>
                        Delete
                    </div>
                </td>
            </tr>
        @endforeach
    </table>

    <a href="{{ route('product.add') }}">Add new product</a>
</body>

</html>

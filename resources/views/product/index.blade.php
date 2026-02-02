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
            <th>Stock</th>
            <th>Actions</th>
            <th>Actions</th>
        </tr>

        @foreach ($products as $product)
            <tr>
                <td>{{ $product['id'] }}</td>
                <td>{{ $product['name'] }}</td>
                <td>{{ $product['price'] }}</td>
                <td>{{ $product['stock'] }}</td>
                <td @style('display: flex')>
                    <a href="/product/{{ $product->id }}/edit">Edit</a>
                </td>
                <td>
                    <form hidden id='delete-form-{{ $product->id }}' method='post' action='/product/{{ $product->id }}'>
                        @csrf
                        @method('delete')
                    </form>
                    <button type='submit' form="delete-form-{{ $product->id }}">Delete</button>
                </td>
            </tr>
        @endforeach
    </table>

    <a href="{{ route('product.add') }}">Add new product</a>
</body>

</html>

<!DOCTYPE html>
<html lang="">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title></title>
        <link href="css/style.css" rel="stylesheet">
    </head>
    <body>
        <p>Products</p>

        <table>
            <tr>
                <th>Name</th>
                <th>Price</th>
            </tr>
            <tr>
                <td>Sick enough to die</td>
                <td>100</td>
            </tr>
        </table>

        <a href="{{ route('product.add') }}">Add new product</a>
    </body>
</html>

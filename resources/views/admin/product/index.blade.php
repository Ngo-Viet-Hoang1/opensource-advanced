@extends('layout.admin-layout')
@section('content')
    <a class='btn btn-primary flex flex-end pb-2' href="{{ route('product.add') }}">Add new product</a>

    <table class='table table-bordered'>
        <tr>
            <th>Id</th>
            <th>Name</th>
            <th>Price</th>
            <th>Stock</th>
            <th></th>
            <th></th>
        </tr>

        @foreach ($products as $product)
            <tr>
                <td>{{ $product['id'] }}</td>
                <td>{{ $product['name'] }}</td>
                <td>{{ $product['price'] }}</td>
                <td>{{ $product['stock'] }}</td>
                <td @style('display: flex')>
                    <a class='btn btn-secondary' href="/product/{{ $product->id }}/edit">Edit</a>
                </td>
                <td>
                    <form hidden id='delete-form-{{ $product->id }}' method='post' action='/product/{{ $product->id }}'>
                        @csrf
                        @method('delete')
                    </form>
                    <button class='btn btn-primary' type='submit' form="delete-form-{{ $product->id }}">Delete</button>
                </td>
            </tr>
        @endforeach
    </table>
@endsection

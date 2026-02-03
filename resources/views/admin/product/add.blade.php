@extends('layout.admin-layout')
@section('content')
    <p>Create new product</p>
    <form action='/product/store' method='post'>
        @csrf
        <div>
            <label for="name">Name:</label>
            <input type="text" name="name" value="">
        </div>
        <div>
            <label for="price">Price:</label>
            <input type="number" step='any' name="price">
        </div>
        <div>
            <label for="stock">Stock:</label>
            <input type="number" name="stock">
        </div>

        <input type="submit">
    </form>
    <a href="{{ route('product') }}">Back to products</a>
@endsection

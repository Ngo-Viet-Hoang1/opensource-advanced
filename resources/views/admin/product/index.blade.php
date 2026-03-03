@extends('layout.admin-layout')
@section('content')
    <div class="px-2">

        <form method="GET" class="row mb-3">
            <div class="col-md-4">
                <input type="text" name="search" class="form-control" placeholder="Tìm sản phẩm..."
                    value="{{ request('search') }}">
            </div>
            <div class="col-md-2">
                <button class="btn btn-outline-secondary w-100">
                    Tìm kiếm
                </button>
            </div>

            <a href="{{ route('products.create') }}" class="btn btn-primary">
                + Thêm sản phẩm
            </a>
        </form>

        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Hình ảnh</th>
                    <th>Tên</th>
                    <th>Slug</th>
                    <th>Giá gốc</th>
                    <th>Giá Sale</th>
                    <th>Stock</th>
                    <th>Danh mục</th>
                    <th>Trạng thái</th>
                    <th width="150">Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                    <tr>
                        <td>{{ $product->id }}</td>
                        <td><img src="{{ $product->image }}" alt="{{ $product->name }}" width="50"></td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->slug }}</td>
                        <td>{{ number_format($product->price) }} đ</td>
                        <td>{{ number_format($product->sale_price) }} đ</td>
                        <td>{{ $product->stock }}</td>
                        <td>{{ $product->category->name ?? 'Không có danh mục' }}</td>
                        <td>
                            @if ($product->is_active)
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-secondary">Hidden</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('products.edit', $product) }}" class="btn btn-sm btn-warning">
                                Sửa
                            </a>

                            <form action="{{ route('products.destroy', $product) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger" onclick="return confirm('Xóa?')">
                                    Xóa
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-3">
            {{ $products->links() }}
        </div>

    </div>
@endsection

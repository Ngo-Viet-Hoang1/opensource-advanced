@extends('layout.admin-layout')

@section('content')
    <div class="px-2">

        <form action="{{ route('products.store') }}" method="POST">
            @csrf

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Tên sản phẩm</label>
                    <input type="text" name="name" class="form-control" required>
                </div>

                <div class="col-md-3 mb-3">
                    <label>Giá</label>
                    <input type="number" step="0.01" name="price" class="form-control" required>
                </div>

                <div class="col-md-3 mb-3">
                    <label>Giá giảm</label>
                    <input type="number" step="0.01" name="sale_price" class="form-control">
                </div>

                <div class="col-md-3 mb-3">
                    <label>Slug</label>
                    <input type="text" name="slug" class="form-control">
                </div>

                <div class="col-md-3 mb-3">
                    <label>Stock</label>
                    <input type="number" name="stock" class="form-control" required>
                </div>

                <div class="col-md-3 mb-3">
                    <label for="category_id" class="form-label">Danh mục</label>

                    <select class="form-control @error('category_id') is-invalid @enderror" name="category_id"
                        id="category_id">
                        <option value="">Chọn danh mục</option>

                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ old('category_id', $product->category_id ?? '') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3 mb-3">
                    <label>Image</label>
                    <input type="text" name="image" class="form-control">
                </div>

                <div class="col-md-12 mb-3">
                    <label>Mô tả</label>
                    <textarea name="description" class="form-control" rows="3"></textarea>
                </div>

                <div class="col-md-12 mb-3">
                    <div class="form-check">
                        <input type="checkbox" name="is_active" value="1" class="form-check-input" checked>
                        <label class="form-check-label">
                            Kích hoạt
                        </label>
                    </div>
                </div>
            </div>

            <input class="btn btn-primary" type="submit" value="Lưu">
            <a href="{{ route('products.index') }}" class="btn btn-secondary">Hủy</a>
        </form>

    </div>
@endsection

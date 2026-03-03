@extends('layout.admin-layout')

@section('content')
    <div class="mx-2">

        <h4 class="mb-4">Sửa sản phẩm</h4>

        <form action="{{ route('products.update', $product) }}" method="POST">
            @csrf
            @method('PATCH')

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Tên sản phẩm</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $product->name) }}"
                        required>
                </div>

                <div class="col-md-3 mb-3">
                    <label>Giá</label>
                    <input type="number" name="price" class="form-control" value="{{ old('price', $product->price) }}"
                        required>
                </div>

                <div class="col-md-3 mb-3">
                    <label>Giá giảm</label>
                    <input type="number" name="sale_price" class="form-control"
                        value="{{ old('sale_price', $product->sale_price) }}">
                </div>

                <div class="col-md-3 mb-3">
                    <label>Slug</label>
                    <input type="text" name="slug" class="form-control" value="{{ old('slug', $product->slug) }}">
                </div>

                <div class="col-md-3 mb-3">
                    <label>Stock</label>
                    <input type="number" name="stock" class="form-control" value="{{ old('stock', $product->stock) }}"
                        required>
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
                    <input type="text" name="image" class="form-control" value="{{ old('image', $product->image) }}">
                </div>

                <div class="col-md-12 mb-3">
                    <label>Mô tả</label>
                    <textarea name="description" class="form-control" rows="3">{{ old('description', $product->description) }}</textarea>
                </div>

                <div class="col-md-12 mb-3">
                    <div class="form-check">
                        {{-- <input type="hidden" name="is_active" value="0"> --}}
                        <input type="checkbox" name="is_active" value="1" class="form-check-input"
                            {{ old('is_active', $product->is_active) ? 'checked' : '' }}>
                        <label class="form-check-label">
                            Kích hoạt
                        </label>
                    </div>
                </div>
            </div>

            <button class="btn btn-primary">Lưu</button>
            <a href="{{ route('products.index') }}" class="btn btn-secondary">Hủy</a>
        </form>

    </div>
@endsection

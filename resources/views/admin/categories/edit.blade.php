@extends('layout.admin-layout')

@section('content')
    <div class="container-fluid">
        <div class="card ">
            <div class="card-header ">
                <h4 class="mb-0">Chỉnh Sửa Danh Mục</h4>
            </div>

            <div class="card-body">
                <form action="{{ route('categories.update', $category) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')

                    <div class="mb-3">
                        <label for="name" class="form-label">Tên danh mục <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name"
                            class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name', $category->name) }}" required>

                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="slug" class="form-label">Slug</label>
                        <input type="text" name="slug" id="slug"
                            class="form-control @error('slug') is-invalid @enderror"
                            value="{{ old('slug', $category->slug) }}" required>

                        @error('slug')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Mô tả</label>
                        <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror"
                            rows="3">{{ old('description', $category->description) }}</textarea>

                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Hình ảnh hiện tại</label>

                        @if ($category->image)
                            <div class="mb-3">
                                <img id="currentImage" src="{{ Storage::url($category->image) }}"
                                    alt="{{ $category->name }}"
                                    style="max-width: 100%; max-height: 300px; border-radius: 8px; border: 2px solid #dee2e6;"
                                    class="img-fluid">

                            </div>
                        @else
                            <p class="text-muted">
                                <i class="fas fa-image me-2"></i>Chưa có hình ảnh
                            </p>
                        @endif
                    </div>

                    <div class="mb-4">
                        <label for="image" class="form-label">
                            {{ $category->image ? 'Thay đổi hình ảnh' : 'Tải lên hình ảnh' }}
                        </label>
                        <input type="file" name="image" id="imageInput"
                            class="form-control @error('image') is-invalid @enderror" accept="image/*">

                        <img id="preview" class="mt-2 img-thumbnail" style="display:none; max-height:200px;">

                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Parent Category --}}
                    <div class="mb-4">
                        <label for="parent_id" class="form-label">Danh mục cha</label>
                        <select name="parent_id" id="parent_id"
                            class="form-select @error('parent_id') is-invalid @enderror">
                            <option value="">-- Không có danh mục cha (Cấp cao nhất) --</option>

                            @foreach ($parentCategories as $cat)
                                @if ($cat->id != $category->id)
                                    @include('admin.categories.option', [
                                        'category' => $cat,
                                        'level' => 0,
                                        'selected' => old('parent_id', $category->parent_id),
                                        'excludeIds' => $excludeIds ?? [$category->id],
                                    ])
                                @endif
                            @endforeach
                        </select>

                        <small class="form-text text-muted">
                            <i class="fas fa-info-circle me-1"></i>
                            Không thể chọn chính danh mục này hoặc danh mục con của nó làm cha
                        </small>

                        @error('parent_id')
                            <div class="invalid-feedback">
                                <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1"
                                {{ old('is_active', $category->is_active) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">
                                Kích hoạt
                            </label>
                        </div>
                    </div>

                    {{-- Buttons --}}
                    <div class="d-flex gap-2 justify-content-between">
                        <div class="d-flex gap-2">
                            <a href="{{ route('categories.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times me-2"></i>Hủy
                            </a>
                            <button type="reset" class="btn btn-outline-secondary">
                                <i class="fas fa-redo me-2"></i>Làm mới
                            </button>
                            <button type="submit" class="btn btn-warning">
                                <i class="fas fa-save me-2"></i>Cập nhật
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- Children Info --}}
        @if ($category->children->count() > 0)
            <div class="card shadow-sm mt-3">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-sitemap me-2"></i>
                        Danh mục con ({{ $category->children->count() }})
                    </h5>
                </div>
                <div class="card-body">
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        Danh mục này có <strong>{{ $category->children->count() }}</strong> danh mục con.
                        Xóa danh mục này sẽ ảnh hưởng đến các danh mục con.
                    </div>
                    <ul class="list-group">
                        @foreach ($category->children as $child)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span>
                                    <i class="fas fa-folder me-2"></i>{{ $child->name }}
                                </span>
                                <a href="{{ route('categories.edit', $child) }}" class="btn btn-sm btn-outline-primary">
                                    Chỉnh sửa
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif
    </div>

    <script>
        const imageInput = document.getElementById('imageInput');
        const preview = document.getElementById('preview');
        const currentImage = document.getElementById('currentImage');

        imageInput.addEventListener('change', function() {
            const file = this.files[0];

            if (file) {
                if (file.size > 2 * 1024 * 1024) {
                    alert('File quá lớn! Vui lòng chọn file nhỏ hơn 2MB.');
                    this.value = '';
                    preview.style.display = 'none';
                    return;
                }

                if (!file.type.match('image.*')) {
                    alert('Vui lòng chọn file hình ảnh!');
                    this.value = '';
                    preview.style.display = 'none';
                    return;
                }

                preview.src = URL.createObjectURL(file);
                preview.style.display = 'block';

                // Hide current image when uploading new one
                if (currentImage) {
                    currentImage.style.opacity = '0.5';
                }
            } else {
                preview.style.display = 'none';
                if (currentImage) {
                    currentImage.style.opacity = '1';
                }
            }
        });
    </script>
@endsection

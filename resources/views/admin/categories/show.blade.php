@extends('layout.admin-layout')

@section('content')
    <div class="container-fluid">
        <div class="row m-auto">
            <div class="card w-100 shadow-sm mb-4">
                <div class="card-header bg-info text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">
                            <i class="fas fa-info-circle me-2"></i>Chi Tiết Danh Mục
                        </h4>
                        <div>
                            @if ($category->is_active)
                                <span class="badge bg-success">
                                    <i class="fas fa-check-circle me-1"></i>Đang hoạt động
                                </span>
                            @else
                                <span class="badge bg-secondary">
                                    <i class="fas fa-times-circle me-1"></i>Tắt
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="card-body p-2">
                    @if ($category->image)
                        <div class="text-center mb-4">
                            <img src="{{ Storage::url($category->image) }}" alt="{{ $category->name }}"
                                class="img-fluid rounded shadow-sm" style="max-height: 400px;">
                        </div>
                    @else
                        <div class="text-center mb-4">
                            <i class="fas fa-image me-2 text-muted" style="font-size: 80px;"></i>
                            <p class="text-muted">Không có hình ảnh</p>
                        </div>
                    @endif

                    <table class="table table-borderless">
                        <tbody>
                            <tr>
                                <th style="width: 200px;">
                                    <i class="fas fa-hashtag me-2 text-muted"></i>ID
                                </th>
                                <td><code>{{ $category->id }}</code></td>
                            </tr>
                            <tr>
                                <th><i class="fas fa-tag me-2 text-muted"></i>Tên danh mục</th>
                                <td><strong>{{ $category->name }}</strong></td>
                            </tr>
                            <tr>
                                <th><i class="fas fa-align-left me-2 text-muted"></i>Mô tả</th>
                                <td>{{ $category->description ?? '—' }}</td>
                            </tr>
                            <tr>
                                <th> <i class="fas fa-sitemap me-2 text-muted"></i>Danh mục cha</th>
                                <td>
                                    @if ($category->parent)
                                        <a href="{{ route('categories.show', $category->parent) }}"
                                            class="text-decoration-none">
                                            <i class="fas fa-folder me-1"></i>{{ $category->parent->name }}
                                        </a>
                                    @else
                                        <span class="text-muted">— (Cấp cao nhất)</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th><i class="fas fa-folder-tree me-2 text-muted"></i>Số danh mục con</th>
                                <td><span class="badge bg-primary">{{ $category->children->count() }}</span></td>
                            </tr>
                            <tr>
                                <th> <i class="fas fa-box me-2 text-muted"></i>Số sản phẩm</th>
                                <td> <span class="badge bg-success">{{ $category->products->count() ?? 0 }}</span></td>
                            </tr>
                            <tr>
                                <th> <i class="fas fa-calendar-plus me-2 text-muted"></i>Ngày tạo</th>
                                <td>{{ $category->created_at->format('d/m/Y H:i:s') }}</td>
                            </tr>
                            <tr>
                                <th> <i class="fas fa-calendar-edit me-2 text-muted"></i>Cập nhật lần cuối</th>
                                <td>{{ $category->updated_at->format('d/m/Y H:i:s') }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="card-footer bg-light">
                    <div class="d-flex gap-2 justify-content-end">
                        <a href="{{ route('categories.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Quay lại
                        </a>
                        <a href="{{ route('categories.edit', $category) }}" class="btn btn-warning">
                            <i class="fas fa-edit me-2"></i>Chỉnh sửa
                        </a>
                        <button type="button" class="btn btn-danger" onclick="confirmDelete()">
                            <i class="fas fa-trash me-2"></i>Xóa
                        </button>
                    </div>

                    <form id="delete-form" action="{{ route('categories.destroy', $category) }}" method="POST"
                        style="display: none;">
                        @csrf
                        @method('DELETE')
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            @if ($category->children->count() > 0)
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-folder me-2"></i>
                            Danh mục con ({{ $category->children->count() }})
                        </h5>
                    </div>
                    <div class="list-group list-group-flush">
                        @foreach ($category->children as $child)
                            <a href="{{ route('categories.show', $child) }}"
                                class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                <span>
                                    @if ($child->image)
                                        <img src="{{ Storage::url($child->image) }}" alt="{{ $child->name }}"
                                            class="rounded me-2" style="width: 30px; height: 30px; object-fit: cover;">
                                    @else
                                        <i class="fas fa-folder me-2 text-muted"></i>
                                    @endif
                                    {{ $child->name }}
                                </span>
                                @if ($child->children->count() > 0)
                                    <span class="badge bg-primary rounded-pill">
                                        {{ $child->children->count() }}
                                    </span>
                                @endif
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>

    <script>
        function confirmDelete() {
            if (confirm('Bạn có chắc muốn xóa danh mục "{{ $category->name }}"?\n\nHành động này không thể hoàn tác!')) {
                document.getElementById('delete-form').submit();
            }
        }
    </script>
@endsection

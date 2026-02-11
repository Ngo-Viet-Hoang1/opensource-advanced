@extends('layout.admin-layout')

@section('content')
    <div class="container-fluid">
        <div class="card mb-3">
            <div class="card-body py-2">
                <form action="{{ route('categories.index') }}" method="GET" class="row g-2 align-items-center">
                    <div class="col-md-4">
                        <input type="text" name="search" class="form-control form-control-sm" placeholder="Tìm kiếm..."
                            value="{{ request('search') }}">
                    </div>
                    <div class="col-md-3">
                        <select name="status" class="form-select form-select-sm">
                            <option value="">Tất cả trạng thái</option>
                            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Hoạt động</option>
                            <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Tắt</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary btn-sm w-100">
                            <i class="fas fa-search me-1"></i>Tìm
                        </button>
                    </div>
                    <div class="col-md-2">
                        <a href="{{ route('categories.create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus me-1"></i>Thêm Mới
                        </a>
                    </div>
                    <div class="col-md-1 text-end">
                        <small class="text-muted">{{ $totalCategories ?? 0 }} categories</small>
                    </div>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-header py-2">
                <h6 class="mb-0"><i class="fas fa-list me-2"></i>Danh Sách Danh Mục</h6>
            </div>
            <div class="card-body p-0">
                @if ($categories->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover table-sm mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 5%">ID</th>
                                    <th style="width: 8%">Hình ảnh</th>
                                    <th style="width: 25%">Tên</th>
                                    <th style="width: 18%">Danh mục cha</th>
                                    <th style="width: 10%">Trạng thái</th>
                                    <th style="width: 12%">Ngày tạo</th>
                                    <th style="width: 12%" class="text-center">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($categories as $category)
                                    <tr>
                                        <td>{{ $category->id }}</td>

                                        <td>
                                            @if ($category->image)
                                                <img src="{{ Storage::url($category->image) }}" alt="{{ $category->name }}"
                                                    class="rounded" style="width: 45px; height: 45px; object-fit: cover;">
                                            @else
                                                <div class="bg-secondary rounded d-flex align-items-center justify-content-center"
                                                    style="width: 45px; height: 45px;">
                                                    <i class="fas fa-image text-white"></i>
                                                </div>
                                            @endif
                                        </td>

                                        <td>
                                            <strong>{{ $category->name }}</strong>
                                        </td>

                                        <td>
                                            @if ($category->parent)
                                                <span class="badge bg-light text-dark">
                                                    {{ $category->parent->name }}
                                                </span>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>

                                        <td>
                                            @if ($category->is_active)
                                                <span class="badge bg-success">Hoạt động</span>
                                            @else
                                                <span class="badge bg-secondary">Tắt</span>
                                            @endif
                                        </td>

                                        <td>
                                            <small>{{ $category->created_at->format('d/m/Y') }}</small>
                                        </td>

                                        <td class="text-center">
                                            <div class="btn-group btn-group-sm">
                                                <a href="{{ route('categories.show', $category) }}" class="btn btn-info"
                                                    title="Xem chi tiết">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('categories.edit', $category) }}" class="btn btn-warning"
                                                    title="Chỉnh sửa">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <button type="button" class="btn btn-danger"
                                                    onclick="confirmDelete({{ $category->id }}, '{{ addslashes($category->name) }}')"
                                                    title="Xóa">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>

                                            <form id="delete-form-{{ $category->id }}"
                                                action="{{ route('categories.destroy', $category) }}" method="POST"
                                                class="d-none">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    @if ($categories->hasPages())
                        <div class="card-footer py-2">
                            {{ $categories->links() }}
                        </div>
                    @endif
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-folder-open fa-3x text-muted mb-3"></i>
                        <p class="text-muted mb-2">Chưa có danh mục nào</p>
                        <a href="{{ route('categories.create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus me-1"></i>Tạo danh mục đầu tiên
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        function confirmDelete(categoryId, categoryName) {
            if (confirm('Bạn có chắc muốn xóa danh mục "' + categoryName + '"?')) {
                document.getElementById('delete-form-' + categoryId).submit();
            }
        }
    </script>
@endsection

<div class="card h-100 shadow-sm position-relative">

    @if ($product->on_sale)
        <span class="badge bg-danger position-absolute top-0 start-0 m-2">
            -{{ $product->discount_percent }}%
        </span>
    @endif

    <a href="{{ route('products.show', $product->id) }}">
        @if ($product->image)
            <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="card-img-top"
                style="height: 200px; object-fit: cover;">
        @else
            <div class="d-flex align-items-center justify-content-center bg-secondary" style="height: 200px;">
                <i class="bi bi-image fs-1 text-white"></i>
            </div>
        @endif
    </a>

    <div class="card-body">
        @if ($product->category)
            <p class="text-muted small mb-1">{{ $product->category->name }}</p>
        @endif

        <h6 class="card-title">
            <a href="{{ route('products.show', $product->id) }}" class="text-dark text-decoration-none">
                {{ $product->name }}
            </a>
        </h6>

        <p class="mb-0">
            <span class="fw-bold {{ $product->on_sale ? 'text-danger' : '' }}">
                {{ number_format($product->sale_price, 0, ',', '.') }}₫
            </span>
            @if ($product->on_sale)
                <del class="text-muted small ms-1">{{ number_format($product->price, 0, ',', '.') }}₫</del>
            @endif
        </p>
    </div>

    <div class="card-footer bg-white border-0 d-grid">
        <a href="{{ route('products.show', $product->id) }}" class="btn btn-dark btn-sm">
            Xem Chi Tiết
        </a>
    </div>

</div>

@extends('layout.app')

@section('content')

    <section class="py-5">
        <div class="container">
            <div class="row g-5">

                <div class="col-md-6">
                    @if ($product->image)
                        <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="img-fluid w-100"
                            style="max-height: 500px; object-fit: cover;">
                    @else
                        <div class="bg-secondary d-flex align-items-center justify-content-center" style="height: 450px;">
                            <i class="bi bi-image display-1 text-white"></i>
                        </div>
                    @endif
                </div>

                <div class="col-md-6">

                    <p class="text-muted small mb-1">
                        {{ $product->category->name ?? 'Chưa phân loại' }}
                        &nbsp;|&nbsp; SKU: #{{ $product->id }}
                    </p>

                    <h2 class="fw-bold">{{ $product->name }}</h2>

                    <hr />

                    <div class="mb-3">
                        <span class="fs-3 fw-bold {{ $product->on_sale ? 'text-danger' : '' }}">
                            {{ number_format($product->sale_price, 0, ',', '.') }}₫
                        </span>
                        @if ($product->on_sale)
                            <del class="text-muted ms-2 fs-5">
                                {{ number_format($product->price, 0, ',', '.') }}₫
                            </del>
                            <span class="badge bg-danger ms-2">-{{ $product->discount_percent }}%</span>
                        @endif
                    </div>

                    <p class="mb-3">
                        Tình trạng:
                        @if ($product->stock > 0)
                            <span class="text-success fw-semibold">Còn hàng ({{ $product->stock }})</span>
                        @else
                            <span class="text-danger fw-semibold">Hết hàng</span>
                        @endif
                    </p>

                    <div class="mb-3">
                        <p class="fw-semibold small text-uppercase mb-2">Số Lượng</p>
                        <div class="input-group" style="width: 140px;">
                            <button class="btn btn-outline-secondary"
                                onclick="let q=document.getElementById('qty'); q.value=Math.max(1,+q.value-1)">−</button>
                            <input type="number" id="qty" class="form-control text-center" value="1"
                                min="1" max="{{ $product->stock }}" />
                            <button class="btn btn-outline-secondary"
                                onclick="let q=document.getElementById('qty'); q.value=Math.min({{ $product->stock }},+q.value+1)">+</button>
                        </div>
                    </div>

                    <div class="d-grid gap-2 mb-3">
                        <button class="btn btn-dark btn-lg" {{ $product->stock == 0 ? 'disabled' : '' }}>
                            <i class="bi bi-cart-plus me-2"></i>Thêm Vào Giỏ Hàng
                        </button>
                        <button class="btn btn-danger btn-lg" {{ $product->stock == 0 ? 'disabled' : '' }}>
                            <i class="bi bi-lightning-fill me-2"></i>Mua Ngay
                        </button>
                        <button class="btn btn-outline-secondary">
                            <i class="bi bi-heart me-2"></i>Thêm Vào Yêu Thích
                        </button>
                    </div>

                </div>
            </div>
        </div>
    </section>


    @if ($product->description)
        <section class="py-5 bg-light border-top">
            <div class="container">
                <h5 class="mb-3">Mô Tả Sản Phẩm</h5>
                <div>{!! nl2br(e($product->description)) !!}</div>
            </div>
        </section>
    @endif


    @if ($related->isNotEmpty())
        <section class="py-5">
            <div class="container">
                <h5 class="mb-4">Sản Phẩm Tương Tự</h5>
                <div class="row g-4">
                    @foreach ($related as $item)
                        <div class="col-6 col-md-3">
                            @include('components.product-card', ['product' => $item])
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

@endsection

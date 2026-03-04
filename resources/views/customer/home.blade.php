@extends('layout.app')

@section('content')
    <div class="bg-success text-white py-5">
        <div class="container text-center py-3">
            <h1 class="display-5 fw-bold">Chào Mừng Đến ShopOnline</h1>
            <p class="lead">Mua sắm dễ dàng – Giao hàng tận nơi – Đổi trả miễn phí</p>
            <a href="#bestseller" class="btn btn-light btn-lg me-2">Mua Sắm Ngay</a>
            <a href="#" class="btn btn-outline-light btn-lg">Xem Ưu Đãi</a>
        </div>
    </div>

    <section class="py-5" id="bestseller">
        <div class="container">
            <h2 class="text-center mb-1">Sản Phẩm Bán Chạy</h2>
            <p class="text-center text-muted mb-4">Những sản phẩm được khách hàng yêu thích nhất</p>

            <div class="row g-4">
                @foreach ($bestSellers as $product)
                    <div class="col-6 col-md-3">
                        @include('product-card', ['product' => $product])
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="py-5 bg-light">
        <div class="container">
            <h2 class="text-center mb-1">Hàng Mới Về</h2>
            <p class="text-center text-muted mb-4">Cập nhật xu hướng mới nhất tuần này</p>

            <div class="row g-4">
                @foreach ($newProducts as $product)
                    <div class="col-6 col-md-3">
                        @include('product-card', ['product' => $product])
                    </div>
                @endforeach
            </div>

            <div class="text-center mt-4">
                <a href="#" class="btn btn-dark px-5">Xem Tất Cả Sản Phẩm</a>
            </div>
        </div>
    </section>
@endsection

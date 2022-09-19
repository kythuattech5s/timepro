@extends('tp::flash_sales.view')
@section('tp_css_end')
    <link rel="stylesheet" href="admin/css/font-awesome.min.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="{'admin/promotion/assets/css/flash_sales.css'}" type="text/css">
    <style>
        
    </style>
@endsection
@section('tp_content')
    <input type="hidden" name="flash_sale_id" value="{{ $currentItem->id }}">
    <div class="detail-flash-sale">
        <h2 class="fw-bold mb-3">Đăng ký sản phẩm</h2>
        <div class="r-10 bg-white p-3">
            <div class="detail-flash-sale-header">
                <div class="row">
                    <div class="col-lg-5 mb-lg-0 mb-3">
                        <div class="flash-sale-header prd-regis">
                            @include('image_loader.big', ['itemImage' => $currentItem])
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <div class="detail-fs-right">
                            <p class="flash-sale__title"><span>Khung giờ khuyến mãi</span></p>
                            <div class="flash-sale-time">
                                <input type="hidden" name="start_at" value="{{ $currentItem->start_at }}">
                                <input type="hidden" name="expired_at" value="{{ $currentItem->expired_at }}">
                                <div class="flash-sale-time--start @if ($currentItem->isRunning()) active @endif">
                                    <p class="mb-1 font-bold">Thời gian diễn ra</p>
                                    <p class="mb-1">{{ Support::showDateTime($currentItem->start_at) }} - {{ Support::showDateTime($currentItem->expired_at) }}</p>
                                    <p class="mb-1">{{ $currentItem->getStatus(false, true) }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="fs-list-product" m-checkbox="">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Khóa học</th>
                            <th>Giá khóa học</th>
                            <th>% Giảm</th>
                            <th>Kích hoạt</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($courses as $course)
                            <tr>
                                <td>{{ $course->name }}</td>
                                <td>
                                    @php
                                        $price = $course->getFirstPrice();
                                    @endphp
                                    {{ $price['price_old'] }}
                                </td>
                                <td>
                                    <input type="text" placeholder="Phần trăm giảm">
                                </td>
                                <td>
                                    <label for="switch-act-{{ $course->id }}" class="switch">
                                        <input id="switch-act-{{ $course->id }}" type="checkbox" name="act" value="0">
                                        <span class="slider"></span>
                                    </label>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>
    @include('tp::components.modalProduct')
@endsection
@section('tp_js_end')
    <script src="{'admin/promotion/assets/_rs/plugins/sweetalert2/sweetalert2.js'}"></script>
    <script src="{'admin/promotion/assets/js/DetailFlashSale.js'}" defer></script>
@endsection

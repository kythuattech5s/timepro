@extends('tp::flash_sales.view')
@section('tp_content')
    <div>
        <a class="btn btn-danger mb-5" href="{{ url()->previous() }}">Quay lại</a>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <label for="">Danh sách sản phẩm đăng ký</label>
            <table class="table border">
                <thead>
                    <tr>
                        <td>STT</td>
                        <td>Tên sản phẩm</td>
                        <td>Số lượng</td>
                        <td>Giá tiền</td>
                        <td>Phần trăm</td>
                        <td>Tối đa</td>
                        <td>Kích hoạt</td>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $key => $item)
                        @php
                            $shopFlashSaleProduct = $item->shopFlashSale->first();
                            $pivot = $shopFlashSaleProduct->pivot;
                        @endphp
                        <tr data-product-id="{{ $item->id }}" data-id="{{ $shopFlashSaleProduct->id }}">
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $pivot->qty }}</td>
                            <td>{{ $pivot->price }}</td>
                            <td>{{ $pivot->percent }} %</td>
                            <td>{{ $pivot->limit }}</td>
                            <td>
                                <label class="switch">
                                    <input type="checkbox" class="active-flash-sale-product" name="act" value="{{ $pivot->act ? 1 : 0 }}" {{ $pivot->act == 1 ? 'checked' : '' }}>
                                    <span class="slider"></span>
                                </label>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="100%">Chưa có shop nào đăng ký!</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
@section('tp_js_end')
    <script src="{'admin/promotion/assets/js/ShopFlashSale.js'}" defer></script>
@endsection

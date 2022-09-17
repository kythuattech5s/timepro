@extends('tp::flash_sales.view')
@section('tp_content')
    <div>
        <a class="btn btn-danger mb-5" href="esystem/view/flash_sales">Quay lại</a>
    </div>
    <div class="row">
        <div class="col-lg-4">
            <label for="">Thông tin chi tiết</label>
            <table class="table-first-right table border">
                <tbody>
                    <tr>
                        <td>Hỉnh ảnh</td>
                        <td><img style="max-width:80px;margin: 0 auto" src="{%IMGV2.flash_sale.img.-1%}" alt="{%AIMGV2.flash_sale.img.alt%}" title="{%AIMGV2.flash_sale.img.title%}"></td>
                    </tr>
                    <tr>
                        <td>Tên</td>
                        <th>{-flash_sale.name-}</th>
                    </tr>
                    <tr>
                        <td>Điều kiện giảm giá</td>
                        <td>{{ $flash_sale->getTypeComparision() }} {{ number_format($flash_sale->discount, 0, 2, '.') }} VND</td>
                    </tr>
                    <tr>
                        <td>Thời gian bắt đầu</td>
                        <td>{{ Support::showDateTime($flash_sale->start_at) }}</td>
                    </tr>
                    <tr>
                        <td>Thời gian kết thúc</td>
                        <td>{{ Support::showDateTime($flash_sale->expired_at) }}</td>
                    </tr>
                    <tr>
                        <td>Trạng thái</td>
                        <th>{{ $flash_sale->getStatus() }}</th>
                    </tr>
                    <tr>
                        <td>Loại giảm giá</td>
                        <td>{{ $flash_sale->promotionType->name }}</td>
                    </tr>
                    <tr>
                        <td>Mực độ ưu tiên</td>
                        <td>{-flash_sale.ord-}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="col-lg-8">
            <label for="">Danh sách shop đăng ký chương trình</label>
            <table class="table border">
                <thead>
                    <tr>
                        <td>STT</td>
                        <td>Tên shop</td>
                        <td>Kích hoạt</td>
                        <td>Thao tác</td>
                    </tr>
                </thead>
                <tbody>
                    @forelse($flash_sale->shopFlashSales as $key => $item)
                        @php
                            $checked = $item->act == 1 ? true : false;
                        @endphp
                        <tr data-id="{{ $item->id }}">
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $item->shop->name }}</td>
                            <td>
                                <label class="switch">
                                    <input type="checkbox" class="active-now" name="act" value="{{ $checked ? 1 : 0 }}" {{ $checked ? 'checked' : '' }}>
                                    <span class="slider"></span>
                                </label>
                            </td>
                            <td>
                                <a href="esystem/flash-sale/{{ $item->id }}/danh-sach-san-pham">Danh sách sản phẩm</a>
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

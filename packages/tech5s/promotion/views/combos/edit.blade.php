@extends('tp::combos.view')
@section('tp_content')
<div class="row">
    <div class="col-lg-12">
        <form action="tp/combo/update/{-currentItem.id-}" class="form-validate" method="POST"
            data-success="AJAX_PROMOTION.createSuccess" absolute check plus="COMBO.checkPriceProductForDiscount">
            <input type="hidden" name="returnurl" value="{{ request()->input('returnurl') }}">
            @csrf
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h4 class="card-title list-link text-[20px] mb-3">Sửa combo</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="manager-combo">
                                <div class="combo-group">
                                    <h4>Thông tin cơ bản</h4>
                                    <div class="combo-group__form">
                                        <label for="combo_name">Tên chương trình</label>
                                        <input class="form-control" type="text" rules="required" id="combo_name"
                                            name="name" value="{-currentItem.name-}"
                                            placeholder="Tên chương trình giảm giá">
                                    </div>
                                    <div class="combo-group__form">
                                        <label>Thời gian chạy Combo</label>
                                        <div class="combo-datetime">
                                            <input class="form-control" type="datetime-local" name="start_at"
                                                rules="required" m-required="Vui lòng chọn thời gian bắt đầu"
                                                value="{{ date('Y-m-d\TH:i', strtotime($currentItem->start_at)) }}">
                                            <input class="form-control" type="datetime-local" name="expired_at"
                                                value="{{ date('Y-m-d\TH:i', strtotime($currentItem->expired_at)) }}"
                                                rules="required" m-required="Vui lòng chọn thời gian kết thúc">
                                        </div>
                                    </div>
                                    @include('tp::combos.components.discount')
                                    <div class="combo-group__form">
                                        <label for="combo_limit">Giới hạn đặt hàng</label>
                                        <input class="form-control" type="text" rules="required" id="combo_limit"
                                            name="limit" value="{-currentItem.limit-}"
                                            placeholder="Số lượng Combo khuyến mãi tối đa mà một người có thể đặt mua">
                                    </div>
                                    <div class="combo-group__form align-items-baseline">
                                        <label for="shop_id">Điều kiện nhận quà</label>
                                        <div class="flex-1">
                                            <input type="text" placeholder="Nhập và tìm tên shop" class="search-shop form-control my-2">
                                            <select name="shop_id" id="shop_id" class="form-control">
                                                <option value="">{{$currentItem->shop->name}}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="combo-group">
                                    <h4>Sản phẩm của Combo Khuyến Mãi</h4>
                                    <div class="item-product" m-checkbox="PRODUCT_CHOOSES_COMBOS">
                                        @include('tp::combos.components.ItemShow')
                                    </div>
                                </div>
                                
                            </div>
                            <span class="frag-footer"></span>
                            <div class="form-footer">
                                <a href="{{base64_decode(request()->input('returnurl',base64_encode(url('esystem/views/combos'))))}}"
                                    class="btn bg-red-400 text-white">Quay lại</a>
                                <button class="btn bg-green-400 text-white" type="submit">Xác nhận</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@include('tp::components.modalProduct')
@endsection
@extends('tp::combos.view')
@section('tp_content')
<div class="row">
    <div class="col-lg-12">
        <form action="tp/combo/create" class="form-validate" method="POST"
            data-success="AJAX_PROMOTION.createSuccess" absolute check plus="COMBO.checkPriceProductForDiscount">
            <input type="hidden" name="returnurl" value="{{ request()->input('returnurl') }}" parent=".group-small">
            @csrf
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h4 class="card-title list-link  text-[20px] mb-3">Thêm combo</h4>
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
                                            name="name" placeholder="Tên chương trình giảm giá">
                                    </div>
                                    <div class="combo-group__form">
                                        <label>Thời gian chạy Combo</label>
                                        <div class="combo-datetime">
                                            <input class="form-control" type="datetime-local" name="start_at"
                                                rules="required" m-required="Vui lòng chọn thời gian bắt đầu"
                                                value="{{ date('Y-m-d\TH:i', time() + 60 * 10) }}">
                                            <input class="form-control" type="datetime-local" name="expired_at"
                                                value="{{ date('Y-m-d\TH:i', time() + 60 * 10 + 60 * 60) }}"
                                                rules="required" m-required="Vui lòng chọn thời gian kết thúc">
                                        </div>
                                    </div>
                                    <div class="combo-group__form align-items-baseline">
                                        <label>Loại combo</label>
                                        <div class="combo-group-options">
                                            <div class="combo-group__item">
                                                <div class="combo-group-type" m-checked="Vui lòng chọn loại giảm giá">
                                                    <input type="radio" name="type" rules="required"
                                                        value="{{ ComboHelper::TYPE_PERCENT }}">
                                                    <label for="combo-type-percent">Giảm giá theo %</label>
                                                </div>
                                                <div class="group-form" style="display:none">
                                                    <span>Mua</span>
                                                    <input type="text" name="qty" rules="required" disabled>
                                                    <span>sản phẩm để được giảm</span>
                                                    <div class="group-small">
                                                        <input type="text" name="discount" rules="required"
                                                            m-required="Vui lòng nhập % giảm giá" percent disabled>
                                                        <span>% Giảm</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="combo-group__item">
                                                <div class="combo-group-type" m-checked="Vui lòng chọn loại giảm giá">
                                                    <input type="radio" name="type"
                                                        value="{{ ComboHelper::TYPE_MONEY }}" rules="required">
                                                    <label for="combo-type-percent">Giảm giá theo số tiền</label>
                                                </div>
                                                <div class="group-form" style="display:none">
                                                    <span>Mua</span>
                                                    <input type="text" name="qty" rules="required" disabled>
                                                    <span>sản phẩm để được giảm</span>
                                                    <div class="group-small">
                                                        <input type="text" name="discount"
                                                            m-required="Vui lòng nhập mức giảm lớn hơn 0"
                                                            rules="required" disabled>
                                                        <span>₫</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="combo-group__item">
                                                <div class="combo-group-type" m-checked="Vui lòng chọn loại giảm giá">
                                                    <input type="radio" name="type"
                                                        value="{{ ComboHelper::TYPE_SPECIAL }}" rules="required">
                                                    <label for="combo-type-percent">Giảm giá đặc biệt</label>
                                                </div>
                                                <div class="group-form" style="display:none">
                                                    <span>Mua</span>
                                                    <input type="text" name="qty" rules="required" disabled>
                                                    <span>sản phẩm chỉ với</span>
                                                    <div class="group-small">
                                                        <input type="text" name="discount"
                                                            m-required="Vui lòng nhập mức giảm lớn hơn 0"
                                                            rules="required" disabled>
                                                        <span>₫</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="combo-group__form">
                                        <label for="combo_limit">Giới hạn đặt hàng</label>
                                        <input class="form-control" type="text" rules="required" id="combo_limit"
                                            name="limit"
                                            placeholder="Số lượng Combo khuyến mãi tối đa mà một người có thể đặt mua">
                                    </div>
                                    <div class="combo-group__form align-items-baseline">
                                        <label for="shop_id">Điều kiện nhận quà</label>
                                        <div class="flex-1">
                                            <input type="text" placeholder="Nhập và tìm tên shop" class="search-shop form-control my-2">
                                            <select name="shop_id" id="shop_id" class="form-control">
                                                <option value="">-- chọn Shop --</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="combo-group">
                                    <h4>Sản phẩm của Combo Khuyến Mãi</h4>
                                    <div class="item-product" m-checkbox="PRODUCT_CHOOSES_COMBOS">
                                        <button type="button" class="btn bg-blue-400 text-white" data-toggle="modal"
                                            data-target="#modalProduct" data-type="combos" data-action="{{$action}}" disabled check-shop-id>
                                            Thêm sản phẩm
                                        </button>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <span class="frag-footer"></span>
            <div class="form-footer">
                <a href="{{base64_decode(request()->input('returnurl',base64_encode(url('esystem/views/combos'))))}}"
                    class="btn bg-red-400 text-white">Quay lại</a>
                <button class="btn bg-green-400 text-white" type="submit">Xác nhận</button>
            </div>
        </form>
    </div>
</div>
@include('tp::components.modalProduct')
@endsection
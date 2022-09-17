@extends('tp::vouchers.view')
@section('tp_content')
    <div class="row">
        <div class="col-lg-12">
            <form action="tp/voucher/update/{-currentItem.id-}" class="form-validate" method="POST" data-success="AJAX_PROMOTION.createSuccess" absolute parent=".check-parent">
                <input type="hidden" name="type" value="create">
                <input type="hidden" name="returnurl" value="{{ request()->input('returnurl') }}">
                @csrf
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h4 class="card-title list-link mb-3 text-[20px]">Sửa Voucher</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-9">
                                <div class="manager-voucher">
                                    <div class="voucher-group">
                                        <h4>Thông tin cơ bản</h4>
                                        <div class="voucher-group__form">
                                            <label>Loại mã</label>
                                            <div class="voucher-type">
                                                <div class="voucher-type__item position-relative">
                                                    <input class="form-control" type="radio" id="type_code_shop" name="code_type" value="{{ VoucherHelper::CODE_TYPE_SHOP }}" {{ $currentItem->code_type == VoucherHelper::CODE_TYPE_SHOP ? 'checked' : 'disabled' }}>
                                                    <label for="type_code_shop" class="no-edit flex space-x-2">
                                                        <img src="admin/promotion/assets/images/shops.png" alt="Shop">
                                                        Voucher toàn shop
                                                    </label>
                                                </div>
                                                @if (VoucherHelper::HAS_FOR_PRODUCT)
                                                    <div class="voucher-type__item position-relative">
                                                        <input class="form-control" type="radio" id=type_code_product name="code_type" value="{{ VoucherHelper::CODE_TYPE_PRODUCT }}" {{ $currentItem->code_type == VoucherHelper::CODE_TYPE_PRODUCT ? 'checked' : 'disabled' }}>
                                                        <label for="type_code_product" class="no-edit flex space-x-2">
                                                            <img src="admin/promotion/assets/images/online-shopping.png" alt="Shop">
                                                            Voucher sản phẩm
                                                        </label>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="voucher-group__form">
                                            <label for="voucher_name">Tên chương trình giảm giá</label>
                                            <input class="form-control" type="text" rules="required" id="voucher_name" name="name" placeholder="Tên chương trình giảm giá" value="{-currentItem.name-}">
                                        </div>
                                        <div class="voucher-group__form align-items-baseline">
                                            <label for="voucher_code">Mã voucher</label>
                                            <div class="voucher-code__form">
                                                <div class="voucher-code__input check-parent">
                                                    <span class="voucher-code__prefix">{{ VoucherHelper::PREFIX_CODE }}</span>
                                                    <input class="form-control" type="text" id="voucher_code" rules="required" name="code" placeholder="Nhập mã" value="{{ $code }}">
                                                    <span class="voucher-code__suffix">{{ strlen($code) }} ký tự</span>
                                                </div>
                                                <div class="voucher-code__suggest">
                                                    <p>Vui lòng chỉ nhập các kí tự chữ cái (A-Z), số (0-9)
                                                    </p>
                                                    <p>Mã giảm giá đầy đủ là: <b>{{ VoucherHelper::PREFIX_CODE }}<span class="input_code">{{ $code }}</span>
                                                    </p></b>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="voucher-group__form">
                                            <label>Thời gian lưu mã giảm giá</label>
                                            <div class="voucher-datetime">
                                                <input class="form-control" type="datetime-local" name="start_at" rules="required" m-required="Vui lòng chọn thời gian bắt đầu" value="{{ date('Y-m-d\TH:i', strtotime($currentItem->start_at)) }}">
                                                <input class="form-control" type="datetime-local" name="expired_at" value="{{ date('Y-m-d\TH:i', strtotime($currentItem->expired_at)) }}" rules="required" m-required="Vui lòng chọn thời gian kết thúc">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="voucher-group">
                                        <h4>Thiết lập mã giảm giá</h4>
                                        <div class="voucher-group__form">
                                            <label>Loại voucher</label>
                                            <div class="voucher-saleBy">
                                                <div class="voucher-saleBy__item">
                                                    <input type="radio" id="sale_by_promotion" name="voucher_type" value="{{ VoucherHelper::VOUCHER_TYPE_PROMOTION }}" {{ $currentItem->voucher_type == VoucherHelper::VOUCHER_TYPE_PROMOTION ? 'checked' : 'disabled' }}>
                                                    <label for="sale_by_promotion" class="no-edit">
                                                        Khuyến mãi
                                                    </label>
                                                </div>
                                                @if (VoucherHelper::HAS_COIN)
                                                    <div class="voucher-saleBy__item">
                                                        <input type="radio" id="sale_by_coin" name="voucher_type" value="{{ VoucherHelper::VOUCHER_TYPE_COIN }}" {{ $currentItem->voucher_type == VoucherHelper::VOUCHER_TYPE_COIN ? 'checked' : 'disabled' }}>
                                                        <label for="sale_by_coin" class="no-edit">
                                                            Hoàn xu
                                                        </label>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="voucher-group__form">
                                            <label>Loại giảm giá | mức giảm</label>
                                            <div class="voucher-discount check-parent">
                                                <select name="type_discount" id="type-discount">
                                                    @if ($currentItem->voucher_type == VoucherHelper::VOUCHER_TYPE_PROMOTION)
                                                        <option value="{{ VoucherHelper::DISCOUNT_MONEY }}" {{ $currentItem->type_discount == VoucherHelper::DISCOUNT_MONEY ? 'selected' : '' }}>
                                                            Theo số tiền
                                                        </option>
                                                    @endif
                                                    <option value="{{ VoucherHelper::DISCOUNT_PERCENT }}" {{ $currentItem->type_discount == VoucherHelper::DISCOUNT_PERCENT ? 'selected' : '' }}>
                                                        Theo phần trăm
                                                    </option>
                                                </select>
                                                <input type="text" class="form-control" name="fake_discount" rules="required" inf placeholder="Số tiền giảm" value="{{ number_format($currentItem->discount, 0, ',', '.') }}">
                                                <input type="hidden" name="discount" value="{-currentItem.discount-}">
                                                <span for="" class="voucher-discount__prefix">
                                                    @if ($currentItem->type_discount == VoucherHelper::DISCOUNT_MONEY)
                                                        VND
                                                    @else
                                                        %
                                                    @endif
                                                </span>
                                            </div>
                                        </div>
                                        <div id="refund-limit-group" class="voucher-group__form align-items-baseline" style="{{ $currentItem->type_discount == VoucherHelper::DISCOUNT_MONEY ? 'display:none' : '' }}">
                                            <label>Mức giảm tối đa</label>
                                            <div class="choose-coin">
                                                <div class="choose-coin__type">
                                                    <div class="choose-coin__item">
                                                        <input type="radio" name="type_limit" id="choose-limit" value="{{ VoucherHelper::VOUCHER_LIMIT }}" {{ $currentItem->max_discount !== null ? 'checked' : '' }}>
                                                        <label for="choose-limit">Giới hạn</label>
                                                    </div>
                                                    <div class="choose-coin__item">
                                                        <input type="radio" name="type_limit" id="choose-no-limit" value="{{ VoucherHelper::VOUCHER_NO_LIMIT }}" {{ $currentItem->max_discount == null ? 'checked' : '' }}>
                                                        <label for="choose-no-limit">Không giới hạn</label>
                                                    </div>
                                                </div>
                                                <div class="choose-coin__footer">
                                                    <div class="input-refund-limit">
                                                        <input type="text" rules="required" class="form-control" name="fake_max_discount" placeholder="Nhập số tiền tối đa" {{ $currentItem->max_discount == null ? 'disabled' : '' }} inf value="{{ Support::numberFormat($currentItem->max_discount) }}">
                                                        <input type="hidden" name="max_discount" value="{{ $currentItem->max_discount !== null ? $currentItem->max_discount : '' }}">
                                                        <span class="limit-prefix">{{ $currentItem->voucher_type == VoucherHelper::VOUCHER_TYPE_COIN ? 'COIN' : 'VND' }}</span>
                                                    </div>
                                                    <p>Tương đương:
                                                        <b>
                                                            <span class="total-coin">{{ $currentItem->max_discount !== null ? Support::numberFormat($currentItem->max_discount) : '0' }}</span>
                                                            <span class="prefix-money">
                                                                {{ $currentItem->voucher_type == VoucherHelper::VOUCHER_TYPE_COIN ? 'COIN' : 'VND' }}
                                                            </span>
                                                        </b>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="voucher-group__form">
                                            <label>Giá trị đơn hàng tối thiểu</label>
                                            <div class="voucher-max check-parent">
                                                <span for="voucher-max__prefix" class="voucher-max__prefix">
                                                    VND
                                                </span>
                                                <input class="form-control" type="text" placeholder="Giá trị đơn hàng tối thiểu" id="voucher-max__prefix" name="fake_minimum_apply_voucher" inf value="{{ Support::numberFormat($currentItem->minimum_apply_voucher) }}">
                                                <input type="hidden" name="minimum_apply_voucher" value="{-currentItem.minimum_apply_voucher-}">
                                            </div>
                                        </div>
                                        <div class="voucher-group__form">
                                            <label>Lượt sử dụng tối đa</label>
                                            <div class="voucher-limit">
                                                <input class="form-control" type="text" rules="required" placeholder="Lượt sử dụng" id="voucher-limit" name="limit" value="{-currentItem.limit-}">
                                            </div>
                                        </div>
                                        @if (VoucherHelper::CONDITION_APPLY)
                                            <div class="voucher-group__form">
                                                <label>Điều kiện được áp dụng</label>
                                                <div class="voucher-type-used">
                                                    <div class="group-form">
                                                        <input type="radio" id="type_used_{{ VoucherHelper::TYPE_USED_NULL }}" value="{{ VoucherHelper::TYPE_USED_NULL }}" name="type_used" {{ $currentItem->type_used == VoucherHelper::TYPE_USED_NULL ? 'checked' : '' }}>
                                                        <label for="type_used_{{ VoucherHelper::TYPE_USED_NULL }}">Không áp
                                                            dụng</label>
                                                    </div>
                                                    <div class="group-form">
                                                        <input type="radio" id="type_used_{{ VoucherHelper::TYPE_USED_AFTER_BUY_ORDER }}" value="{{ VoucherHelper::TYPE_USED_AFTER_BUY_ORDER }}" name="type_used" {{ $currentItem->type_used == VoucherHelper::TYPE_USED_AFTER_BUY_ORDER ? 'checked' : '' }}>
                                                        <label for="type_used_{{ VoucherHelper::TYPE_USED_AFTER_BUY_ORDER }}">Theo
                                                            số đơn đã mua</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="voucher-group__form">
                                                <label>Áp dụng sau</label>
                                                <input name="number_satisfy" class="form-control" value={{ $currentItem->number_satisfy }} placeholder="Áp dụng sau số đơn" {{ $currentItem->type_used == VoucherHelper::TYPE_USED_NULL ? 'disabled' : '' }}>
                                            </div>
                                        @endif
                                        @if (VoucherHelper::CONDITION_RECEIVE)
                                            <div class="voucher-group__form">
                                                <label for="">Điều kiện để được nhận</label>
                                                <input type="text" class="form-control" value="{{ number_format($currentItem->condition_receive, 0, ',', '.') }}" placeholder="Giá trị đơn hàng từ..." inputNeedFormat>
                                                <input type="hidden" name="condition_receive" value="{{ $currentItem->condition_receive }}">
                                            </div>
                                        @endif
                                        <div class="voucher-group__form">
                                            <label>Độ ưu tiên</label>
                                            <input name="ord" class="form-control" value="{{ $currentItem->ord ?? 0 }}" placeholder="Độ ưu tiên">
                                        </div>
                                    </div>
                                    <div class="voucher-group footer">
                                        <h4>Hiện thị mã giảm giá và sản phẩm áp dụng</h4>
                                        <div class="voucher-group__form align-items-baseline">
                                            <label>Thiết lập hiển thị</label>
                                            <div class="voucher-public">
                                                <div class="voucher-public__group">
                                                    <input type="radio" id="voucher-public__all" name="is_public" value="{{ VoucherHelper::TYPE_PUBLIC }}" {{ (int) $currentItem->is_public == VoucherHelper::TYPE_PUBLIC ? 'checked' : '' }}>
                                                    <label for="voucher-public__all">Toàn trang</label>
                                                </div>
                                                <div class="voucher-public__group">
                                                    <input type="radio" id="voucher-public__private" name="is_public" value="{{ VoucherHelper::TYPE_PRIVATE }}" {{ (int) $currentItem->is_public == VoucherHelper::TYPE_PRIVATE ? 'checked' : '' }}>
                                                    <label for="voucher-public__private">Riêng</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="voucher-group__form align-items-baseline">
                                            <label for="">Danh mục sản phẩm được áp dụng</label>
                                            @if ($currentItem->code_type == VoucherHelper::CODE_TYPE_SHOP)
                                                <div class="voucher-category-all">
                                                    Tất cả danh mục sản phẩm
                                                </div>
                                                <div m-checkbox="CATEGORY_CHOOSE_VOUCHER" class="apply-category d-none flex-1">
                                                </div>
                                            @else
                                                <div m-checkbox="CATEGORY_CHOOSE_VOUCHER" class="apply-category flex-1">
                                                    @include('tp::vouchers.components.categoryShow', ['listItems' => $course_categories, 'listProducts' => $listCourseCategories])
                                                </div>
                                            @endif
                                        </div>
                                        <div class="voucher-group__form apply-product align-items-baseline">
                                            <label>Sản phẩm được áp dụng</label>
                                            @if ($currentItem->code_type == VoucherHelper::CODE_TYPE_SHOP)
                                                <div class="voucher-for">
                                                    Tất cả sản phẩm
                                                </div>
                                                <div class="item-product" style="display:none;">
                                                    <button style="display:none" type="button" class="btn bg-green-400 text-white" data-toggle="modal" data-target="#modalProduct" data-type="vouchers" data-action="{{ $action }}">
                                                        Thêm sản phẩm
                                                    </button>
                                                </div>
                                            @else
                                                <div class="item-product">
                                                    @include('tp::vouchers.components.ItemShow')
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                @include('tp::components.update_image')
                            </div>
                        </div>
                    </div>
                </div>
                <span class="frag-footer"></span>
                <div class="form-footer">
                    <a class="btn bg-red-400 text-white" href="{{ base64_decode(request()->input('returnurl', base64_encode(url('esystem/view/vouchers')))) }}">Quay lại</a>
                    <button class="btn bg-green-400 text-white" type="submit">Cập nhật</button>
                </div>
            </form>
        </div>
    </div>
    @include('tp::components.modalProduct')
@endsection

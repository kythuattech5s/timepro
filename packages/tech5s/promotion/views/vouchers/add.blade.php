@extends('tp::vouchers.view')
@section('tp_content')
    <div class="row">
        <div class="col-lg-12">
            <form action="tp/voucher/create" class="form-validate" method="POST"
                  data-success="AJAX_PROMOTION.createSuccess" absolute parent=".check-parent" autocomplete="off">
                <input type="hidden" name="type" value="create">
                <input type="hidden" name="returnurl" value="{{ request()->input('returnurl') }}">
                @csrf
                <div class="card">
                    <div class="card-header flex justify-between">
                        <h4 class="card-title list-link mb-3 text-[20px]">Thêm Voucher</h4>
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
                                                <div class="voucher-type__item relative">
                                                    <input class="form-control" type="radio" id="type_code_shop"
                                                           name="code_type" value="{{ VoucherHelper::CODE_TYPE_SHOP }}"
                                                           checked>
                                                    <label for="type_code_shop" class="flex space-x-2">
                                                        <img src="admin/promotion/assets/images/shops.png"
                                                             alt="Shop">
                                                        Voucher toàn shop
                                                    </label>
                                                </div>
                                                @if (VoucherHelper::HAS_FOR_PRODUCT)
                                                    <div class="voucher-type__item relative">
                                                        <input class="form-control" type="radio" id=type_code_product
                                                               name="code_type" value="{{ VoucherHelper::CODE_TYPE_PRODUCT }}">
                                                        <label for="type_code_product" class="flex space-x-2">
                                                            <img src="admin/promotion/assets/images/online-shopping.png"
                                                                 alt="Shop">
                                                            Voucher sản phẩm
                                                        </label>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="voucher-group__form">
                                            <label for="voucher_name">Tên chương trình giảm giá</label>
                                            <input class="form-control" type="text" rules="required" id="voucher_name"
                                                   name="name" placeholder="Tên chương trình giảm giá">
                                        </div>
                                        <div class="voucher-group__form align-items-baseline">
                                            <label for="voucher_code">Mã voucher</label>
                                            <div class="voucher-code__form">
                                                <div class="voucher-code__input check-parent">
                                                    <span class="voucher-code__prefix">{{ VoucherHelper::PREFIX_CODE }}</span>
                                                    <input class="form-control" type="text" id="voucher_code"
                                                           rules="required" name="code" placeholder="Nhập mã">
                                                    <span class="voucher-code__suffix">ký tự</span>
                                                </div>
                                                <div class="voucher-code__suggest">
                                                    <p>Vui lòng chỉ nhập các kí tự chữ cái (A-Z), số (0-9)
                                                    </p>
                                                    <p>Mã giảm giá đầy đủ là: <b>{{ VoucherHelper::PREFIX_CODE }}<span
                                                                  class="input_code"></span>
                                                    </p></b>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="voucher-group__form">
                                            <label>Thời gian lưu mã giảm giá</label>
                                            <div class="voucher-datetime">
                                                <input class="form-control" type="datetime-local" name="start_at"
                                                       rules="required" m-required="Vui lòng chọn thời gian bắt đầu"
                                                       value="{{ date('Y-m-d\TH:i', time() + 60 * 10) }}">
                                                <input class="form-control" type="datetime-local" name="expired_at"
                                                       value="{{ date('Y-m-d\TH:i', time() + 60 * 10 + 60 * 60) }}"
                                                       rules="required" m-required="Vui lòng chọn thời gian kết thúc">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="voucher-group">
                                        <h4>Thiết lập mã giảm giá</h4>
                                        <div class="voucher-group__form">
                                            <label>Loại voucher</label>
                                            <div class="voucher-saleBy">
                                                <div class="voucher-saleBy__item">
                                                    <input type="radio" id="sale_by_promotion" name="voucher_type"
                                                           value="{{ VoucherHelper::VOUCHER_TYPE_PROMOTION }}" checked>
                                                    <label for="sale_by_promotion">
                                                        Khuyến mãi
                                                    </label>
                                                </div>
                                                @if (VoucherHelper::HAS_COIN)
                                                    <div class="voucher-saleBy__item">
                                                        <input type="radio" id="sale_by_coin" name="voucher_type"
                                                               value="{{ VoucherHelper::VOUCHER_TYPE_COIN }}">
                                                        <label for="sale_by_coin">
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
                                                    <option value="{{ VoucherHelper::DISCOUNT_MONEY }}">Theo số tiền
                                                    </option>
                                                    <option value="{{ VoucherHelper::DISCOUNT_PERCENT }}">Theo phần trăm
                                                    </option>
                                                </select>
                                                <input type="text" class="form-control" name="fake_discount"
                                                       rules="required" placeholder="Số tiền giảm" inf>
                                                <input type="hidden" placeholder="Số tiền giảm" name="discount">
                                                <span for="" class="voucher-discount__prefix">
                                                    VND
                                                </span>
                                            </div>
                                        </div>
                                        <div id="refund-limit-group" class="voucher-group__form align-items-baseline"
                                             style="display:none">
                                            <label>Mức giảm tối đa</label>
                                            <div class="choose-coin">
                                                <div class="choose-coin__type">
                                                    <div class="choose-coin__item">
                                                        <input type="radio" name="type_limit" id="choose-limit"
                                                               value="{{ VoucherHelper::VOUCHER_LIMIT }}" checked disabled>
                                                        <label for="choose-limit">Giới hạn</label>
                                                    </div>
                                                    <div class="choose-coin__item">
                                                        <input type="radio" name="type_limit" id="choose-no-limit"
                                                               value="{{ VoucherHelper::VOUCHER_NO_LIMIT }}" disabled>
                                                        <label for="choose-no-limit">Không giới hạn</label>
                                                    </div>
                                                </div>
                                                <div class="choose-coin__footer">
                                                    <div class="input-refund-limit">
                                                        <input type="text" rules="required" class="form-control"
                                                               name="fake_max_discount" placeholder="Nhập số tiền tối đa"
                                                               disabled inf>
                                                        <input type="hidden" name="max_discount" disabled>
                                                        <span class="limit-prefix">VND</span>
                                                    </div>
                                                    <p>Tương đương: <b><span class="total-coin"></span> <span
                                                                  class="prefix-money">VND</span></b></p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="voucher-group__form">
                                            <label>Giá trị đơn hàng tối thiểu</label>
                                            <div class="voucher-max check-parent">
                                                <span for="voucher-max__prefix" class="voucher-max__prefix">
                                                    VND
                                                </span>
                                                <input class="form-control" type="text" rules="required"
                                                       placeholder="Giá trị đơn hàng tối thiểu" id="voucher-max__prefix"
                                                       name="fake_minimum_apply_voucher" value="0" inf>
                                                <input type="hidden" name="minimum_apply_voucher" value="0">
                                            </div>
                                        </div>
                                        <div class="voucher-group__form">
                                            <label>Lượt sử dụng tối đa</label>
                                            <div class="voucher-limit">
                                                <input class="form-control" type="text" rules="required"
                                                       placeholder="Lượt sử dụng" id="voucher-limit" name="limit">
                                            </div>
                                        </div>
                                        @if (VoucherHelper::CONDITION_APPLY)
                                            <div class="voucher-group__form">
                                                <label>Điều kiện được áp dụng</label>
                                                <div class="voucher-type-used">
                                                    <div>
                                                        <div class="">
                                                            <input type="radio" id="type_used_{{ VoucherHelper::TYPE_USED_NULL }}"
                                                                   value="{{ VoucherHelper::TYPE_USED_NULL }}" name="type_used"
                                                                   checked>
                                                            <label for="type_used_{{ VoucherHelper::TYPE_USED_NULL }}">Không áp
                                                                dụng</label>
                                                        </div>
                                                        <div class="">
                                                            <input type="radio"
                                                                   id="type_used_{{ VoucherHelper::TYPE_USED_AFTER_BUY_ORDER }}"
                                                                   value="{{ VoucherHelper::TYPE_USED_AFTER_BUY_ORDER }}"
                                                                   name="type_used">
                                                            <label
                                                                   for="type_used_{{ VoucherHelper::TYPE_USED_AFTER_BUY_ORDER }}">Theo
                                                                số đơn đã mua</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="voucher-group__form">
                                                <label>Áp dụng sau</label>
                                                <input name="number_satisfy" class="form-control"
                                                       placeholder="Áp dụng sau số đơn" disabled>
                                            </div>
                                        @endif
                                        @if (VoucherHelper::CONDITION_RECEIVE)
                                            <div class="voucher-group__form">
                                                <label for="">Điều kiện để được nhận</label>
                                                <input type="text" class="form-control" placeholder="Giá trị đơn hàng từ..." inf>
                                                <input type="hidden" name="condition_receive">
                                            </div>
                                        @endif
                                        <div class="voucher-group__form">
                                            <label>Độ ưu tiên</label>
                                            <input name="ord" class="form-control" value="0"
                                                   placeholder="Độ ưu tiên">
                                        </div>
                                    </div>
                                    <div class="voucher-group footer">
                                        <h4>Hiện thị mã giảm giá và sản phẩm áp dụng</h4>
                                        <div class="voucher-group__form align-items-baseline">
                                            <label>Thiết lập hiển thị</label>
                                            <div class="voucher-public">
                                                <div class="voucher-public__group">
                                                    <input type="radio" id="voucher-public__all" name="is_public"
                                                           value="{{ VoucherHelper::TYPE_PUBLIC }}" checked>
                                                    <label for="voucher-public__all">Toàn trang</label>
                                                </div>
                                                <div class="voucher-public__group">
                                                    <input type="radio" id="voucher-public__private" name="is_public"
                                                           value="{{ VoucherHelper::TYPE_PRIVATE }}">
                                                    <label for="voucher-public__private">Riêng</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="voucher-group__form align-items-baseline">
                                            <label for="">Danh mục sản phẩm được áp dụng</label>
                                            <div class="voucher-category-all">
                                                Tất cả danh mục sản phẩm
                                            </div>
                                            <div m-checkbox="CATEGORY_CHOOSE_VOUCHER" class="apply-category d-none flex-1">

                                            </div>
                                        </div>
                                        <div class="voucher-group__form apply-product align-items-baseline">
                                            <label>Sản phẩm được áp dụng</label>
                                            <div class="voucher-for">
                                                Tất cả sản phẩm
                                            </div>
                                            <div class="item-product"
                                                 m-checkbox="PRODUCT_CHOOSES_VOUCHERS">
                                                <button type="button" class="btn d-none bg-green-400 text-white"
                                                        data-toggle="modal" data-target="#modalProduct" data-type="vouchers"
                                                        data-action="{{ $action }}">
                                                    Thêm sản phẩm
                                                </button>
                                            </div>
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
                    <a class="btn bg-red-400 text-white"
                       href="{{ base64_decode(request()->input('returnurl', base64_encode(url('esystem/view/vouchers')))) }}">Quay
                        lại</a>
                    <button class="btn bg-green-400 text-white" type="submit">Tạo mã giảm giảm</button>
                </div>
            </form>
        </div>
    </div>
    @include('tp::components.modalProduct')
@endsection

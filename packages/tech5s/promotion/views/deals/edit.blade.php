@extends('tp::deals.view')
@section('tp_content')
    <div class="row">
        <div class="col-lg-12">
            <form action="/tp/deal/save" class="form-validate" method="POST"
                  data-success="AJAX_PROMOTION.createSuccess" absolute parent=".group-input">
                <input type="hidden" name="type" value="edit">
                <input type="hidden" name="returnurl" value="{{ request()->input('returnurl') }}">
                @csrf
                <div class="card">
                    <div class="card-header d-flex justify-content-between mb-5">
                        <h4 class="card-title list-link mb-3 text-[20px]">Sửa Deal</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="manager-deal">
                                    <div class="deal-group">
                                        <div class="deal-progress @if ($currentItem !== null) done @endif">
                                            <span class="number">
                                                @if ($currentItem !== null)
                                                    @include('tp::deals.components.icon_done')
                                                @endif
                                            </span>
                                        </div>
                                        <div class="content">
                                            @include('tp::deals.components.itemDeal', ['noEdit' => $product_mains->count() > 0 ? true : false])
                                        </div>
                                    </div>
                                    <div class="deal-group">
                                        <div
                                             class="deal-progress @if ($product_mains->count() > 0) done @else active @endif">
                                            <span class="number">
                                                @if ($product_mains->count() > 0)
                                                    @include('tp::deals.components.icon_done')
                                                @endif
                                            </span>
                                        </div>
                                        <div class="content">
                                            <div class="item-product-main" m-checkbox="PRODUCT_CHOOSES_PRODUCT_MAIN"
                                                 data-action="{{ $action }}">
                                                @if ($product_mains->count() > 0)
                                                    @include('tp::deals.components.itemMain', ['products' => $product_mains, 'type' => 'main', 'product_checked' => $product_main_checked, 'noEdit' => $product_subs->count() > 0 ? true : false])
                                                @else
                                                    @include('tp::deals.components.itemMainShow', ['products' => $product_mains, 'type' => 'main', 'product_checked' => $product_main_checked])
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="deal-group">
                                        <div
                                             class="deal-progress @if ($product_subs->count() > 0) done @elseif($product_subs->count() == 0 && $product_mains->count() > 0) active @endif">
                                            <span class="number">
                                                @if ($product_subs->count() > 0)
                                                    @include('tp::deals.components.icon_done')
                                                @endif
                                            </span>
                                        </div>
                                        <div class="content">
                                            <div class="item-product-sub" m-checkbox="PRODUCT_CHOOSES_PRODUCT_SUB"
                                                 data-action="{{ $action }}">
                                                @if ($product_subs->count() > 0)
                                                    @include('tp::deals.components.itemSub', ['products' => $product_subs, 'type' => 'sub', 'product_checked' => $product_sub_checked])
                                                @elseif($product_mains->count() > 0 && $currentItem->type == DealHelper::TYPE_DEAL)
                                                    <h4>Sản phẩm mua kèm</h4>
                                                    <p>Người mua có thể tận hưởng các sản phẩm mua kèm giá khuyến mãi khi họ mua
                                                        bất kỳ sản phẩm chính nào.</p>
                                                    <button type="button" class="btn bg-green-400 text-white" data-toggle="modal"
                                                            data-target="#modalProduct" data-type="{{ $promotion }}"
                                                            data-action="{{ $action }}" data-type-product="sub">
                                                        Thêm sản phẩm
                                                    </button>
                                                @elseif($product_mains->count() > 0 && $currentItem->type == DealHelper::TYPE_GIFT)
                                                    <h4>Quà tặng</h4>
                                                    <p>Người mua chỉ có thể nhận quà tặng một lần duy nhất trên một đơn
                                                        hàng.</p>
                                                    <button type="button" class="btn bg-green-400 text-white" data-toggle="modal"
                                                            data-target="#modalProduct" data-type="{{ $promotion }}"
                                                            data-action="{{ $action }}" data-type-product="sub">
                                                        Thêm sản phẩm
                                                    </button>
                                                @elseif($currentItem->type == DealHelper::TYPE_GIFT)
                                                    <h4>Sản phẩm mua kèm</h4>
                                                    <p>Người mua có thể tận hưởng các sản phẩm mua kèm giá khuyến mãi khi họ mua
                                                        bất kỳ sản phẩm chính nào.
                                                    </p>
                                                @else
                                                    <h4>Quà tặng</h4>
                                                    <p>Người mua chỉ có thể nhận quà tặng một lần duy nhất trên một đơn
                                                        hàng.</p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <span class="frag-footer"></span>
                                <div class="form-footer d-flex justify-content-end mt-4">
                                    <a href="{{ base64_decode(request()->input('returnurl', base64_encode(url('esystem/view/deals')))) }}"
                                       class="btn me-2 bg-red-400 text-white">Quay lại</a>
                                    <button class="btn bg-green-400 text-white" type="submit" @if ($currentItem !== null && $product_mains->count() > 0 && $product_subs->count() > 0) @else disabed @endif>Xác
                                        nhận</button>
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

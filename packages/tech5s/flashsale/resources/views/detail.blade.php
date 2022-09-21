@extends('tpf::master')
@section('tp_main')
    <input type="hidden" name="flash_sale_id" value="{{ $currentItem->id }}">
    <div class="detail-flash-sale">
        <p class="mb-3 bg-blue-500 p-3 text-3xl text-white">Đăng ký sản phẩm</p>
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
                            <p class="text-2xl font-bold"><span>Khung giờ khuyến mãi</span></p>
                            <div class="flash-sale-time">
                                <input type="hidden" name="start_at" value="{{ $currentItem->start_at }}">
                                <input type="hidden" name="expired_at" value="{{ $currentItem->expired_at }}">
                                <div class="flash-sale-time--start @if ($currentItem->isRunning()) active @endif">
                                    <p class="mb-1">{{ Support::showDateTime($currentItem->start_at) }} - {{ Support::showDateTime($currentItem->expired_at) }}</p>
                                    <p class="mb-1">{{ $currentItem->getStatus(false, true) }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div>
        <p class="mb-3 bg-blue-500 p-3 text-3xl text-white">{{ ucfirst(config('tpfc_setting.table_name')) }} tham gia Flash Sale</p>
        <div class="item-product" m-checkbox="PRODUCT_CHOOSES_FLASHSALE">
            @if ($listItems->count() == 0)
                <button type="button" class="btn bg-green-400 text-white" data-toggle="modal" data-target="#modalProduct">
                    <i class="fa fa-plus"></i> Thêm {{ config('tpfc_setting.table_name') }}
                </button>
            @else
                @include('tpf::components.ItemShow')
            @endif
        </div>
    </div>
    <span class="frag-footer"></span>
    <div class="form-footer mt-5">

        <button type="submit" class="btn save-product-flashsale bg-green-400 text-white">Lưu sản phẩm</button>

    </div>

    @include('tpf::components.modalProduct')
@endsection

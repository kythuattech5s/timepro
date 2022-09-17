@extends('tech5spromotion::marketing.view')
@section('css')
    <link rel="stylesheet" type="text/css" href="{'tech5sMarketing/css/marketing/flash-sale.css'}">
@endsection
@section('main')
    <form action="/sys-promotion/flash_sales/create" class="form-validate" method="POST"  plus="FLASH_SALE.saveProductNoActive" data-success="AJAX_PROMOTION.createSuccess" absolute>
        <div class="row">
            <div class="col-lg-12">
                <input type="hidden" name="type" value="create">
                <input type="hidden" name="returnurl" value="{{ request()->input('returnurl') }}">
                @csrf
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h4 class="card-title list-link">Thêm Flash Sale</h4>
                    </div>
                    <div class="flash-sale-group">
                        <h4>Thông tin cơ bản</h4>
                        <div class="flash-sale-group__form d-flex">
                            <label>Tên chương trình</label>
                            <input class="form-control" type="text" name="name" rules="required" placeholder="Tên chương trình">
                        </div>
                        <div class="flash-sale-group__form d-flex">
                            <label>Khung giờ Flashsale</label>
                            <div class="flash-sale-datetime d-flex">
                                <input class="form-control" type="datetime-local" name="start_at" rules="required"
                                    m-required="Vui lòng chọn thời gian bắt đầu"
                                    value="{{ date('Y-m-d\TH:i', time() + 60 * 10) }}">
                                <input class="form-control" type="datetime-local" name="expired_at"
                                    value="{{ date('Y-m-d\TH:i', time() + 60 * 10 + 60 * 60 * 2) }}" rules="required"
                                    m-required="Vui lòng chọn thời gian kết thúc">
                            </div>
                            <button class="btn btn-sm bg-green-400 text-white saveTimeSlot" type="button">Lưu</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="flash-sale-group">
                    <h4>Sản phẩm tham gia cùng Flash Sale</h4>
                    <div class="item-product" m-checkbox="CHOOSE_FLASH_SALE">
                        <button type="button" class="btn bg-green-400 text-white" data-action="{{$action}}" data-toggle="modal" data-target="#modalProduct"
                            data-type="flash_sales" disabled>
                            Thêm sản phẩm
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-form">
            <a href="{{base64_decode(request()->input('returnurl',base64_encode(url('esystem/views/flash_sales'))))}}" class="btn bg-red-400 text-white">Quay lại</a>
            <button type="submit" class="btn bg-green-400 text-white" disabled>Xác nhận</button>
        </div>
    </form>
    @include('tech5spromotion::marketing.modalProduct')
@endsection

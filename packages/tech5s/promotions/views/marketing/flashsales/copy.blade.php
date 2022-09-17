@extends('tech5spromotion::marketing.view')
@section('css')
    <link rel="stylesheet" type="text/css" href="{'tech5sMarketing/css/marketing/flash-sale.css'}">
@endsection
@section('main')
    <form action="/sys-promotion/flash_sales/create-copy" class="form-validate" method="POST"  plus="FLASH_SALE.saveProductNoActive" data-success="AJAX_PROMOTION.createSuccess" absolute>
        <div class="row">
            <div class="col-lg-12">
                <input type="hidden" name="type" value="create">
                <input type="hidden" name="returnurl" value="{{ request()->input('returnurl') }}">
                @csrf
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h4 class="card-title list-link">Copy Flash Sale</h4>
                    </div>
                    <div class="flash-sale-group">
                        <h4>Thông tin cơ bản</h4>
                        <div class="flash-sale-group__form d-flex">
                            <label>Tên chương trình</label>
                            <input class="form-control" type="text" name="name" placeholder="Tên chương trình">
                        </div>
                        <div class="flash-sale-group__form d-flex">
                            <label>Khung giờ Flashsale</label>
                            <div class="flash-sale-datetime d-flex">
                                @include('tech5spromotion::marketing.flashsales.editTimeSlot',['flash_sale'=> $currentItem])
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="flash-sale-group">
                    <h4>Sản phẩm tham gia cùng Flash Sale</h4>
                    <div class="item-product" m-checkbox="CHOOSE_FLASH_SALE">
                        @include('tech5spromotion::marketing.flashsales.itemShow')
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-form">

            <a href="{{base64_decode(request()->input('returnurl',base64_encode(url('esystem/views/flash_sales'))))}}" class="btn bg-red-400 text-white">Quay lại</a>
            <button type="submit" class="btn bg-green-400 text-white">Cập nhật</button>
        </div>
    </form>
    @include('tech5spromotion::marketing.modalProduct')
@endsection

@extends('index')
@section('main')
<div class="main-breadcrumb py-4">
    <div class="container">
        {{\Breadcrumbs::render('static','Thanh toán',\VRoute::get("viewPayment"))}}
    </div>
</div>
<section class="section-payment 2xl:py-14 py-6">
    <div class="container">
        <form action="{{\VRoute::get("sendPayment")}}" method="post" class="grid grid-cols-1 lg:grid-cols-2 2xl:gap-6 gap-4 formValidation" absolute data-success="NOTIFICATION.toastrMessageRedirect" accept-charset="utf8">
            @csrf
            <div class="col-span-1">
                <div class="box bg-white lg:p-4 p-2 rounded ">
                    <p class="title font-bold text-[#252525] mb-4 2xl:text-[1.125rem]">Thông tin đặt hàng</p>
                    <p class="mb-1">Họ và tên*</p>
                    <input type="text" name="name" placeholder="Nhập họ tên của bạn" class="form-control outline-none w-full py-3 px-4 rounded border-[1px] border-solid border-[#ebebeb] mb-4" value="{{Support::show($user,'name')}}" rules="required">
                    <p class="mb-1">Số điện thoại*</p>
                    <input type="text" name="phone" placeholder="Nhập số điện thoại của bạn" class="form-control outline-none w-full py-3 px-4 rounded border-[1px] border-solid border-[#ebebeb] mb-4" value="{{Support::show($user,'phone')}}" rules="required||phone">
                    <p class="mb-1">Email*</p>
                    <input type="text" name="email" placeholder="Nhập email của bạn" class="form-control outline-none w-full py-3 px-4 rounded border-[1px] border-solid border-[#ebebeb] mb-4" value="{{Support::show($user,'email')}}" rules="required||email">
                    <p class="mb-1">Ghi chú</p>
                    <textarea name="note" rows="3" class="form-control outline-none w-full py-3 px-4 rounded border-[1px] border-solid border-[#ebebeb]"></textarea>
                </div>
            </div>
            <div class="col-span-1">
                <div class="box lg:p-4 bg-white p-2 rounded 2xl:mb-6 mb-4" content-total>
                    @include('carts.components.contentTotal')
                </div>
                <div class="box lg:p-4 bg-white p-2 rounded 2xl:mb-6 mb-4 flex items-center gap-3">
                    <h1 class="title font-bold text-[#252525] 2xl:text-[1.125rem]">Mã giảm giá</h1>
                    <div class="flex-1 flex items-center relative border rounded-sm">
                        <input type="text" placeholder="Mã giảm giá..." class="w-full outline-none border-none p-3 pr-25 disabled:bg-gray-200" value="@if($voucherCheck && $voucherCheck->voucher != null) {{$voucherCheck->voucher->code}} @endif" code-voucher @if($voucherCheck && $voucherCheck->voucher != null) disabled @endif> 
                        <button class="absolute bg-gradition-main right-[5px] rounded px-3 text-white outline-none whitespace-nowrap" type="button" apply-voucher="{{$voucherCheck && $voucherCheck->voucher != null? "true" : ''}}">@if($voucherCheck && $voucherCheck->voucher != null) Bỏ áp dụng @else Áp dụng @endif</button>
                    </div>
                </div>
                <div class="box lg:p-4 p-2 bg-white rounded">
                    @include('carts.block_payment_method')
                    <button type="submit" class="btn btn-red-gradien flex w-fit mx-auto items-center justify-center font-semibold text-white lg:px-14 py-2 px-4 rounded uppercase bg-gradient-to-r from-[#F44336] to-[#C62828] shadow-[0_6px_20px_rgba(178,30,37,.4)]">Hoàn tất đơn hàng</button>
                </div>
            </div>
        </form>
    </div>
</section>
@endsection
@section('js')
    <script type="module" src="{'assets/promotion/voucher/js/client.js'}" defer></script>
@endsection
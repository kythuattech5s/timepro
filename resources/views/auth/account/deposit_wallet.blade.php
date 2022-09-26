@extends('index')
@section('main')
<div class="main-breadcrumb py-4">
    <div class="container">
        {{Breadcrumbs::render('static',trans('fdb::deposit_wallet'),\VRoute::get('deposit_wallet'))}}
    </div>
</div>
<section class="section-payment 2xl:py-14 py-6">
    <div class="container">
        <form method="POST" action="{{\VRoute::get('deposit_wallet')}}" class="formValidation grid grid-cols-1 lg:grid-cols-2 2xl:gap-6 gap-4" absolute data-success="NOTIFICATION.toastrMessageRedirect" accept-charset="utf8">
            @csrf
            <div class="col-span-1">
                <div class="box bg-white lg:p-4 p-2 rounded">
                    <p class="title font-bold text-[#252525] mb-4 2xl:text-[1.125rem]">
                        Thông tin đặt hàng
                    </p>
                    <p class="mb-1">Họ và tên*</p>
                    <input type="text" name="name" value="{{Support::show($user,'name')}}" placeholder="Nhập họ tên của bạn" class="form-control outline-none w-full py-3 px-4 rounded border-[1px] border-solid border-[#ebebeb] mb-4"/>
                    <p class="mb-1">Số điện thoại*</p>
                    <input type="text" name="phone" value="{{Support::show($user,'phone')}}" placeholder="Nhập số điện thoại của bạn" class="form-control outline-none w-full py-3 px-4 rounded border-[1px] border-solid border-[#ebebeb] mb-4"/>
                    <p class="mb-1">Email*</p>
                    <input type="text" name="email" value="{{Support::show($user,'email')}}" placeholder="Nhập email của bạn" class="form-control outline-none w-full py-3 px-4 rounded border-[1px] border-solid border-[#ebebeb] mb-4"/>
                    <p class="mb-1">Số tiền muốn nạp</p>
                    <input type="text" name="amount" placeholder="Số tiền muốn nạp" class="form-control outline-none w-full py-3 px-4 rounded border-[1px] border-solid border-[#ebebeb]"/>
                </div>
            </div>
            <div class="col-span-1">
                <div class="box lg:p-4 p-2 bg-white rounded">
                    @include('carts.block_payment_method',['list_method_notshow'=>['1']])
                    <button type="submit" class="btn btn-red-gradien flex w-fit mx-auto items-center justify-center font-semibold text-white lg:px-14 py-2 px-4 rounded uppercase bg-gradient-to-r from-[#F44336] to-[#C62828] shadow-[0_6px_20px_rgba(178,30,37,.4)]">
                        Hoàn tất đơn hàng
                    </button>
                </div>
            </div>
        </form>
    </div>
</section>
@endsection
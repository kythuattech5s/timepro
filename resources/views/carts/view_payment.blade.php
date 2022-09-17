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
                <div class="box lg:p-4 bg-white p-2 rounded 2xl:mb-6 mb-4">
                    <h1 class="title font-bold text-[#252525] mb-4 2xl:text-[1.125rem]">Thông tin đơn hàng</h1>
                    @foreach ($listItems as $item)
                        <p class="flex items-center justify-between py-2 border-b-[1px] border-solid border-[#ebebeb]">
                            <span class="name-pro text-[0.875rem] max-w-[60%]">{{Support::show($item->realItem,'name')}} (Gói: {{Support::show($item->itemTimePackage,'name')}})</span>
                            <span class="price text-[0.875rem]">{{Currency::showMoney($item->price)}}</span>
                        </p>
                    @endforeach
                    <p class="flex items-center justify-between font-semibold mt-2">
                        <span class="title">Tổng:</span>
                        <span class="total-price">{{Currency::showMoney($totalMoney)}}</span>
                    </p>
                </div>
                <div class="box lg:p-4 p-2 bg-white rounded">
                    <p class="title font-bold text-[#252525] mb-4 2xl:text-[1.125rem]">Phương thức thanh toán</p>
                    <div class="list-method mb-6">
                        @foreach ($listPaymentMethod as $key => $itemPaymentMethod)
                            <label class="payment-method__item relative w-full block mb-4 last:mb-0">
                                <input type="radio" name="payment_method" value="{{Support::show($itemPaymentMethod,'id')}}" class="opacity-0 absolute cursor-pointer" {{$key == 0 ? 'checked':''}}>
                                <p class="payment-method__content relative">
                                    @include('image_loader.big',['itemImage'=>$itemPaymentMethod,'key'=>'img'])
                                    {{Support::show($itemPaymentMethod,'name')}}
                                </p>
                                <div class="method-des mt-4 pl-20">
                                    <div class="s-content mb-2">
                                        {!!Support::show($itemPaymentMethod,'content')!!}
                                    </div>
                                    @if ($itemPaymentMethod->isPayWallet())
                                        <a href="{{\VRoute::get("recharge")}}" title="Nạp tiền" class="btn btn-red-gradien inline-flex items-center justify-center font-semibold text-white py-2 px-4 rounded uppercase bg-[#CD272F] mb-4">Nạp tiền</a>
                                    @endif
                                </div>
                            </label>
                        @endforeach
                    </div>
                    <button type="submit" class="btn btn-red-gradien flex w-fit mx-auto items-center justify-center font-semibold text-white lg:px-14 py-2 px-4 rounded uppercase bg-gradient-to-r from-[#F44336] to-[#C62828] shadow-[0_6px_20px_rgba(178,30,37,.4)]">Hoàn tất đơn hàng</button>
                </div>
            </div>
        </form>
    </div>
</section>
@endsection
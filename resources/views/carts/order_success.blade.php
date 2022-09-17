@extends('index')
@section('main')
<div class="main-breadcrumb py-4">
    <div class="container">
        {{\Breadcrumbs::render('static','Đặt hàng thành công',\VRoute::get("paymentSucess").'?order='.$order->code)}}
    </div>
</div>
<section class="payment-success 2xl:py-14 py-6">
    <div class="container text-center">
        @include('image_loader.config.all',['config_key'=>'img_order_success','noLazyLoad'=>1])
        <h1 class="title fotn-bold 2xl:text-[2.5rem] lg:text-[1.875rem] text-[1.25rem] text-[#CD272F] mt-6 mb-4">Đặt hàng thành công!</h1>
        <div class="2xl:mb-10 mb-6 s-content">
            {[text_order_success]}
        </div>
        <div class="box grid grid-cols-2 md:grid-cols-5 gap-4 bg-white py-4 2xl:px-10 rounded max-w-[1120px] mx-auto">
            <div class="col-span-1 text-center">
                <p class="mb-2">Mã đơn hàng</p>
                <p class="font-bold">{{Support::show($order,'code')}}</p>
            </div>
            <div class="col-span-1 text-center">
                <p class="mb-2">Ngày đặt</p>
                <p class="font-semibold">{{Support::showDateTime($order->created_at,'d/m/Y H:i')}}</p>
            </div>
            <div class="col-span-1 text-center">
                <p class="mb-2">Email</p>
                <p class="font-semibold">{{Support::show($order,'email')}}</p>
            </div>
            <div class="col-span-1 text-center">
                <p class="mb-2">Tổng thanh toán</p>
                <p class="font-semibold">{{Currency::showMoney($order->total_final)}}</p>
            </div>
            <div class="col-span-1 text-center">
                <p class="mb-2">Phương thức thanh toán</p>
                <p class="font-semibold">{{Support::show($order->paymentMethod,'name')}}</p>
            </div>
        </div>
    </div>
</section>
@endsection
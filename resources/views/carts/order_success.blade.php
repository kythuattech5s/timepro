@extends('index')
@section('main')
<div class="main-breadcrumb py-4">
    <div class="container">
        {{\Breadcrumbs::render('static','Đặt hàng thành công',\VRoute::get("paymentSucess").'?order='.$order->code)}}
    </div>
</div>
<section class="payment-success 2xl:py-14 py-6">
    <div class="container text-center">
        <img src="theme/frontend/images/bg-success.png" class="inline-block" alt="">
        <p class="title fotn-bold 2xl:text-[2.5rem] lg:text-[1.875rem] text-[1.25rem] text-[#CD272F] mt-6 mb-4">
            Đặt hàng thành công!
        </p>
        <p class="2xl:mb-10 mb-6">Cảm ơn bạn đã tin tưởng và đặt hàng tại Times Pro Edu! Mã kích hoạt sẽ được gửi về email của bạn</p>
        <div class="box grid grid-cols-2 md:grid-cols-4 gap-4 bg-white py-4 2xl:px-10 rounded max-w-[1120px] mx-auto">
            <div class="col-span-1 text-center">
                <p class="mb-2">Thời gian</p>
                <p class="font-semibold">07/09/2022 - 07/12/2022</p>
            </div>
            <div class="col-span-1 text-center">
                <p class="mb-2">Email</p>
                <p class="font-semibold">abc@gmail.com</p>
            </div>
            <div class="col-span-1 text-center">
                <p class="mb-2">Tổng thanh toán</p>
                <p class="font-semibold">500.000đ</p>
            </div>
            <div class="col-span-1 text-center">
                <p class="mb-2">Phương thức thanh toán</p>
                <p class="font-semibold">Ví VNPay</p>
            </div>
        </div>
    </div>
</section>
@endsection
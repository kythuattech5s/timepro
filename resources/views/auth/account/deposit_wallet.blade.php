@extends('index')
@section('main')
<div class="main-breadcrumb py-4">
    <div class="container">
        {{Breadcrumbs::render('static',trans('fdb::deposit_wallet'),\VRoute::get('deposit_wallet'))}}
    </div>
</div>
<section class="section-payment 2xl:py-14 py-6">
    <div class="container">
        <div class="grid grid-cols-1 lg:grid-cols-2 2xl:gap-6 gap-4">
            <div class="col-span-1">
                <div class="box bg-white lg:p-4 p-2 rounded">
                    <p class="title font-bold text-[#252525] mb-4 2xl:text-[1.125rem]">
                        Thông tin đặt hàng
                    </p>
                    <p class="mb-1">Họ và tên*</p>
                    <input type="text" name="" placeholder="Nhập họ tên của bạn" class="form-control outline-none w-full py-3 px-4 rounded border-[1px] border-solid border-[#ebebeb] mb-4"/>
                    <p class="mb-1">Số điện thoại*</p>
                    <input type="text" name="" placeholder="Nhập số điện thoại của bạn" class="form-control outline-none w-full py-3 px-4 rounded border-[1px] border-solid border-[#ebebeb] mb-4"/>
                    <p class="mb-1">Email*</p>
                    <input type="text" name="" placeholder="Nhập email của bạn" class="form-control outline-none w-full py-3 px-4 rounded border-[1px] border-solid border-[#ebebeb] mb-4"/>
                    <p class="mb-1">Số tiền muốn nạp</p>
                    <input type="text" name="" placeholder="Số tiền muốn nạp" class="form-control outline-none w-full py-3 px-4 rounded border-[1px] border-solid border-[#ebebeb]"/>
                </div>
            </div>
            <div class="col-span-1">
                <div class="box lg:p-4 p-2 bg-white rounded">
                    <p class="title font-bold text-[#252525] mb-4 2xl:text-[1.125rem]">
                        Phương thức thanh toán
                    </p>
                    <div class="list-method mb-6">
                        <label class="payment-method__item relative w-full block mb-4 last:mb-0">
                            <input type="radio" name="method" class="opacity-0 absolute cursor-pointer"/>
                            <p class="payment-method__content relative">
                                <img src="theme/frontend/images/payment-1.svg" class="inline-block w-10 object-contain mr-2" alt=""/>
                                Chuyển khoản qua Internet Banking
                            </p>
                            <div class="method-des mt-4 pl-20">
                                <p class="mb-2">
                                    Nạp tiền vào ví hoặc chuyển khoản
                                    trực tiếp
                                </p>
                                <a  href="#" title="Nạp tiền" class="btn btn-red-gradien inline-flex items-center justify-center font-semibold text-white py-2 px-4 rounded uppercase bg-[#CD272F] mb-4">
                                    Nạp tiền
                                </a>
                                <p class="mb-2 text-[#252525] pb-2 border-b-[1px] border-solid border-[#ebebeb]">
                                    Thông tin chuyển khoản
                                </p>
                                <div class="bank-info__detail py-2 border-b-[1px] border-solid border-[#ebebeb]">
                                    <img src="theme/frontend/images/tech.png"alt=""/>
                                    <p class="mb-2 last:mb-0">
                                        Tên chủ tài khoản: Dương Minh Đức
                                    </p>
                                    <p class="mb-2 last:mb-0">
                                        Số tài khoản: 12345678910
                                    </p>
                                    <p class="mb-2 last:mb-0">
                                        Chi nhánh: Techcombank Cầu Giấy - Hà Nội
                                    </p>
                                </div>
                                <div class="bank-info__detail py-2 border-b-[1px] border-solid border-[#ebebeb]">
                                    <img src="theme/frontend/images/bidv.png" alt=""/>
                                    <p class="mb-2 last:mb-0">
                                        Tên chủ tài khoản: Dương Minh
                                        Đức
                                    </p>
                                    <p class="mb-2 last:mb-0">
                                        Số tài khoản: 12345678910
                                    </p>
                                    <p class="mb-2 last:mb-0">
                                        Chi nhánh: Techcombank Cầu Giấy
                                        - Hà Nội
                                    </p>
                                </div>
                                <p class="font-semibold text-[#252525] mb-2 mt-4">
                                    Ghi chú chuyển khoản
                                </p>
                                <p class="note rounded p-3 text-center bg-[#f5f5f5]">
                                    Số điện thoại, E-mail
                                </ơ>
                            </div>
                        </label>
                        <label class="payment-method__item relative w-full block mb-4 last:mb-0">
                            <input type="radio" name="method" class="opacity-0 absolute cursor-pointer" />
                            <p class="payment-method__content relative">
                                <img src="theme/frontend/images/payment-2.svg" class="inline-block w-10 object-contain mr-2" alt=""/>
                                Thanh toán qua ví VNPAY
                            </p>
                        </label>
                        <label class="payment-method__item relative w-full block mb-4 last:mb-0">
                            <input type="radio" name="method" class="opacity-0 absolute cursor-pointer"/>
                            <p class="payment-method__content relative">
                                <img src="theme/frontend/images/payment-3.svg" class="inline-block w-10 object-contain mr-2" alt=""/>
                                Thanh toán trực tiếp tại văn phòng
                            </p>
                        </label>
                    </div>
                    <button class="btn btn-red-gradien flex w-fit mx-auto items-center justify-center font-semibold text-white lg:px-14 py-2 px-4 rounded uppercase bg-gradient-to-r from-[#F44336] to-[#C62828] shadow-[0_6px_20px_rgba(178,30,37,.4)]">
                        Hoàn tất đơn hàng
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
<?php
$user = Auth::user();
$wallet = $user->wallet()->first();
?>
<div class="box-info-student mb-2 rounded bg-white p-4">
    @if (Support::show($user, 'img'))
        <span class="ava img-ava mx-auto mb-4 block h-20 w-20 overflow-hidden rounded-full lg:h-24 lg:w-24 2xl:h-40 2xl:w-40">
            @include('image_loader.tiny', ['keyImage' => 'img', 'itemImage' => $user])
        </span>
    @else
        <span class="ava mx-auto mb-4 block h-20 w-20 overflow-hidden rounded-full lg:h-24 lg:w-24 2xl:h-40 2xl:w-40">
            @include('image_loader.config.tiny', ['config_key' => 'logo'])
        </span>
    @endif
    <p class="name mb-2 text-center font-bold text-[#252525] 2xl:text-[1.25rem]">{{ Support::show($user, 'name') }}</p>
    <p class="text color-gradient text-center font-semibold">Học viên</p>

    <hr class="line my-4 border-[#ebebeb] opacity-100">
    <p class="contact-sutdent mb-2">
        <strong class="font-semibold">Email</strong>
        {{ Support::show($user, 'email') }}
    </p>
    <p class="contact-sutdent mb-2">
        <strong class="font-semibold">Số điện thoại</strong>
        {{ Support::show($user, 'phone') }}
    </p>
    <p class="contact-sutdent mb-2">
        <strong class="font-semibold">Khóa học đã tham gia</strong>
        {{ count($user->userAllCourseId()) }}
    </p>
    <hr class="line my-4 border-[#ebebeb] opacity-100">
    <div class="box-wallet flex items-center justify-between gap-4">
        <div class="wallet-balance">
            <p class="title mb-1 text-[0.75rem] font-semibold">Số dư ví: </p>
            <p class="price color-gradient text-[1rem] font-bold lg:text-[1.125rem]">{{ Currency::showMoney(Support::show($wallet, 'amount_available')) }}</p>
        </div>
        <a href="{{ \VRoute::get('deposit_wallet') }}" title="Nạp tiền" class="btn btn-red-gradien inline-flex items-center justify-center rounded-[1.25rem] bg-gradient-to-r from-[#F44336] to-[#C62828] py-2 px-4 font-semibold text-white shadow-[0_6px_20px_rgba(178,30,37,.4)]">
            <svg width="25" height="24" class="mr-2 inline-block" viewBox="0 0 25 24" fill="none"
                 xmlns="http://www.w3.org/2000/svg">
                <path d="M17.5019 6.99832V5.9979C17.5019 4.89287 16.6061 3.99707 15.5011 3.99707H5.99714C4.61585 3.99707 3.49609 5.11682 3.49609 6.49811V18.5031C3.49609 19.8844 4.61585 21.0042 5.99714 21.0042H19.0026C20.3838 21.0042 21.5036 19.8844 21.5036 18.5031V8.99915C21.5036 7.89412 20.6078 6.99832 19.5028 6.99832H3.49609" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                <path d="M17.5008 14.0012H15.5" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
            <span>Nạp tiền</span>
        </a>
    </div>
</div>

<a href="{{ \VRoute::get('my_course') }}" class="sidebar-admin__item {{ Str::contains(url()->current(), [\VRoute::get('my_course')]) ? 'active' : '' }} mb-2 flex items-center justify-between rounded bg-white py-3 px-4 transition-all duration-300 2xl:px-6">

    <span class="title font-bold text-[#252525]">Khóa học của tôi</span>
    <i class="fa fa-angle-right text-[1.875rem]" aria-hidden="true"></i>
</a>
<a href="{{ \VRoute::get('my_exam') }}" class="sidebar-admin__item {{ Str::contains(url()->current(), [\VRoute::get('my_exam')]) ? 'active' : '' }} mb-2 flex items-center justify-between rounded bg-white py-3 px-4 transition-all duration-300 2xl:px-6">
    <span class="title font-bold text-[#252525]">Kỳ thi</span>
    <div class="noti">
        <span class="count mr-4 inline-block h-5 min-w-[1.25rem] rounded-full bg-gradient-to-r from-[#F44336] to-[#C62828] text-center text-[0.875rem] font-semibold leading-5 text-white">{{ $user->getCountNeedDoneExam() }}</span>
        <i class="fa fa-angle-right text-[1.875rem]" aria-hidden="true"></i>
    </div>
</a>
<a href="{{ \VRoute::get('my_exam_result') }}" class="sidebar-admin__item {{ Str::contains(url()->current(), [\VRoute::get('my_exam_result')]) ? 'active' : '' }} mb-2 flex items-center justify-between rounded bg-white py-3 px-4 transition-all duration-300 2xl:px-6">
    <span class="title font-bold text-[#252525]">Kết quả thi</span>
    <i class="fa fa-angle-right text-[1.875rem]" aria-hidden="true"></i>
</a>
<a href="{{ \VRoute::get('my_profile') }}" class="sidebar-admin__item {{ Str::contains(url()->current(), [\VRoute::get('my_profile')]) ? 'active' : '' }} mb-2 flex items-center justify-between rounded bg-white py-3 px-4 transition-all duration-300 2xl:px-6">
    <span class="title font-bold text-[#252525]">Thông tin cá nhân</span>
    <i class="fa fa-angle-right text-[1.875rem]" aria-hidden="true"></i>
</a>
<<<<<<< HEAD
<a href="{{ \VRoute::get('my_notification') }}" class="sidebar-admin__item {{ Str::contains(url()->current(), [\VRoute::get('my_notification')]) ? 'active' : '' }} mb-2 flex items-center justify-between rounded bg-white py-3 px-4 transition-all duration-300 2xl:px-6">
=======
{{-- <a href="{{\VRoute::get('my_notification')}}" class="sidebar-admin__item bg-white rounded flex items-center justify-between py-3 2xl:px-6 px-4 mb-2 transition-all duration-300 {{Str::contains(url()->current(),[\VRoute::get('my_notification')]) ? 'active':''}}">
>>>>>>> 817ae984474702e0a448b0ba948336d65fda760e
    <span class="title font-bold text-[#252525]">Thông báo</span>
    <div class="noti flex items-center">
        <span class="count mr-4 inline-block h-5 min-w-[1.25rem] rounded-full bg-gradient-to-r from-[#F44336] to-[#C62828] text-center text-[0.875rem] font-semibold leading-5 text-white" count-not-read>
            @php
                if (!isset($countNotifiactionNoRead)) {
                    $countNotifiactionNoRead =
                        $user !== null
                            ? $user
                                ->unreadNotifications()
                                ->whereHas('catalog', function ($q) {
                                    $q->where('act', 1);
                                })
                                ->count()
                            : 0;
                }
            @endphp
            {{ $countNotifiactionNoRead }}
        </span>
        <i class="fa fa-angle-right text-[1.875rem]" aria-hidden="true"></i>
    </div>
<<<<<<< HEAD
</a>
<a href="{{ \VRoute::get('my_order') }}" class="sidebar-admin__item {{ Str::contains(url()->current(), [\VRoute::get('my_order')]) ? 'active' : '' }} mb-2 flex items-center justify-between rounded bg-white py-3 px-4 transition-all duration-300 2xl:px-6">
    <span class="title font-bold text-[#252525]">Theo dõi đơn hàng</span>
    <i class="fa fa-angle-right text-[1.875rem]" aria-hidden="true"></i>
</a>
<a href="{{ \VRoute::get('my_question') }}" class="sidebar-admin__item {{ Str::contains(url()->current(), [\VRoute::get('my_question')]) ? 'active' : '' }} mb-2 flex items-center justify-between rounded bg-white py-3 px-4 transition-all duration-300 2xl:px-6">
=======
</a> --}}
<a href="{{\VRoute::get('my_order')}}" class="sidebar-admin__item bg-white rounded flex items-center justify-between py-3 2xl:px-6 px-4 mb-2 transition-all duration-300 {{Str::contains(url()->current(),[\VRoute::get('my_order')]) ? 'active':''}}">
    <span class="title font-bold text-[#252525]">Theo dõi đơn hàng</span>
    <i class="fa fa-angle-right text-[1.875rem]" aria-hidden="true"></i>
</a>
{{-- <a href="{{\VRoute::get('my_question')}}" class="sidebar-admin__item bg-white rounded flex items-center justify-between py-3 2xl:px-6 px-4 mb-2 transition-all duration-300 {{Str::contains(url()->current(),[\VRoute::get('my_question')]) ? 'active':''}}">
>>>>>>> 817ae984474702e0a448b0ba948336d65fda760e
    <span class="title font-bold text-[#252525]">Câu hỏi thắc mắc</span>
    <i class="fa fa-angle-right text-[1.875rem]" aria-hidden="true"></i>
</a> --}}
{{-- <a href="{{\VRoute::get('my_payment_history')}}" class="sidebar-admin__item bg-white rounded flex items-center justify-between py-3 2xl:px-6 px-4 mb-2 transition-all duration-300">
    <span class="title font-bold text-[#252525]">Lịch sử thanh toán</span>
    <i class="fa fa-angle-right text-[1.875rem]" aria-hidden="true"></i>
</a> --}}
<a href="{{ \VRoute::get('upgrade_account') }}" class="sidebar-admin__item {{ Str::contains(url()->current(), [\VRoute::get('upgrade_account')]) ? 'active' : '' }} mb-2 flex items-center justify-between rounded bg-white py-3 px-4 transition-all duration-300 2xl:px-6">
    <div class="vip">
        <img src="theme/frontend/images/vip.svg" class="mr-2 inline-block" alt="">
        <span class="title font-bold text-[#252525]">Nâng cấp tài khoản VIP</span>
    </div>
    <i class="fa fa-angle-right text-[1.875rem]" aria-hidden="true"></i>
</a>

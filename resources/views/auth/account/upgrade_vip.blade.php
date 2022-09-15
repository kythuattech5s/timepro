@extends('index')
@section('main')
<section class="2xl:py-8 py-6 bg-[#EEEAEA]">
    <div class="container">
        <div class="grid grid-cols-1 lg:grid-cols-4 2xl:gap-8 gap-4">
            <div class="col-span-1">
                @include('auth.account.sidebar')
            </div>
            <div class="col-span-1 lg:col-span-3">
                @include('auth.account.notification_exam')
                <div class="box-content bg-white p-4 rounded 2xl:mb-6 mb-4 last:mb-0 pt-0">
                    <div class="head-vip text-white mx-[-1rem] font-bold uppercase 2xl:text-[1.25rem] text-[1rem] text-center 2xl:py-7 py-4 px-4 bg-no-repeat bg-cover mb-4" style="background-image: url(theme/frontend/images/bg-head-vip.jpg);">
                        ĐĂNG KÝ GÓI TÀI KHOẢN VIP - NHẬN VÔ VÀN ƯU ĐÃI
                    </div>
                    <div class="swiper-container slide-package__vip">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide h-auto">
                                <div class="item-package__vip h-full rounded overflow-hidden border-[1px] border-solid border-[#ebebeb]">
                                    <div class="img c-img pt-[45%]">
                                        <img src="theme/frontend/images/img-vip.jpg" alt="">
                                    </div>
                                    <div class="content lg:p-4 p-2 -mt-12 relative">
                                        <span class="icon block mx-auto w-16 h-16 rounded-full overflow-hidden mb-2">
                                            <img src="theme/frontend/images/icon-vip.png" alt="">
                                        </span>
                                        <p class="title font-bold text-[#252525] lg:text-[1.125rem] text-center mb-2">Gói VIP 1</p>
                                        <div class="s-content mb-2">
                                            <ul>
                                                <li>Học tất cả các khóa học có trên website trong 3 tháng</li>
                                                <li>Có name - tag tài khoản VIP</li>
                                            </ul>
                                        </div>
                                        <a href="#" title="Nâng cấp ngay"
                                            class="btn btn-red-gradien uppercase inline-flex w-full items-center justify-center font-semibold text-white py-2 px-6 rounded bg-gradient-to-r from-[#F44336] to-[#C62828]">
                                            Nâng cấp ngay
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="flex justify-center items-center gap-4 mt-6">
                            <div class="package-prev swiper-package cursor-pointer">
                                <svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M23.75 15H6.25" stroke="#888888" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M15 6.25L6.25 15L15 23.75" stroke="#888888" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </div>
                            <div class="pagination-red pagintion-package"></div>
                            <div class="package-next swiper-package cursor-pointer">
                                <svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M6.25 15H23.75" stroke="#888888" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M15 6.25L23.75 15L15 23.75" stroke="#888888" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>

                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>
@endsection

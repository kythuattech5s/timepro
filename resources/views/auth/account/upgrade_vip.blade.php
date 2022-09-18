@extends('index')
@section('main')
<section class="2xl:py-8 py-6 bg-[#EEEAEA]">
    <div class="container">
        <div class="grid grid-cols-1 lg:grid-cols-4 2xl:gap-8 gap-4">
            <div class="col-span-1">
                @include('auth.account.sidebar')
            </div>
            <div class="col-span-1 lg:col-span-3">
                <div class="box-content bg-white p-4 rounded 2xl:mb-6 mb-4 last:mb-0 pt-0">
                    <div class="head-vip text-white mx-[-1rem] font-bold uppercase 2xl:text-[1.25rem] text-[1rem] text-center 2xl:py-7 py-4 px-4 bg-no-repeat bg-cover mb-4" style="background-image: url(theme/frontend/images/bg-head-vip.jpg);">
                        ĐĂNG KÝ GÓI TÀI KHOẢN VIP - NHẬN VÔ VÀN ƯU ĐÃI
                    </div>
                    @if (count($listCourseCombo) > 0)
                        <div class="swiper-container slide-package__vip">
                            <div class="swiper-wrapper">
                                @foreach ($listCourseCombo as $item)
                                    @php
                                        $fisrtPackage = $item->timePackage->first();
                                    @endphp
                                    <div class="swiper-slide h-auto">
                                        <div class="item-package__vip h-full rounded overflow-hidden border-[1px] border-solid border-[#ebebeb] buy-item-box">
                                            <div class="img c-img pt-[45%]">
                                                <img src="theme/frontend/images/img-vip.jpg" alt="">
                                            </div>
                                            <div class="content lg:p-4 p-2 -mt-12 relative">
                                                <span class="icon block mx-auto w-16 h-16 rounded-full overflow-hidden mb-2">
                                                    <img src="theme/frontend/images/icon-vip.png" alt="">
                                                </span>
                                                <p class="title font-bold text-[#252525] lg:text-[1.125rem] text-center mb-2">{{Support::show($item,'name')}}</p>
                                                <div class="s-content mb-2">
                                                    {!!$item->content!!}
                                                </div>
                                                <div class="box-price">
                                                    <span class="price lg:text-[1.375rem] text-[1.1rem] color-gradient font-semibold item-price-main"></span>
                                                    <span class="price-old text-[#888888] mr-2 line-through item-price-sub"></span>
                                                </div>
                                                <select class="w-full px-[1rem] py-[0.8125rem] text-[#888888] bg-[#F5F5F5] rounded rounded-[5px] overflow-hidden my-[0.825rem] font-semibold select-time-package">
                                                    @foreach ($item->timePackage as $key => $itemTimePackage)
                                                        <option value="{{$itemTimePackage->id}}" data-price="{{Currency::showMoney($itemTimePackage->price)}}" data-subprice="{{$itemTimePackage->price_old > $itemTimePackage->price ? Currency::showMoney($itemTimePackage->price_old):''}}">{{$itemTimePackage->name}}</option>
                                                    @endforeach
                                                </select>
                                                @if (isset($fisrtPackage))
                                                    <a href="javascript:void(0)" title="Nâng cấp ngay" class="btn btn-red-gradien uppercase inline-flex w-full items-center justify-center font-semibold text-white py-2 px-6 rounded bg-gradient-to-r from-[#F44336] to-[#C62828] btn-buy-item" data-action="buy-now" data-type="vip" data-id="{{$item->id}}" data-package="{{$fisrtPackage->id}}">
                                                        Nâng cấp ngay
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
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
                    @else
                        <p class="text-[1.125rem]">Tạm thời chưa có gói Vip nào.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

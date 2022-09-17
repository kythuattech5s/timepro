@extends('index')
@section('main')
    <div class="main-breadcrumb py-4">
        <div class="container">
            {{\Breadcrumbs::render('static','Giỏ hàng',\VRoute::get("viewCart"))}}
        </div>
    </div>
    <section class="section-cart 2xl:py-14 py-6">
        <div class="container">
            <h1 class="title font-bold text-[#252525] 2xl:text-[1.6rem] lg:text-[1.3rem] text-[1rem] uppercase mb-4">GIỎ HÀNG CỦA BẠN</h1>
            @if (count($listItems) > 0)
                <div class="grid grid-cols-1 lg:grid-cols-3 2xl:gap-6 gap-4">
                    <div class="col-span-1 lg:col-span-2">
                        <div class="box bg-white lg:p-4 p-2 rounded">
                            @foreach ($listItems as $item)
                                <div class="item-pro__cart sm:flex items-center justify-between py-4 border-b-[1px] border-solid border-[#ebebeb] last:border-none" rowcart="{{$item->rowId}}">
                                    <div class="box-pro flex lg:gap-4 gap-2 sm:max-w-[85%] md:max-w-[70%]">
                                        <div class="image shrink-0 w-[120px] sm:w-[170px]">
                                            <a href="{{Support::show($item->realItem,'slug')}}" title="{{Support::show($item->realItem,'name')}}" class="img block c-img pt-[77%] rounded overflow-hidden">
                                                @include('image_loader.big',['itemImage'=>$item->realItem,'key'=>'img'])
                                            </a>
                                        </div>
                                        <div class="content">
                                            <h3>
                                                <a href="{{Support::show($item->realItem,'slug')}}" title="{{Support::show($item,'name')}}" class="title block font-bold 2xl:text-[1.125rem] mb-3">{{Support::show($item,'name')}}</a>
                                            </h3>
                                            @if (isset($item->realItem->teacher))
                                                <p class="text-[#888] text-[0.875rem] mb-1">{{Support::show($item->realItem->teacher,'name')}}</p>
                                            @endif
                                            <p class="text-[#888] text-[0.875rem] mb-1">Gói: {{Support::show($item->itemTimePackage,'name')}}</p>
                                            <p class="price font-semibold color-gradient">{{Currency::showMoney($item->price)}}</p>
                                        </div>
                                    </div>
                                    <a href="javascript:void(0)" title="Xóa" class="btn-delete flex w-[1.875rem] h-[1.875rem] rounded-full items-center justify-center sm:w-auto sm:h-auto bg-[#d9d9d9] sm:bg-transparent mx-auto sm:mr-0 mt-2 lg:text-[1.875rem] text-[1.25rem] btn-delete-item-cart" data-row="{{$item->rowId}}" data-instance="{{$item->instance}}"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="col-span-1">
                        <div class="bg-white lg:p-4 p-2 rounded">
                            <p class="flex items-center justify-between mb-4">
                                <span class="title font-bold text-[#252525] 2xl:text-[1.125rem]">Tổng tiền</span>
                                <span class="price font-bold text-[#CD272F] 2xl:text-[1.6rem] lg:text-[1.3rem] text-[1rem]">{{Currency::showMoney($totalMoney)}}</span>
                            </p>
                            <a href="{{\VRoute::get("viewPayment")}}" title="Thanh toán" class="btn btn-red-gradien inline-flex w-full items-center justify-center font-semibold text-white py-2 px-4 rounded bg-gradient-to-r from-[#F44336] to-[#C62828]">Thanh toán</a>
                        </div>
                    </div>
                </div>
            @else
                <div class="bg-white rounded p-3">
                    <p class="text-[1.125rem]">Bạn chưa có sản phẩm nào trong giỏ hàng.</p>
                </div>
            @endif
        </div>
    </section>
    @if (count($listRelateCourse) > 0)
        <section class="2xl:py-14 2xl:pt-6 py-6">
            <div class="container">
                <p class="title font-bold text-[#252525] 2xl:text-[1.6rem] lg:text-[1.3rem] text-[1rem] uppercase mb-4">
                    THƯỜNG ĐƯỢC MUA CÙNG
                </p>
                <div class="swiper-container slide-bundled__pro">
                    <div class="swiper-wrapper">
                        @foreach ($listRelateCourse as $item)
                            <div class="swiper-slide h-auto">
                                @include('courses.item')
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    @endif
@endsection
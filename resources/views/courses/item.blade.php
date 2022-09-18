@php
    $firstPriceInfo = $item->getFirstPrice();
@endphp
<div class="item-course flex flex-col h-full bg-white rounded-lg overflow-hidden border-[1px] border-solid border-[#ebebeb] transition-all duration-300 hover:border-transparent hover:shadow-[0_4px_10px_rgba(0,0,0,.3)]">
    <div class="relative shrink-0 box-img">
        @if (!$item->isFree() && $firstPriceInfo['sale_percent'] > 0)
            <span class="discount absolute top-0 left-6 z-[1] rounded-b-md font-semibold text-white text-[0.875rem] bg-gradient-to-r from-[#F44336] to-[#C62828] inline-block p-1">-{{$firstPriceInfo['sale_percent']}}%</span>
        @endif
        <a href="{{Support::show($item,'slug')}}" title="{{Support::show($item,'name')}}" class="img img__ block c-img pt-[70%]">
            @include('image_loader.big',['itemImage'=>$item,'key'=>'img'])
        </a>
        <div
            class="info-course z-[1] text-white absolute bottom-0 left-0 w-full bg-[rgba(0,0,0,.35)] py-1 px-6 flex items-center justify-between">
            <span class="item md:text-[0.875rem]">
                <img src="theme/frontend/images/users.svg" class="mr-1 inline-block w-6 h-6 object-contain" alt="user">
                {{$item->number_student+$plusMoreStudentNumber}}
            </span>
            <span class="item md:text-[0.875rem]">
                <img src="theme/frontend/images/time.svg" class="mr-1 inline-block w-6 h-6 object-contain" alt="time">
                {{Support::show($item,'duration')}} phút
            </span>
        </div>
    </div>
    <div class="content flex-1 flex flex-col 2xl:p-4 lg:p-2 p-1">
        <h3>
            <a href="{{Support::show($item,'slug')}}" title="{{Support::show($item,'name')}}" class="title font-bold 2xl:text-[1.125rem] text-[#252525] block line-clamp-2 mb-2">{{Support::show($item,'name')}}</a>
        </h3>
        @if (isset($item->teacher))
            <div class="teacher flex items-center gap-2 mb-4">
                <span class="ava img-ava block lg:w-10 lg:h-10 w-8 h-8 rounded-full overflow-hidden shrink-0">
                    @include('image_loader.tiny',['itemImage'=>$item->teacher,'key'=>'img'])
                </span>
                <div class="teacher-info">
                    <p class="name font-semibold text-[0.875rem] text-[#252525]">{{Support::show($item->teacher,'name')}}</p>
                    <p class="desc text-[#888] text-[0.875rem]">{{Support::show($item->teacher,'teacher_job')}}</p>
                </div>
            </div>
        @endif
        <div class="flex gap-4 items-end justify-between button-action mt-auto">
            <a href="{{Support::show($item,'slug')}}" title="Tham gia" class="btn btn-orange lg:text-[0.875rem] whitespace-nowrap inline-flex items-center justify-center py-2 px-4 rounded bg-gradient-to-r from-[#FE8C00] to-[#F83600] text-white">Tham gia <i class="fa fa-angle-double-right ml-1" aria-hidden="true"></i></a>
            <div class="form-price">
                <div class="rating-item mb-1 justify-end">
                    <p class="rating">
                        <span class="rating-box mr-0">
                            <i class="fa fa-star-o" aria-hidden="true"></i>
                            <i class="fa fa-star-o" aria-hidden="true"></i>
                            <i class="fa fa-star-o" aria-hidden="true"></i>
                            <i class="fa fa-star-o" aria-hidden="true"></i>
                            <i class="fa fa-star-o" aria-hidden="true"></i>
                            <span style="width:94%">
                                <i class="fa fa-star" aria-hidden="true"></i>
                                <i class="fa fa-star" aria-hidden="true"></i>
                                <i class="fa fa-star" aria-hidden="true"></i>
                                <i class="fa fa-star" aria-hidden="true"></i>
                                <i class="fa fa-star" aria-hidden="true"></i>
                            </span>
                        </span>
                    </p>
                </div>
                <p class="text-right">
                    @if (!$item->isFree())
                        @if ($firstPriceInfo['sale_percent'] > 0)
                            <span class="price-old text-[#888 text-[0.75rem] line-through">{{Currency::showMoney($firstPriceInfo['price_old'])}}</span>
                        @endif
                        <span class="price font-bold 2xl:text-[1.125rem] text-[#008BD9] ml-1">{{Currency::showMoney($firstPriceInfo['price'])}}</span>
                    @else
                        <span class="price font-bold 2xl:text-[1.125rem] text-[#008BD9] ml-1">Free</span>
                    @endif
                </p>
            </div>
        </div>
    </div>
</div>
@php
    $firstPriceInfo = $item->getFirstPrice();
@endphp
<div class="item-category-main relative rounded-lg overflow-hidden">
    @if (!$item->isFree() && $firstPriceInfo['sale_percent'] > 0)
        <span class="discount absolute top-0 left-6 z-[1] rounded-b-md font-semibold text-white text-[0.875rem] bg-gradient-to-r from-[#F44336] to-[#C62828] inline-block p-1">-{{$firstPriceInfo['sale_percent']}}%</span>
    @endif
    <a href="{{Support::show($item,'slug')}}" title="{{Support::show($item,'name')}}" class="img img__ block c-img 2xl:pt-[62.5%] pt-[57%]">
        @include('image_loader.all',['itemImage'=>$item,'key'=>'img'])
    </a>
    <div class="content 2xl:p-4 p-2 bg-[rgba(0,0,0,.5)] absolute bottom-0 left-0 w-full z-[1]">
        <div class="flex justify-between items-end text-white mb-4">
            <h3 class="max-w-[60%]">
                <a href="{{Support::show($item,'slug')}}" title="{{Support::show($item,'name')}}" class="title font-bold 2xl:text-[1.25rem] block">{{Support::show($item,'name')}}</a>
            </h3>
            <p class="">
                @if (!$item->isFree())
                    @if ($firstPriceInfo['sale_percent'] > 0)
                        <span class="price-old text-[#888 text-[0.75rem] line-through">{{Currency::showMoney($firstPriceInfo['price_old'])}}</span>
                    @endif
                    <span class="price font-bold 2xl:text-[1.125rem] text-[#008BD9] ml-1">{{Currency::showMoney($firstPriceInfo['price'])}}</span>
                @else
                    <span class="font-bold 2xl:text-[1.125rem]">FREE</span>
                @endif
            </p>
        </div>
        <div class="flex items-center justify-between">
            @if (isset($item->teacher))
                <div class="teacher flex items-center gap-2">
                    <span class="ava img-ava block lg:w-10 lg:h-10 w-8 h-8 rounded-full overflow-hidden shrink-0">
                        @include('image_loader.tiny',['itemImage'=>$item->teacher,'key'=>'img'])
                    </span>
                    <div class="teacher-info">
                        <p class="name font-semibold text-[0.875rem] text-white">{{Support::show($item->teacher,'name')}}</p>
                        <p class="desc text-[#ebebeb] text-[0.875rem]">{{Support::show($item->teacher,'teacher_job')}}</p>
                    </div>
                </div>
            @endif`
            <a href="{{Support::show($item,'slug')}}" title="Tham gia ngay" class="btn btn-orange inline-flex items-center justify-center py-2 lg:px-5 px-4 rounded bg-gradient-to-r from-[#FE8C00] to-[#F83600] text-white">Tham gia ngay <i class="fa fa-angle-double-right ml-1" aria-hidden="true"></i>
            </a>
        </div>
        <hr class="line my-3 border-[rgba(255,255,255,.3)]" />
        <div class="flex items-center justify-between flex-wrap">
            <div class="rating-item">
                <p class="rating">
                    <span class="rating-box">
                        <i class="fa fa-star-o" aria-hidden="true"></i>
                        <i class="fa fa-star-o" aria-hidden="true"></i>
                        <i class="fa fa-star-o" aria-hidden="true"></i>
                        <i class="fa fa-star-o" aria-hidden="true"></i>
                        <i class="fa fa-star-o" aria-hidden="true"></i>
                        <span style="width: 94%">
                            <i class="fa fa-star" aria-hidden="true"></i>
                            <i class="fa fa-star" aria-hidden="true"></i>
                            <i class="fa fa-star" aria-hidden="true"></i>
                            <i class="fa fa-star" aria-hidden="true"></i>
                            <i class="fa fa-star" aria-hidden="true"></i>
                        </span>
                    </span>
                </p>
                <p class="text-[#888] text-[0.75rem]">(4.8/5)</p>
            </div>
            <span class="item md:text-[0.875rem] text-white">
                <img src="theme/frontend/images/users.svg" class="mr-1 inline-block w-6 h-6 object-contain" alt="user" /> {{$item->number_student+$plusMoreStudentNumber}} học viên 
            </span>
            <span class="item md:text-[0.875rem] text-white">
                <img src="theme/frontend/images/time.svg" class="mr-1 inline-block w-6 h-6 object-contain" alt="time" /> {{Support::show($item,'duration')}} phút
            </span>
        </div>
    </div>
</div>
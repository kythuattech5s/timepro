@extends('index')
@section('main')
@include('course_categories.banner_page')
<div class="main-breadcrumb py-4">
    <div class="container">
        {{\Breadcrumbs::render('course',$currentItem,$parent)}}
    </div>
</div>
<section class="pages bg-[#EEEAEA] py-[2rem]">
    <div class="container mx-auto">
        <div class="lg:grid lg:grid-cols-4 lg:gap-4 gap-3">
            <div class="col-span-3">
                <div class="box-video rounded rounded-[0.3125rem] overflow-hidden mb-[1.5rem] relative z-10 aspect aspect-[16/9]">
                    @include('image_loader.all',['itemImage'=>$currentItem,'key'=>'img_video_trailer'])
                    <svg class="absolute z-1 top-[50%] left-[50%] translate-x-[-50%] translate-y-[-50%]" xmlns="http://www.w3.org/2000/svg"
                        width="101" height="101" viewBox="0 0 101 101" fill="none">
                        <circle opacity="0.3" cx="50.604" cy="50.2674" r="50.106" fill="white" />
                        <path d="M71.2938 50.0352L40.5833 68.2873L40.7418 31.5299L71.2938 50.0352Z" fill="white" />
                    </svg>
                </div>
                <div class="tabs mb-[1.5rem] text-center md:p-[1rem] p-[0.5rem] flex overflow-x-auto snap-start gap-4 md-[0.5rem] pb-[1rem] md:justify-around justify-start bg-[#fff] rounded rounded-[0.3125rem] sticky top-0 z-10">
                    <a href="#gioi-thieu" title="Giới thiệu" class="flex-none text-[#454545] md:text-base font-semibold text-[0.875rem]">Giới thiệu</a>
                    <a href="#noi-dung-khoa-hoc" title="Nội dung khóa học" class="flex-none text-[#454545] md:text-base font-semibold text-[0.875rem]">Nội dung khóa học</a>
                    <a href="#thong-tin-giang-vien" title="Thông tin giảng viên" class="flex-none text-[#454545] md:text-base font-semibold text-[0.875rem]">Thông tin giảng viên</a>
                    <a href="#danh-gia" title="Đánh giá" class="flex-none text-[#454545] md:text-base font-semibold text-[0.875rem]">Đánh giá</a>
                </div>
                <div class="box md:p-[1.5rem] p-[0.5rem] bg-[#fff] rounded rounded-[0.3125rem] overflow-hidden mb-[1.5rem]" id="gioi-thieu">
                    <p class="text-[1.125rem] font-semibold text-[#252525] pb-[0.625rem] mb-[0.625rem] border-b-[#EBEBEB] border-b-[1px]">
                        Giới thiệu khóa học</p>
                    <div class="s-content">
                        {!!$currentItem->content!!}
                    </div>
                </div>
                <div class="box md:p-[1.5rem] p-[0.5rem] bg-[#fff] rounded rounded-[0.3125rem] overflow-hidden mb-[1.5rem]" id="noi-dung-khoa-hoc">
                    <p class="text-[1.125rem] font-semibold text-[#252525] pb-[0.625rem] mb-[0.625rem] border-b-[#EBEBEB] border-b-[1px]">
                        Nội dung bài học</p>
                    <div class="list text-[#252525] max-h-[31.25rem] overflow-y-hidden">
                        @foreach ($listVideo as $itemVideo)
                            <div class="flex items-center justify-between p-[0.625rem] border-b-[#EBEBEB] border-b-[1px] rounded rounded-[0.3125rem] overflow-hidden hover:bg-[#F5F5F5]">
                                <span class="inline-flex items-center truncate flex-[0_0_40%] pr-1">
                                    @include('icon_svgs.video_list_dot')
                                    {{Support::show($itemVideo,'name')}}
                                </span>
                                <div class="flex items-center">
                                    <span class="time mr-4">{{$itemVideo->getDurationView()}}</span>
                                    @if ($isOwn)
                                        <a href="{{$currentItem->slug}}/video/{{$itemVideo->id}}" title="{{Support::show($itemVideo,'name')}}" class="flex-1 text-sm text-white bg-gradient-to-r from-[#F44336] to-[#C62828] inline-flex items-center p-1 rounded-[1.875rem] rounded w-fit hover:text-[#fff]">
                                            <img class="mr-1 sm:inline-block hidden" src="theme/frontend/images/play.png" alt="Play"> &emsp;Học&emsp;
                                        </a>
                                    @else
                                        @if ($itemVideo->isFree())
                                            <a href="{{$currentItem->slug}}/video/{{$itemVideo->id}}" title="{{Support::show($itemVideo,'name')}}" class="flex-1 text-sm text-white bg-gradient-to-r from-[#F44336] to-[#C62828] inline-flex items-center p-1 rounded-[1.875rem] rounded w-fit hover:text-[#fff]">
                                                <img class="mr-1 sm:inline-block hidden" src="theme/frontend/images/play.png" alt="Play"> Học thử
                                            </a>
                                        @else
                                            <a href="javascript:void(0)" title="{{Support::show($itemVideo,'name')}}" class="flex-1 text-sm text-white bg-gradient-to-r from-[#F44336] to-[#C62828] inline-flex items-center p-1 rounded-[1.875rem] rounded w-fit hover:text-[#fff] btn-show-warning" data-warning="Vui lòng đăng ký khóa học để học bài này">
                                                &ensp;&emsp;&emsp;<i class="fa fa-lock" aria-hidden="true"></i>&emsp;&emsp;&ensp;
                                            </a>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                @if (isset($currentItem->teacher))
                    @php
                        $userTeacher = $currentItem->teacher;
                    @endphp
                    <div class="box md:p-[1.5rem] p-[0.5rem] bg-[#fff] rounded rounded-[0.3125rem] overflow-hidden mb-[1.5rem]" id="thong-tin-giang-vien">
                        <p class="text-[1.125rem] font-semibold text-[#252525] pb-[0.625rem] mb-[1rem] border-b-[#EBEBEB] border-b-[1px]">Thông tin giảng viên</p>
                        <div class="teacher md:flex flex-wrap items-center justify-between">
                            <div class="teacher-info flex items-center md:mb-0 mb-3">
                                <div class="d-block w-[9.375rem] h-[9.375rem] rounded rounded-[50%] lg:mr-[1.25rem] mr-[1rem] border-[1px] border-[#C4C4C4] overflow-hidden">
                                    @include('image_loader.big',['itemImage'=>$userTeacher,'key'=>'img'])
                                </div>
                                <div class="teacher-content text-[#454545]">
                                    <p class="text-base font-semibold mb-1">{{Support::show($userTeacher,'name')}}</p>
                                    <div class="pl-[1.125rem] s-content">
                                        {!!Support::show($userTeacher,'teacher_description')!!}
                                    </div>
                                </div>
                            </div>
                            @if ($userTeacher->uslug != '')
                                <a href="thong-tin-giang-vien/{{$userTeacher->uslug}}" title="Chi tiết giảng viên" class="font-semibold md:inline-block block text-center bg-gradient-to-r from-[#F44336] to-[#C62828] rounded-md py-2 px-5 text-white shadow-lg ">Chi tiết giảng viên</a>
                            @endif
                        </div>
                    </div>
                @endif
                @if (count($listRelateCourse) > 0)
                    <div class="course-block rounded rounded-[0.3125rem] overflow-hidden">
                        <div class="course-head md:p-4 p-2 lg:px-4 px-3" style="background-image:url('theme/frontend/images/course-banner.jpg');background-repeat: no-repeat;background-size: cover;">
                            <p class="border-l-[4px] border-l-[#fff] text-[#fff] pl-[1rem] 2xl:text-[1.625rem] sm:text-[1.325rem] text-[1.125rem] uppercase font-semibold py-2">CÁC KHÓA HỌC LIÊN QUAN</p>
                        </div>
                        <div class="course-content bg-[#fff] p-4">
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 2xl:gap-3 gap-2">
                                @foreach ($listRelateCourse as $item)
                                    <div class="col-span-1">
                                        @include('courses.item')
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
            </div>
            <div class="col-span-1 lg:max-w-[20.5rem] lg:mt-0 mt-[1.875rem]">
                <div class="aside grid lg:grid-cols-1 lg:gap-0 md:gap-2 md:grid-cols-2">
                    @if (!$isOwn)
                        @php
                            $fisrtPackage = $currentItem->timePackage->first();
                        @endphp
                        <div class="bg-[#fff] rounded rounded-[0.4688rem] overflow-hidden p-2 lg:sticky lg:top-[1rem]">
                            <div class="item-course buy-item-box">
                                @include('image_loader.all',['itemImage'=>$currentItem,'key'=>'img'])
                                <div class="p-2">
                                    <h1 class="font-semibold text-base text-[#252525] mb-[0.3125rem]">{{Support::show($currentItem,'name')}}</h1>
                                    <div class="box-price">
                                        <span class="price-old text-[#888888] mr-2 line-through item-price-sub"></span>
                                        <span class="price lg:text-[1.375rem] text-[1.1rem] color-gradient font-semibold item-price-main"></span>
                                    </div>
                                    <select class="w-full px-[1rem] py-[0.8125rem] text-[#888888] bg-[#F5F5F5] rounded rounded-[5px] overflow-hidden lg:my-[1.5rem] my-[1.125rem] font-semibold select-time-package">
                                        @foreach ($currentItem->timePackage as $key => $itemTimePackage)
                                            <option value="{{$itemTimePackage->id}}" data-price="{{Currency::showMoney($itemTimePackage->price)}}" data-subprice="{{$itemTimePackage->price_old > $itemTimePackage->price ? Currency::showMoney($itemTimePackage->price_old):''}}">{{$itemTimePackage->name}}</option>
                                        @endforeach
                                    </select>
                                    <a href="javascript:void(0)" title="Đăng ký ngay" class="py-[0.725rem] px-[0.3125rem] rounded rounded-[0.3125rem] overflow-hidden bg-gradient-to-r from-[#F44336] to-[#C62828] flex items-center justify-center text-white hover:text-[#fff] mb-2 border-[2px] border-[#fff] font-semibold btn-buy-item" data-action="buy-now" data-type="course" data-id="{{$currentItem->id}}" data-package="{{$fisrtPackage->id}}">Đăng kí ngay</a>
                                    <a href="javascript:void(0)" title="Thêm vào giỏ hàng" class="py-[0.725rem] px-[0.3125rem] rounded rounded-[0.3125rem] overflow-hidden flex items-center justify-center text-[#CD272F] bg-[#fff] border-[2px] border-[#CD272F] font-semibold btn-buy-item" data-action="add-cart" data-type="course" data-id="{{$currentItem->id}}" data-package="{{$fisrtPackage->id}}"> @include('icon_svgs.add_cart') Thêm vào giỏ hàng </a>
                                </div>
                            </div>
                        </div>
                    @endif
                    <div class="box rounded rounded-[0.3125rem] overflow-hidden 2xl:mt-[1.875rem] md:mt-0 mt-[1.275rem] bg-[#fff]">
                        <p class="lg:text-[1.375rem] text-[1.1rem] bg-gradient-to-r from-[#F44336] to-[#C62828] font-semibold text-white p-[1rem] text-center">Thông tin khóa học</p>
                        <div class="md:p-[1.25rem] p-[0.75rem]">
                            <div class="flex items-center lg:mb-[1rem] mb-[0.75rem]">
                                @include('icon_svgs.course_clock')
                                <strong class="inline-block font-semibold md:text-base text-[0.875rem] text-[#252525] mr-2">Thời lượng</strong>
                                <span class="line-block md:text-base text-[0.875rem] text-[#454545]">{{$currentItem->getDurationView()}}</span>
                            </div>
                            <div class="flex items-center lg:mb-[1rem] mb-[0.75rem]">
                                @include('icon_svgs.giao_trinh')
                                <strong class="inline-block font-semibold md:text-base text-[0.875rem] text-[#252525] mr-2">Videos</strong>
                                <span class="line-block md:text-base text-[0.875rem] text-[#454545]">{{count($listVideo)}} Video</span>
                            </div>
                            <div class="flex items-center lg:mb-[1rem] mb-[0.75rem]">
                                @include('icon_svgs.tai_lieu')
                                <strong class="inline-block font-semibold md:text-base text-[0.875rem] text-[#252525] mr-2">{{$currentItem->getCountDocument()}}
                                    tài liệu</strong>
                                </span>
                            </div>
                            <div class="flex items-center lg:mb-[1rem] mb-[0.75rem]">
                                @include('icon_svgs.calender')
                                <strong class="inline-block font-semibold md:text-base text-[0.875rem] text-[#252525] mr-2">Cập
                                    nhật {{Support::showDateTime($currentItem->updated_at,'d/m/Y')}}</strong>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

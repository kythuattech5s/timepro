@extends('index')
@section('main')
@if (count($listBanner) > 0)
<div class="swiper-container slide-banner__index">
    <div class="swiper-wrapper">
        @foreach ($listBanner as $k => $itemBanner)
        <div class="swiper-slide">
            <div class="link-banner img_full relative">
                @if($k == 0)
                    @include('image_loader.all',['itemImage'=>$itemBanner,'key'=>'img','noLazyLoad'=>1])
                @else
                    @include('image_loader.all',['itemImage'=>$itemBanner,'key'=>'img'])
                @endif
                <div class=" absolute top-0 container z-[1] left-1/2 -translate-x-1/2">
                    <div class="banner-content xl:max-w-[820px] md:max-w-[50%] ml-0 2xl:mt-20 xl:mt-10 sm:mt-6 mt-2">
                        <div class="s-content-title md:text-center uppercase font-bold 2xl:text-[4.5rem] xl:text-[3rem] lg:text-[2.5rem] sm:text-[1.25rem] text-[0.875rem] sm:mb-4 mb-2">
                            <p style="color:#fff">{{Support::show($itemBanner,'title_one')}}</p>
                            <p style="color:#FF2D37">{{Support::show($itemBanner,'title_true')}}</p>
                            <p style="color:#fff">{{Support::show($itemBanner,'title_three')}}</p>
                        </div>
                        <div class="short_content hidden lg:block text-center mb-4 text-white">
                            {!! nl2br(Support::show($itemBanner,'content')) !!}
                        </div>
                        <?php $list_button = Support::extractJson(Support::show($itemBanner,'list_button')); ?>
                        @if(count($list_button) > 0)
                        <div class="flex items-center md:justify-center sm:gap-4 gap-2 flex-wrap">
                            @foreach($list_button as $button)
                            <a href="{{$button['link'] ?? ''}}" title="{{$button['title'] ?? ''}}" class="btn-banner inline-flex items-center justify-center sm:py-2 py-1 lg:px-5 px-4 rounded bg-transparent text-white border-[1px] border-solid border-white hover:bg-white hover:text-[#252525] sm:text-[0.875rem] text-[0.75rem]">
                                {{$button['title'] ?? ''}}
                            </a>
                            @endforeach
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endif
@include('sections.about_us')
@include('sections.advantage')
@include('sections.list_cate')
<section class="section-cate__index">
    @foreach ($listCourseCategory as $itemCourseCategory)
    @php
        $listCourseShow = $itemCourseCategory->course()->baseView()->limit(10)->get();
    @endphp
    <div class="item group 2xl:py-14 py-6" style="background-image: url(theme/frontend/images/bg-category.jpg)">
        <div class="container">
            <div class="head-category block md:flex items-center justify-between gap-8 mb-6">
                <div class="main-title relative after:hidden md:after:block after:absolute after:top-0 after:left-0 after:w-[5px] after:h-full after:bg-white md:pl-5">
                    <h2 class="title font-bold text-[#252525] md:text-white 2xl:text-[1.6rem] lg:text-[1.3rem] text-[1rem] uppercase mb-2">{{Support::show($itemCourseCategory,'name')}}</h2>
                    <div class="short_content md:text-white">{{Support::show($itemCourseCategory,'short_content')}}</div>
                </div>
                <a href="{{Support::show($itemCourseCategory,'slug')}}" title="Xem thêm" class="btn btn-orange shrink-0 hidden md:inline-flex items-center justify-center py-2 lg:px-5 px-4 rounded bg-white text-[#CD272F] hover:bg-[#FE8C00] hover:text-white"> Xem thêm </a>
            </div>
            <div class="box-slide grid grid-cols-1 lg:grid-cols-2 gap-4 relative mb-4">
                <div class="col-span-1 hidden lg:block">
                    <div class="swiper-container slide-category-main">
                        <div class="swiper-wrapper">
                            @foreach ($listCourseShow as $item)
                            <div class="swiper-slide">
                                @include('courses.item_big')
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-span-1 lg:group-odd:order-first">
                    <div class="swiper-container slide-category__thumbs">
                        <div class="swiper-wrapper">
                            @foreach ($listCourseShow as $item)
                            <div class="swiper-slide h-auto">
                                @include('courses.item')
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="button-slide swiper-slide__prev cate__prev cursor-pointer absolute top-1/2 left-[-55px] -translate-y-1/2 z-[1]">
                    <svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M23.75 15H6.25" stroke="#ebebeb" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M15 6.25L6.25 15L15 23.75" stroke="#ebebeb" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </div>
                <div class="button-slide swiper-slide__next cate__next cursor-pointer absolute top-1/2 right-[-55px] -translate-y-1/2 z-[1]">
                    <svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M6.25 15H23.75" stroke="#ebebeb" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M15 6.25L23.75 15L15 23.75" stroke="#ebebeb" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</section>
<section class="2xl:py-14 py-6 section-lecturers bg-no-repeat bg-left" style="background-image: url(theme/frontend/images/bg-lec.png);">
    <div class="container">
        <p class="subtitle__all w-fit mx-auto relative uppercase text-[0.75rem] font-bold mb-2">{:our_lecturer:}</p>
        <h2 class="title-all font-bold text-[#252525] 2xl:text-[2rem] lg:text-[1.5rem] text-[1.125rem] text-center 2xl:mb-6 mb-4">ĐỘI NGŨ GIẢNG VIÊN</h2>
        <div class="box-slide relative">
            <div class="swiper-container slide-lecturers lg:py-5">
                <div class="swiper-wrapper">
                    @foreach ($listTeacher as $itemTeacher)
                    @php
                        $ratingInfo = $itemTeacher->getRating('main');
                    @endphp
                    <div class="swiper-slide h-auto">
                        <div class="items-lecturers bg-white h-full rounded-lg overflow-hidden border-[1px] border-solid border-[#ebebeb] hover:border-transparent hover:shadow-[0_4px_10px_rgba(0,0,0,.3)] transition-all duration-300">
                            <span class="banner block c-img pt-[26%]">
                                <img src="theme/frontend/images/banner-lec.jpg" alt="">
                            </span>
                            <div class="content relative lg:p-4 p-2 pt-0 text-center lg:mt-[-75px] -mt-10">
                                <a href="{{$itemTeacher->buildHrefTeacher()}}" title="{{$itemTeacher->name}}" class="ava block img-ava mx-auto lg:w-[8rem] lg:h-[8rem] w-[5rem] h-[5rem] rounded-full overflow-hidden mb-3">
                                    @include('image_loader.big',['itemImage'=>$itemTeacher,'key'=>'img'])
                                </a>
                                <p class="name font-bold text-[#252525] 2xl:text-[1.25rem] text-[1rem] mb-1">
                                    <a href="{{$itemTeacher->buildHrefTeacher()}}" title="{{$itemTeacher->name}}">{{Support::show($itemTeacher,'name')}}</a>
                                </p>
                                <p class="role text-[#CD272F] mb-4">{{Support::show($itemTeacher,'teacher_job')}}</p>
                                <div class="short_content lg:text-[0.875rem] mb-4">{{Support::show($itemTeacher,'teacher_short_content')}}</div>
                                <div class="grid grid-cols-3 gap-4 border-[1px] border-solid border-[#ebebeb] rounded lg:py-4 py-2 2xl:px-8 lg:px-6 px-4 mb-4 mt-auto">
                                    <div class="col-span-1 text-center">
                                        <p class="font-bold text-[#252525] text-[0.75rem] mb-2">Số khóa học</p>
                                        <span class="count inline-block font-semibold text-white px-2 py-1 rounded bg-[#E099C8]">{{$itemTeacher->teacherCourses->count()}}</span>
                                    </div>
                                    <div class="col-span-1 text-center">
                                        <p class="font-bold text-[#252525] text-[0.75rem] mb-2">Tổng giờ giảng</p>
                                        <span class="count inline-block font-semibold text-white px-2 py-1 rounded bg-[#E099C8]">{{$itemTeacher->totalDuration()}}</span>
                                    </div>
                                    <div class="col-span-1 text-center">
                                        <p class="font-bold text-[#252525] text-[0.75rem] mb-2">Đánh giá</p>
                                        <span class="count inline-block font-semibold text-white px-2 py-1 rounded bg-[#E099C8]"> {{$ratingInfo['scoreAll']}}/5</span>
                                    </div>
                                </div>
                                <div class="teacher-social flex justify-center items-center">
                                    <a href="tel:{{Support::show($itemTeacher,'phone')}}" title="Điện thoại" class="item-social lg:mr-6 mr-3">
                                        @include('icon_svgs.user_phone')
                                    </a>
                                    <a href="mailto:{{Support::show($itemTeacher,'email')}}" title="Email" class="item-social lg:mr-6 mr-3">
                                        @include('icon_svgs.user_email')
                                    </a>
                                    <a href="{{Support::show($itemTeacher,'facebook')}}" title="Facebook" class="item-social" target="_blank" rel="noindex,nofollow,noopener">
                                        @include('icon_svgs.user_facebook')
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="pagination-red pagination-lecturers mt-5"></div>
            </div>
            <div class="button-slide swiper-slide__prev lecturers__prev hidden lg:block cursor-pointer absolute top-1/2 left-[-55px] -translate-y-1/2 z-[1]">
                <svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M23.75 15H6.25" stroke="#888" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M15 6.25L6.25 15L15 23.75" stroke="#888" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </div>
            <div class="button-slide swiper-slide__next lecturers__next hidden lg:block cursor-pointer absolute top-1/2 right-[-55px] -translate-y-1/2 z-[1]">
                <svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M6.25 15H23.75" stroke="#888" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M15 6.25L23.75 15L15 23.75" stroke="#888" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </div>
        </div>
    </div>
</section>
@include('sections.testimonial')
@include('sections.contact')
@endsection
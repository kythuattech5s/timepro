@extends('index')
@section('main')
@if (count($listBanner) > 0)
    <div class="swiper-container slide-banner__index">
        <div class="swiper-wrapper">
            @foreach ($listBanner as $itemBanner)
                <div class="swiper-slide">
                    <a href="{{$itemBanner->link != '' ? $itemBanner->link:'javascript:void(0)'}}" title="{{$itemBanner->link}}" class="link-banner img_full">
                        @include('image_loader.all',['itemImage'=>$itemBanner,'key'=>'img'])
                    </a>
                </div>
            @endforeach
        </div>
    </div>
@endif
<section class="about-index 2xl:py-14 py-6">
    <div class="container">
        <p class="subtitle__all w-fit mx-auto relative uppercase text-[0.75rem] font-bold mb-2"> About us </p>
        <h2 class="title-all uppercase font-bold text-[#252525] 2xl:text-[2rem] lg:text-[1.5rem] text-[1.125rem] text-center mb-4"> GIỚI THIỆU VỀ TIMES PRO </h2>
        <div class="short_content text-center mb-6"> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Tempor orci facilisi consectetur interdum sed. Mauris, nec ac condimentum felis, gravida neque, platea id arcu. Facilisis sed risus at eget mauris faucibus facilisis. Lacus vel, vitae morbi tincidunt rhoncus nibh. Nisl, elit libero pellentesque aliquet. Nunc magna egestas urna hendrerit nec. Ultrices sit dui condimentum porttitor libero vestibulum. </div>
        <a href="#" title="Xem chi tiết" class="btn btn-red-gradien flex w-fit uppercase mx-auto items-center justify-center font-semibold text-white py-2 px-6 rounded bg-gradient-to-r from-[#F44336] to-[#C62828] lg:mb-10 mb-6"> Xem chi tiết </a>
    </div>
    <div class="max-w-[1700px] mx-auto px-[0.938rem]">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 sm:gap-4 gap-2 module-statis">
            <div class="col-span-1 flex flex-col justify-center lg:justify-end lg:pb-20 order-[1] lg:order-[first] sm:gap-4 gap-2 lg:gap-0">
                <div class="item lg:w-fit flex items-center justify-center lg:justify-start bg-white gap-2 lg:gap-1 p-1 px-4 rounded shadow-[2px_4px_32px_rgba(0,0,0,.1)] lg:mb-20 last:mb-0 xl:last:ml-20 lg:last:ml-10">
                    <span class="count leading-[1] font-bold 2xl:text-[3.5rem] lg:text-[2.5rem] text-[2rem] color-gradient" tech5s-number="5">5</span>
                    <span class="text font-semibold">năm <br /> thành lập </span>
                </div>
                <div class="item lg:w-fit flex items-center justify-center lg:justify-start bg-white gap-2 lg:gap-1 p-1 px-4 rounded shadow-[2px_4px_32px_rgba(0,0,0,.1)] lg:mb-20 last:mb-0 xl:last:ml-20 lg:last:ml-10">
                    <span class="count leading-[1] font-bold 2xl:text-[3.5rem] lg:text-[2.5rem] text-[2rem] color-gradient" tech5s-number="10+">10+</span>
                    <span class="text font-semibold">giảng viên <br /> giàu kinh nghiệm </span>
                </div>
            </div>
            <div class="col-span-1 sm:col-span-2 order-first lg:order-[1]">
                <a href="" title="" data-fslightbox="video-intro" class="video-intro block c-img pt-[52%] rounded-lg overflow-hidden">
                    <img src="theme/frontend/images/video-intro.jpg" alt="" />
                    <span class="btn-play flex items-center justify-center w-[3.75rem] h-[3.75rem] rounded-full bg-white shadow-[0_6px_32px_rgba(0,0,0,.01)] absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 z-[1] text-[#F44336]">
                        <i class="fa fa-play 2xl:text-[1.875rem] text-[1.125rem] relative left-[2px]" aria-hidden="true"></i>
                    </span>
                </a>
            </div>
            <div class="col-span-1 flex flex-col justify-center lg:justify-end lg:pb-20 lg:items-end order-[2] sm:gap-4 gap-2 lg:gap-0">
                <div class="item lg:w-fit flex items-center justify-center lg:justify-start bg-white gap-2 lg:gap-1 p-1 px-4 rounded shadow-[2px_4px_32px_rgba(0,0,0,.1)] lg:mb-20 last:mb-0 xl:last:mr-20 lg:last:mr-10">
                    <span class="count leading-[1] font-bold 2xl:text-[3.5rem] lg:text-[2.5rem] text-[1.5rem] color-gradient" tech5s-number="100%">100%</span>
                    <span class="text font-semibold">học viên <br /> hài lòng </span>
                </div>
                <div class="item lg:w-fit flex items-center justify-center lg:justify-start bg-white gap-2 lg:gap-1 p-1 px-4 rounded shadow-[2px_4px_32px_rgba(0,0,0,.1)] lg:mb-20 last:mb-0 xl:last:mr-20 lg:last:mr-10">
                    <span class="count leading-[1] font-bold 2xl:text-[3.5rem] lg:text-[2.5rem] text-[1.5rem] color-gradient" tech5s-number="60+">60+</span>
                    <span class="text font-semibold">khoá học <br /> chất lượng </span>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="endow-index 2xl:py-14 py-6 bg-no-repeat bg-cover" style="background-image: url(theme/frontend/images/bg-endow.jpg)">
    <div class="container">
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="col-span-1 text-center">
                <span class="icon block lg:w-[3.75rem] lg:h-[3.75rem] w-[2.5rem] h-[2.5rem] mx-auto 2xl:mb-4 mb-2">
                    <img src="theme/frontend/images/endow-1.svg" alt="" />
                </span>
                <p class="font-bold text-white 2xl:text-[1.25rem] mb-1"> Chất lượng bài giảng cao </p>
                <p class="text-white"> Lorem ipsum dolor sit amet, consectetur adipiscing elit ipsum dolor. </p>
            </div>
            <div class="col-span-1 text-center">
                <span class="icon block lg:w-[3.75rem] lg:h-[3.75rem] w-[2.5rem] h-[2.5rem] mx-auto 2xl:mb-4 mb-2">
                    <img src="theme/frontend/images/endow-2.svg" alt="" />
                </span>
                <p class="font-bold text-white 2xl:text-[1.25rem] mb-1"> Đăng ký học dễ dàng </p>
                <p class="text-white"> Lorem ipsum dolor sit amet, consectetur adipiscing elit ipsum dolor. </p>
            </div>
            <div class="col-span-1 text-center">
                <span class="icon block lg:w-[3.75rem] lg:h-[3.75rem] w-[2.5rem] h-[2.5rem] mx-auto 2xl:mb-4 mb-2">
                    <img src="theme/frontend/images/endow-3.svg" alt="" />
                </span>
                <p class="font-bold text-white 2xl:text-[1.25rem] mb-1"> Hỗ trợ học viên tận tình </p>
                <p class="text-white"> Lorem ipsum dolor sit amet, consectetur adipiscing elit ipsum dolor. </p>
            </div>
            <div class="col-span-1 text-center">
                <span class="icon block lg:w-[3.75rem] lg:h-[3.75rem] w-[2.5rem] h-[2.5rem] mx-auto 2xl:mb-4 mb-2">
                    <img src="theme/frontend/images/endow-4.svg" alt="" />
                </span>
                <p class="font-bold text-white 2xl:text-[1.25rem] mb-1"> Có thể áp dụng thực tế ngay </p>
                <p class="text-white"> Lorem ipsum dolor sit amet, consectetur adipiscing elit ipsum dolor. </p>
            </div>
        </div>
    </div>
</section>
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
                    <a href="{{Support::show($itemCourseCategory,'short_content')}}" title="Xem thêm" class="btn btn-orange shrink-0 hidden md:inline-flex items-center justify-center py-2 lg:px-5 px-4 rounded bg-white text-[#CD272F] hover:bg-[#FE8C00] hover:text-white"> Xem thêm </a>
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
        <p class="subtitle__all w-fit mx-auto relative uppercase text-[0.75rem] font-bold mb-2"> OUR LECTURERS </p>
        <h2 class="title-all font-bold text-[#252525] 2xl:text-[2rem] lg:text-[1.5rem] text-[1.125rem] text-center 2xl:mb-6 mb-4">ĐỘI NGŨ GIẢNG VIÊN</h2>
        <div class="box-slide relative">
            <div class="swiper-container slide-lecturers lg:py-5">
                <div class="swiper-wrapper">
                    @foreach ($listTeacher as $itemTeacher)
                        <div class="swiper-slide h-auto">
                            <div class="items-lecturers bg-white h-full rounded-lg overflow-hidden border-[1px] border-solid border-[#ebebeb] hover:border-transparent hover:shadow-[0_4px_10px_rgba(0,0,0,.3)] transition-all duration-300">
                                <span class="banner block c-img pt-[26%]">
                                    <img src="theme/frontend/images/banner-lec.jpg" alt="">
                                </span>
                                <div class="content relative lg:p-4 p-2 pt-0 text-center lg:mt-[-75px] -mt-10">
                                    <span class="ava block img-ava mx-auto lg:w-[8rem] lg:h-[8rem] w-[5rem] h-[5rem] rounded-full overflow-hidden">
                                        @include('image_loader.big',['itemImage'=>$itemTeacher,'key'=>'img'])
                                    </span>
                                    <p class="name font-bold text-[#252525] 2lx:text-[1.25rem] text-[1rem] mb-1">{{Support::show($itemTeacher,'name')}}</p>
                                    <p class="role text-[#CD272F] mb-4">{{Support::show($itemTeacher,'teacher_job')}}</p>
                                    <div class="short_content lg:text-[0.875rem] mb-4">{{Support::show($itemTeacher,'teacher_short_content')}}</div>
                                    <div class="grid grid-cols-3 gap-4 border-[1px] border-solid border-[#ebebeb] rounded lg:py-4 py-2 2xl:px-8 lg:px-6 px-4 mb-4 mt-auto">
                                        <div class="col-span-1 text-center">
                                            <p class="font-bold text-[#252525] text-[0.75rem] mb-2">Số khóa học</p>
                                            <span class="count inline-block font-semibold text-white px-2 py-1 rounded bg-[#E099C8]"> {{$itemTeacher->course->count()}} </span>
                                        </div>
                                        <div class="col-span-1 text-center">
                                            <p class="font-bold text-[#252525] text-[0.75rem] mb-2">Tổng giờ giảng</p>
                                            <span class="count inline-block font-semibold text-white px-2 py-1 rounded bg-[#E099C8]"> {{(int)($itemTeacher->course->sum('duration')/60)}} </span>
                                        </div>
                                        <div class="col-span-1 text-center">
                                            <p class="font-bold text-[#252525] text-[0.75rem] mb-2">Lượt đánh giá</p>
                                            <span class="count inline-block font-semibold text-white px-2 py-1 rounded bg-[#E099C8]"> 4.6/5 </span>
                                        </div>
                                    </div>
                                    <div class="teacher-social flex justify-center items-center">
                                        <a href="tel:{{Support::show($itemTeacher,'phone')}}" title="Điện thoại" class="item-social lg:mr-6 mr-3">
                                            @include('icon_svgs.user_phone')
                                        </a>
                                        <a href="mailto:{{Support::show($itemTeacher,'email')}}" title="Email" class="item-social lg:mr-6 mr-3">
                                            @include('icon_svgs.user_email')
                                        </a>
                                        <a href="{{Support::show($itemTeacher,'facebook')}}" title="Facebook" class="item-social" rel="noindex,nofollow,noopener">
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
<section class="2xl:py-14 py-6 section-feeling bg-no-repeat bg-cover" style="background-image: url(theme/frontend/images/bg-feeling.jpg);">
    <div class="container">
        <p class="subtitle-white flex items-center text-white w-fit mx-auto relative uppercase text-[0.75rem] font-bold mb-2"> TESTIMONIALS </p>
        <h2 class="title-all font-bold text-white 2xl:text-[2rem] lg:text-[1.5rem] text-[1.125rem] text-center 2xl:mb-6 mb-4"> CẢM NGHĨ CỦA HỌC VIÊN VỀ TIMES PRO </h2>
    </div>
    <div class="swiper-container slide-feeling">
        <div class="swiper-wrapper">
            <div class="swiper-slide h-auto">
                <div class="item-feeling h-full relative lg:pt-[4rem] pt-[2.5rem]">
                    <span class="ava absolute top-0 left-1/2 -translate-x-1/2 z-[1] block img-ava lg:w-[8rem] lg:h-[8rem] h-[5rem] w-[5rem] rounded-full overflow-hidden">
                        <img src="theme/frontend/images/ava-student.jpg" alt="">
                    </span>
                    <div class="content rounded-lg bg-[rgba(255,255,255,.25)]  2xl:p-8 lg:p-6 p-4  text-white text-center relative">
                        <p class="name 2xl:text-[1.25rem] font-bold mb-2">Nguyễn Lê Ngọc Duy</p>
                        <div class="rating-item mb-4 justify-center">
                            <p class="rating">
                                <span class="rating-box">
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
                        <div class="s-content"> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Tempor orci facilisi consectetur interdum sed. Mauris, nec ac condimentum felis, gravida neque, platea id arcu. Facilisis sed risus at eget mauris faucibus facilisis. Lacus vel, vitae morbi tincidunt rhoncus nibh. Nisl, elit libero pellentesque aliquet. </div>
                    </div>
                </div>
            </div>
            <div class="swiper-slide h-auto">
                <div class="item-feeling h-full relative lg:pt-[4rem] pt-[2.5rem]">
                    <span class="ava absolute top-0 left-1/2 -translate-x-1/2 z-[1] block img-ava lg:w-[8rem] lg:h-[8rem] h-[5rem] w-[5rem] rounded-full overflow-hidden">
                        <img src="theme/frontend/images/ava-student.jpg" alt="">
                    </span>
                    <div class="content rounded-lg bg-[rgba(255,255,255,.25)]  2xl:p-8 lg:p-6 p-4  text-white text-center relative">
                        <p class="name 2xl:text-[1.25rem] font-bold mb-2">Nguyễn Lê Ngọc Duy</p>
                        <div class="rating-item mb-4 justify-center">
                            <p class="rating">
                                <span class="rating-box">
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
                        <div class="s-content"> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Tempor orci facilisi consectetur interdum sed. Mauris, nec ac condimentum felis, gravida neque, platea id arcu. Facilisis sed risus at eget mauris faucibus facilisis. Lacus vel, vitae morbi tincidunt rhoncus nibh. Nisl, elit libero pellentesque aliquet. </div>
                    </div>
                </div>
            </div>
            <div class="swiper-slide h-auto">
                <div class="item-feeling h-full relative lg:pt-[4rem] pt-[2.5rem]">
                    <span class="ava absolute top-0 left-1/2 -translate-x-1/2 z-[1] block img-ava lg:w-[8rem] lg:h-[8rem] h-[5rem] w-[5rem] rounded-full overflow-hidden">
                        <img src="theme/frontend/images/ava-student.jpg" alt="">
                    </span>
                    <div class="content rounded-lg bg-[rgba(255,255,255,.25)]  2xl:p-8 lg:p-6 p-4  text-white text-center relative">
                        <p class="name 2xl:text-[1.25rem] font-bold mb-2">Nguyễn Lê Ngọc Duy</p>
                        <div class="rating-item mb-4 justify-center">
                            <p class="rating">
                                <span class="rating-box">
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
                        <div class="s-content"> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Tempor orci facilisi consectetur interdum sed. Mauris, nec ac condimentum felis, gravida neque, platea id arcu. Facilisis sed risus at eget mauris faucibus facilisis. Lacus vel, vitae morbi tincidunt rhoncus nibh. Nisl, elit libero pellentesque aliquet. </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="pagination-red pagination-feeling mt-5"></div>
    </div>
</section>
<section class="section-form relative lg:py-0 py-6">
    <div class="hidden lg:block bg-form absolute top-0 left-0 w-[60%] h-full img-ava">
        <img src="theme/frontend/images/bg-form.jpg" alt="">
    </div>
    <div class="hidden lg:block absolute top-0 right-0 w-[40%] h-full bg-no-repeat bg-[length:100%_100%]" style="background-image: url(theme/frontend/images/bg-form-2.png);"></div>
    <div class="container relative z-[1] lg:flex items-center justify-end 2xl:min-h-[700px] lg:min-h-[500px]">
        <form action="" method="" class="form-regis max-w-[820px] lg:mr-0 mx-auto bg-white rounded-lg shadow-[6px_8px_48px_rgba(0,0,0,.1)] 2xl:p-8 lg:p-6 p-4">
            <p class="text-center font-bold text-[#252525] uppercase 2xl:text-[2.5rem] lg:text-[1.875rem] text-[1.125rem] mb-2"> ĐĂNG KÝ TƯ VẤN - NHẬN ƯU ĐÃI </p>
            <div class="short_content text-center mb-6"> Quý khách vui lòng nhập địa chỉ e-mail để chúng tôi có thể tư vấn một cách chu đáo và nhận những thông tin, ưu đãi sớm nhất từ TIMES PRO! </div>
            <div class="form relative">
                <input type="text" name="" placeholder="Nhập từ khoá tìm kiếm ..." class="form-control w-full py-3 px-4 outline-none bg-[#f5f5f5] rounded-lg">
                <button class="btn btn-orange font-semibold absolute top-0 right-0 h-full inline-flex items-center justify-center p-2 px-4 rounded bg-gradient-to-r from-[#F44336] to-[#C62828] text-white"> Gửi thông tin </button>
            </div>
        </form>
    </div>
</section>
@endsection

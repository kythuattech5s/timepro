@extends('index')
@section('css')
    <link rel="stylesheet" href="{'assets/css/font-awesome.min.css'}" type="text/css" media="screen" />
    <link href="{'comment/css/style.css'}" rel="stylesheet">
    <link href="{'comment/css/star.css'}" rel="stylesheet">
    <link href="{'comment/css/selectStar.css'}" rel="stylesheet">
    <link href="{{ mix('comment/style/app.css') }}" rel="stylesheet">
@endsection
@section('main')
    <div class="banner-pages">
        <a href="{[link_banner_course_all]}" title="{[title_banner_course_all]}" class="link img_full block">
            @include('image_loader.config.all', ['config_key' => 'banner_course_all', 'noLazyLoad' => 1])
        </a>
    </div>
    <div class="main-breadcrumb py-4">
        <div class="container">
            {{ \Breadcrumbs::render('course', $currentItem, $parent) }}
        </div>
    </div>
    <section class="pages bg-[#EEEAEA] py-[2rem]">
        <div class="container mx-auto">
            <div class="gap-3 lg:grid lg:grid-cols-4 lg:gap-4">
                <div class="col-span-3">
                    <div class="box-video aspect relative z-10 mb-[1.5rem] aspect-[16/9] overflow-hidden rounded rounded-[0.3125rem]">
                        @include('image_loader.all', ['itemImage' => $currentItem, 'key' => 'img_video_trailer'])
                        <svg class="z-1 absolute top-[50%] left-[50%] translate-x-[-50%] translate-y-[-50%]" xmlns="http://www.w3.org/2000/svg"
                             width="101" height="101" viewBox="0 0 101 101" fill="none">
                            <circle opacity="0.3" cx="50.604" cy="50.2674" r="50.106" fill="white" />
                            <path d="M71.2938 50.0352L40.5833 68.2873L40.7418 31.5299L71.2938 50.0352Z" fill="white" />
                        </svg>
                    </div>
                    <div class="tabs md-[0.5rem] sticky top-0 z-10 mb-[1.5rem] flex snap-start justify-start gap-4 overflow-x-auto rounded rounded-[0.3125rem] bg-[#fff] p-[0.5rem] pb-[1rem] text-center md:justify-around md:p-[1rem]">
                        <a href="#gioi-thieu" title="Giới thiệu" class="flex-none text-[0.875rem] font-semibold text-[#454545] md:text-base">Giới thiệu</a>
                        <a href="#noi-dung-khoa-hoc" title="Nội dung khóa học" class="flex-none text-[0.875rem] font-semibold text-[#454545] md:text-base">Nội dung khóa học</a>
                        <a href="#thong-tin-giang-vien" title="Thông tin giảng viên" class="flex-none text-[0.875rem] font-semibold text-[#454545] md:text-base">Thông tin giảng viên</a>
                        <a href="#danh-gia" title="Đánh giá" class="flex-none text-[0.875rem] font-semibold text-[#454545] md:text-base">Đánh giá</a>
                    </div>
                    <div class="box mb-[1.5rem] overflow-hidden rounded bg-[#fff] p-[0.5rem] md:p-[1.5rem]" id="gioi-thieu">
                        <p class="mb-[0.625rem] border-b-[1px] border-b-[#EBEBEB] pb-[0.625rem] text-[1.125rem] font-semibold text-[#252525]">
                            Giới thiệu khóa học</p>
                        <div class="s-content">
                            {!! $currentItem->content !!}
                        </div>
                    </div>
                    <div class="box mb-[1.5rem] overflow-hidden rounded bg-[#fff] p-[0.5rem] md:p-[1.5rem]" id="noi-dung-khoa-hoc">
                        <p class="mb-[0.625rem] border-b-[1px] border-b-[#EBEBEB] pb-[0.625rem] text-[1.125rem] font-semibold text-[#252525]">
                            Nội dung bài học</p>
                        <div class="list max-h-[31.25rem] overflow-y-hidden text-[#252525]">
                            @foreach ($listVideo as $itemVideo)
                                <div class="flex items-center justify-between overflow-hidden rounded rounded-[0.3125rem] border-b-[1px] border-b-[#EBEBEB] p-[0.625rem] hover:bg-[#F5F5F5]">
                                    <span class="inline-flex flex-[0_0_40%] items-center truncate pr-1">
                                        @include('icon_svgs.video_list_dot')
                                        {{ Support::show($itemVideo, 'name') }}
                                    </span>
                                    <div class="flex items-center">
                                        <span class="time mr-4">{{ $itemVideo->getDurationView() }}</span>
                                        @if ($isOwn)
                                            <a href="{{ $currentItem->slug }}/video/{{ $itemVideo->id }}" title="{{ Support::show($itemVideo, 'name') }}" class="inline-flex w-fit flex-1 items-center rounded-[1.875rem] rounded bg-gradient-to-r from-[#F44336] to-[#C62828] p-1 text-sm text-white hover:text-[#fff]">
                                                <img class="mr-1 hidden sm:inline-block" src="theme/frontend/images/play.png" alt="Play"> &emsp;Học&emsp;
                                            </a>
                                        @else
                                            @if ($itemVideo->isFree())
                                                <a href="{{ $currentItem->slug }}/video/{{ $itemVideo->id }}" title="{{ Support::show($itemVideo, 'name') }}" class="inline-flex w-fit flex-1 items-center rounded-[1.875rem] rounded bg-gradient-to-r from-[#F44336] to-[#C62828] p-1 text-sm text-white hover:text-[#fff]">
                                                    <img class="mr-1 hidden sm:inline-block" src="theme/frontend/images/play.png" alt="Play"> Học thử
                                                </a>
                                            @else
                                                <a href="javascript:void(0)" title="{{ Support::show($itemVideo, 'name') }}" class="btn-show-warning inline-flex w-fit flex-1 items-center rounded-[1.875rem] rounded bg-gradient-to-r from-[#F44336] to-[#C62828] p-1 text-sm text-white hover:text-[#fff]" data-warning="Vui lòng đăng ký khóa học để học bài này">
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
                        <div class="box mb-[1.5rem] overflow-hidden rounded bg-[#fff] p-[0.5rem] md:p-[1.5rem]" id="thong-tin-giang-vien">
                            <p class="mb-[1rem] border-b-[1px] border-b-[#EBEBEB] pb-[0.625rem] text-[1.125rem] font-semibold text-[#252525]">Thông tin giảng viên</p>
                            <div class="teacher flex-wrap items-center justify-between md:flex">
                                <div class="teacher-info mb-3 flex items-center md:mb-0">
                                    <div class="d-block mr-[1rem] h-[9.375rem] w-[9.375rem] overflow-hidden rounded rounded-[50%] border-[1px] border-[#C4C4C4] lg:mr-[1.25rem]">
                                        @include('image_loader.big', ['itemImage' => $userTeacher, 'key' => 'img'])
                                    </div>
                                    <div class="teacher-content text-[#454545]">
                                        <p class="mb-1 text-base font-semibold">{{ Support::show($userTeacher, 'name') }}</p>
                                        <div class="s-content pl-[1.125rem]">
                                            {!! Support::show($userTeacher, 'teacher_description') !!}
                                        </div>
                                    </div>
                                </div>
                                @if ($userTeacher->slug != '')
                                    <a href="thong-tin-giang-vien/{{ $userTeacher->uslug }}" title="Chi tiết giảng viên" class="block rounded-md bg-gradient-to-r from-[#F44336] to-[#C62828] py-2 px-5 text-center font-semibold text-white shadow-lg md:inline-block">Chi tiết giảng viên</a>
                                @endif
                            </div>
                        </div>
                    @endif
                    <div class="box comment-box mb-[1.5rem] overflow-hidden rounded-[0.3125rem] bg-[#fff] p-[0.5rem] md:p-[1.5rem]" id="danh-gia">
                        @include('commentRS::comment_box', ['map_table' => 'courses'])
                    </div>
                    <div class="box mb-[1.5rem] overflow-hidden rounded-[0.3125rem] bg-[#fff] p-[0.5rem] md:p-[1.5rem]" id="hoi-dap">
                        <div class="">
                            <p class="font-bold mb-4">Hỏi đáp</p>
                            <form action="hoi-dap" class="form-validate overflow-hidden border-[1px] border-solid border-[#ebebeb] rounded-lg" absolute check method="POST" data-success="ASK_AND_ANSWER.showNotify">
                                @csrf
                                <textarea name="" class="w-full resize-none h-[6.25rem] p-3 border-b-[1px] border-solid border-[#ebebeb]" placeholder="Mời bạn tham gia thảo luận, vui lòng nhập tiếng Việt có đấu."></textarea>
                                <input type="text">
                                <div class="flex flex-col sm:flex-row items-center p-3 gap-4 flex-wrap">
                                    <div class="gap-4 flex items-center">
                                        <label for="asMale">
                                            <input type="radio" name="gender" rules="required" id="asMale" type="male">
                                            <span></span>
                                            <span>Anh</span>
                                        </label>
                                        <label for="asFemale">
                                            <input type="radio" name="gender" rules="required" id="asFemale" type="female">
                                            <span></span>
                                            <span>Chị</span>
                                        </label>
                                    </div>
                                    <div class="flex-1 flex gap-4 flex-wrap">
                                        <input type="text" name="name" class="py-2 px-4 rounded border-[1px] border-solid border-[#ebebeb] flex-1" placeholder="Họ tên *" rules="required">
                                        <input type="text" class="py-2 px-4 rounded border-[1px] border-solid border-[#ebebeb] flex-1" placeholder="Số điện thoại*" name="phone" rules="required">
                                    </div>
                                    <button type="submit" class="btn btn-red-gradien inline-flex items-center justify-center rounded bg-gradient-to-r from-[#F44336] to-[#C62828] py-2 px-4 font-semibold text-white">Gửi</button>
                                </div>
                            </form>
                        </div>

                        <div class="mt-6">
                            @foreach ($asks as $ask)
                                <div>
                                    <div class="flex gap-2 mb-2">
                                        <p class="font-semibold text-[#252525]">{{ $ask->name }}</p>
                                        <span class="inline-flex items-center lg:text-[0.75rem] text-[#888] relative before:w-1 before:h-1 before:rounded-full before:bg-[#888] before:mr-2">{{ RSCustom::showTime($ask->created_at) }}</span>
                                    </div>
                                    <div class="text-[#252525] mb-2">
                                        {!! $ask->content !!}
                                    </div>
                                    <div class="flex flex-wrap gap-4 lg:pl-14 pl-6">
                                        <a type="button" data-placeholder="Trả lời bình luận" class="group flex items-center cursor-pointer gap-[4px] duration-300 hover:text-[#CD272F]" comment-skeleton>
                                            @include('commentRS::icon.reply') <span> Trả lời</span></a>
                                        <a class="{{ $ask->likes->first(function ($q) {
                                            return $q->pivot->user_id == Auth::id();
                                        }) != null
                                            ? 'like'
                                            : '' }} flex items-center cursor-pointer gap-[4px]" data-id="{-ask.id-}" comment-skeleton>
                                            @include('commentRS::icon.like') <span>Thích</span>
                                        </a>
                                        @php
                                            $ask_childs = $ask->asks;
                                        @endphp
                                        <div class="w-full">
                                            @foreach ($ask_childs as $ask_child)
                                                <div class="flex gap-3 mb-4 last:mb-0">
                                                    <div class="img-ava w-12 h-12 rounded-full overflow-hidden shrink-0">

                                                        <img src="" alt="">
                                                    </div>
                                                    <div>
                                                        <div class="flex flex-wrap items-center gap-2 mb-2">
                                                            <p>{!! $ask_child->user->name !!}</p>
                                                            <span class=" relative pl-3 text-[#F44336] after:absolute after:left-0 after:top-1/2 after:-translate-y-1/2 after:w-1 after:h-1 after:rounded-full after:bg-[#F44336]">Đã trả lời</span>
                                                            <p class=" text-[#888] relative pl-3 after:absolute after:top-1/2 after:-translate-y-1/2 after:left-0  after:w-1 after:h-1 after:rounded-full after:bg-[#888]">{{ RSCustom::showTime($ask_child->created_at) }}</p>
                                                        </div>
                                                        <div class="text-[#252525]">
                                                            {!! $ask_child->content !!}
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    @if (count($listRelateCourse) > 0)
                        <div class="course-block overflow-hidden rounded">
                            <div class="course-head p-2 px-3 md:p-4 lg:px-4" style="background-image:url('theme/frontend/images/course-banner.jpg');background-repeat: no-repeat;background-size: cover;">
                                <p class="border-l-[4px] border-l-[#fff] py-2 pl-[1rem] text-[1.125rem] font-semibold uppercase text-[#fff] sm:text-[1.325rem] 2xl:text-[1.625rem]">CÁC KHÓA HỌC LIÊN QUAN</p>
                            </div>
                            <div class="course-content bg-[#fff] p-4">
                                <div class="grid grid-cols-1 gap-2 sm:grid-cols-2 lg:grid-cols-4 2xl:gap-3">
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
                <div class="col-span-1 mt-[1.875rem] lg:mt-0 lg:max-w-[20.5rem]">
                    <div class="aside grid md:grid-cols-2 md:gap-2 lg:grid-cols-1 lg:gap-0">
                        @if (!$isOwn)
                            @php
                                $fisrtPackage = $currentItem->timePackage->first();
                            @endphp
                            <div class="overflow-hidden rounded-[0.4688rem] bg-[#fff] p-2 lg:sticky lg:top-[1rem]">
                                <div class="item-course buy-item-box">
                                    @include('image_loader.all', ['itemImage' => $currentItem, 'key' => 'img'])
                                    <div class="p-2">
                                        <h1 class="mb-[0.3125rem] text-base font-semibold text-[#252525]">{{ Support::show($currentItem, 'name') }}</h1>
                                        <div class="box-price">
                                            <span class="price-old item-price-sub mr-2 text-[#888888] line-through"></span>
                                            <span class="price color-gradient item-price-main text-[1.1rem] font-semibold lg:text-[1.375rem]"></span>
                                        </div>
                                        <select class="select-time-package my-[1.125rem] w-full overflow-hidden rounded bg-[#F5F5F5] px-[1rem] py-[0.8125rem] font-semibold text-[#888888] lg:my-[1.5rem]">
                                            @foreach ($currentItem->timePackage as $key => $itemTimePackage)
                                                <option value="{{ $itemTimePackage->id }}" data-price="{{ Currency::showMoney($itemTimePackage->price) }}" data-subprice="{{ $itemTimePackage->price_old > $itemTimePackage->price ? Currency::showMoney($itemTimePackage->price_old) : '' }}">{{ $itemTimePackage->name }}</option>
                                            @endforeach
                                        </select>
                                        <a href="javascript:void(0)" title="Đăng ký ngay" class="btn btn-red-gradien btn-buy-item mb-2 flex items-center justify-center overflow-hidden rounded border-[2px] border-[#fff] bg-gradient-to-r from-[#F44336] to-[#C62828] py-[0.725rem] px-[0.3125rem] font-semibold text-white hover:text-[#fff]" data-action="buy-now" data-type="course" data-id="{{ $currentItem->id }}" data-package="{{ $fisrtPackage->id }}">Đăng kí ngay</a>
                                        <a href="javascript:void(0)" title="Thêm vào giỏ hàng" class="btn-buy-item flex items-center justify-center overflow-hidden rounded border-[2px] border-[#CD272F] bg-[#fff] py-[0.725rem] px-[0.3125rem] font-semibold text-[#CD272F]" data-action="add-cart" data-type="course" data-id="{{ $currentItem->id }}" data-package="{{ $fisrtPackage->id }}"> @include('icon_svgs.add_cart') Thêm vào giỏ hàng </a>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <div class="box mt-[1.275rem] overflow-hidden rounded bg-[#fff] md:mt-0 2xl:mt-[1.875rem]">
                            <p class="bg-gradient-to-r from-[#F44336] to-[#C62828] p-[1rem] text-center text-[1.1rem] font-semibold text-white lg:text-[1.375rem]">Thông tin khóa học</p>
                            <div class="p-[0.75rem] md:p-[1.25rem]">
                                <div class="mb-[0.75rem] flex items-center lg:mb-[1rem]">
                                    @include('icon_svgs.course_clock')
                                    <strong class="mr-2 inline-block text-[0.875rem] font-semibold text-[#252525] md:text-base">Thời lượng</strong>
                                    <span class="line-block text-[0.875rem] text-[#454545] md:text-base">{{ $currentItem->getDurationView() }}</span>
                                </div>
                                <div class="mb-[0.75rem] flex items-center lg:mb-[1rem]">
                                    @include('icon_svgs.giao_trinh')
                                    <strong class="mr-2 inline-block text-[0.875rem] font-semibold text-[#252525] md:text-base">Videos</strong>
                                    <span class="line-block text-[0.875rem] text-[#454545] md:text-base">{{ count($listVideo) }} Video</span>
                                </div>
                                <div class="mb-[0.75rem] flex items-center lg:mb-[1rem]">
                                    @include('icon_svgs.tai_lieu')
                                    <strong class="mr-2 inline-block text-[0.875rem] font-semibold text-[#252525] md:text-base">{{ $currentItem->getCountDocument() }}
                                        tài liệu</strong>
                                    </span>
                                </div>
                                <div class="mb-[0.75rem] flex items-center lg:mb-[1rem]">
                                    @include('icon_svgs.calender')
                                    <strong class="mr-2 inline-block text-[0.875rem] font-semibold text-[#252525] md:text-base">Cập
                                        nhật {{ Support::showDateTime($currentItem->updated_at, 'd/m/Y') }}</strong>
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
@section('js')
    <script src="{'assets/js/FormData.js'}" defer></script>
    <script src="{'assets/js/ValidateFormHasFile.js'}" defer></script>
    <script src="{'assets/js/XHR.js'}" defer></script>
    <script src="{'comment/js/comment.js'}" defer></script>
    <script src="{'theme/frontend/js/question.js'}" defer></script>
@endsection

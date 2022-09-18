@extends('index')
@section('main')
<div class="banner-pages ">
    <div class="link img_full block">
        <img src="{Ibanner_page_introduce.imgI}" alt="{Ibanner_page_introduce.imgI}" title="{Ibanner_page_introduce.imgI}">
    </div>
</div>
<div class="main-breadcrumb py-4">
    <div class="container">
        {{Breadcrumbs::render('static',trans('fdb::introduce'),\VRoute::get('introduce'))}}
    </div>
</div>
<section class="about-index 2xl:py-14 py-6">
    <div class="container">
        <p class="subtitle__all w-fit mx-auto relative uppercase text-[0.75rem] font-bold mb-2">{:about_us:}</p>
        <h2 class="title-all uppercase font-bold text-[#252525] 2xl:text-[2rem] lg:text-[1.5rem] text-[1.125rem] text-center mb-4">{[title_about_us]}</h2>
        <div class="short_content text-center mb-6">{[content_about_us]}</div>
    </div>
    <?php 
    	$historyBeginAbouts = Support::extractJson(SettingHelper::getSetting('history_begin_about')); 
    	$historyBeginAboutLefts = array_slice($historyBeginAbouts, 0,2);
    	$historyBeginAboutRights = array_slice($historyBeginAbouts, 2,2);
    ?>
    <div class="max-w-[1700px] mx-auto px-[0.938rem]">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 sm:gap-4 gap-2 module-statis">
            <div class="col-span-1 flex flex-col justify-center lg:justify-end lg:pb-20 order-[1] lg:order-[first] sm:gap-4 gap-2 lg:gap-0">
            	@foreach($historyBeginAboutLefts as $historyBeginAboutLeft)
                <div class="item lg:w-fit flex items-center justify-center lg:justify-start bg-white gap-2 lg:gap-1 p-1 px-4 rounded shadow-[2px_4px_32px_rgba(0,0,0,.1)] lg:mb-20 last:mb-0 xl:last:ml-20 lg:last:ml-10">
                    <span class="count leading-[1] font-bold 2xl:text-[3.5rem] lg:text-[2.5rem] text-[2rem] color-gradient" tech5s-number="{{Support::show($historyBeginAboutLeft,'number')}}">{{Support::show($historyBeginAboutLeft,'number')}}</span>
                    <span class="text font-semibold">
                    	{!! nl2br(Support::show($historyBeginAboutLeft,'content')) !!}
                    </span>
                </div>
                @endforeach
            </div>
            <div class="col-span-1 sm:col-span-2 order-first lg:order-[1]">
            	<?php
                    $idYoutube = Support::getYoutubeId(SettingHelper::getSetting('link_video_about'));
                    $imgVideoYoutube = "https://img.youtube.com/vi/$idYoutube/mqdefault.jpg";
                ?>
                <a href="{[link_video]}" title="" data-fslightbox="video-intro" class="video-intro block c-img pt-[52%] rounded-lg overflow-hidden">
                    <img src="{{$imgVideoYoutube ?? ''}}" alt="{[title_about_us]}" title="{[title_about_us]}"/>
                    <span class="btn-play flex items-center justify-center w-[3.75rem] h-[3.75rem] rounded-full bg-white shadow-[0_6px_32px_rgba(0,0,0,.01)] absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 z-[1] text-[#F44336]">
                        <i class="fa fa-play 2xl:text-[1.875rem] text-[1.125rem] relative left-[2px]" aria-hidden="true"></i>
                    </span>
                </a>
            </div>
            <div class="col-span-1 flex flex-col justify-center lg:justify-end lg:pb-20 lg:items-end order-[2] sm:gap-4 gap-2 lg:gap-0">
            	@foreach($historyBeginAboutRights as $historyBeginAboutRight)
                <div class="item lg:w-fit flex items-center justify-center lg:justify-start bg-white gap-2 lg:gap-1 p-1 px-4 rounded shadow-[2px_4px_32px_rgba(0,0,0,.1)] lg:mb-20 last:mb-0 xl:last:mr-20 lg:last:mr-10">
                    <span class="count leading-[1] font-bold 2xl:text-[3.5rem] lg:text-[2.5rem] text-[1.5rem] color-gradient"
                        tech5s-number="{{Support::show($historyBeginAboutRight,'number')}}">{{Support::show($historyBeginAboutRight,'number')}}</span>
                    <span class="text font-semibold">
                    	{!! nl2br(Support::show($historyBeginAboutLeft,'content')) !!}
                    </span>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
<?php 
	$advantageAbouts = Support::extractJson(SettingHelper::getSetting('advantage_about')); 
?>
<section class="endow-index 2xl:py-14 py-6 bg-no-repeat bg-cover" style="background-image: url({Ibg_advantage_about.imgI})">
    <div class="container">
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        	@foreach($advantageAbouts as $advantageAbout)
            <div class="col-span-1 text-center">
                <span class="icon block lg:w-[3.75rem] lg:h-[3.75rem] w-[2.5rem] h-[2.5rem] mx-auto 2xl:mb-4 mb-2">
                    @include('image_loader.tiny',['keyImage'=>'image','itemImage'=>$advantageAbout])
                </span>
                <p class="font-bold text-white 2xl:text-[1.25rem] mb-1">{{Support::show($advantageAbout,'title')}}</p>
                <p class="text-white">
                    {!! nl2br(Support::show($advantageAbout,'content')) !!}
                </p>
            </div>
            @endforeach
        </div>
    </div>
</section>
<section class="section-course__cate 2xl:py-14 py-6">
    <div class="container">
        <p class="subtitle__all w-fit mx-auto relative uppercase text-[0.75rem] font-bold mb-2">
            OUR COURSES
        </p>
        <h2
            class="title-all font-bold text-[#252525] 2xl:text-[2rem] lg:text-[1.5rem] text-[1.125rem] text-center 2xl:mb-6 mb-4">
            DANH MỤC CÁC KHÓA HỌC TẠI TIMES PRO
        </h2>
        <div class="grid grid-cols-2 md:grid-cols-3 2xl:gap-6 sm:gap-4 gap-2">
            <div class="col-span-1">
                <div class="item-course__cate h-full text-center rounded-lg overflow-hidden 2xl:py-24 lg:py-20 lg:px-8 px-4 py-10 bg-no-repeat bg-cover relative after:absolute after:top-0 after:left-0 after:w-full after:h-full after:bg-[rgba(0,0,0,.6)] hover:shadow-[0_8px_40px_rgba(205,39,47,.4)]"
                    style="
            background-image: url(theme/frontend/images/course-cate.jpg);
          ">
                    <h3 class="relative z-[1]">
                        <a href="#" title="" class="title font-bold text-white 2xl:text-[1.25rem] block mb-2">
                            Chân dung của một nhà môi giới chuyên nghiệp
                        </a>
                    </h3>
                    <span class="count relative z-[1] font-semibold text-white">16 khóa học</span>
                </div>
            </div>
            <div class="col-span-1">
                <div class="item-course__cate h-full text-center rounded-lg overflow-hidden 2xl:py-24 lg:py-20 lg:px-8 px-4 py-10 bg-no-repeat bg-cover relative after:absolute after:top-0 after:left-0 after:w-full after:h-full after:bg-[rgba(0,0,0,.6)] hover:shadow-[0_8px_40px_rgba(205,39,47,.4)]"
                    style="
            background-image: url(theme/frontend/images/course-cate.jpg);
          ">
                    <h3 class="relative z-[1]">
                        <a href="#" title="" class="title font-bold text-white 2xl:text-[1.25rem] block mb-2">
                            Phân tích sản phẩm bất động sản như một chuyên gia
                        </a>
                    </h3>
                    <span class="count relative z-[1] font-semibold text-white">16 khóa học</span>
                </div>
            </div>
            <div class="col-span-1">
                <div class="item-course__cate h-full text-center rounded-lg overflow-hidden 2xl:py-24 lg:py-20 lg:px-8 px-4 py-10 bg-no-repeat bg-cover relative after:absolute after:top-0 after:left-0 after:w-full after:h-full after:bg-[rgba(0,0,0,.6)] hover:shadow-[0_8px_40px_rgba(205,39,47,.4)]"
                    style="
            background-image: url(theme/frontend/images/course-cate.jpg);
          ">
                    <h3 class="relative z-[1]">
                        <a href="#" title="" class="title font-bold text-white 2xl:text-[1.25rem] block mb-2">
                            Phân tích sản phẩm bất động sản như một chuyên gia
                        </a>
                    </h3>
                    <span class="count relative z-[1] font-semibold text-white">16 khóa học</span>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="section-roadmap 2xl:py-14 py-6 bg-no-repeat"
    style="background-image: url(theme/frontend/images/head-roadmap.jpg);">
    <div class="container">
        <p
            class="subtitle-white flex items-center text-[#252525] lg:text-white w-fit mx-auto relative uppercase text-[0.75rem] font-bold mb-2">
            OUR HISTORY
        </p>
        <h2
            class="title-all font-bold text-[#252525] lg:text-white 2xl:text-[2rem] lg:text-[1.5rem] text-[1.125rem] text-center 2xl:mb-10 mb-6">
            LỊCH SỬ HÌNH THÀNH
        </h2>
        <div class="main-roadmap relative lg:min-h-[776px]">
            <div class="box-logo hidden lg:flex items-center justify-center absolute block w-[254px] h-[254px] rounded-full bg-white shadow-[6px_8px_48px_rgba(0,0,0,.08)] bg-no-repeat bg-center"
                style="background-image: url(theme/frontend/images/bg-box-logo.png);">
                <img src="theme/frontend/images/logo-roadmap.png" alt="">
            </div>
            <div class="box-layer hidden lg:block">
                <span class="layer layer-1">
                    <img src="theme/frontend/images/layer-1.svg" alt="icon">
                </span>
                <span class="layer layer-2">
                    <img src="theme/frontend/images/layer-2.svg" alt="icon">
                </span>
                <span class="layer layer-3">
                    <img src="theme/frontend/images/layer-3.svg" alt="icon">
                </span>
                <span class="layer layer-4">
                    <img src="theme/frontend/images/layer-4.svg" alt="icon">
                </span>
                <span class="layer layer-5">
                    <img src="theme/frontend/images/layer-5.svg" alt="icon">
                </span>
                <span class="layer layer-6">
                    <img src="theme/frontend/images/vector-1.svg" alt="icon">

                </span>
                <span class="layer layer-7">
                    <img src="theme/frontend/images/vector-2.svg" alt="icon">

                </span>
                <span class="layer layer-8">
                    <img src="theme/frontend/images/vector-3.svg" alt="icon">
                </span>
                <span class="layer layer-9">
                    <img src="theme/frontend/images/vector-4.svg" alt="icon">
                </span>
                <span class="layer layer-10">
                    <img src="theme/frontend/images/vector-5.svg" alt="icon">
                </span>
            </div>
            <div class="box-text grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="item col-span-1">
                    <p class="year font-bold color-gradient 2xl:text-[2.5rem] lg:text-[1.875rem] text-[1.25rem] mb-[2px]">
                        2018
                    </p>
                    <p class="title font-bold text-[#252525] mb-1 2xl:text-[1.25rem]">Thành lập công ty</p>
                    <p class="desc lg:text-[0.875rem]">Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                        Risus, semper integer
                        ut neque auctor amet vitae. Sit amet purus pretium nibh sagittis imperdiet.</p>
                </div>
                <div class="item col-span-1">
                    <p class="year font-bold color-gradient 2xl:text-[2.5rem] lg:text-[1.875rem] text-[1.25rem] mb-[2px]">
                        2019
                    </p>
                    <p class="title font-bold text-[#252525] mb-1 2xl:text-[1.25rem]">Gây dựng thương hiệu</p>
                    <p class="desc lg:text-[0.875rem]">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Risus, semper integer ut neque
                        auctor amet vitae. Sit amet purus pretium nibh sagittis imperdiet.
                    </p>
                </div>
                <div class="item col-span-1">
                    <p class="year font-bold color-gradient 2xl:text-[2.5rem] lg:text-[1.875rem] text-[1.25rem] mb-[2px]">
                        2020
                    </p>
                    <p class="title font-bold text-[#252525] mb-1 2xl:text-[1.25rem]">Tự tạo uy tín</p>
                    <p class="desc lg:text-[0.875rem]">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Risus, semper integer ut neque
                        auctor amet vitae. Sit amet purus pretium nibh sagittis imperdiet.
                    </p>
                </div>
                 <div class="item col-span-1">
                    <p class="year font-bold color-gradient 2xl:text-[2.5rem] lg:text-[1.875rem] text-[1.25rem] mb-[2px]">
                        2021
                    </p>
                    <p class="title font-bold text-[#252525] mb-1 2xl:text-[1.25rem]">Bắt đầu phát triển</p>
                    <p class="desc lg:text-[0.875rem]">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Risus, semper integer ut neque
                        auctor amet vitae. Sit amet purus pretium nibh sagittis imperdiet.
                    </p>
                </div>
                <div class="item col-span-1">
                    <p class="year font-bold color-gradient 2xl:text-[2.5rem] lg:text-[1.875rem] text-[1.25rem] mb-[2px]">
                        2022
                    </p>
                    <p class="title font-bold text-[#252525] mb-1 2xl:text-[1.25rem]">Phát triển thần tốc</p>
                    <p class="desc lg:text-[0.875rem]">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Risus, semper integer ut neque
                        auctor amet vitae. Sit amet purus pretium nibh sagittis imperdiet.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="section-vision">
    <div class="grid grid-cols-1 lg:grid-cols-5">
        <div class="col-span-1 lg:col-span-3 img_full img-vision">
            <img src="theme/frontend/images/img-vision.jpg" alt="">
        </div>
        <div class="col-span-1 lg:col-span-2">
            <div class="box-vision bg-no-repeat h-full 2xl:p-8 p-4 flex flex-col justify-center text-white"
                style="background-image: url(theme/frontend/images/bg-vision.jpg);">
                <p class="title font-bold 2xl:text-[2.5rem] lg:text-[1.875rem] text-[1.125rem] mb-4">Tầm nhìn</p>
                <div class="s-content 2xl:mb-10 mb-6">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquet fermentum tristique senectus
                    enim mi, magna velit. Magna arcu purus luctus lacus, dolor. Tristique odio luctus hendrerit
                    mauris libero neque. Velit sit ut ac mi erat tortor tellus iaculis vitae. Lectus dignissim
                    euismod arcu duis cras cursus phasellus. Mauris, libero sit nulla pellentesque. Ultricies
                    quisque quam lacus laoreet in rhoncus. Arcu consectetur massa elementum eget condimentum. Vel
                    bibendum tortor, non nunc justo sodales porta tincidunt ut. Est fermentum, egestas turpis eget
                    amet faucibus arcu adipiscing.
                </div>
                <p class="title font-bold 2xl:text-[2.5rem] lg:text-[1.875rem] text-[1.125rem] mb-4">Sứ mệnh</p>
                <div class="s-content">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquet fermentum tristique senectus
                    enim mi, magna velit. Magna arcu purus luctus lacus, dolor. Tristique odio luctus hendrerit
                    mauris libero neque. Velit sit ut ac mi erat tortor tellus iaculis vitae. Lectus dignissim
                    euismod arcu duis cras cursus phasellus. Mauris, libero sit nulla pellentesque. Ultricies
                    quisque quam lacus laoreet in rhoncus. Arcu consectetur massa elementum eget condimentum. Vel
                    bibendum tortor, non nunc justo sodales porta tincidunt ut. Est fermentum, egestas turpis eget
                    amet faucibus arcu adipiscing.
                </div>
            </div>
        </div>
    </div>
</section>
<section class="2xl:py-14 py-6 section-lecturers bg-no-repeat bg-left"
    style="background-image: url(theme/frontend/images/bg-lec.png);">
    <div class="container">
        <p class="subtitle__all w-fit mx-auto relative uppercase text-[0.75rem] font-bold mb-2">
            OUR LECTURERS
        </p>
        <h2
            class="title-all font-bold text-[#252525] 2xl:text-[2rem] lg:text-[1.5rem] text-[1.125rem] text-center 2xl:mb-6 mb-4">
            ĐỘI NGŨ DIỄN GIẢ - BAN CỐ VẤN
        </h2>
        <div class="box-slide relative">
            <div class="swiper-container slide-lecturers lg:py-5">
                <div class="swiper-wrapper">
                    <div class="swiper-slide h-auto">
                        <div
                            class="items-lecturers bg-white h-full rounded-lg overflow-hidden border-[1px] border-solid border-[#ebebeb] hover:border-transparent hover:shadow-[0_4px_10px_rgba(0,0,0,.3)] transition-all duration-300">
                            <span class="banner block c-img pt-[26%]">
                                <img src="theme/frontend/images/banner-lec.jpg" alt="">
                            </span>
                            <div class="content relative lg:p-4 p-2 pt-0 text-center lg:mt-[-75px] -mt-10">
                                <span
                                    class="ava block img-ava mx-auto lg:w-[8rem] lg:h-[8rem] w-[5rem] h-[5rem rounded-full overflow-hidden">
                                    <img src="theme/frontend/images/ava-teacher.jpg" alt="">
                                </span>
                                <p class="name font-bold text-[#252525] 2lx:text-[1.25rem] text-[1rem] mb-1">Mrs. Lê
                                    Ngọc Anh</p>
                                <p class="role text-[#CD272F] mb-4">Chủ Tịch Hội Đồng Quản Trị Times Pro</p>
                                <div class="short_content lg:text-[0.875rem] mb-4">
                                    “Lorem ipsum dolor sit amet, consectetur adipiscing elit. Tempor orci facilisi
                                    consectetur interdum
                                    sed. Mauris, nec ac condimentum felis, gravida neque, platea id arcu. Facilisis
                                    eget mauris faucibus
                                    facilisis.”
                                </div>
                                <div
                                    class="grid grid-cols-3 gap-4 border-[1px] border-solid border-[#ebebeb] rounded lg:py-4 py-2 2xl:px-8 lg:px-6 px-4 mb-4">
                                    <div class="col-span-1 text-center">
                                        <p class="font-bold text-[#252525] text-[0.75rem] mb-2">Số khóa học</p>
                                        <span
                                            class="count inline-block font-semibold text-white px-2 py-1 rounded bg-[#E099C8]">
                                            10
                                        </span>
                                    </div>
                                    <div class="col-span-1 text-center">
                                        <p class="font-bold text-[#252525] text-[0.75rem] mb-2">Tổng giờ giảng</p>
                                        <span
                                            class="count inline-block font-semibold text-white px-2 py-1 rounded bg-[#E099C8]">
                                            699
                                        </span>
                                    </div>
                                    <div class="col-span-1 text-center">
                                        <p class="font-bold text-[#252525] text-[0.75rem] mb-2">Lượt đánh giá</p>
                                        <span
                                            class="count inline-block font-semibold text-white px-2 py-1 rounded bg-[#E099C8]">
                                            4.6/5
                                        </span>
                                    </div>
                                </div>
                                <div class="teacher-social flex justify-center items-center">
                                    <a href="" title="Điện thoại" class="item-social lg:mr-6 mr-3"
                                        rel="noindex,nofollow,noopener">
                                        <svg width="30" height="30" viewBox="0 0 30 30" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <g clip-path="url(#clip0_258_41388)">
                                                <path
                                                    d="M25.605 4.3918C19.7463 -1.46517 10.2487 -1.46377 4.39177 4.39502C-1.4652 10.2538 -1.4638 19.7513 4.39499 25.6082C10.2538 31.4652 19.7512 31.4638 25.6082 25.605C28.4211 22.7913 30.0009 18.9754 30 14.9968C29.9992 11.0189 28.4183 7.20418 25.605 4.3918ZM22.717 20.8948C22.7163 20.8955 22.7157 20.8962 22.715 20.8968V20.8919L21.955 21.6468C20.972 22.6422 19.5405 23.0517 18.1799 22.7268C16.8091 22.3599 15.506 21.7759 14.32 20.9969C13.218 20.2926 12.1969 19.4694 11.275 18.5418C10.4267 17.6998 9.66462 16.7752 8.99993 15.7818C8.2729 14.713 7.69745 13.5486 7.28993 12.3218C6.82276 10.8806 7.20989 9.29926 8.28995 8.23684L9.17993 7.34686C9.42737 7.0983 9.82944 7.09742 10.0779 7.34487C10.0786 7.34551 10.0793 7.34615 10.0799 7.34686L12.8899 10.1568C13.1385 10.4043 13.1393 10.8064 12.8919 11.0548C12.8913 11.0555 12.8906 11.0561 12.8899 11.0568L11.2399 12.7068C10.7665 13.1751 10.7069 13.9193 11.0999 14.4569C11.6967 15.2759 12.3571 16.0466 13.075 16.7619C13.8753 17.5657 14.7453 18.2969 15.6749 18.9469C16.2121 19.3215 16.9403 19.2584 17.4049 18.7969L18.9999 17.1769C19.2473 16.9283 19.6494 16.9275 19.8979 17.1749C19.8985 17.1755 19.8992 17.1762 19.8999 17.1769L22.7149 19.9969C22.9635 20.2443 22.9644 20.6463 22.717 20.8948Z"
                                                    fill="#D2D2D2"></path>
                                            </g>
                                            <defs>
                                                <clipPath id="clip0_258_41388">
                                                    <rect width="30" height="30" fill="white"></rect>
                                                </clipPath>
                                            </defs>
                                        </svg>
                                    </a>
                                    <a href="" title="Email" class="item-social lg:mr-6 mr-3"
                                        rel="noindex,nofollow,noopener">
                                        <svg width="30" height="30" viewBox="0 0 30 30" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <g clip-path="url(#clip0_258_41393)">
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M15 0C23.2843 0 30 6.71572 30 15C30 23.2843 23.2843 30 15 30C6.71572 30 0 23.2843 0 15C0 6.71572 6.71572 0 15 0ZM24.5215 20.8149V9.66668L18.9471 15.2408L24.5215 20.8149ZM6.66937 21.042H23.331L18.2387 15.9497L16.2979 17.8903C16.2038 17.9841 16.0763 18.0368 15.9434 18.0367H14.0567C13.9909 18.0368 13.9257 18.0239 13.8649 17.9988C13.804 17.9736 13.7487 17.9368 13.7021 17.8903L11.7614 15.9497L6.66914 21.042H6.66937ZM5.47852 9.66633V20.8152L11.0529 15.2408L5.47852 9.66633ZM23.8129 8.95799H6.1875L14.2643 17.0348H15.736L23.8129 8.95799Z"
                                                    fill="#D2D2D2"></path>
                                            </g>
                                            <defs>
                                                <clipPath id="clip0_258_41393">
                                                    <rect width="30" height="30" fill="white"></rect>
                                                </clipPath>
                                            </defs>
                                        </svg>
                                    </a>
                                    <a href="" title="Facebook" class="item-social" rel="noindex,nofollow,noopener">
                                        <svg width="30" height="30" viewBox="0 0 30 30" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <g clip-path="url(#clip0_258_41396)">
                                                <path
                                                    d="M30 15C30 6.71484 23.2852 0 15 0C6.71484 0 0 6.71484 0 15C0 23.2852 6.71484 30 15 30C15.0879 30 15.1758 30 15.2637 29.9941V18.3223H12.041V14.5664H15.2637V11.8008C15.2637 8.5957 17.2207 6.84961 20.0801 6.84961C21.4512 6.84961 22.6289 6.94922 22.9688 6.99609V10.3477H21C19.4473 10.3477 19.1426 11.0859 19.1426 12.1699V14.5605H22.8633L22.377 18.3164H19.1426V29.4199C25.4121 27.6211 30 21.8496 30 15Z"
                                                    fill="#D2D2D2"></path>
                                            </g>
                                            <defs>
                                                <clipPath id="clip0_258_41396">
                                                    <rect width="30" height="30" fill="white"></rect>
                                                </clipPath>
                                            </defs>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide h-auto">
                        <div
                            class="items-lecturers bg-white h-full rounded-lg overflow-hidden border-[1px] border-solid border-[#ebebeb] hover:border-transparent hover:shadow-[0_4px_10px_rgba(0,0,0,.3)] transition-all duration-300">
                            <span class="banner block c-img pt-[26%]">
                                <img src="theme/frontend/images/banner-lec.jpg" alt="">
                            </span>
                            <div class="content relative lg:p-4 p-2 pt-0 text-center lg:mt-[-75px] -mt-10">
                                <span
                                    class="ava block img-ava mx-auto lg:w-[8rem] lg:h-[8rem] w-[5rem] h-[5rem rounded-full overflow-hidden">
                                    <img src="theme/frontend/images/ava-teacher.jpg" alt="">
                                </span>
                                <p class="name font-bold text-[#252525] 2lx:text-[1.25rem] text-[1rem] mb-1">Mrs. Lê
                                    Ngọc Anh</p>
                                <p class="role text-[#CD272F] mb-4">Chủ Tịch Hội Đồng Quản Trị Times Pro</p>
                                <div class="short_content lg:text-[0.875rem] mb-4">
                                    “Lorem ipsum dolor sit amet, consectetur adipiscing elit. Tempor orci facilisi
                                    consectetur interdum
                                    sed. Mauris, nec ac condimentum felis, gravida neque, platea id arcu. Facilisis
                                    eget mauris faucibus
                                    facilisis.”
                                </div>
                                <div
                                    class="grid grid-cols-3 gap-4 border-[1px] border-solid border-[#ebebeb] rounded lg:py-4 py-2 2xl:px-8 lg:px-6 px-4 mb-4">
                                    <div class="col-span-1 text-center">
                                        <p class="font-bold text-[#252525] text-[0.75rem] mb-2">Số khóa học</p>
                                        <span
                                            class="count inline-block font-semibold text-white px-2 py-1 rounded bg-[#E099C8]">
                                            10
                                        </span>
                                    </div>
                                    <div class="col-span-1 text-center">
                                        <p class="font-bold text-[#252525] text-[0.75rem] mb-2">Tổng giờ giảng</p>
                                        <span
                                            class="count inline-block font-semibold text-white px-2 py-1 rounded bg-[#E099C8]">
                                            699
                                        </span>
                                    </div>
                                    <div class="col-span-1 text-center">
                                        <p class="font-bold text-[#252525] text-[0.75rem] mb-2">Lượt đánh giá</p>
                                        <span
                                            class="count inline-block font-semibold text-white px-2 py-1 rounded bg-[#E099C8]">
                                            4.6/5
                                        </span>
                                    </div>
                                </div>
                                <div class="teacher-social flex justify-center items-center">
                                    <a href="" title="Điện thoại" class="item-social lg:mr-6 mr-3"
                                        rel="noindex,nofollow,noopener">
                                        <svg width="30" height="30" viewBox="0 0 30 30" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <g clip-path="url(#clip0_258_41388)">
                                                <path
                                                    d="M25.605 4.3918C19.7463 -1.46517 10.2487 -1.46377 4.39177 4.39502C-1.4652 10.2538 -1.4638 19.7513 4.39499 25.6082C10.2538 31.4652 19.7512 31.4638 25.6082 25.605C28.4211 22.7913 30.0009 18.9754 30 14.9968C29.9992 11.0189 28.4183 7.20418 25.605 4.3918ZM22.717 20.8948C22.7163 20.8955 22.7157 20.8962 22.715 20.8968V20.8919L21.955 21.6468C20.972 22.6422 19.5405 23.0517 18.1799 22.7268C16.8091 22.3599 15.506 21.7759 14.32 20.9969C13.218 20.2926 12.1969 19.4694 11.275 18.5418C10.4267 17.6998 9.66462 16.7752 8.99993 15.7818C8.2729 14.713 7.69745 13.5486 7.28993 12.3218C6.82276 10.8806 7.20989 9.29926 8.28995 8.23684L9.17993 7.34686C9.42737 7.0983 9.82944 7.09742 10.0779 7.34487C10.0786 7.34551 10.0793 7.34615 10.0799 7.34686L12.8899 10.1568C13.1385 10.4043 13.1393 10.8064 12.8919 11.0548C12.8913 11.0555 12.8906 11.0561 12.8899 11.0568L11.2399 12.7068C10.7665 13.1751 10.7069 13.9193 11.0999 14.4569C11.6967 15.2759 12.3571 16.0466 13.075 16.7619C13.8753 17.5657 14.7453 18.2969 15.6749 18.9469C16.2121 19.3215 16.9403 19.2584 17.4049 18.7969L18.9999 17.1769C19.2473 16.9283 19.6494 16.9275 19.8979 17.1749C19.8985 17.1755 19.8992 17.1762 19.8999 17.1769L22.7149 19.9969C22.9635 20.2443 22.9644 20.6463 22.717 20.8948Z"
                                                    fill="#D2D2D2"></path>
                                            </g>
                                            <defs>
                                                <clipPath id="clip0_258_41388">
                                                    <rect width="30" height="30" fill="white"></rect>
                                                </clipPath>
                                            </defs>
                                        </svg>
                                    </a>
                                    <a href="" title="Email" class="item-social lg:mr-6 mr-3"
                                        rel="noindex,nofollow,noopener">
                                        <svg width="30" height="30" viewBox="0 0 30 30" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <g clip-path="url(#clip0_258_41393)">
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M15 0C23.2843 0 30 6.71572 30 15C30 23.2843 23.2843 30 15 30C6.71572 30 0 23.2843 0 15C0 6.71572 6.71572 0 15 0ZM24.5215 20.8149V9.66668L18.9471 15.2408L24.5215 20.8149ZM6.66937 21.042H23.331L18.2387 15.9497L16.2979 17.8903C16.2038 17.9841 16.0763 18.0368 15.9434 18.0367H14.0567C13.9909 18.0368 13.9257 18.0239 13.8649 17.9988C13.804 17.9736 13.7487 17.9368 13.7021 17.8903L11.7614 15.9497L6.66914 21.042H6.66937ZM5.47852 9.66633V20.8152L11.0529 15.2408L5.47852 9.66633ZM23.8129 8.95799H6.1875L14.2643 17.0348H15.736L23.8129 8.95799Z"
                                                    fill="#D2D2D2"></path>
                                            </g>
                                            <defs>
                                                <clipPath id="clip0_258_41393">
                                                    <rect width="30" height="30" fill="white"></rect>
                                                </clipPath>
                                            </defs>
                                        </svg>
                                    </a>
                                    <a href="" title="Facebook" class="item-social" rel="noindex,nofollow,noopener">
                                        <svg width="30" height="30" viewBox="0 0 30 30" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <g clip-path="url(#clip0_258_41396)">
                                                <path
                                                    d="M30 15C30 6.71484 23.2852 0 15 0C6.71484 0 0 6.71484 0 15C0 23.2852 6.71484 30 15 30C15.0879 30 15.1758 30 15.2637 29.9941V18.3223H12.041V14.5664H15.2637V11.8008C15.2637 8.5957 17.2207 6.84961 20.0801 6.84961C21.4512 6.84961 22.6289 6.94922 22.9688 6.99609V10.3477H21C19.4473 10.3477 19.1426 11.0859 19.1426 12.1699V14.5605H22.8633L22.377 18.3164H19.1426V29.4199C25.4121 27.6211 30 21.8496 30 15Z"
                                                    fill="#D2D2D2"></path>
                                            </g>
                                            <defs>
                                                <clipPath id="clip0_258_41396">
                                                    <rect width="30" height="30" fill="white"></rect>
                                                </clipPath>
                                            </defs>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide h-auto">
                        <div
                            class="items-lecturers bg-white h-full rounded-lg overflow-hidden border-[1px] border-solid border-[#ebebeb] hover:border-transparent hover:shadow-[0_4px_10px_rgba(0,0,0,.3)] transition-all duration-300">
                            <span class="banner block c-img pt-[26%]">
                                <img src="theme/frontend/images/banner-lec.jpg" alt="">
                            </span>
                            <div class="content relative lg:p-4 p-2 pt-0 text-center lg:mt-[-75px] -mt-10">
                                <span
                                    class="ava block img-ava mx-auto lg:w-[8rem] lg:h-[8rem] w-[5rem] h-[5rem] rounded-full overflow-hidden">
                                    <img src="theme/frontend/images/ava-teacher.jpg" alt="">
                                </span>
                                <p class="name font-bold text-[#252525] 2lx:text-[1.25rem] text-[1rem] mb-1">Mrs. Lê
                                    Ngọc Anh</p>
                                <p class="role text-[#CD272F] mb-4">Chủ Tịch Hội Đồng Quản Trị Times Pro</p>
                                <div class="short_content lg:text-[0.875rem] mb-4">
                                    “Lorem ipsum dolor sit amet, consectetur adipiscing elit. Tempor orci facilisi
                                    consectetur interdum
                                    sed. Mauris, nec ac condimentum felis, gravida neque, platea id arcu. Facilisis
                                    eget mauris faucibus
                                    facilisis.”
                                </div>
                                <div
                                    class="grid grid-cols-3 gap-4 border-[1px] border-solid border-[#ebebeb] rounded lg:py-4 py-2 2xl:px-8 lg:px-6 px-4 mb-4">
                                    <div class="col-span-1 text-center">
                                        <p class="font-bold text-[#252525] text-[0.75rem] mb-2">Số khóa học</p>
                                        <span
                                            class="count inline-block font-semibold text-white px-2 py-1 rounded bg-[#E099C8]">
                                            10
                                        </span>
                                    </div>
                                    <div class="col-span-1 text-center">
                                        <p class="font-bold text-[#252525] text-[0.75rem] mb-2">Tổng giờ giảng</p>
                                        <span
                                            class="count inline-block font-semibold text-white px-2 py-1 rounded bg-[#E099C8]">
                                            699
                                        </span>
                                    </div>
                                    <div class="col-span-1 text-center">
                                        <p class="font-bold text-[#252525] text-[0.75rem] mb-2">Lượt đánh giá</p>
                                        <span
                                            class="count inline-block font-semibold text-white px-2 py-1 rounded bg-[#E099C8]">
                                            4.6/5
                                        </span>
                                    </div>
                                </div>
                                <div class="teacher-social flex justify-center items-center">
                                    <a href="" title="Điện thoại" class="item-social lg:mr-6 mr-3"
                                        rel="noindex,nofollow,noopener">
                                        <svg width="30" height="30" viewBox="0 0 30 30" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <g clip-path="url(#clip0_258_41388)">
                                                <path
                                                    d="M25.605 4.3918C19.7463 -1.46517 10.2487 -1.46377 4.39177 4.39502C-1.4652 10.2538 -1.4638 19.7513 4.39499 25.6082C10.2538 31.4652 19.7512 31.4638 25.6082 25.605C28.4211 22.7913 30.0009 18.9754 30 14.9968C29.9992 11.0189 28.4183 7.20418 25.605 4.3918ZM22.717 20.8948C22.7163 20.8955 22.7157 20.8962 22.715 20.8968V20.8919L21.955 21.6468C20.972 22.6422 19.5405 23.0517 18.1799 22.7268C16.8091 22.3599 15.506 21.7759 14.32 20.9969C13.218 20.2926 12.1969 19.4694 11.275 18.5418C10.4267 17.6998 9.66462 16.7752 8.99993 15.7818C8.2729 14.713 7.69745 13.5486 7.28993 12.3218C6.82276 10.8806 7.20989 9.29926 8.28995 8.23684L9.17993 7.34686C9.42737 7.0983 9.82944 7.09742 10.0779 7.34487C10.0786 7.34551 10.0793 7.34615 10.0799 7.34686L12.8899 10.1568C13.1385 10.4043 13.1393 10.8064 12.8919 11.0548C12.8913 11.0555 12.8906 11.0561 12.8899 11.0568L11.2399 12.7068C10.7665 13.1751 10.7069 13.9193 11.0999 14.4569C11.6967 15.2759 12.3571 16.0466 13.075 16.7619C13.8753 17.5657 14.7453 18.2969 15.6749 18.9469C16.2121 19.3215 16.9403 19.2584 17.4049 18.7969L18.9999 17.1769C19.2473 16.9283 19.6494 16.9275 19.8979 17.1749C19.8985 17.1755 19.8992 17.1762 19.8999 17.1769L22.7149 19.9969C22.9635 20.2443 22.9644 20.6463 22.717 20.8948Z"
                                                    fill="#D2D2D2"></path>
                                            </g>
                                            <defs>
                                                <clipPath id="clip0_258_41388">
                                                    <rect width="30" height="30" fill="white"></rect>
                                                </clipPath>
                                            </defs>
                                        </svg>
                                    </a>
                                    <a href="" title="Email" class="item-social lg:mr-6 mr-3"
                                        rel="noindex,nofollow,noopener">
                                        <svg width="30" height="30" viewBox="0 0 30 30" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <g clip-path="url(#clip0_258_41393)">
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M15 0C23.2843 0 30 6.71572 30 15C30 23.2843 23.2843 30 15 30C6.71572 30 0 23.2843 0 15C0 6.71572 6.71572 0 15 0ZM24.5215 20.8149V9.66668L18.9471 15.2408L24.5215 20.8149ZM6.66937 21.042H23.331L18.2387 15.9497L16.2979 17.8903C16.2038 17.9841 16.0763 18.0368 15.9434 18.0367H14.0567C13.9909 18.0368 13.9257 18.0239 13.8649 17.9988C13.804 17.9736 13.7487 17.9368 13.7021 17.8903L11.7614 15.9497L6.66914 21.042H6.66937ZM5.47852 9.66633V20.8152L11.0529 15.2408L5.47852 9.66633ZM23.8129 8.95799H6.1875L14.2643 17.0348H15.736L23.8129 8.95799Z"
                                                    fill="#D2D2D2"></path>
                                            </g>
                                            <defs>
                                                <clipPath id="clip0_258_41393">
                                                    <rect width="30" height="30" fill="white"></rect>
                                                </clipPath>
                                            </defs>
                                        </svg>
                                    </a>
                                    <a href="" title="Facebook" class="item-social" rel="noindex,nofollow,noopener">
                                        <svg width="30" height="30" viewBox="0 0 30 30" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <g clip-path="url(#clip0_258_41396)">
                                                <path
                                                    d="M30 15C30 6.71484 23.2852 0 15 0C6.71484 0 0 6.71484 0 15C0 23.2852 6.71484 30 15 30C15.0879 30 15.1758 30 15.2637 29.9941V18.3223H12.041V14.5664H15.2637V11.8008C15.2637 8.5957 17.2207 6.84961 20.0801 6.84961C21.4512 6.84961 22.6289 6.94922 22.9688 6.99609V10.3477H21C19.4473 10.3477 19.1426 11.0859 19.1426 12.1699V14.5605H22.8633L22.377 18.3164H19.1426V29.4199C25.4121 27.6211 30 21.8496 30 15Z"
                                                    fill="#D2D2D2"></path>
                                            </g>
                                            <defs>
                                                <clipPath id="clip0_258_41396">
                                                    <rect width="30" height="30" fill="white"></rect>
                                                </clipPath>
                                            </defs>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="pagination-red pagination-lecturers mt-5"></div>
            </div>
            <div
                class="button-slide swiper-slide__prev lecturers__prev hidden lg:block cursor-pointer absolute top-1/2 left-[-55px] -translate-y-1/2 z-[1]">
                <svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M23.75 15H6.25" stroke="#888" stroke-width="2.5" stroke-linecap="round"
                        stroke-linejoin="round" />
                    <path d="M15 6.25L6.25 15L15 23.75" stroke="#888" stroke-width="2.5" stroke-linecap="round"
                        stroke-linejoin="round" />
                </svg>
            </div>
            <div
                class="button-slide swiper-slide__next lecturers__next hidden lg:block cursor-pointer absolute top-1/2 right-[-55px] -translate-y-1/2 z-[1]">
                <svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M6.25 15H23.75" stroke="#888" stroke-width="2.5" stroke-linecap="round"
                        stroke-linejoin="round" />
                    <path d="M15 6.25L23.75 15L15 23.75" stroke="#888" stroke-width="2.5" stroke-linecap="round"
                        stroke-linejoin="round" />
                </svg>
            </div>
        </div>
    </div>
</section>
<section class="2xl:py-14 py-6 section-feeling bg-no-repeat bg-cover"
    style="background-image: url(theme/frontend/images/bg-feeling.jpg);">
    <div class="container">
        <p
            class="subtitle-white flex items-center text-white w-fit mx-auto relative uppercase text-[0.75rem] font-bold mb-2">
            TESTIMONIALS
        </p>
        <h2
            class="title-all font-bold text-white 2xl:text-[2rem] lg:text-[1.5rem] text-[1.125rem] text-center 2xl:mb-6 mb-4">
            CẢM NGHĨ CỦA HỌC VIÊN VỀ TIMES PRO
        </h2>
    </div>
    <div class="swiper-container slide-feeling">
        <div class="swiper-wrapper">
            <div class="swiper-slide h-auto">
                <div class="item-feeling h-full relative lg:pt-[4rem] pt-[2.5rem]">
                    <span
                        class="ava absolute top-0 left-1/2 -translate-x-1/2 z-[1] block img-ava lg:w-[8rem] lg:h-[8rem] h-[5rem] w-[5rem] rounded-full overflow-hidden">
                        <img src="theme/frontend/images/ava-student.jpg" alt="">
                    </span>
                    <div
                        class="content rounded-lg bg-[rgba(255,255,255,.25)]  2xl:p-8 lg:p-6 p-4  text-white text-center relative">
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
                        <div class="s-content">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Tempor orci facilisi
                            consectetur interdum sed.
                            Mauris, nec ac condimentum felis, gravida neque, platea id arcu. Facilisis sed risus at
                            eget mauris
                            faucibus facilisis. Lacus vel, vitae morbi tincidunt rhoncus nibh. Nisl, elit libero
                            pellentesque
                            aliquet.
                        </div>
                    </div>
                </div>
            </div>
            <div class="swiper-slide h-auto">
                <div class="item-feeling h-full relative lg:pt-[4rem] pt-[2.5rem]">
                    <span
                        class="ava absolute top-0 left-1/2 -translate-x-1/2 z-[1] block img-ava lg:w-[8rem] lg:h-[8rem] h-[5rem] w-[5rem] rounded-full overflow-hidden">
                        <img src="theme/frontend/images/ava-student.jpg" alt="">
                    </span>
                    <div
                        class="content rounded-lg bg-[rgba(255,255,255,.25)]  2xl:p-8 lg:p-6 p-4  text-white text-center relative">
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
                        <div class="s-content">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Tempor orci facilisi
                            consectetur interdum sed.
                            Mauris, nec ac condimentum felis, gravida neque, platea id arcu. Facilisis sed risus at
                            eget mauris
                            faucibus facilisis. Lacus vel, vitae morbi tincidunt rhoncus nibh. Nisl, elit libero
                            pellentesque
                            aliquet.
                        </div>
                    </div>
                </div>
            </div>
            <div class="swiper-slide h-auto">
                <div class="item-feeling h-full relative lg:pt-[4rem] pt-[2.5rem]">
                    <span
                        class="ava absolute top-0 left-1/2 -translate-x-1/2 z-[1] block img-ava lg:w-[8rem] lg:h-[8rem] h-[5rem] w-[5rem] rounded-full overflow-hidden">
                        <img src="theme/frontend/images/ava-student.jpg" alt="">
                    </span>
                    <div
                        class="content rounded-lg bg-[rgba(255,255,255,.25)]  2xl:p-8 lg:p-6 p-4  text-white text-center relative">
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
                        <div class="s-content">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Tempor orci facilisi
                            consectetur interdum sed.
                            Mauris, nec ac condimentum felis, gravida neque, platea id arcu. Facilisis sed risus at
                            eget mauris
                            faucibus facilisis. Lacus vel, vitae morbi tincidunt rhoncus nibh. Nisl, elit libero
                            pellentesque
                            aliquet.
                        </div>
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
    <div class="hidden lg:block absolute top-0 right-0 w-[40%] h-full bg-no-repeat bg-[length:100%_100%]"
        style="background-image: url(theme/frontend/images/bg-form-2.png);"></div>
    <div class="container relative z-[1] lg:flex items-center justify-end 2xl:min-h-[700px] lg:min-h-[500px]">
        <form action="" method=""
            class="form-regis max-w-[820px] lg:mr-0 mx-auto bg-white rounded-lg shadow-[6px_8px_48px_rgba(0,0,0,.1)] 2xl:p-8 lg:p-6 p-4">
            <p
                class="text-center font-bold text-[#252525] uppercase 2xl:text-[2.5rem] lg:text-[1.875rem] text-[1.125rem] mb-2">
                ĐĂNG KÝ TƯ VẤN - NHẬN ƯU ĐÃI
            </p>
            <div class="short_content text-center mb-6">
                Quý khách vui lòng nhập địa chỉ e-mail để chúng tôi có thể tư vấn một cách chu đáo và nhận những
                thông tin, ưu đãi sớm nhất từ TIMES PRO!
            </div>
            <div class="form relative">

                <input type="text" name="" placeholder="Nhập từ khoá tìm kiếm ..."
                    class="form-control w-full py-3 px-4 outline-none bg-[#f5f5f5] rounded-lg">
                <button
                    class="btn btn-orange font-semibold absolute top-0 right-0 h-full inline-flex items-center justify-center p-2 px-4 rounded bg-gradient-to-r from-[#F44336] to-[#C62828] text-white">
                    Gửi thông tin
                </button>
            </div>
        </form>
    </div>
</section>
@endsection
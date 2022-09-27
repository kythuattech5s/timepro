@extends('index')
@section('main')
    @if (count($listBanner) > 0)
        <div class="swiper-container slide-banner__index">
            <div class="swiper-wrapper">
                @foreach ($listBanner as $k => $itemBanner)
                    <div class="swiper-slide hidden-no-swiper">
                        <div class="link-banner img_full relative">
                            @if ($k == 0)
                                @include('image_loader.all', ['itemImage' => $itemBanner, 'key' => 'img', 'noLazyLoad' => 1])
                            @else
                                @include('image_loader.all', ['itemImage' => $itemBanner, 'key' => 'img'])
                            @endif
                            <div class="container absolute top-0 left-1/2 z-[1] -translate-x-1/2">
                                <div class="banner-content ml-0 mt-2 sm:mt-6 md:max-w-[50%] xl:mt-10 xl:max-w-[820px] 2xl:mt-20">
                                    <div class="s-content-title mb-2 text-[0.875rem] font-bold uppercase sm:mb-4 sm:text-[1.25rem] md:text-center lg:text-[2.5rem] xl:text-[3rem] 2xl:text-[4.5rem]">
                                        <p style="color:#fff">{{ Support::show($itemBanner, 'title_one') }}</p>
                                        <p style="color:#FF2D37">{{ Support::show($itemBanner, 'title_true') }}</p>
                                        <p style="color:#fff">{{ Support::show($itemBanner, 'title_three') }}</p>
                                    </div>
                                    <div class="short_content mb-4 hidden text-center text-white lg:block">
                                        {!! nl2br(Support::show($itemBanner, 'content')) !!}
                                    </div>
                                    <?php $list_button = Support::extractJson(Support::show($itemBanner, 'list_button')); ?>
                                    @if (count($list_button) > 0)
                                        <div class="flex flex-wrap items-center gap-2 sm:gap-4 md:justify-center">
                                            @foreach ($list_button as $button)
                                                <a href="{{ $button['link'] ?? '' }}" title="{{ $button['title'] ?? '' }}" class="btn-banner inline-flex items-center justify-center rounded border-[1px] border-solid border-white bg-transparent py-1 px-4 text-[0.75rem] text-white hover:bg-white hover:text-[#252525] sm:py-2 sm:text-[0.875rem] lg:px-5">
                                                    {{ $button['title'] ?? '' }}
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
    </section>
    <section class="section-lecturers bg-left bg-no-repeat py-6 2xl:py-14" style="background-image: url(theme/frontend/images/bg-lec.png);">
        <div class="container">
            <p class="subtitle__all relative mx-auto mb-2 w-fit text-[0.75rem] font-bold uppercase">{:our_lecturer:}</p>
            <h2 class="title-all mb-4 text-center text-[1.125rem] font-bold text-[#252525] lg:text-[1.5rem] 2xl:mb-6 2xl:text-[2rem]">ĐỘI NGŨ GIẢNG VIÊN</h2>
            <div class="box-slide relative">
                <div class="swiper-container slide-lecturers lg:py-5">
                    <div class="swiper-wrapper">
                        @foreach ($listTeacher as $itemTeacher)
                            @php
                                $ratingInfo = $itemTeacher->getRating('main');
                            @endphp
                            <div class="swiper-slide h-auto">
                                <div class="items-lecturers h-full overflow-hidden rounded-lg border-[1px] border-solid border-[#ebebeb] bg-white transition-all duration-300 hover:border-transparent hover:shadow-[0_4px_10px_rgba(0,0,0,.3)]">
                                    <span class="banner c-img block pt-[26%]">
                                        <img src="theme/frontend/images/banner-lec.jpg" alt="">
                                    </span>
                                    <div class="content relative -mt-10 p-2 pt-0 text-center lg:mt-[-75px] lg:p-4">
                                        <a href="{{ $itemTeacher->buildHrefTeacher() }}" title="{{ $itemTeacher->name }}" class="ava img-ava mx-auto mb-3 block h-[5rem] w-[5rem] overflow-hidden rounded-full lg:h-[8rem] lg:w-[8rem]">
                                            @include('image_loader.tiny', ['itemImage' => $itemTeacher, 'key' => 'img'])
                                        </a>
                                        <p class="name mb-1 text-[1rem] font-bold text-[#252525] 2xl:text-[1.25rem]">
                                            <a href="{{ $itemTeacher->buildHrefTeacher() }}" title="{{ $itemTeacher->name }}">{{ Support::show($itemTeacher, 'name') }}</a>
                                        </p>
                                        <p class="role mb-4 text-[#CD272F]">{{ Support::show($itemTeacher, 'teacher_job') }}</p>
                                        <div class="short_content mb-4 lg:text-[0.875rem]">{{ Support::show($itemTeacher, 'teacher_short_content') }}</div>
                                        <div class="mb-4 mt-auto grid grid-cols-3 gap-4 rounded border-[1px] border-solid border-[#ebebeb] py-2 px-4 lg:py-4 lg:px-6 2xl:px-8">
                                            <div class="col-span-1 text-center">
                                                <p class="mb-2 text-[0.75rem] font-bold text-[#252525]">Số khóa học</p>
                                                <span class="count inline-block rounded bg-[#E099C8] px-2 py-1 font-semibold text-white">{{ $itemTeacher->teacherCourses->count() }}</span>
                                            </div>
                                            <div class="col-span-1 text-center">
                                                <p class="mb-2 text-[0.75rem] font-bold text-[#252525]">Tổng giờ giảng</p>
                                                <span class="count inline-block rounded bg-[#E099C8] px-2 py-1 font-semibold text-white">{{ $itemTeacher->totalDuration() }}</span>
                                            </div>
                                            <div class="col-span-1 text-center">
                                                <p class="mb-2 text-[0.75rem] font-bold text-[#252525]">Đánh giá</p>
                                                <span class="count inline-block rounded bg-[#E099C8] px-2 py-1 font-semibold text-white"> {{ $ratingInfo['scoreAll'] }}/5</span>
                                            </div>
                                        </div>
                                        <div class="teacher-social flex items-center justify-center">
                                            <a href="tel:{{ Support::show($itemTeacher, 'phone') }}" title="Điện thoại" class="item-social mr-3 lg:mr-6">
                                                @include('icon_svgs.user_phone')
                                            </a>
                                            <a href="mailto:{{ Support::show($itemTeacher, 'email') }}" title="Email" class="item-social mr-3 lg:mr-6">
                                                @include('icon_svgs.user_email')
                                            </a>
                                            <a href="{{ Support::show($itemTeacher, 'facebook') }}" title="Facebook" class="item-social" target="_blank" rel="noindex,nofollow,noopener">
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
                <div class="button-slide swiper-slide__prev lecturers__prev absolute top-1/2 left-[-55px] z-[1] hidden -translate-y-1/2 cursor-pointer lg:block">
                    <svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M23.75 15H6.25" stroke="#888" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M15 6.25L6.25 15L15 23.75" stroke="#888" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </div>
                <div class="button-slide swiper-slide__next lecturers__next absolute top-1/2 right-[-55px] z-[1] hidden -translate-y-1/2 cursor-pointer lg:block">
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
@section('js')
    <script defer>
        window.addEventListener('DOMContentLoaded', async () => {
            const res = await XHR.send({
                url: "/tai-danh-muc-khoa-hoc",
                method: "GET",
            });
            document.querySelector('.section-cate__index').innerHTML = await res.html;
            SLIDER.slideCategory();
        })
    </script>
@endsection

@foreach ($listCourseCategory as $itemCourseCategory)
    @php
        $listCourseShow = $itemCourseCategory->course->take(10);
    @endphp
    <div class="item group py-6 2xl:py-14" style="background-image: url(theme/frontend/images/bg-category.jpg)">
        <div class="container">
            <div class="head-category mb-6 block items-center justify-between gap-8 md:flex">
                <div class="main-title relative after:absolute after:top-0 after:left-0 after:hidden after:h-full after:w-[5px] after:bg-white md:pl-5 md:after:block">
                    <h2 class="title mb-2 text-[1rem] font-bold uppercase text-[#252525] md:text-white lg:text-[1.3rem] 2xl:text-[1.6rem]">{{ Support::show($itemCourseCategory, 'name') }}</h2>
                    <div class="short_content md:text-white">{{ Support::show($itemCourseCategory, 'short_content') }}</div>
                </div>
                <a href="{{ Support::show($itemCourseCategory, 'slug') }}" title="Xem thêm" class="btn btn-orange hidden shrink-0 items-center justify-center rounded bg-white py-2 px-4 text-[#CD272F] hover:bg-[#FE8C00] hover:text-white md:inline-flex lg:px-5"> Xem thêm </a>
            </div>
            <div class="box-slide relative mb-4 grid grid-cols-1 gap-4 lg:grid-cols-2">
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
                <div class="button-slide swiper-slide__prev cate__prev absolute top-1/2 left-[-55px] z-[1] -translate-y-1/2 cursor-pointer">
                    <svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M23.75 15H6.25" stroke="#ebebeb" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M15 6.25L6.25 15L15 23.75" stroke="#ebebeb" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </div>
                <div class="button-slide swiper-slide__next cate__next absolute top-1/2 right-[-55px] z-[1] -translate-y-1/2 cursor-pointer">
                    <svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M6.25 15H23.75" stroke="#ebebeb" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M15 6.25L23.75 15L15 23.75" stroke="#ebebeb" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </div>
            </div>
        </div>
    </div>
@endforeach

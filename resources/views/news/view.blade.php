@extends('index')
@section('css')
    <link rel="stylesheet" href="{'comment/css/selectStar.css'}">
    <link rel="stylesheet" href="{'comment/css/star.css'}">
@endsection
@section('main')
    <div class="banner-pages">
        <div class="link img_full block">
            @include('image_loader.all', ['keyImage' => 'img', 'itemImage' => $parent])
        </div>
    </div>
    <div class="main-breadcrumb hidden py-4">
        <div class="container">
            {{ Breadcrumbs::render('news', $currentItem, $parent) }}
        </div>
    </div>
    <section class="section-new__detail py-6 2xl:py-14">
        <div class="container">
            <div class="grid grid-cols-1 gap-4 lg:grid-cols-3 2xl:gap-6">
                <div class="col-span-1 lg:col-span-2">
                    @php
                        $dataRatings = $currentItem->getRating('main');
                    @endphp
                    <div class="rating-item mb-2 flex gap-2 items-center" >
                        @include('commentRS::rating', ['rating' => $dataRatings['scoreAll'] * 20 . '%'])
                        <p>{-dataRatings.scoreAll-}/5 trong {-dataRatings.totalRating-} Đánh giá</p>
                    </div>
                    <h1 class="title-new mb-4 text-[1.125rem] font-bold text-[#252525] lg:text-[1.3rem] 2xl:text-[1.6rem]">
                        {{ Support::show($currentItem, 'name') }}
                    </h1>
                    <div class="s-content mb-6">
                        {!! Support::show($currentItem, 'content') !!}
                    </div>
                    @if (isset($tags) && count($tags))
                        <ul class="tag-new mb-6">
                            <li class="mr-4 inline-block text-[0.875rem] font-semibold text-[#252525]">Tags:</li>
                            @foreach ($tags as $tag)
                                <li class="mr-4 inline-block lg:text-[0.875rem]">
                                    <a href="{{ Support::show($tag, 'slug') }}" title="{{ Support::show($tag, 'name') }}" class="link inline-block whitespace-nowrap rounded-[50px] bg-[#EBEBEB] py-1 px-3 text-[#888] hover:bg-[#F44336] hover:text-white">
                                        {{ Support::show($tag, 'name') }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                    <div class="mb-4 flex flex-wrap items-center justify-between gap-2">
                        <div class="rating-now" data-table="news" data-id="{{ $currentItem->id }}">
                            @include('commentRS::selectStar')
                        </div>
                        <div class="flex items-center gap-4">
                            <div class="like">
                                <div id="fb-root"></div>
                                <script async defer crossorigin="anonymous" src="https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v15.0" nonce="ejJKIBLB"></script>
                                <div class="fb-like" data-href="https://developers.facebook.com/docs/plugins/" data-width="" data-layout="button" data-action="like" data-size="large" data-share="false"></div>
                            </div>
                            <ul>
                                <li class="mr-4 inline-block text-[0.875rem] text-[#252525] last:mr-0">Chia sẻ: </li>
                                <li class="mr-4 inline-block last:mr-0">
                                    <a href="http://www.facebook.com/sharer.php?u={{url(Support::show($currentItem,'slug'))}}" title="Facebook" class="flex h-6 w-6 items-center justify-center rounded-full bg-[#888] text-white hover:bg-[#F44336] hover:text-white" target="_blank">
                                        <i class="fa fa-facebook text-[0.75rem]" aria-hidden="true"></i>
                                    </a>
                                </li>
                                <li class="mr-4 inline-block last:mr-0">
                                    <a href="mailto:?subject={{Support::show($currentItem,'name')}}&body={{Support::show($currentItem,'name')}} - {{url(Support::show($currentItem,'slug'))}}" title="Gmail" class="flex h-6 w-6 items-center justify-center rounded-full bg-[#888] text-white hover:bg-[#F44336] hover:text-white" target="_blank">
                                        <i class="fa fa-google text-[0.75rem]" aria-hidden="true"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="comment-facebook">
                        <h2 class="title-all mb-3 font-bold text-[#252525]">Đánh giá bài viết! </h2>
                        <div id="fb-root"></div>
                        <script async defer crossorigin="anonymous" src="https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v9.0&appId={[fbappid]}&autoLogAppEvents=1" nonce="YTQOJB7h"></script>
                        <div class="fb-comments" data-href="{{ url()->current() }}" data-numposts="2" data-width="100%"></div>
                    </div>
                </div>
                <div class="col-span-1">
                    @include('news.sidebar')
                </div>
            </div>
        </div>
    </section>
    @if (isset($products) && count($products) > 0)
        <section class="py-6 2xl:py-14 2xl:pt-6">
            <div class="container">
                <p class="mb-4 text-[1rem] font-bold text-[#252525] lg:text-[1.3rem] 2xl:mb-6 2xl:text-[1.6rem]">Khóa học gợi ý</p>
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4 2xl:gap-6">
                    @foreach ($products as $itemProduct)
                        <div class="col-span-1">
                            @include('courses.item', ['item' => $itemProduct])
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
@endsection
@section('js')
    <script src="{'comment/js/rating.js'}" defer></script>
@endsection

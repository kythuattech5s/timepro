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
    $achievementAbouts = Support::extractJson(SettingHelper::getSetting('achievement_about'));
    $achievementAboutLefts = array_slice($achievementAbouts, 0, 2);
    $achievementAboutRights = array_slice($achievementAbouts, 2, 2);
    ?>
    <div class="max-w-[1700px] mx-auto px-[0.938rem]">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 sm:gap-4 gap-2 module-statis">
            <div class="col-span-1 flex flex-col justify-center lg:justify-end lg:pb-20 order-[1] lg:order-[first] sm:gap-4 gap-2 lg:gap-0">
                @foreach($achievementAboutLefts as $achievementAboutLeft)
                <div class="item lg:w-fit flex items-center justify-center lg:justify-start bg-white gap-2 lg:gap-1 p-1 px-4 rounded shadow-[2px_4px_32px_rgba(0,0,0,.1)] lg:mb-20 last:mb-0 xl:last:ml-20 lg:last:ml-10">
                    <span class="count leading-[1] font-bold 2xl:text-[3.5rem] lg:text-[2.5rem] text-[2rem] color-gradient" tech5s-number="{{Support::show($achievementAboutLeft,'number')}}">{{Support::show($achievementAboutLeft,'number')}}</span>
                    <span class="text font-semibold">
                        {!! nl2br(Support::show($achievementAboutLeft,'content')) !!}
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
                    <img src="{{$imgVideoYoutube ?? ''}}" alt="{[title_about_us]}" title="{[title_about_us]}" />
                    <span class="btn-play flex items-center justify-center w-[3.75rem] h-[3.75rem] rounded-full bg-white shadow-[0_6px_32px_rgba(0,0,0,.01)] absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 z-[1] text-[#F44336]">
                        <i class="fa fa-play 2xl:text-[1.875rem] text-[1.125rem] relative left-[2px]" aria-hidden="true"></i>
                    </span>
                </a>
            </div>
            <div class="col-span-1 flex flex-col justify-center lg:justify-end lg:pb-20 lg:items-end order-[2] sm:gap-4 gap-2 lg:gap-0">
                @foreach($achievementAboutRights as $achievementAboutRight)
                <div class="item lg:w-fit flex items-center justify-center lg:justify-start bg-white gap-2 lg:gap-1 p-1 px-4 rounded shadow-[2px_4px_32px_rgba(0,0,0,.1)] lg:mb-20 last:mb-0 xl:last:mr-20 lg:last:mr-10">
                    <span class="count leading-[1] font-bold 2xl:text-[3.5rem] lg:text-[2.5rem] text-[2rem] color-gradient" tech5s-number="{{Support::show($achievementAboutRight,'number')}}">{{Support::show($achievementAboutRight,'number')}}</span>
                    <span class="text font-semibold">
                        {!! nl2br(Support::show($achievementAboutRight,'content')) !!}
                    </span>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
<?php $advantageAbouts = Support::extractJson(SettingHelper::getSetting('advantage_about')); ?>
@if(isset($advantageAbouts) && count($advantageAbouts) > 0)
<section class="endow-index 2xl:py-14 py-6 bg-no-repeat bg-cover" style="background-image: url({Ibg_advantage_about.imgI}),linear-gradient(91.8deg, rgba(244, 67, 54, 0.85) 0%, rgba(198, 40, 40, 0.85) 100%);">
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
@endif
<?php $historyBeginAbouts = Support::extractJson(SettingHelper::getSetting('history_begin_about')); ?>
@if(isset($historyBeginAbouts) && count($historyBeginAbouts) > 0)
<section class="section-roadmap 2xl:py-14 py-6 bg-no-repeat" style="background-image: url({Ibg_history_begin_about.imgI});">
    <div class="container">
        <p class="subtitle-white flex items-center text-[#252525] lg:text-white w-fit mx-auto relative uppercase text-[0.75rem] font-bold mb-2">{:our_history:}</p>
        <h2 class="title-all font-bold text-[#252525] lg:text-white 2xl:text-[2rem] lg:text-[1.5rem] text-[1.125rem] text-center 2xl:mb-10 mb-6">
            {[title_history_begin_about]}
        </h2>
        <div class="main-roadmap relative lg:min-h-[776px]">
            <div class="box-logo hidden lg:flex items-center justify-center absolute block w-[254px] h-[254px] rounded-full bg-white shadow-[6px_8px_48px_rgba(0,0,0,.08)] bg-no-repeat bg-center" style="background-image: url(theme/frontend/images/bg-box-logo.png);">
                <img src="{Ilogo_history_begin_about.imgI}" alt="{Ilogo_history_begin_about.altI}" title="{Ilogo_history_begin_about.titleI}">
            </div>
            <div class="box-layer hidden lg:block">
              
                <span class="layer layer-1 transition-all duration-300 hover:scale-[1.05]">
                    <img src="theme/frontend/images/layer-1.svg" alt="icon">
                </span>
                <span class="layer layer-2 transition-all duration-300 hover:scale-[1.05]">
                    <img src="theme/frontend/images/layer-2.svg" alt="icon">
                </span>
                <span class="layer layer-3 transition-all duration-300 hover:scale-[1.05] hover:-translate-x-1/2">
                    <img src="theme/frontend/images/layer-3.svg" alt="icon">
                </span>
                <span class="layer layer-4 transition-all duration-300 hover:scale-[1.05]">
                    <img src="theme/frontend/images/layer-4.svg" alt="icon">
                </span>
                <span class="layer layer-5 transition-all duration-300 hover:scale-[1.05] ">
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
                @foreach($historyBeginAbouts as $historyBeginAbout)
                <div class="item col-span-1">
                    <p class="year font-bold color-gradient 2xl:text-[2.5rem] lg:text-[1.875rem] text-[1.25rem] mb-[2px]">{{Support::show($historyBeginAbout,'year')}}</p>
                    <p class="title font-bold text-[#252525] mb-1 2xl:text-[1.25rem]">{{Support::show($historyBeginAbout,'title')}}</p>
                    <p class="desc lg:text-[0.875rem]">
                        {!! nl2br(Support::show($historyBeginAbout,'content')) !!}
                    </p>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
@endif
<?php $listMissonVission = Support::extractJson(SettingHelper::getSetting('content_misson_vission_about')); ?>
<section class="section-vision">
    <div class="grid grid-cols-1 lg:grid-cols-5">
        <div class="col-span-1 lg:col-span-3 img_full img-vision">
            <img src="{Iimage_misson_vission_about.imgI}" alt="">
        </div>
        <div class="col-span-1 lg:col-span-2">
            <div class="box-vision bg-no-repeat h-full 2xl:p-8 p-4 flex flex-col justify-center text-white" style="background-image: url(theme/frontend/images/bg-vision.jpg);">
                @foreach($listMissonVission as $missonVission)
                <p class="title font-bold 2xl:text-[2.5rem] lg:text-[1.875rem] text-[1.125rem] mb-4">{{Support::show($missonVission,'title')}}</p>
                <div class="s-content 2xl:mb-10 mb-6">
                    {!! Support::show($missonVission,'content') !!}
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
<?php $testimonials = App\Models\Testimonial::act()->get(); ?>
<section class="2xl:py-14 py-6 section-feeling bg-no-repeat bg-cover" style="background-image: url({Ibg_testimonial.imgI}),linear-gradient(91.8deg, rgba(244, 67, 54, 0.85) 0%, rgba(198, 40, 40, 0.85) 100%);">
    <div class="container">
        <p class="subtitle-white flex items-center text-white w-fit mx-auto relative uppercase text-[0.75rem] font-bold mb-2">
            {:testimonial:}
        </p>
        <h2 class="title-all font-bold text-white 2xl:text-[2rem] lg:text-[1.5rem] text-[1.125rem] text-center 2xl:mb-6 mb-4">{[title_testimonial]}</h2>
    </div>
    <div class="swiper-container slide-feeling">
        <div class="swiper-wrapper">
            @foreach($testimonials as $testimonial)
            <div class="swiper-slide h-auto">
                <div class="item-feeling h-full relative lg:pt-[4rem] pt-[2.5rem]">
                    <span class="ava absolute top-0 left-1/2 -translate-x-1/2 z-[1] block img-ava lg:w-[8rem] lg:h-[8rem] h-[5rem] w-[5rem] rounded-full overflow-hidden">
                        @include('image_loader.tiny',['keyImage'=>'img','itemImage'=>$testimonial])
                    </span>
                    <div class="content rounded-lg bg-[rgba(255,255,255,.25)]  2xl:p-8 lg:p-6 p-4  text-white text-center relative">
                        <p class="name 2xl:text-[1.25rem] font-bold mb-2">{{Support::show($testimonial,'name')}}</p>
                        <?php $withStar = (int)Support::show($testimonial, 'star', 5) / 5 * 100; ?>
                        <div class="rating-item mb-4 justify-center">
                            <p class="rating">
                                <span class="rating-box">
                                    <i class="fa fa-star-o" aria-hidden="true"></i>
                                    <i class="fa fa-star-o" aria-hidden="true"></i>
                                    <i class="fa fa-star-o" aria-hidden="true"></i>
                                    <i class="fa fa-star-o" aria-hidden="true"></i>
                                    <i class="fa fa-star-o" aria-hidden="true"></i>
                                    <span style="width:{{$withStar ?? '100'}}%">
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
                            {!! Support::show($testimonial,'content') !!}
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="pagination-red pagination-feeling mt-5"></div>
    </div>
</section>

<section class="section-form relative lg:py-0 py-6">
    <div class="hidden lg:block bg-form absolute top-0 left-0 w-[60%] h-full img-ava">
        @include('image_loader.config.all',['config_key'=>'image_form_contact_about'])
    </div>
    <div class="hidden lg:block absolute top-0 right-0 w-[40%] h-full bg-no-repeat bg-[length:100%_100%]" style="background-image: url(theme/frontend/images/bg-form-2.png);"></div>
    <div class="container relative z-[1] lg:flex items-center justify-end 2xl:min-h-[700px] lg:min-h-[500px]">
        <form action="{{\VRoute::get('send_contact')}}" method="POST" class="formValidation form-regis max-w-[820px] lg:mr-0 mx-auto bg-white rounded-lg shadow-[6px_8px_48px_rgba(0,0,0,.1)] 2xl:p-8 lg:p-6 p-4">
            <p class="text-center font-bold text-[#252525] uppercase 2xl:text-[2.5rem] lg:text-[1.875rem] text-[1.125rem] mb-2">
                {[title_form_contact_about]}
            </p>
            <div class="short_content text-center mb-6">
                {[content_form_contact_about]}
            </div>
            <div class="form relative">
                <input type="text" name="email" placeholder="Nhập địa chỉ email của bạn..." class="form-control w-full py-3 px-4 outline-none bg-[#f5f5f5] rounded-lg">
                <button type="submit" class="btn btn-orange font-semibold absolute top-0 right-0 h-full inline-flex items-center justify-center p-2 px-4 rounded bg-gradient-to-r from-[#F44336] to-[#C62828] text-white">Gửi thông tin</button>
            </div>
        </form>
    </div>
</section>
@endsection
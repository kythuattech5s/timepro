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
@include('sections.about_us')
@include('sections.advantage')
@include('sections.list_cate')
<?php $historyBeginAbouts = Support::extractJson(SettingHelper::getSetting('history_begin_about')); ?>
@if(isset($historyBeginAbouts) && count($historyBeginAbouts) > 0)
<section class="section-roadmap 2xl:py-14 py-6 bg-no-repeat" style="background-image: url('theme/frontend/images/head-roadmap.jpg');">
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
@include('sections.testimonial')
@include('sections.contact')
@endsection
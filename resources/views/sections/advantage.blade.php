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
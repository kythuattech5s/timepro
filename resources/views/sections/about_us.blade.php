<section class="about-index py-6 2xl:py-14">
    <div class="container">
        <p class="subtitle__all relative mx-auto mb-2 w-fit text-[0.75rem] font-bold uppercase">{:about_us:}</p>
        <h2 class="title-all mb-4 text-center text-[1.125rem] font-bold uppercase text-[#252525] lg:text-[1.5rem] 2xl:text-[2rem]">{[title_about_us]}</h2>
        <div class="short_content s-content mx-auto mb-6 max-w-[62.5rem] text-center">{[content_about_us]}</div>
    </div>
    <?php
    $achievementAbouts = Support::extractJson(SettingHelper::getSetting('achievement_about'));
    $achievementAboutLefts = array_slice($achievementAbouts, 0, 2);
    $achievementAboutRights = array_slice($achievementAbouts, 2, 2);
    ?>
    <div class="mx-auto max-w-[1700px] px-[0.938rem]">
        <div class="module-statis grid grid-cols-1 gap-2 sm:grid-cols-2 sm:gap-4 lg:grid-cols-4">
            <div class="order-[1] col-span-1 flex flex-col justify-center gap-2 sm:gap-4 lg:order-[first] lg:justify-end lg:gap-0 lg:pb-20">
                @foreach ($achievementAboutLefts as $achievementAboutLeft)
                    <div class="item flex items-center justify-center gap-2 rounded bg-white p-1 px-4 shadow-[2px_4px_32px_rgba(0,0,0,.1)] last:mb-0 lg:mb-20 lg:w-fit lg:justify-start lg:gap-1 lg:last:ml-10 xl:last:ml-20">
                        <span class="count color-gradient text-[2rem] font-bold leading-[1] lg:text-[2.5rem] 2xl:text-[3.5rem]" tech5s-number="{{ Support::show($achievementAboutLeft, 'number') }}">{{ Support::show($achievementAboutLeft, 'number') }}</span>
                        <span class="text font-semibold">
                            {!! nl2br(Support::show($achievementAboutLeft, 'content')) !!}
                        </span>
                    </div>
                @endforeach
            </div>
            <div class="order-first col-span-1 sm:col-span-2 lg:order-[1]">
                <?php
                $idYoutube = Support::getYoutubeId(SettingHelper::getSetting('link_video_about'));
                ?>
                <a href="{[link_video_about]}" title="{[title_about_us]}" data-fslightbox="video-intro" class="video-intro c-img block overflow-hidden rounded-lg pt-[52%]">
                    @include('image_loader.config.all', ['config_key' => 'img_youtube'])
                    <span class="btn-play absolute top-1/2 left-1/2 z-[1] flex h-[3.75rem] w-[3.75rem] -translate-x-1/2 -translate-y-1/2 items-center justify-center rounded-full bg-white text-[#F44336] shadow-[0_6px_32px_rgba(0,0,0,.01)]">
                        <i class="fa fa-play relative left-[2px] text-[1.125rem] 2xl:text-[1.875rem]" aria-hidden="true"></i>
                    </span>
                </a>
            </div>
            <div class="order-[2] col-span-1 flex flex-col justify-center gap-2 sm:gap-4 lg:items-end lg:justify-end lg:gap-0 lg:pb-20">
                @foreach ($achievementAboutRights as $achievementAboutRight)
                    <div class="item flex items-center justify-center gap-2 rounded bg-white p-1 px-4 shadow-[2px_4px_32px_rgba(0,0,0,.1)] last:mb-0 lg:mb-20 lg:w-fit lg:justify-start lg:gap-1 lg:last:mr-10 xl:last:mr-20">
                        <span class="count color-gradient text-[2rem] font-bold leading-[1] lg:text-[2.5rem] 2xl:text-[3.5rem]" tech5s-number="{{ Support::show($achievementAboutRight, 'number') }}">{{ Support::show($achievementAboutRight, 'number') }}</span>
                        <span class="text font-semibold">
                            {!! nl2br(Support::show($achievementAboutRight, 'content')) !!}
                        </span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

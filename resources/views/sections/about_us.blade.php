<section class="about-index 2xl:py-14 py-6">
    <div class="container">
        <p class="subtitle__all w-fit mx-auto relative uppercase text-[0.75rem] font-bold mb-2">{:about_us:}</p>
        <h2 class="title-all uppercase font-bold text-[#252525] 2xl:text-[2rem] lg:text-[1.5rem] text-[1.125rem] text-center mb-4">{[title_about_us]}</h2>
        <div class="short_content text-center mb-6 s-content max-w-[62.5rem] mx-auto">{[content_about_us]}</div>
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
                $imgVideoYoutube = "https://img.youtube.com/vi/$idYoutube/maxresdefault.jpg";
                ?>
                <a href="{[link_video_about]}" title="{[title_about_us]}" data-fslightbox="video-intro" class="video-intro block c-img pt-[52%] rounded-lg overflow-hidden">
                    <img src="{{$imgVideoYoutube ?? ''}}" alt="{[title_about_us]}" title="{[title_about_us]}" loading="lazy" />
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
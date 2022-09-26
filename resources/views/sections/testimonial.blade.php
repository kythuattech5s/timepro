<?php $testimonials = Cache::rememberForever('testimonials', function () {
    return App\Models\Testimonial::act()->get();
}); ?>
<section class="section-feeling bg-cover bg-no-repeat py-6 2xl:py-14" style="background-image: url({Ibg_testimonial.imgI})">
    <div class="container">
        <p class="subtitle-white relative mx-auto mb-2 flex w-fit items-center text-[0.75rem] font-bold uppercase text-white">
            {:testimonial:}
        </p>
        <h2 class="title-all mb-4 text-center text-[1.125rem] font-bold text-white lg:text-[1.5rem] 2xl:mb-6 2xl:text-[2rem]">{[title_testimonial]}</h2>
    </div>
    <div class="swiper-container slide-feeling">
        <div class="swiper-wrapper">
            @foreach ($testimonials as $testimonial)
                <div class="swiper-slide h-auto">
                    <div class="item-feeling relative h-full pt-[2.5rem] lg:pt-[4rem]">
                        <span class="ava img-ava absolute top-0 left-1/2 z-[1] block h-[5rem] w-[5rem] -translate-x-1/2 overflow-hidden rounded-full lg:h-[8rem] lg:w-[8rem]">
                            @include('image_loader.tiny', ['keyImage' => 'img', 'itemImage' => $testimonial])
                        </span>
                        <div class="content relative rounded-lg bg-[rgba(255,255,255,.25)] p-4 text-center text-white lg:p-6 2xl:p-8">
                            <p class="name mb-2 font-bold 2xl:text-[1.25rem]">{{ Support::show($testimonial, 'name') }}</p>
                            <?php $withStar = ((int) Support::show($testimonial, 'star', 5) / 5) * 100; ?>
                            <div class="rating-item mb-4 justify-center">
                                <p class="rating">
                                    <span class="rating-box">
                                        <i class="fa fa-star-o" aria-hidden="true"></i>
                                        <i class="fa fa-star-o" aria-hidden="true"></i>
                                        <i class="fa fa-star-o" aria-hidden="true"></i>
                                        <i class="fa fa-star-o" aria-hidden="true"></i>
                                        <i class="fa fa-star-o" aria-hidden="true"></i>
                                        <span style="width:{{ $withStar ?? '100' }}%">
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
                                {!! Support::show($testimonial, 'content') !!}
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="pagination-red pagination-feeling mt-5"></div>
    </div>
</section>

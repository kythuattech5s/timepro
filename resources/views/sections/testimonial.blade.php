<?php $testimonials = App\Models\Testimonial::act()->get(); ?>
<section class="2xl:py-14 py-6 section-feeling bg-no-repeat bg-cover" style="background-image: url({Ibg_testimonial.imgI})">
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
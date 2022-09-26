@if (!isset($listCourseCategory))
    @php
        $listCourseCategory = \Cache::rememberForever('listHomeCourseCategory', function () {
            return \App\Models\CourseCategory::act()->with(['course'=>function($q){
                $q->select('id','act')->act();
            }])->where('home',1)->ord()->limit(5)->get();
        });
    @endphp
@endif
<section class="section-course__cate 2xl:py-14 py-6">
    <div class="container">
        <p class="subtitle__all w-fit mx-auto relative uppercase text-[0.75rem] font-bold mb-2"> OUR COURSES </p>
        <h2 class="title-all font-bold text-[#252525] 2xl:text-[2rem] lg:text-[1.5rem] text-[1.125rem] text-center 2xl:mb-6 mb-4"> DANH MỤC CÁC KHÓA HỌC TẠI TIMES PRO </h2>
        <div class="grid grid-cols-2 md:grid-cols-3 2xl:gap-6 sm:gap-4 gap-2">
            @foreach ($listCourseCategory as $itemCourseCategory)
                <div class="col-span-1">
                    <div class="item-course__cate h-full text-center rounded-lg overflow-hidden 2xl:py-24 lg:py-20 lg:px-8 px-4 py-10 bg-no-repeat bg-cover relative after:absolute after:top-0 after:left-0 after:w-full after:h-full after:bg-[rgba(0,0,0,.6)] hover:shadow-[0_8px_40px_rgba(205,39,47,.4)]" style="background-image: url({%IMGV2.itemCourseCategory.img.450x0%});">
                        <h2 class="relative z-[1]">
                            <a href="{{Support::show($itemCourseCategory,'slug')}}" title="{{Support::show($itemCourseCategory,'name')}}" class="title font-bold text-white 2xl:text-[1.25rem] block mb-2">{{Support::show($itemCourseCategory,'name')}}</a>
                        </h2>
                        <span class="count relative z-[1] font-semibold text-white">{{$itemCourseCategory->course->count()}} khóa học</span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
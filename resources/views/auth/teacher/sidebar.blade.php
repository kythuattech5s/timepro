<div class="box-info-student bg-white p-4 rounded mb-2">
	@if(Support::show($user,'img'))
    <span class="ava block mx-auto 2xl:w-40 2xl:h-40 lg:w-24 lg:h-24 w-20 h-20 rounded-full overflow-hidden mb-4">
        @include('image_loader.tiny',['keyImage'=>'img','itemImage'=>$user])
    </span>
    @else
    <span class="ava block mx-auto 2xl:w-40 2xl:h-40 lg:w-24 lg:h-24 w-20 h-20 rounded-full overflow-hidden mb-4">
        @include('image_loader.config.tiny',['config_key'=>'logo'])
    </span>
    @endif
    <p class="name text-center font-bold text-[#252525] 2xl:text-[1.25rem] mb-2">{{Support::show($user,'name')}}</p>
    <p class="text color-gradient text-center font-semibold">Giảng viên</p>
    <p class="teacher-statis flex items-center justify-between gap-4 mb-4">
        <span class="title font-semibold inline-flex items-center text-[#252525] text-[0.75rem]">
            <img src="theme/frontend/images/hat.svg" class="mr-1 inline-block" alt="icon">
            <span>Số khóa học</span>
        </span>
        <span class="count inline-block font-semibold text-white px-2 py-1 bg-gradient-to-r from-[#F44336] to-[#C62828] rounded">{{$user->teacherCourses->count()}}</span>
    </p>
    <p class="teacher-statis flex items-center justify-between gap-4 mb-4">
        <span class="title font-semibold inline-flex items-center text-[#252525] text-[0.75rem]">
            <img src="theme/frontend/images/user-profile-time-clock.svg" class="mr-1 inline-block" alt="icon">
            <span>Tổng giờ giảng</span>
        </span>
        <span class="count inline-block font-semibold text-white px-2 py-1 bg-gradient-to-r from-[#F44336] to-[#C62828] rounded">{{$user->totalDuration()}}</span>
    </p>
    <p class="teacher-statis flex items-center justify-between gap-4 mb-4">
        <span class="title font-semibold inline-flex items-center text-[#252525] text-[0.75rem]">
            <img src="theme/frontend/images/star.svg" class="mr-1 inline-block" alt="icon">
            <span>Lượt đánh giá</span>
        </span>
        <span class="count inline-block font-semibold text-white px-2 py-1 bg-gradient-to-r from-[#F44336] to-[#C62828] rounded">{{$user->getRatingScore()}}/5</span>
    </p>
</div>
<a href="{{\VRoute::get('my_profile')}}" class="sidebar-admin__item bg-white rounded flex items-center justify-between py-3 2xl:px-6 px-4 mb-2 transition-all duration-300">
    <span class="title font-bold text-[#252525]">Thông tin cá nhân</span>
    <i class="fa fa-angle-right text-[1.875rem]" aria-hidden="true"></i>
</a>
{{-- <a href="" class="sidebar-admin__item bg-white rounded flex items-center justify-between py-3 2xl:px-6 px-4 mb-2 transition-all duration-300">
    <span class="title font-bold text-[#252525]">Quản lý học viên</span>
    <i class="fa fa-angle-right text-[1.875rem]" aria-hidden="true"></i>
</a>
<a href=""
    class="sidebar-admin__item bg-white rounded flex items-center justify-between py-3 2xl:px-6 px-4 mb-2 transition-all duration-300">
    <span class="title font-bold text-[#252525]">Kì thi</span>
    <i class="fa fa-angle-right text-[1.875rem]" aria-hidden="true"></i>
</a>
<a href="" class="sidebar-admin__item bg-white rounded flex items-center justify-between py-3 2xl:px-6 px-4 mb-2 transition-all duration-300">
    <span class="title font-bold text-[#252525]">Kết quả kì thi</span>
    <i class="fa fa-angle-right text-[1.875rem]" aria-hidden="true"></i>
</a>

<a href="" class="sidebar-admin__item bg-white rounded flex items-center justify-between py-3 2xl:px-6 px-4 mb-2 transition-all duration-300">
    <span class="title font-bold text-[#252525]">Câu hỏi - thắc mắc</span>
    <i class="fa fa-angle-right text-[1.875rem]" aria-hidden="true"></i>
</a> --}}
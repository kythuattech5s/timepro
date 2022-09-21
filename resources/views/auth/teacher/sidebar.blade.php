<div class="box-info-student mb-2 rounded bg-white p-4">
    @if (Support::show($user, 'img'))
        <span class="ava mx-auto mb-4 block h-20 w-20 overflow-hidden rounded-full lg:h-24 lg:w-24 2xl:h-40 2xl:w-40">
            @include('image_loader.tiny', ['keyImage' => 'img', 'itemImage' => $user])
        </span>
    @else
        <span class="ava mx-auto mb-4 block h-20 w-20 overflow-hidden rounded-full lg:h-24 lg:w-24 2xl:h-40 2xl:w-40">
            @include('image_loader.config.tiny', ['config_key' => 'logo'])
        </span>
    @endif
    <p class="name mb-2 text-center font-bold text-[#252525] 2xl:text-[1.25rem]">{{ Support::show($user, 'name') }}</p>
    <p class="text color-gradient text-center font-semibold">Giảng viên</p>
    <p class="teacher-statis mb-4 flex items-center justify-between gap-4">
        <span class="title inline-flex items-center text-[0.75rem] font-semibold text-[#252525]">
            <img src="theme/frontend/images/hat.svg" class="mr-1 inline-block" alt="icon">
            <span>Số khóa học</span>
        </span>
        <span class="count inline-block rounded bg-gradient-to-r from-[#F44336] to-[#C62828] px-2 py-1 font-semibold text-white">{{ $user->teacherCourses->count() }}</span>
    </p>
    <p class="teacher-statis mb-4 flex items-center justify-between gap-4">
        <span class="title inline-flex items-center text-[0.75rem] font-semibold text-[#252525]">
            <img src="theme/frontend/images/user-profile-time-clock.svg" class="mr-1 inline-block" alt="icon">
            <span>Tổng giờ giảng</span>
        </span>
        <span class="count inline-block rounded bg-gradient-to-r from-[#F44336] to-[#C62828] px-2 py-1 font-semibold text-white">{{ $user->totalDuration() }}</span>
    </p>
    <p class="teacher-statis mb-4 flex items-center justify-between gap-4">
        <span class="title inline-flex items-center text-[0.75rem] font-semibold text-[#252525]">
            <img src="theme/frontend/images/star.svg" class="mr-1 inline-block" alt="icon">
            <span>Lượt đánh giá</span>
        </span>
        <span class="count inline-block rounded bg-gradient-to-r from-[#F44336] to-[#C62828] px-2 py-1 font-semibold text-white">{{ $user->getRatingScore() }}/5</span>
    </p>
</div>
<a href="{{ url('trang-ca-nhan') }}" class="sidebar-admin__item mb-2 flex items-center justify-between rounded bg-white py-3 px-4 transition-all duration-300 2xl:px-6 {{ Str::contains(url()->current(), [url('trang-ca-nhan')]) ? 'active' : '' }}">
    <span class="title font-bold text-[#252525]">Thông tin cá nhân</span>
    <i class="fa fa-angle-right text-[1.875rem]" aria-hidden="true"></i>
</a>
<a href="{{ url('thong-bao-cua-toi') }}" class="sidebar-admin__item {{ Str::contains(url()->current(), [url('thong-bao-cua-toi')]) ? 'active' : '' }} mb-2 flex items-center justify-between rounded bg-white py-3 px-4 transition-all duration-300 2xl:px-6">
    <span class="title font-bold text-[#252525]">Thông báo</span>
    <div class="noti flex items-center">
        <span class="count mr-4 inline-block h-5 min-w-[1.25rem] rounded-full bg-gradient-to-r from-[#F44336] to-[#C62828] text-center text-[0.875rem] font-semibold leading-5 text-white" count-not-read>
            @php
                if (!isset($countNotifiactionNoRead)) {
                    $countNotifiactionNoRead =
                        $user !== null
                            ? $user
                                ->unreadNotifications()
                                ->whereHas('catalog', function ($q) {
                                    $q->where('act', 1);
                                })
                                ->count()
                            : 0;
                }
            @endphp
            {{ $countNotifiactionNoRead }}
        </span>
        <i class="fa fa-angle-right text-[1.875rem]" aria-hidden="true"></i>
    </div>
</a>
<a href="{{\VRoute::get('manage_student')}}" class="sidebar-admin__item bg-white rounded flex items-center justify-between py-3 2xl:px-6 px-4 mb-2 transition-all duration-300 {{Str::contains(url()->current(),[\VRoute::get('manage_student')]) ? 'active':''}}">
    <span class="title font-bold text-[#252525]">Quản lý học viên</span>
    <i class="fa fa-angle-right text-[1.875rem]" aria-hidden="true"></i>
</a>
<a href="{{\VRoute::get('examResult')}}" class="sidebar-admin__item bg-white rounded flex items-center justify-between py-3 2xl:px-6 px-4 mb-2 transition-all duration-300 {{Str::contains(url()->current(),[\VRoute::get('examResult')]) ? 'active':''}}">
    <span class="title font-bold text-[#252525]">Kết quả kỳ thi</span>
    <i class="fa fa-angle-right text-[1.875rem]" aria-hidden="true"></i>
</a>
<a href="{{url('cau-hoi-va-thac-mac')}}" class="sidebar-admin__item mb-2 flex items-center justify-between rounded bg-white py-3 px-4 transition-all duration-300 2xl:px-6 {{ Str::contains(url()->current(), [url('cau-hoi-va-thac-mac')]) ? 'active' : '' }}">
    <span class="title font-bold text-[#252525]">Câu hỏi - thắc mắc</span>
    <i class="fa fa-angle-right text-[1.875rem]" aria-hidden="true"></i>
</a>

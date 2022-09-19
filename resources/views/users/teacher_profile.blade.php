@extends('index')
@section('main')
<div class="banner-teacher relative max-h-[20rem] overflow-hidden img_full">
    <img src="theme/frontend/images/banner-teacher.jpg" alt="">
    <div class="container absolute top-4 left-1/2 -translate-x-1/2 z-[1] text-white">
        {{\Breadcrumbs::render('static',$currentItem->name,$currentItem->slug)}}
    </div>
</div>
<section class="2xl:pb-14 pb-6 bg-[#EEEAEA]">
    <div class="container">
        <div class="teacher-block relative block sm:flex flex-wrap items-center justify-between 2xl:-mt-[5.6rem] lg:-mt-[4.6rem] -mt-4 2xl:mb-10 mb-6">
            <div class="box flex items-center">
                <div class="avatar img-ava 2xl:w-[17.875rem] 2xl:h-[17.875rem] lg:w-[15rem] lg:h-[15rem] w-20 h-20 rounded-full overflow-hidden aspect-square border lg:border-[7.5px] border-[2px] border-[#fff] mb-2 sm:mb-0">
                    @include('image_loader.big',['itemImage'=>$userTeacher,'key'=>'img'])
                </div>
                <div class="teacher-infomation lg:ml-[1.875rem] ml-4">
                    <p class="2xl:text-[2.5rem] lg:text-[1.875rem] text-[1.25rem] font-semibold text-[#252525] lg:mb-[0.325rem] mb-[0.325rem] font-averta">{{Support::show($userTeacher,'name')}}</p>
                    <div class="2xl:text-[1.125rem] color-gradient font-semibold font-averta">{{Support::show($userTeacher,'teacher_job')}}</div>
                </div>
            </div>
            <div class="teacher-social inline-flex items-center ml-auto">
                <a href="tel:{{Support::show($userTeacher,'phone')}}" title="Điện thoại" class="item-social lg:mr-[1rem] mr-[0.3125rem]" rel="noindex,nofollow,noopener">
                    @include('icon_svgs.user_phone')
                </a>
                <a href="mailto:{{Support::show($userTeacher,'email')}}" title="Email" class="item-social lg:mr-[1rem] mr-[0.3125rem]" rel="noindex,nofollow,noopener">
                    @include('icon_svgs.user_email')
                </a>
                <a href="{{Support::show($userTeacher,'facebook')}}" title="Facebook" class="item-social" target="_blank" rel="noindex,nofollow,noopener">
                    @include('icon_svgs.user_facebook')
                </a>
            </div>
        </div>
        <div class="button-tabs tab-info-lesson justify-center block border-b-[1px] border-solid border-[#d9d9d9] 2xl:mb-6 mb-4">
            <button type="button" class="tablinks font-bold 2xl:text-[1.25rem] py-4 border-b-[2px] border-solid border-transparent 2xl:mr-16 lg:mr-8 mr-4 last:mr-0 active"
                data-electronic="tab-lesson-1" data-target="tab-lesson">Thông tin cá nhân</button>
            <button type="button" class="tablinks font-bold 2xl:text-[1.25rem] py-4 border-b-[2px] border-solid border-transparent 2xl:mr-16 lg:mr-8 mr-4 last:mr-0"
                data-electronic="tab-lesson-2" data-target="tab-lesson">Khóa học đã dạy</button>
        </div>
        <div class="wrapper_tabcontent">
            <div class="tabcontent active" id="tab-lesson-1" data-target="tab-lesson">
                <div class="grid grid-cols-1 lg:grid-cols-3 2xl:gap-6 gap-4">
                    <div class="col-span-1">
                        <div class="box bg-white rounded-lg lg:p-4 p-2">
                            <p class="info text-[#252525] mb-4">
                                <span class="title font-semibold ">Họ và tên:</span>
                                <span class="text">{{Support::show($userTeacher,'name')}}</span>
                            </p>
                            <p class="info text-[#252525] mb-4">
                                <span class="title font-semibold ">Năm sinh:</span>
                                <span class="text">{{Support::showDate($userTeacher->birthday,'d/m/Y','Y-m-d')}}</span>
                            </p>
                            @if (isset($userTeacher->gender))
                                <p class="info text-[#252525] mb-4">
                                    <span class="title font-semibold ">Giới tính:</span>
                                    <span class="text">{{Support::show($userTeacher->gender,'name')}}</span>
                                </p>
                            @endif
                            <p class="info text-[#252525] mb-4">
                                <span class="title font-semibold ">Số điện thoại:</span>
                                <span class="text">{{Support::show($userTeacher,'phone')}}</span>
                            </p>
                            <p class="info text-[#252525] mb-4">
                                <span class="title font-semibold ">Email:</span>
                                <span class="text">{{Support::show($userTeacher,'email')}}</span>
                            </p>
                            <div class="grid grid-cols-3 gap-4 border-[1px] border-solid border-[#ebebeb] rounded 2xl:py-4 py-2 2xl:px-8 px-4">
                                <div class="col-span-1 text-center">
                                    <p class="font-semibold text-[0.75rem] text-[#252525] mb-2">Số khóa học</p>
                                    <span class="count inline-block py-1 px-2 rounded bg-['mix'] font-semibold text-white bg-gradient-to-r from-[#F44336] to-[#C62828]">{{count($userTeacher->course)}}</span>
                                </div>
                                <div class="col-span-1 text-center">
                                    <p class="font-semibold text-[0.75rem] text-[#252525] mb-2">Tổng giờ giảng</p>
                                    <span class="count inline-block py-1 px-2 rounded bg-['mix'] font-semibold text-white bg-gradient-to-r from-[#F44336] to-[#C62828]">{{(int)($userTeacher->course->sum('duration')/60)}}</span>
                                </div>
                                <div class="col-span-1 text-center">
                                    <p class="font-semibold text-[0.75rem] text-[#252525] mb-2">Lượt đánh giá</p>
                                    <span class="count inline-block py-1 px-2 rounded bg-['mix'] font-semibold text-white bg-gradient-to-r from-[#F44336] to-[#C62828]">4.6/5</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-span-1 lg:col-span-2">
                        <div class="box bg-white rounded-lg lg:p-4 p-2">
                            <p class="title font-bold text-[#252525] 2xl:text-[1.6rem] lg:text-[1.3rem] text-[1rem] mb-4">
                                Thông tin giảng viên
                            </p>
                            <div class="s-content mb-6">
                                {!!$userTeacher->teacher_description!!}
                            </div>
                            @if (count($userTeacher->skills) > 0)
                                <p class="title font-bold text-[#252525] 2xl:text-[1.6rem] lg:text-[1.3rem] text-[1rem] mb-4">
                                    Chuyên gia về
                                </p>
                                <ul class="list-cate">
                                    @foreach ($userTeacher->skills as $itemSkill)
                                        <li class="inline-block whitespace-nowrap font-semibold text-[#252525] bg-[#f5f5f5] py-2 px-5 rounded-[1.875rem] 2xl:mr-6 lg:mr-4 mr-2 last:mr-0 mb-2">{{Support::show($itemSkill,'name')}}</li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="tabcontent" id="tab-lesson-2" data-target="tab-lesson">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 2xl:gap-6 sm:gap-4 gap-2">
                    @foreach ($userTeacher->course as $item)
                        <div class="col-span-1">
                            @include('courses.item')
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
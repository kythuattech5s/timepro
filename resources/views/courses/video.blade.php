@extends('index')
@section('css')
    <link rel="stylesheet" href="{'comment/css/selectStar.css'}">
    <link rel="stylesheet" href="{'comment/css/star.css'}">
    {{-- <link href="https://vjs.zencdn.net/7.20.3/video-js.css" rel="stylesheet" /> --}}
    {{-- <link href="https://unpkg.com/@videojs/themes@1/dist/city/index.css" rel="stylesheet" /> --}}
    @include('tvs::video_css')
    <script type="text/javascript">
        var VIDEO_ID = {{ $secretId }}
    </script>
@endsection
@section('main')
    <section class="section-lesson mx-auto max-w-[1920px] bg-white py-6 2xl:py-14">
        <div class="head mb-6 block items-center justify-between gap-4 px-4 lg:flex lg:px-6 2xl:mb-8 2xl:px-10">
            <a href="{{ $currentItem->slug }}" title="Trở về" class="back mb-2 inline-block font-bold text-[#CD272F] lg:mb-0 2xl:text-[1.125rem]">
                <svg width="24" height="24" class="mr-2 inline-block" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M19 12H5" stroke="#CD272F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M12 19L5 12L12 5" stroke="#CD272F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                Trở về</a>
            <h1 class="title-lesson mb-2 text-[1rem] font-bold uppercase text-[#252525] lg:mb-0 lg:text-[1.25rem] 2xl:text-[1.6rem]">
                {{ Support::show($currentItem, 'name') }}
            </h1>
            <div class="rating-lesson">
                @php
                    $dataRating = $currentItem->getRating();
                @endphp
                <span class="title font-bold 2xl:text-[1.125rem]">Đánh giá: @include('commentRS::rating', ['rating' => $dataRating['percentAll'] . '%'])</span>
            </div>
        </div>
        <div class="main-lesson grid grid-cols-1 lg:grid-cols-3">
            <div class="col-span-1 border-r-[1px] border-solid border-[#ebebeb] lg:col-span-2">
                <div class="box-video-lesson">
                    <div class="video-lesson relative">
                        <video-js id="my_video_1" class="video-js vjs-default-skin vjs-16-9" controls preload="none" data-id="{{ Support::show($videoFirst, 'id') }}" width="640" height="268" poster="{%IMGV2.videoFirst.img.-1%}">
                            <source src="{{ route('tvs-video.playlist', ['tvsMapItemId' => Support::show($tvsMapItem,'id') ]) }}" type="application/x-mpegURL">
                        </video-js>
                    </div>
                </div>
                <div class="button-tabs tab-info-lesson mb-4 flex flex-wrap border-b-[1px] border-solid border-[#ebebeb] px-4 sm:block lg:px-10 2xl:mb-6 2xl:px-20">
                    <button class="tablinks active basis-1/2 border-b-[2px] border-solid border-transparent py-4 font-bold last:mr-0 sm:mr-4 lg:mr-8 2xl:mr-16 2xl:text-[1.25rem]" data-electronic="tab-lesson-1" data-target="tab-lesson">Tổng quan</button>
                    <button class="tablinks basis-1/2 border-b-[2px] border-solid border-transparent py-4 font-bold last:mr-0 sm:mr-4 lg:mr-8 2xl:mr-16 2xl:text-[1.25rem]" data-electronic="tab-lesson-2" data-target="tab-lesson">Thông tin giảng viên</button>
                    <button class="tablinks basis-1/2 border-b-[2px] border-solid border-transparent py-4 font-bold last:mr-0 sm:mr-4 lg:mr-8 2xl:mr-16 2xl:text-[1.25rem]" data-electronic="tab-lesson-3" data-target="tab-lesson">Tài liệu</button>
                    <button class="tablinks basis-1/2 border-b-[2px] border-solid border-transparent py-4 font-bold last:mr-0 sm:mr-4 lg:mr-8 2xl:mr-16 2xl:text-[1.25rem]" data-electronic="tab-lesson-4" data-target="tab-lesson">Hỏi đáp cùng giảng viên</button>
                </div>
                <div class="wrapper_tabcontent mb-4">
                    <div class="tabcontent active px-4 2xl:px-10" id="tab-lesson-1" data-target="tab-lesson">
                        <div class="s-content">
                            {!! Support::show($currentItem, 'content') !!}
                        </div>
                    </div>
                    <div class="tabcontent px-4 2xl:px-10" id="tab-lesson-2" data-target="tab-lesson">
                        @if (isset($currentItem->teacher))
                            @php
                                $userTeacher = $currentItem->teacher;
                            @endphp
                            <div class="grid gap-4 md:grid-cols-1 lg:grid-cols-5">
                                <div class="col-span-1 lg:col-span-3">
                                    <div class="module-info-teacher">
                                        <div class="info-teacher mb-4 flex items-center gap-4">
                                            <span class="ava img-ava block h-14 w-14 shrink-0 overflow-hidden rounded-full lg:h-20 lg:w-20 2xl:h-28 2xl:w-28">
                                                @include('image_loader.big', ['itemImage' => $userTeacher, 'key' => 'img'])

                                            </span>
                                            <div class="info-content">
                                                <p class="name mb-1 font-bold text-[#252525] 2xl:text-[1.25rem]">{{ Support::show($userTeacher, 'name') }}</p>
                                                <p class="desc text-[#CD272F]">{{ Support::show($userTeacher, 'teacher_job') }}</p>
                                            </div>
                                        </div>
                                        <div class="s-content mb-4 text-justify 2xl:mb-6">{!! $userTeacher->teacher_description !!}</div>
                                        <div class="statis ml-0 mr-auto mb-4 grid max-w-[25rem] grid-cols-3 gap-4 rounded border-[1px] border-solid border-[#ebebeb] py-4 px-4 lg:px-6 2xl:mb-6 2xl:px-9">
                                            <div class="col-span-1 text-center">
                                                <p class="title mb-2 text-[0.75rem] font-semibold text-[#252525]">Số khóa học</p>
                                                <span class="count inline-block rounded bg-[#E27B76] px-2 py-1 font-semibold text-white">{{ count($userTeacher->teacherCourses) }}</span>
                                            </div>
                                            <div class="col-span-1 text-center">
                                                <p class="title mb-2 text-[0.75rem] font-semibold text-[#252525]">Tổng giờ giảng</p>
                                                <span class="count inline-block rounded bg-[#E27B76] px-2 py-1 font-semibold text-white">{{ $userTeacher->totalDuration() }}</span>
                                            </div>
                                            @php
                                                $ratingInfo = $userTeacher->getRating('main');
                                            @endphp
                                            <div class="col-span-1 text-center">
                                                <p class="title mb-2 text-[0.75rem] font-semibold text-[#252525]">Lượt đánh
                                                    giá</p>
                                                <span class="count inline-block rounded bg-[#E27B76] px-2 py-1 font-semibold text-white">{{ $ratingInfo['scoreAll'] }}/5</span>
                                            </div>
                                        </div>
                                        <ul class="social-teacher">
                                            <li class="mr-4 inline-block last:mr-0 2xl:mr-6">
                                                <a href="tel:{{ Support::show($userTeacher, 'phone') }}" title="Số điện thoại" class="flex h-8 w-8 items-center justify-center rounded-full bg-[#D2D2D2] text-white">
                                                    <i class="fa fa-phone" aria-hidden="true"></i>
                                                </a>
                                            </li>
                                            <li class="mr-4 inline-block last:mr-0 2xl:mr-6">
                                                <a href="mailto:{{ Support::show($userTeacher, 'email') }}" title="Email" class="flex h-8 w-8 items-center justify-center rounded-full bg-[#D2D2D2] text-white">
                                                    <i class="fa fa-envelope-o" aria-hidden="true"></i>
                                                </a>
                                            </li>
                                            <li class="mr-4 inline-block last:mr-0 2xl:mr-6">
                                                <a href="{{ Support::show($userTeacher, 'facebook') }}" title="Facebool" class="flex h-8 w-8 items-center justify-center rounded-full bg-[#D2D2D2] text-white" target="_blank" rel="noindex,nofollow,noopener">
                                                    <i class="fa fa-facebook" aria-hidden="true"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-span-1 lg:col-span-2">
                                    <div class="form-rating__teacher rounded-lg border-[1px] border-solid border-[#ebebeb] p-4 lg:p-6 2xl:py-10 2xl:px-7">
                                        @php
                                            $commentTeacher = $currentItem->commentTeacher->first(function ($q) {
                                                return $q->user_id == \Auth::id();
                                            });
                                        @endphp
                                        @if ($commentTeacher == null)
                                            @include('courses.components.form_rating_teacher')
                                        @else
                                            <div class="form-rating__teacher mb-6 flex flex-col gap-4 p-4 lg:p-6 lg:px-10 2xl:mb-10 2xl:py-10 2xl:px-14">
                                                @include('courses.components.rating_teacher', ['comment' => $commentTeacher])
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="tabcontent px-4 2xl:px-10" id="tab-lesson-3" data-target="tab-lesson">
                        @php
                            $documents = ($documents = json_decode($currentItem->documents, true)) != null ? $documents : [];
                        @endphp
                        @foreach ($documents as $document)
                            @if ($document['act'] == 1 && ($file = json_decode($document['source'], true)) !== null)
                                <div class="item-document mb-4 block items-center justify-between gap-4 rounded-lg border-[1px] border-solid border-[#ebebeb] p-2 transition-all duration-300 last:mb-0 hover:border-transparent hover:bg-[#f5f5f5] sm:flex md:p-4 2xl:p-6">
                                    <div class="item mb-2 flex items-center gap-2 sm:mb-0">
                                        <span class="icon block h-12 w-12 shrink-0">
                                            <img src="theme/frontend/images/icon-doc.png" class="h-full w-full object-contain" alt="">
                                        </span>
                                        <div class="content">
                                            <p class="title mb-1 font-bold text-[#252525] 2xl:text-[1.125rem]">{{ $document['name'] }}</p>
                                            <p class="desc text-[0.75rem]">{{ $file['file_name'] }}</p>
                                        </div>
                                    </div>
                                    <a href="/{{ $file['path'] . $file['file_name'] }}" title="" class="btn btn-red-gradien mx-auto flex w-fit items-center justify-center rounded bg-gradient-to-r from-[#F44336] to-[#C62828] py-2 px-4 font-semibold text-white shadow-[0_6px_20px_rgba(178,30,37,.4)] sm:mr-0 sm:inline-flex" download="">
                                        <img src="theme/frontend/images/icon-download.svg" class="mr-2 h-5 w-5 object-contain" alt="">
                                        Download
                                    </a>
                                </div>
                            @endif
                        @endforeach
                    </div>
                    <div class="tabcontent px-4 2xl:px-10" id="tab-lesson-4" data-target="tab-lesson" question-teacher-main>
                        @include('components.question_teacher', ['listItems' => $listQuestions])
                    </div>
                </div>
            </div>
            <div class="col-span-1 lg:ml-[-2px]">
                <div course-el>
                    <div class="button-tabs tab-sidebar__lesson flex">
                        <button class="tablinks active inline-flex flex-1 items-center justify-center bg-[#ebebeb] p-3 font-semibold text-[#888] transition-all duration-300" data-electronic="tab-sidebar-1" data-target="tab-sidebar">
                            <i class="fa fa-file-text-o mr-2" aria-hidden="true"></i> Nội dung bài học
                        </button>
                        <button class="tablinks inline-flex flex-1 items-center justify-center bg-[#ebebeb] p-3 font-semibold text-[#888] transition-all duration-300" data-electronic="tab-sidebar-2" data-target="tab-sidebar">
                            <i class="fa fa-pencil-square-o mr-2" aria-hidden="true"></i>
                            Ghi chú
                        </button>
                    </div>
                    <div class="wrapper_tabcontent py-3 px-4 lg:px-6 2xl:py-6 2xl:px-10">
                        <div class="tabcontent active" id="tab-sidebar-1" data-target="tab-sidebar">
                            <p class="title mb-4 text-[1rem] font-bold text-[#252525] 2xl:text-[1.25rem]">Nội dung bài học
                            </p>
                            <div class="list-lesson__item mb-10 border-b-[1px] border-solid border-[#ebebeb] pb-4 2xl:mb-20">
                                @foreach ($videos as $video)
                                    @php
                                        $source = json_decode(Support::show($video, 'source'), true);
                                    @endphp
                                    <div class="item-lesson @if ($video->users->count() > 0) active @endif mb-2 flex cursor-pointer items-center justify-between gap-4 rounded-md p-2 transition-all duration-300 last:mb-0" data-link="{{ $source['path'] . $source['file_name'] }}" data-id="{{ Support::show($video, 'id') }}">
                                        <span class="title relative pl-2 font-semibold text-[#252525] after:absolute after:top-1/2 after:left-0 after:h-1 after:w-1 after:-translate-y-1/2 after:rounded-full after:bg-[#252525]">{{ Support::show($video, 'name') }}</span>
                                        <span class="time">{{ RSCustom::getTimeOfVideo(Support::show($video, 'duration'), [
                                            'hour' => ' giờ ',
                                            'minute' => ' phút ',
                                            'second' => ' giây ',
                                        ]) }}</span>
                                    </div>
                                @endforeach
                                @if ($currentItem->isDone())
                                    <button rating-course class="btn btn-red-gradien mx-auto flex w-fit items-center justify-center rounded bg-gradient-to-r from-[#F44336] to-[#C62828] py-2 px-4 font-semibold uppercase text-white shadow-[0_6px_20px_rgba(178,30,37,.4)]">Đánh giá khóa học</button>
                                @endif
                            </div>
                            <form action="" method="" class="form-note">
                                <textarea class="form-control h-24 w-full resize-none rounded-lg bg-[#F5F5F5] p-3 outline-none" name="note" placeholder="Nhập ghi chú và nhấn Enter để lưu lại "></textarea>
                            </form>
                        </div>
                        <div class="tabcontent" id="tab-sidebar-2" data-target="tab-sidebar">
                            <div list-note>
                                @include('courses.components.list_note')
                            </div>
                        </div>
                    </div>
                </div>
                <div rating-course-el class="hidden">
                    @php
                        $comment = $currentItem->comments->first(function ($q) {
                            return $q->user_id == \Auth::id();
                        });
                    @endphp
                    @if ($comment == null)
                        @include('courses.components.form_rating')
                    @else
                        <div class="form-rating__teacher mb-6 p-4 lg:p-6 lg:px-10 2xl:mb-10 2xl:py-10 2xl:px-14">
                            @include('courses.components.rating_course')
                        </div>
                    @endif
                    <a href="javascript:void(0)" back-to-course title="Quay lại bài học" class="back mx-auto mb-2 block w-fit text-[#CD272F] lg:mb-0 2xl:text-[1.125rem]">
                        <svg width="24" height="24" class="mr-2 inline-block" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M19 12H5" stroke="#CD272F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                            <path d="M12 19L5 12L12 5" stroke="#CD272F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg>
                        Quay lại bài học
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('js')
    @include('tvs::video_js')
    <script type="text/javascript">
        videojs('my_video_1');

        // function actionPlayVideo() {
        //     videojs('my_video_1').play();
        // }
    </script>
    {{-- <script src="https://vjs.zencdn.net/7.20.3/video.min.js"></script> --}}
    <script src="{'assets/js/FormData.js'}" defer></script>
    <script src="{'assets/js/ValidateFormHasFile.js'}" defer></script>
    <script src="{'theme/frontend/js/video-chapter.js'}" defer></script>
    <script type="module" src="{'video/js/app.js'}" defer></script>
    <script type="module" src="{'assets/js/question.js'}"></script>
@endsection

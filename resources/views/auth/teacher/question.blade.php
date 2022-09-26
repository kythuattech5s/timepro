@extends('index')
@section('main')
    <section class="bg-[#EEEAEA] py-6 2xl:py-8">
        <div class="container">
            <div class="grid grid-cols-1 gap-4 lg:grid-cols-4 2xl:gap-8">
                <div class="col-span-1">
                    @if (Auth::user()->isAccount())
                        @include('auth.account.sidebar')
                    @else
                        @include('auth.teacher.sidebar')
                    @endif
                </div>
                <div class="col-span-1 lg:col-span-3">
                    <div class="mb-4 box-content rounded bg-white p-4 last:mb-0 2xl:mb-6">
                        <form action="" method="GET" class="form-search formValidation relative" absolute>
                            <i class="fa fa-search absolute top-1/2 left-4 -translate-y-1/2 text-[#888]" aria-hidden="true"></i>
                            <input type="text" name="q" rules="required" value="{{ request()->input('q') }}" placeholder="Nhập từ khóa tìm kiếm..." class="form-control w-full rounded-[1.25rem] bg-[#f5f5f5] py-3 pl-10 pr-32 outline-none">
                            <button type="submit" title="Tìm kiếm" class="btn btn-red-gradien absolute top-0 right-0 inline-flex h-full items-center justify-center rounded-[1.25rem] bg-gradient-to-r from-[#F44336] to-[#C62828] py-2 px-6 font-semibold text-white">
                                Tìm kiếm
                            </button>
                        </form>
                    </div>
                    <div class="mb-4 box-content rounded bg-white p-4 last:mb-0 2xl:mb-6">
                        <div class="grid grid-cols-1 gap-4">
                            @foreach ($courses as $course)
                                <div class="bg-gradition-main w-full rounded-sm py-[13px] px-[24px]">
                                    <div class="flex justify-between">
                                        <div class="border-l-2 border-white px-2">
                                            <p class="text-lg text-white">{{ $course->name }}</p>
                                            <p class="text-sm text-white">Giảng viên: {{ $user->name }}</p>
                                        </div>
                                        <a href="{{ url($course->slug) }}" class="flex items-center justify-center gap-2 rounded-[5px] bg-white px-[20px] py-[10px]">Đi đến bài giảng <i class="fa fa-arrow-right" aria-hidden="true"></i></a>
                                    </div>
                                </div>
                                @php
                                    $listQuestions = RSCustom::paginate($course->questions, 5);
                                @endphp
                                <div question-teacher-main>
                                    @include('components.question_teacher', ['currentItem' => $course, 'listItems' => $listQuestions])
                                </div>
                            @endforeach
                            @if ($courses->count() == 0)
                                Chưa có khóa học nào!
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('js')
    <script src="{'assets/js/FormData.js'}" defer></script>
    <script src="{'assets/js/ValidateFormHasFile.js'}" defer></script>
    <script type="module" src="{'assets/js/question.js'}" defer></script>
@endsection

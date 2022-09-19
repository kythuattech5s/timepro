@extends('index')
@section('cssl')
    <script src="{{ Support::asset('managequestion/frontend/js/hack-timer.js')}}" defer></script>
@endsection
@section('css')
    {{-- <link rel="stylesheet" href="{{ Support::asset('managequestion/frontend/css/question.css')}}"/> --}}
    <link rel="stylesheet" href="{{ Support::asset('managequestion/frontend/css/confirm.min.css')}}"/>
    <script type="text/javascript">
       const dataExam = {!!$exam->builDataFrontend()!!};
    </script>
@endsection
@section('main')
<section class="2xl:py-8 py-6 bg-[#EEEAEA]">
    <div class="container">
        <div class="grid grid-cols-1 lg:grid-cols-4 2xl:gap-8 gap-4">
            <div class="col-span-1">
                @include('auth.account.sidebar')
            </div>
            <div class="col-span-1 lg:col-span-3">
                <div class="box-content bg-white p-4 rounded 2xl:mb-6 mb-4 last:mb-0">
                    <h1 class="title font-bold text-[#252525] 2xl:text-[1.6rem] lg:text-[1.25rem] text-[1rem] mb-4 text-center">Làm bài kiểm tra</h1>
                    <div class="item-exam grid grid-cols-1 sm:grid-cols-3 gap-2 items-center 2xl:p-4 p-2 rounded border-[1px] border-solid border-[#ebebeb] mb-4">
                        <div class="col-span-1">
                            <p class="cate text-[#252525] text-[0.875rem] mb-1">Khóa học</p>
                            <h3>
                                <a href="{{Support::show($mainCourse,'slug')}}" title="{{Support::show($mainCourse,'name')}}" class="title font-bold text-[#252525] lg:text-[1.25rem]">{{Support::show($mainCourse,'name')}}</a>
                            </h3>
                        </div>
                        <div class="col-span-1 lg:pl-14">
                            <a href="javascript:void(0)" title="Bắt đầu làm bài" class="btn btn-red-gradien inline-flex items-center justify-center font-semibold text-white py-2 px-6 rounded bg-gradient-to-r from-[#F44336] to-[#C62828]">Bắt đầu làm bài</a>
                        </div>
                    </div>
                    @php
                        $count = 1;
                    @endphp
                    <div id="module-content__exam">
                        <div id="count-down-exam" class="time-exam d-none"></div>
                        @foreach ($exam->pivotQuestion as $itemPivotQuestion)
                            @php $question = $itemPivotQuestion->question; @endphp
                            <div class="module-question-box" question="{{Support::show($question,'id')}}">
                                <p class="question font-semibold text-[#252525] mb-2">Câu {{$count}}: {{Support::show($question,'name')}}</p>
                                <div class="s-content mb-4">
                                    {!!$question->question_content!!}
                                </div>
                                @include('mtc::question.load_frontend',['question'=>$question])
                            </div>
                            @php $count++; @endphp
                        @endforeach
                        <div class="form-button__submit">
                            <button title="Hoàn thành" class="btn btn-yellow__all" onclick="MODULE_EXAM.submitExam(this)">Nộp bài</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('jsl')
    <script src="{{ Support::asset('managequestion/frontend/js/jquery-3.4.0.min.js')}}" defer></script>
    <script src="{{ Support::asset('managequestion/frontend/js/jquery-ui.min.js')}}" defer></script>
    <script src="{{ Support::asset('managequestion/frontend/js/jquery-confirm.min.js')}}" defer></script>
    <script src="{{ Support::asset('managequestion/frontend/js/audio.js')}}" defer></script>
    <script src="{{ Support::asset('managequestion/frontend/js/question.js')}}" defer></script>
    <script src="{{ Support::asset('managequestion/frontend/js/countdown.js')}}" defer></script>
@endsection
@section('js')
    <script src="{{ Support::asset('managequestion/frontend/js/exam.js')}}" defer></script>
@endsection

@extends('index')
@section('cssl')
    <script src="{{ Support::asset('managequestion/frontend/js/hack-timer.js')}}" defer></script>
@endsection
@section('css')
    <style>
        .max-width-800{
            max-width: 800px;
            margin: auto;
        }
    </style>
    <link rel="stylesheet" href="{{ Support::asset('managequestion/frontend/css/confirm.min.css')}}"/>
    <script type="text/javascript">
       const dataExam = {!!$exam->builDataFrontend($exam->id)!!};
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
                    <h1 class="title font-bold text-[#252525] 2xl:text-[1.6rem] lg:text-[1.25rem] text-[1rem] mb-4 text-center">Làm bài thi</h1>
                    <div class="head-exam block sm:flex items-center justify-between 2xl:mb-10 mb-6">
                        <div class="exam mb-2 sm:mb-0">
                            <p class="title font-bold text-[#252525] lg:text-[1.25rem] mb-2">{{Support::show($exam,'name')}}</p>
                            <p class="text-[#252525] ">Thời gian: {{(int)$exam->time/60}} phút</p>
                        </div>
                        <div class="exam mb-2 sm:mb-0">
                            <p class="text-[#252525] ">Thời gian mở: <span class="font-bold">{{Support::showDateTime($exam->open_time,'d/m/Y H:i:s')}}</span></p>
                            <p class="text-[#252525] ">Thời gian đóng: <span class="font-bold">{{Support::showDateTime($exam->close_time,'d/m/Y H:i:s')}}</span></p>
                        </div>
                        <div class="box-exam-time hidden flex items-center gap-2">
                            <img src="theme/frontend/images/clock.svg" alt="clock">
                            <div id="count-down-exam" class="time font-bold lg:text-[1.25rem] text-[#252525]"></div>
                        </div>
                    </div>
                    @php
                        $count = 1;
                    @endphp
                    <div id="module-content__exam">
                        @foreach ($exam->pivotQuestion()->inRandomOrder()->get() as $itemPivotQuestion)
                            @php $question = $itemPivotQuestion->question; @endphp
                            <div class="module-question-exam" question="{{Support::show($question,'id')}}">
                                <div class="module-question-box" question="{{Support::show($question,'id')}}">
                                    <p class="question font-semibold text-[#252525] mb-2">Câu {{$count}}: {{Support::show($question,'name')}}</p>
                                    <div class="s-content mb-4">
                                        {!!$question->question_content!!}
                                    </div>
                                    @include('mtc::question.load_frontend',['question'=>$question])
                                </div>
                            </div>
                            @php $count++; @endphp
                        @endforeach
                        <div class="form-button__submit text-center mt-3">
                            <button title="Hoàn thành" class="btn btn-red-gradien inline-flex items-center justify-center font-semibold text-white py-2 px-6 rounded bg-gradient-to-r from-[#F44336] to-[#C62828]" onclick="MODULE_EXAM.submitExam(this)">Nộp bài</button>
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

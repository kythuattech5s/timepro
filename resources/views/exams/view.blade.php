@extends('index')
@section('cssl')
    <script src="{{ Support::asset('managequestion/frontend/js/hack-timer.js')}}" defer></script>
@endsection
@section('css')
    <link rel="stylesheet" href="{{ Support::asset('managequestion/frontend/css/question.css')}}"/>
    <link rel="stylesheet" href="{{ Support::asset('managequestion/frontend/css/confirm.min.css')}}"/>
    <script type="text/javascript">
       const dataExam = {!!$currentItem->builDataFrontend()!!};
    </script>
@endsection
@section('main')
<section class="container">
    @php
        $count = 1;
    @endphp
    <div id="module-content__exam">
        <div id="count-down-exam" class="time-exam d-none"></div>
        @foreach ($currentItem->pivotQuestion as $itemPivotQuestion)
            @php $question = $itemPivotQuestion->question; @endphp
            <div class="module-question-box" question="{{Support::show($question,'id')}}">
                <span class="question-number">Câu {{$count}}</span>
                <div class="d-flex flex-wrap align-items-center justify-content-center mb-40">
                    @if ($question->audio_question_name != '')
                        <button class="audio-question" media="{%IMGV2.question.audio_question_name.-1%}"></button>
                    @endif
                    <div class="position-relative">
                        {{Support::show($question,'name')}}
                    </div>
                </div>
                <div class="content-question s-content">
                    {!!$question->question_content!!}
                </div>
                <div class="box-scrollstyle">
                    @include('mtc::question.load_frontend',['question'=>$question])
                </div>
            </div>
            @php $count++; @endphp
        @endforeach
        <div class="form-button__submit">
            <button title="Hoàn thành" class="btn btn-yellow__all" onclick="MODULE_EXAM.submitExam(this)">Nộp bài</button>
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

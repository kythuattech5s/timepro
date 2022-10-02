@extends('index')
@section('css')
    <link rel="stylesheet" href="{{ Support::asset('managequestion/frontend/css/custom_question.css')}}"/>
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
                    <div class="item-exam grid grid-cols-1 sm:grid-cols-3 gap-2 items-center 2xl:p-4 p-2 rounded border-[1px] border-solid border-[#ebebeb] mb-4">
                        <div class="col-span-1">
                            <p class="cate text-[#252525] text-[0.875rem] mb-1">Ngày thi</p>
                            <p class="date orange-gradient font-bold lg:text-[1.25rem]">{{Support::showDateTime($examResult->created_at,'d/m/Y')}}</p>
                        </div>
                    </div>
                    <div class="head-exam block sm:flex items-center justify-between 2xl:mb-10 mb-6">
                        <div class="exam mb-2 sm:mb-0 flex-1 text-center">
                            <p class="title font-bold text-[#252525] lg:text-[1.25rem] mb-2">{{Support::show($exam,'name')}}</p>
                            <p class="text-[#252525] ">Thời gian: {{(int)$exam->time/60}} phút</p>
                        </div>
                        <div class="total-result bg-[#f2f2f2] rounded py-3 px-6 shrink-0 text-[#888]">
                            Đúng: {{Support::show($examResult,'total_question_done')}}/{{Support::show($examResult,'total_question')}}
                        </div>
                    </div>
                    <div class="module-content__exam">
                        @php
                            $listExamResult = $examResult->getQuestionResult();
                        @endphp
                        @foreach ($examResult->exam->pivotQuestion as $key => $itemPivotQuestion)
                            @php 
                                $question = $itemPivotQuestion->question; 
                            @endphp
                            <div class="module-question-exam mb-4">
                                <p class="question font-semibold text-[#252525] mb-2">Câu {{$key + 1}}: {{Support::show($question,'name')}}</p>
                                <div class="s-content mb-4">
                                    {!!$question->question_content!!}
                                </div>
                                <div class="box-scrollstyle">
                                    @include('mtc::question.load_frontend_resutl',['question'=>$question,'answer'=>$listExamResult[$question->id]['answer'] ?? null])
                                </div>
                                <div class="border p-2 rounded">
                                    <span class="mr-2 font-bold">Đáp án đúng là:</span> 
                                    <div class="s-content">{!!$question->getTrueAnswerFrontend()!!}</div>
                                </div>
                                @if ($question->explanation_guide != '')
                                    <span class="show-result inline-block cursor-pointer font-semibold text-[#12CA3B] text-[0.875rem] mb-2">
                                        Hiện lời giải <i class="fa fa-angle-down ml-1 text-[1.25rem]" aria-hidden="true"></i>
                                    </span>
                                    <div class="box-result__content s-content hidden">
                                        {!!$question->explanation_guide!!}
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
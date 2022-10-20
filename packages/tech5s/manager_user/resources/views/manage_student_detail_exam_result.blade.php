@extends('vh::master')
@section('css')
<script src="https://cdn.tailwindcss.com"></script>
@endsection
@section('content')
<div class="content_history_learn w-100">
    @if (count($listItems) > 0)
        <div class="table-result">
            <div class="head-table grid grid-cols-7 gap-2 font-semibold text-[#252525] border-b-[1px] border-solid border-[#ebebeb]">
                <div class="col-span-1">
                    <p class="2xl:py-4 py-2">STT</p>
                </div>
                <div class="col-span-2">
                    <p class="2xl:py-4 py-2 text-center">Khóa học</p>
                </div>
                <div class="col-span-2">
                    <p class="2xl:py-4 py-2 text-center">Bài thi</p>
                </div>
                <div class="col-span-1">
                    <p class="2xl:py-4 py-2 text-center">Ngày thi</p>
                </div>
                <div class="col-span-1">
                    <p class="2xl:py-4 py-2 text-center">Kết quả</p>
                </div>
            </div>
            <div class="body-table">
                @foreach ($listItems as $key => $item)
                    <div class="item grid grid-cols-7 gap-2 border-b-[1px] border-solid border-[#ebebeb]">
                        <div class="col-span-1">
                            <p class="2xl:py-4 py-2">{{sprintf('%02d',($listItems->currentPage() - 1) * 10 + $key + 1)}}</p>
                        </div>
                        <div class="col-span-2">
                            <p class="2xl:py-4 py-2 text-center">{{Support::show($item->course,'name')}}</p>
                        </div>
                        <div class="col-span-2">
                            <p class="2xl:py-4 py-2 text-center">{{Support::show($item->exam,'name')}}</p>
                        </div>
                        <div class="col-span-1">
                            <p class="2xl:py-4 py-2 text-center">{{Support::showDateTime($item->created_at,'d/m/Y')}}</p>
                        </div>
                        <div class="col-span-1">
                            <p class="2xl:py-4 py-2 text-center">{{$item->total_question_done}}/{{$item->total_question}}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="pagination">
            {{$listItems->withQueryString()->links('bases.pagination')}}
        </div>
    @else
        <p class="text-[1.125rem]">Tạm thời chưa có kết quả bài thi nào</p>
    @endif
</div>
@endsection

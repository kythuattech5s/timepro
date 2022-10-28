@extends('vh::master')
@section('css')
<script src="https://cdn.tailwindcss.com"></script>
@endsection
@section('content')
<style>
    .content_history_learn{
        font-size:20px;
    }
</style>
<div class="content_history_learn w-100">
    <div class="infor_user" style="margin-bottom:20px;">
        <h1>Kết quả học của:{{Support::show($user,'name')}}</h1>
        <h3>Email:{{Support::show($user,'email')}}</h3>
    </div>
    <div class="grid grid-cols-3 gap-4">
   
    @foreach ($listItems as $item)
    <div class="process-course md:flex lg:gap-4 gap-2 2xl:mb-6 mb-4 col-span-1">
        <div class="img shrink-0 md:w-[15rem] mb-2 md:mb-0">
            <a href="{{Support::show($item,'slug')}}" title="{{Support::show($item,'name')}}" class="img c-img block img__ rounded-lg overflow-hidden">
                @include('image_loader.big',['itemImage'=>$item,'key'=>'img'])
            </a>
        </div>
        <div class="content flex-1 {{isset($onlyViewMode) && $onlyViewMode == 1 ? '':'max-w-[28.8125rem]'}}">
            <h3 class="title font-bold text-[#252525]  mb-2">
                <a href="{{Support::show($item,'slug')}}" title="{{Support::show($item,'name')}}">{{Support::show($item,'name')}}</a>
            </h3>
            @if (isset($item->teacher))
                <div class="flex items-center gap-2 mb-4">
                    <span class="img-ava shrink-0 w-10 h-10 rounded-full overflow-hidden">
                        @include('image_loader.big',['itemImage'=>$item->teacher,'key'=>'img'])
                    </span>
                    <div class="info">
                        <p class="name font-semibold text-[1rem]">{{Support::show($item->teacher,'name')}}</p>
                        <p class="text-[#888] text-[1rem]">{{Support::show($item->teacher,'teacher_job')}}</p>
                    </div>
                </div>
            @endif
            <div class="flex items-center 2xl;gap-6 gap-4 mb-3">
                <a href="javascript:void(0)" title="Tài liệu" class="link text-[1rem]">
                    <i class="fa fa-file-text-o mr-1 text-[1.125rem]" aria-hidden="true"></i> {{$item->getCountDocument()}} tài liệu 
                </a>
                <a href="javascript:void(0)" title="Cầu trả lời" class="link text-[1rem]">
                    <i class="fa fa-comments-o" aria-hidden="true"></i> {{$item->comments()->count()}} câu trả lời 
                </a>
            </div>
            @php
                $percenComplete = $item->percentComplete($user->id);
            @endphp
            <div class="flex items-center gap-2">
                <div class="process w-full flex-1 h-[6px] rounded-[1.25rem] bg-[#f5f5f5] overflow-hidden">
                    <div class="progress-bar bg-gradient-to-r from-[#FE8C00] to-[#F83600] h-full rounded-[1.25rem]" role="progressbar" style="width: {{$percenComplete}}%" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <span class="title text-[1rem] shrink-0 min-w-[110px]">{{$percenComplete}}% hoàn thành</span>
            </div>
        </div>
    </div>
    @endforeach
    </div>
    <hr class="line opacity-100 border-[#ebebeb] mx-0" />
    <div class="pagination">
        {{$listItems->withQueryString()->links('bases.pagination')}}
    </div>
</div>
@endsection

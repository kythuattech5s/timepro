@extends('vh::master')
@section('css')
<script src="https://cdn.tailwindcss.com"></script>
@endsection
@section('content')
<div class="content_history_learn w-100">
    <p class="text-[20px]">Danh sách học viên</p>
    @if (count($listItems) > 0)
        <div class="grid grid-cols-2 gap-4">
            @foreach ($listItems as $itemUser)
            <div class="col-span-2 md:col-span-1">
                <div class="student-manager grid grid-cols-2 gap-4 items-center 2xl:p-4 p-2 border-[1px] border-solid border-[#ebebeb] rounded mb-3 last:mb-0">
                    <div class="col-span-2 md:col-span-1">
                        <div class="student-info flex items-center gap-2">
                            <span class="ava w-16 h-16 rounded-full overflow-hidden shrink-0">
                                @include('image_loader.tiny',['itemImage'=>$itemUser,'key'=>'img'])
                            </span>
                            <div class="info">
                                <p class="name font-bold text-[#252525] 2xl:text-[1.125rem] mb-1">{{Support::show($itemUser,'name')}}</p>
                                <p class="email">{{Support::show($itemUser,'email')}}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="pagination">
            {{$listItems->withQueryString()->links('bases.pagination')}}
        </div>
    @else
        <p class="text-[1.125rem]">Tạm thời chưa có học viên nào</p>
    @endif
</div>
@endsection

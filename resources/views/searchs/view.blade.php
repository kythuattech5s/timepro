@extends('index')
@section('main')
<div class="main-breadcrumb py-4">
    <div class="container">
        {{\Breadcrumbs::render('static','Tìm kiếm',\VRoute::get("search"))}}
    </div>
</div>
<section class="section-categories 2xl:py-10 py-6">
    <div class="container">
        @if (count($listItems) > 0)
            <h1 class="title font-bold text-[#252525] 2xl:text-[1.6rem] lg:text-[1.25rem] text-[1rem] mb-4">Kết quả tìm kiếm với từ khóa: {{$keySeach}}</h1>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 2xl:gap-6 gap-4">
                @foreach ($listItems as $item)
                    <div class="col-span-1">
                        @include('courses.item')
                    </div>
                @endforeach
            </div>
        @else
            <div class="bg-white rounded p-3">
                <p class="text-[1.125rem]">Không tìm thấy khóa học nào</p>
            </div>
        @endif
    </div>
</section>
@endsection

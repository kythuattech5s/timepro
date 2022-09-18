@extends('index')
@section('main')
@include('course_categories.banner_page')
<div class="main-breadcrumb py-4">
    <div class="container">
        {{\Breadcrumbs::render('course_category',$currentItem)}}
    </div>
</div>
<section class="section-categories 2xl:py-14 py-6 bg-no-repeat" style="background-image: url(theme/frontend/images/bg-category.jpg)">
    <div class="container">
        @if (count($listItems) > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 2xl:gap-6 gap-4">
                @foreach ($listItems as $item)
                    <div class="col-span-1">
                        @include('courses.item')
                    </div>
                @endforeach
            </div>
        @else
            <div class="bg-white rounded p-3">
                <p class="text-[1.125rem]">Tạm thời chưa có khóa học nào.</p>
            </div>
        @endif
    </div>
</section>
@include('sections.list_cate')
@endsection

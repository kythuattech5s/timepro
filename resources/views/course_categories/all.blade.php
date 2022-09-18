@extends('index')
@section('main')
@include('course_categories.banner_page')
<div class="main-breadcrumb py-4">
    <div class="container">
        {{\Breadcrumbs::render('static','Thư viện',\VRoute::get("allCourse"))}}
    </div>
</div>
<section class="section-library 2xl:py-14 py-6">
    <div class="container">
        <p class="subtitle__all w-fit mx-auto relative uppercase text-[0.75rem] font-bold mb-2">
            OUR COURSES
        </p>
        <h1 class="title-all font-bold text-[#252525] 2xl:text-[2rem] lg:text-[1.5rem] text-[1.125rem] text-center 2xl:mb-6 mb-4">GỢI Ý KHÓA HỌC DÀNH CHO BẠN</h1>
        <ul class="nav-course text-center font-bold 2xl:text-[1.25rem] border-b-[1px] border-solid border-[#ebebeb] 2xl:mb-6 mb-4">
            <li class="inline-block 2xl:mx-6 mx-8">
                <a href="{{\VRoute::get("allCourse")}}" title="Khóa học mới" class="block pb-4 border-b-[2px] border-solid border-transparent {{$type == '' || $type == 'new' ?'active':''}}">Khóa học mới</a>
            </li>
            <li class="inline-block 2xl:mx-6 mx-8">
                <a href="{{\VRoute::get("allCourse")}}/khoa-hoc-dang-hot" title="Khóa học đang hot" class="block pb-4 border-b-[2px] border-solid border-transparent {{$type == 'khoa-hoc-dang-hot' ? 'active':''}}">Khóa học đang hot</a>
            </li>
            <li class="inline-block 2xl:mx-6 mx-8">
                <a href="{{\VRoute::get("allCourse")}}/goi-y-cho-ban" title="Gợi ý cho bạn" class="block pb-4 border-b-[2px] border-solid border-transparent {{$type == 'goi-y-cho-ban' ? 'active':''}}">Gợi ý cho bạn</a>
            </li>
        </ul>
        <div class="container">
            @if (count($listItems) > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 2xl:gap-6 gap-4">
                    @foreach ($listItems as $item)
                        <div class="col-span-1">
                            @include('courses.item')
                        </div>
                    @endforeach
                </div>
                <div class="pagination">
                    {{$listItems->withQueryString()->links('bases.pagination')}}
                </div>
            @else
                <div class="bg-white rounded p-3">
                    <p class="text-[1.125rem]">Tạm thời chưa có khóa học nào.</p>
                </div>
            @endif
        </div>
    </div>
</section>
@include('sections.list_cate')
@endsection

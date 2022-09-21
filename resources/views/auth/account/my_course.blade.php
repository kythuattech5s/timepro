@extends('index')
@section('css')
<style>
    .tabs .active {
        border: 1px solid #f44336;
        color:#f44336;
     
    }
</style>
@endsection
@section('main')
<section class="2xl:py-8 py-6 bg-[#EEEAEA]">
    <div class="container">
        <div class="grid grid-cols-1 lg:grid-cols-4 2xl:gap-8 gap-4">
            <div class="col-span-1">
                @include('auth.account.sidebar')
            </div>
            <div class="col-span-1 lg:col-span-3">
                <div class="box-content bg-white p-4 lg:px-8 rounded 2xl:mb-6 mb-4 last:mb-0">
                    <h1 class="title font-bold text-[#252525] 2xl:text-[1.6rem] lg:text-[1.25rem] text-[1rem] mb-4 text-center"> Khóa học của tôi </h1>
                    <div class="student-manager grid grid-cols-2 md:grid-cols-3 gap-4 items-center mb-4"></div>
                    <form id="form-fillter-my-course" action="{{\VRoute::get("my_course")}}" method="get" class="button-tabs tab-info-lesson justify-center block border-b-[1px] border-solid border-[#ebebeb] 2xl:mb-6 mb-4" accept-charset="utf8">
                        <div class="flex flex-wrap items-center justify-between mb-[1rem]">
                            <div class="filter-category sm:w-fit w-full font-semibold text-base inline-flex items-center sm:mb-0 mb-3">
                                @include('icon_svgs.fillter')
                                Bộ lọc: 
                                <select name="category" class="text-[#454545] font-normal sm:ml-0 ml-auto inline-block text-base inline-block focus:outline-none item-fillter">
                                    <option value=""> Tất cả danh mục </option>
                                    @foreach ($listCourseCategory as $itemCourseCategory)
                                        <option value="{{$itemCourseCategory->id}}" {{$activeCategoryId == $itemCourseCategory->id ? 'selected':''}}>{{$itemCourseCategory->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="filter-order sm:w-fit w-full inline-flex items-center font-semibold text-base"> 
                                Sắp xếp: 
                                <select name="sort" class="text-[#454545] font-normal sm:ml-0 ml-auto inline-block text-base rounded rounded-[2.1875rem] bg-[#F5F5F5] p-1 px-3 focus:outline-none item-fillter">
                                    <option value="1" {{$sort == 1 ? 'selected':''}}>Mới nhất</option>
                                    <option value="2" {{$sort == 2 ? 'selected':''}}>Cũ nhất</option>
                                </select>
                            </div>
                        </div>
                        <div class="tabs flex flex-nowrap items-center lg:gap-4 gap-3 overflow-x-auto snap-start mb-[1.25rem] sm:pb-0 pb-[0.625rem]">
                            <label class="flex-none text-[#888888] border-[1px] border-[#888888] font-semibold inline-block rounded-[1.875rem] p-1 px-3 {{$type == 1 ? 'active color-gradient':''}}">
                                <input class="hidden item-fillter" type="radio" name="type" value="1">
                                Tất cả
                            </label>
                            <label class="flex-none text-[#888888] border-[1px] border-[#888888] font-semibold inline-block rounded-[1.875rem] p-1 px-3 {{$type == 2 ? 'active color-gradient':''}}">
                                <input class="hidden item-fillter" type="radio" name="type" value="2">
                                Chưa học
                            </label>
                            <label class="flex-none text-[#888888] border-[1px] border-[#888888] font-semibold inline-block rounded-[1.875rem] p-1 px-3 {{$type == 3 ? 'active color-gradient':''}}">
                                <input class="hidden item-fillter" type="radio" name="type" value="3">
                                Đang học
                            </label>
                            <label class="flex-none text-[#888888] border-[1px] border-[#888888] font-semibold inline-block rounded-[1.875rem] p-1 px-3 {{$type == 4 ? 'active color-gradient':''}}">
                                <input class="hidden item-fillter" type="radio" name="type" value="4">
                                Đã hoàn thành
                            </label>
                        </div>
                    </form>
                    <div class="wrapper_tabcontent">
                        <div class="tabcontent active" id="tab-lesson-1">
                            @if (count($listItems) > 0)
                                @foreach ($listItems as $item)
                                    @include('auth.account.process_course')
                                @endforeach
                                <hr class="line opacity-100 border-[#ebebeb] mx-0" />
                                <div class="pagination">
                                    {{$listItems->withQueryString()->links('bases.pagination')}}
                                </div>
                            @else
                                <p class="text-[1.125rem]">Tạm thời chưa có khóa học nào.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('js')
    <script src="{{ Support::asset('theme/frontend/js/user_course_control.js') }}" defer></script>
@endsection
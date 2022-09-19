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
                    <form action="{{\VRoute::get("my_course")}}" method="get" class="button-tabs tab-info-lesson justify-center block border-b-[1px] border-solid border-[#ebebeb] 2xl:mb-6 mb-4" accept-charset="utf8">
                        <div class="flex flex-wrap items-center justify-between mb-[1rem]">
                            <div class="filter-category sm:w-fit w-full font-semibold text-base inline-flex items-center sm:mb-0 mb-3">
                                @include('icon_svgs.fillter')
                                Bộ lọc: 
                                <select name="category" class="text-[#454545] font-normal sm:ml-0 ml-auto inline-block text-base inline-block focus:outline-none">
                                    <option value=""> Tất cả danh mục </option>
                                </select>
                            </div>
                            <div class="filter-order sm:w-fit w-full inline-flex items-center font-semibold text-base"> 
                                Sắp xếp: 
                                <select name="ord" class="text-[#454545] font-normal sm:ml-0 ml-auto inline-block text-base rounded rounded-[2.1875rem] bg-[#F5F5F5] p-1 px-3 focus:outline-none">
                                    <option value="">Mới nhất</option>
                                    <option value="">Cũ nhất</option>
                                </select>
                            </div>
                        </div>
                        <div class="tabs flex flex-nowrap items-center lg:gap-4 gap-3 overflow-x-auto snap-start mb-[1.25rem] sm:pb-0 pb-[0.625rem]">
                            <label class="flex-none text-[#888888] border-[1px] border-[#888888] font-semibold inline-block rounded-[1.875rem] p-1 px-3 active">
                                <input class="hidden" type="radio" name="type" value="1">
                                Tất cả
                            </label>
                            <label class="flex-none text-[#888888] border-[1px] border-[#888888] font-semibold inline-block rounded-[1.875rem] p-1 px-3">
                                <input class="hidden" type="radio" name="type" value="2">
                                Chưa học
                            </label>
                            <label class="flex-none text-[#888888] border-[1px] border-[#888888] font-semibold inline-block rounded-[1.875rem] p-1 px-3">
                                <input class="hidden" type="radio" name="type" value="3">
                                Đang học
                            </label>
                            <label class="flex-none text-[#888888] border-[1px] border-[#888888] font-semibold inline-block rounded-[1.875rem] p-1 px-3">
                                <input class="hidden" type="radio" name="type" value="4">
                                Đã hoàn thành
                            </label>
                        </div>
                    </form>
                    <div class="wrapper_tabcontent">
                        <div class="tabcontent active" id="tab-lesson-1">
                            @if (count($listItems) > 0)
                                @foreach ($listItems as $item)
                                    <div class="process-course md:flex lg:gap-4 gap-2 2xl:mb-6 mb-4">
                                        <div class="img shrink-0 md:w-[15rem] mb-2 md:mb-0">
                                            <span class="img c-img block img__ rounded-lg overflow-hidden pt-[56%]">
                                                @include('image_loader.big',['itemImage'=>$item,'key'=>'img'])
                                            </span>
                                        </div>
                                        <div class="content flex-1 max-w-[28.8125rem]">
                                            <h3 class="title font-bold text-[#252525] lg:text-[1.125rem] mb-2">{{Support::show($item,'name')}}</h3>
                                            @if (isset($item->teacher))
                                                <div class="flex items-center gap-2 mb-4">
                                                    <span class="img-ava shrink-0 w-10 h-10 rounded-full overflow-hidden">
                                                        @include('image_loader.big',['itemImage'=>$item->teacher,'key'=>'img'])
                                                    </span>
                                                    <div class="info">
                                                        <p class="name font-semibold text-[0.875rem]">{{Support::show($item->teacher,'name')}}</p>
                                                        <p class="text-[#888] text-[0.875rem]">{{Support::show($item->teacher,'teacher_job')}}</p>
                                                    </div>
                                                </div>
                                            @endif
                                            <div class="flex items-center 2xl;gap-6 gap-4 mb-3">
                                                <a href="javascript:void(0)" title="Tài liệu" class="link text-[0.875rem]">
                                                    <i class="fa fa-file-text-o mr-1 text-[1.125rem]" aria-hidden="true"></i> {{$item->getCountDocument()}} tài liệu 
                                                </a>
                                                <a href="javascript:void(0)" title="Cầu trả lời" class="link text-[0.875rem]">
                                                    <i class="fa fa-comments-o" aria-hidden="true"></i> 0 câu trả lời 
                                                </a>
                                            </div>
                                            @php
                                                $percenComplete = $item->percentStudy();
                                            @endphp
                                            <div class="flex items-center gap-2">
                                                <div class="process w-full flex-1 h-[6px] rounded-[1.25rem] bg-[#f5f5f5] overflow-hidden">
                                                    <div class="progress-bar bg-gradient-to-r from-[#FE8C00] to-[#F83600] h-full rounded-[1.25rem]" role="progressbar" style="width: {{$percenComplete}}%" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                                <span class="title text-[0.875rem] shrink-0 min-w-[110px]">{{$percenComplete}}% hoàn thành</span>
                                            </div>
                                        </div>
                                        <a href="{{Support::show($item,'slug')}}" title="Học ngay" class="md:mt-0 mt-3 ml-auto btn btn-orange inline-flex items-center justify-center py-2 lg:px-5 px-4 rounded bg-gradient-to-r from-[#FE8C00] to-[#F83600] text-white self-center hover:text-[#fff]">Học ngay <i class="fa fa-angle-double-right ml-1" aria-hidden="true"></i>
                                        </a>
                                    </div>
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
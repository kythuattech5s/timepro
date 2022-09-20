@extends('index')
@section('main')
<section class="2xl:py-8 py-6 bg-[#EEEAEA]">
    <div class="container">
        <div class="grid grid-cols-1 lg:grid-cols-4 2xl:gap-8 gap-4">
            <div class="col-span-1">
                @include('auth.teacher.sidebar')
            </div>
            <div class="col-span-1 lg:col-span-3">
                <div class="box-content bg-white p-4 rounded 2xl:mb-6 mb-4 last:mb-0">
                    <h1 class="title font-bold text-[#252525] 2xl:text-[1.6rem] lg:text-[1.25rem] text-[1rem] mb-4 text-center">Kết quả kỳ thi</h1>
                    <form action="{{\VRoute::get('examResult')}}" method="get" class="form-search flex flex-wrap relative mb-3 gap-2" accept-charset="utf8">
                        <select class="form-control pl-4 rounded-[1.25rem] flex-1 py-3 outline-none bg-[#f5f5f5]" name="course">
                            <option value="">Tất cả khóa học</option>
                            @foreach ($listTeacherCousre as $itemTeacherCousre)
                                <option value="{{ $itemTeacherCousre->id }}" {{$activeCourseId == $itemTeacherCousre->id ? 'selected':''}}>{{ $itemTeacherCousre->name }}</option>
                            @endforeach
                        </select>
                        <button type="submit" class="btn btn-red-gradien h-100 inline-flex items-center justify-center font-semibold text-white py-2 px-6 rounded-[1.25rem] bg-gradient-to-r from-[#F44336] to-[#C62828]">Tìm kiếm</button>
                    </form>
                    @if (isset($activeCourse))
                        <div class="exam-manager grid grid-cols-1 md:grid-cols-2 gap-4 items-center 2xl:p-4 p-2 border-[1px] border-solid border-[#ebebeb] rounded mb-3 last:mb-0">
                            <div class="col-span-1">
                                <h3 class="title font-bold text-[#252525] 2xl:text-[1.125rem] mb-1">
                                    Khóa học: 
                                    <a href="{{Support::show($activeCourse,'slug')}}" title="{{Support::show($activeCourse,'name')}}">{{Support::show($activeCourse,'name')}}</a>
                                </h3>
                                @if (isset($activeCourse->exam))
                                    <p class="text">Kỳ thi: {{Support::show($activeCourse->exam,'name')}}</p>
                                @endif
                            </div>
                            <div class="col-span-1">
                                <p class="price">
                                    <span class="note">Số lượng học viên đã làm bài kiểm tra: </span>
                                    <strong class="font-bold 2xl:text-[1.25rem] text-[1rem]">{{$activeCourse->examResult()->count()}}</strong>
                                </p>
                            </div>
                        </div>
                    @endif
                    @if (count($listItems) > 0)
                        <div class="table-result">
                            <div class="head-table grid grid-cols-6 gap-2 font-semibold text-[#252525] border-b-[1px] border-solid border-[#ebebeb]">
                                <div class="col-span-1">
                                    <p class="2xl:py-4 py-2">STT</p>
                                </div>
                                <div class="col-span-1">
                                    <p class="2xl:py-4 py-2 text-center">Họ và tên</p>
                                </div>
                                <div class="col-span-2">
                                    <p class="2xl:py-4 py-2 text-center">Tên kỳ thi</p>
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
                                    <div class="item grid grid-cols-6 gap-2 border-b-[1px] border-solid border-[#ebebeb]">
                                        <div class="col-span-1">
                                            <p class="2xl:py-4 py-2">{{sprintf('%02d',($listItems->currentPage() - 1) * 10 + $key + 1)}}</p>
                                        </div>
                                        <div class="col-span-1">
                                            <p class="2xl:py-4 py-2 text-center">{{Support::show($item->user,'name')}}</p>
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
            </div>
        </div>
    </div>
</section>
@endsection
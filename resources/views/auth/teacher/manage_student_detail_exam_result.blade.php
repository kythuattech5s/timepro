@extends('index')
@section('main')
<section class="2xl:py-8 py-6 bg-[#EEEAEA]">
    <div class="container">
        <div class="grid grid-cols-1 lg:grid-cols-4 2xl:gap-8 gap-4">
            <div class="col-span-1">
                @include('auth.teacher.sidebar')
            </div>
            <div class="col-span-1 lg:col-span-3">
                <div class="box-content bg-white p-4 lg:px-8 rounded 2xl:mb-6 mb-4 last:mb-0">
                    <a href="{{\VRoute::get('manage_student')}}" title="Trở về" class="back mb-4 inline-block font-bold 2xl:text-[1.125rem] text-[#CD272F]">
                        <svg width="24" height="24" class="mr-2 inline-block" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M19 12H5" stroke="#CD272F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                            <path d="M12 19L5 12L12 5" stroke="#CD272F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg>
                        Trở về</a>
                    <div class="student-manager grid grid-cols-2 md:grid-cols-3 gap-4 items-center mb-4">
                        <div class="col-span-2 md:col-span-1">
                            <div class="student-info flex items-center gap-2">
                                <span class="ava w-16 h-16 rounded-full overflow-hidden shrink-0">
                                    @include('image_loader.tiny',['itemImage'=>$userStudent,'key'=>'img'])
                                </span>
                                <div class="info">
                                    <p class="name font-bold text-[#252525] 2xl:text-[1.125rem] mb-1">{{Support::show($userStudent,'name')}}</p>
                                    <p class="email">{{Support::show($userStudent,'email')}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <form action="{{\VRoute::get('manage_student')}}/thong-tin-hoc-vien-{{Support::show($userStudent,'id')}}/ket-qua-thi" method="get" class="form-search flex flex-wrap relative mb-3 gap-2" accept-charset="utf8">
                        <select class="form-control pl-4 rounded-[1.25rem] flex-1 py-3 outline-none bg-[#f5f5f5]" name="course">
                            <option value="">Tất cả khóa học</option>
                            @foreach ($listTeacherCousre as $itemTeacherCousre)
                                <option value="{{ $itemTeacherCousre->id }}" {{$activeCourseId == $itemTeacherCousre->id ? 'selected':''}}>{{ $itemTeacherCousre->name }}</option>
                            @endforeach
                        </select>
                        <button type="submit" class="btn btn-red-gradien h-100 inline-flex items-center justify-center font-semibold text-white py-2 px-6 rounded-[1.25rem] bg-gradient-to-r from-[#F44336] to-[#C62828]">Tìm kiếm</button>
                    </form>
                    <div class="button-tabs tab-info-lesson justify-center block border-b-[1px] border-solid border-[#ebebeb] 2xl:mb-6 mb-4">
                        <a href="{{\VRoute::get('manage_student')}}/thong-tin-hoc-vien-{{Support::show($userStudent,'id')}}" class="tablinks inline-block font-bold 2xl:text-[1.25rem] py-4 border-b-[2px] border-solid border-transparent 2xl:mr-16 lg:mr-8 mr-4 last:mr-0">Khóa học tham gia</a>
                        <a href="{{\VRoute::get('manage_student')}}/thong-tin-hoc-vien-{{Support::show($userStudent,'id')}}/ket-qua-thi" class="tablinks inline-block font-bold 2xl:text-[1.25rem] py-4 border-b-[2px] border-solid border-transparent 2xl:mr-16 lg:mr-8 mr-4 last:mr-0 active">Kết quả thi</a>
                    </div>
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
            </div>
        </div>
    </div>
</section>
@endsection
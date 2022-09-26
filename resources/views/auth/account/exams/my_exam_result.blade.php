@extends('index')
@section('main')
<section class="2xl:py-8 py-6 bg-[#EEEAEA]">
    <div class="container">
        <div class="grid grid-cols-1 lg:grid-cols-4 2xl:gap-8 gap-4">
            <div class="col-span-1">
                @include('auth.account.sidebar')
            </div>
            <div class="col-span-1 lg:col-span-3">
                <div class="box-content bg-white p-4 rounded 2xl:mb-6 mb-4 last:mb-0">
                    <h1 class="title font-bold text-[#252525] 2xl:text-[1.6rem] lg:text-[1.25rem] text-[1rem] mb-4 text-center">Kết quả thi</h1>
                    @if (count($listItems) > 0)
                        @foreach ($listItems as $item)
                            <div class="item-exam grid grid-cols-2 md:grid-cols-4 gap-2 items-center 2xl:p-4 p-2 rounded border-[1px] border-solid border-[#ebebeb] mb-4">
                                <div class="col-span-2">
                                    <p class="cate text-[#252525] text-[0.875rem] mb-1">Kết quả sát hạch</p>
                                    <h3>
                                        <a href="{{\VRoute::get("my_exam_result").'/ket-qua-bai-thi-'.$item->id}}" title="{{Support::show($item->exam,'name')}}" class="title font-bold text-[#252525] lg:text-[1.25rem]">{{Support::show($item->exam,'name')}}</a>
                                    </h3>
                                </div>
                                <div class="col-span-1">
                                    <p class="font-semibold text-[#252525] mb-1 last:mb-0">Khóa học: {{Support::show($item->course,'name')}}</p>
                                </div>
                                <div class="col-span-1 lg:pl-14 text-right">
                                    <a href="{{\VRoute::get("my_exam_result").'/ket-qua-bai-thi-'.$item->id}}" title="Xem kết quả" class="md:mt-0 mt-3 ml-auto btn btn-orange inline-flex items-center justify-center py-2 lg:px-5 px-4 rounded bg-gradient-to-r from-[#FE8C00] to-[#F83600] text-white self-center hover:text-[#fff]">Xem kết quả <i class="fa fa-angle-double-right ml-1" aria-hidden="true"></i>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                        <div class="pagination">
                            {{$listItems->withQueryString()->links('bases.pagination')}}
                        </div>
                    @else
                        <p class="text-[1.125rem]">Tạm thời chưa có kết quả bài thi nào.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('js')
    <script src="{{ Support::asset('theme/frontend/js/user_course_control.js') }}" defer></script>
@endsection
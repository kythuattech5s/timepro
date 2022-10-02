@extends('index')
@section('main')
<section class="2xl:py-8 py-6 bg-[#EEEAEA]">
    <div class="container">
        <div class="grid grid-cols-1 lg:grid-cols-4 2xl:gap-8 gap-4">
            <div class="col-span-1">
                @include('auth.account.sidebar')
            </div>
            <div class="col-span-1 lg:col-span-3">
                @if (count($listItemUpcoming) > 0)
                    <div class="box-content bg-white p-4 rounded 2xl:mb-6 mb-4 last:mb-0">
                        <p class="title font-bold text-[#252525] 2xl:text-[1.6rem] lg:text-[1.25rem] text-[1rem] mb-4">
                            Kỳ thi sắp tới
                        </p>
                        @foreach ($listItemUpcoming as $item)
                            <div class="item lg:py-4 py-2 border-t-[1px] border-solid border-[#ebebeb] last:border-b-[1px]">
                                <h3>
                                    <a href="javascript:void(0)" title="" class="title block mb-2 font-semibold text-[#252525]">{{Support::show($item,'name')}}</a>
                                </h3>
                                <p class="time text-[#888] text-[0.875rem] inline-flex items-center" style="margin-right: 20px;"><img src="theme/frontend/images/cal.svg" class="inline-block w-6 h-6 object-contain mr-2" alt="Thời gian mở">Thời gian mở: {{Support::showDateTime($item->open_time,'d/m/y H:i:s')}}</p>
                                <p class="time text-[#888] text-[0.875rem] inline-flex items-center"><img src="theme/frontend/images/cal.svg" class="inline-block w-6 h-6 object-contain mr-2" alt="Thời gian đóng">Thời gian đóng: {{Support::showDateTime($item->close_time,'d/m/y H:i:s')}}</p>
                            </div>
                        @endforeach
                    </div>
                @endif
                <div class="box-content bg-white p-4 rounded 2xl:mb-6 mb-4 last:mb-0">
                    <h1 class="title font-bold text-[#252525] 2xl:text-[1.6rem] lg:text-[1.25rem] text-[1rem] mb-4 text-center">Kỳ thi cần hoàn thành</h1>
                    @if (count($listItems) > 0)
                        @foreach ($listItems as $item)
                            <div class="item-exam grid grid-cols-2 md:grid-cols-4 gap-2 items-center 2xl:p-4 p-2 rounded border-[1px] border-solid border-[#ebebeb] mb-4">
                                <div class="col-span-1">
                                    <p class="cate text-[#252525] text-[0.875rem] mb-1">Kỳ thi</p>
                                    <h3>
                                        <a href="{{\VRoute::get("my_obligatory_exam")}}/lam-bai-thi-{{$item->id}}" title="{{Support::show($item,'name')}}" class="title font-bold text-[#252525] lg:text-[1.25rem]">{{Support::show($item,'name')}}</a>
                                    </h3>
                                </div>
                                <div class="col-span-2">
                                    <p class="font-semibold text-[#252525] mb-1 last:mb-0">Thời gian mở: {{Support::showDateTime($item->open_time,'d/m/Y H:i:s')}}</p>
                                    <p class="font-semibold text-[#252525] mb-1 last:mb-0">Thời gian đóng: {{Support::showDateTime($item->close_time,'d/m/Y H:i:s')}}</p>
                                </div>
                                <div class="col-span-1 lg:pl-14 text-right">
                                    <a href="{{\VRoute::get("my_obligatory_exam")}}/lam-bai-thi-{{$item->id}}" title="Làm bài ngay" class="md:mt-0 mt-3 ml-auto btn btn-orange inline-flex items-center justify-center py-2 lg:px-5 px-4 rounded bg-gradient-to-r from-[#FE8C00] to-[#F83600] text-white self-center hover:text-[#fff]">Làm bài ngay <i class="fa fa-angle-double-right ml-1" aria-hidden="true"></i>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                        <div class="pagination">
                            {{$listItems->withQueryString()->links('bases.pagination')}}
                        </div>
                    @else
                        <p class="text-[1.125rem] text-center">Tạm thời chưa có bài kì thi cần hoàn thành nào.</p>
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
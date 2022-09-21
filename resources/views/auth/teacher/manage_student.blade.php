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
                    <p class="title text-center font-bold text-[#252525] 2xl:text-[1.6rem] lg:text-[1.25rem] text-[1rem] mb-4">Danh sách học viên</p>
                    <form action="{{\VRoute::get('manage_student')}}" method="get" class="form-search relative mb-6" accept-charset="utf8">
                        <i class="fa fa-search text-[#888] absolute top-1/2 left-4 -translate-y-1/2" aria-hidden="true"></i>
                        <input type="text" name="usersearch" placeholder="Nhập tên hoặc email học viên..." class="form-control pl-10 pr-32 rounded-[1.25rem] w-full py-3 outline-none bg-[#f5f5f5]" value="{{$usersearch ?? ''}}">
                        <button type="submit" class="btn btn-red-gradien absolute top-0 right-0 h-full inline-flex items-center justify-center font-semibold text-white py-2 px-6 rounded-[1.25rem] bg-gradient-to-r from-[#F44336] to-[#C62828]">Tìm kiếm</button>
                    </form>
                    @if (count($listItems) > 0)
                        @foreach ($listItems as $itemUser)
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
                                <div class="col-span-1 text-right">
                                    <a href="{{\VRoute::get('manage_student')}}/thong-tin-hoc-vien-{{Support::show($itemUser,'id')}}" title="Xem chi tiết" class="readmore font-semibold color-gradient">
                                        Xem chi tiết <i class="fa fa-angle-double-right ml-1 text-[1.25rem]" aria-hidden="true"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="pagination">
                                {{$listItems->withQueryString()->links('bases.pagination')}}
                            </div>
                        @endforeach
                    @else
                        <p class="text-[1.125rem]">Tạm thời chưa có học viên nào</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
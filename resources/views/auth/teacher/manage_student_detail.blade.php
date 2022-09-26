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
                    <div class="button-tabs tab-info-lesson justify-center block border-b-[1px] border-solid border-[#ebebeb] 2xl:mb-6 mb-4">
                        <a href="{{\VRoute::get('manage_student')}}/thong-tin-hoc-vien-{{Support::show($userStudent,'id')}}" class="tablinks inline-block font-bold 2xl:text-[1.25rem] py-4 border-b-[2px] border-solid border-transparent 2xl:mr-16 lg:mr-8 mr-4 last:mr-0 active">Khóa học tham gia</a>
                        <a href="{{\VRoute::get('manage_student')}}/thong-tin-hoc-vien-{{Support::show($userStudent,'id')}}/ket-qua-thi" class="tablinks inline-block font-bold 2xl:text-[1.25rem] py-4 border-b-[2px] border-solid border-transparent 2xl:mr-16 lg:mr-8 mr-4 last:mr-0">Kết quả thi</a>
                    </div>
                    <div class="wrapper_tabcontent">
                        @if (count($listItems) > 0)
                            @foreach ($listItems as $item)
                                @include('auth.account.process_course',['item'=>$item,'user'=>$userStudent,'onlyViewMode'=>1])
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
</section>
@endsection
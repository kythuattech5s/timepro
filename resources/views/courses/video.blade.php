@extends('index')
@section('main')
    <section class="section-lesson mx-auto max-w-[1920px] py-6 2xl:py-14">
        <div class="head mb-6 block items-center justify-between gap-4 px-4 lg:flex lg:px-6 2xl:mb-8 2xl:px-10">
            <a href="#" title="Trở về" class="back mb-2 inline-block font-bold text-[#CD272F] lg:mb-0 2xl:text-[1.125rem]">
                <svg width="24" height="24" class="mr-2 inline-block" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M19 12H5" stroke="#CD272F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M12 19L5 12L12 5" stroke="#CD272F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                Trở về</a>
            <h1 class="title-lesson mb-2 text-[1rem] font-bold uppercase text-[#252525] lg:mb-0 lg:text-[1.25rem] 2xl:text-[1.6rem]">
                Chân dung 1 nhà môi giới bất động sản chuyên nghiệp
            </h1>
            <div class="rating-lesson">
                <span class="title font-bold 2xl:text-[1.125rem]">Đánh giá: </span>
            </div>
        </div>
        <div class="main-lesson grid grid-cols-1 lg:grid-cols-3">
            <div class="col-span-1 border-r-[1px] border-solid border-[#ebebeb] lg:col-span-2">
                <div class="box-video-lesson">
                    <div class="video-lesson relative pt-[63%]">
                        @php
                            $videoFirst = $videos[0];
                            $videoFirst = json_decode($videoFirst['source'], true);
                        @endphp
                        <video controls>
                            <source src="{{ $videoFirst['path'] . $videoFirst['name'] }}" type="">
                        </video>
                    </div>
                </div>
                <div class="button-tabs tab-info-lesson mb-4 flex flex-wrap border-b-[1px] border-solid border-[#ebebeb] px-4 sm:block lg:px-10 2xl:mb-6 2xl:px-20">
                    <button class="tablinks active basis-1/2 border-b-[2px] border-solid border-transparent py-4 font-bold last:mr-0 sm:mr-4 lg:mr-8 2xl:mr-16 2xl:text-[1.25rem]" data-electronic="tab-lesson-1">Tổng quan</button>
                    <button class="tablinks basis-1/2 border-b-[2px] border-solid border-transparent py-4 font-bold last:mr-0 sm:mr-4 lg:mr-8 2xl:mr-16 2xl:text-[1.25rem]" data-electronic="tab-lesson-2">Thông tin giảng viên</button>
                    <button class="tablinks basis-1/2 border-b-[2px] border-solid border-transparent py-4 font-bold last:mr-0 sm:mr-4 lg:mr-8 2xl:mr-16 2xl:text-[1.25rem]" data-electronic="tab-lesson-3">Tài liệu</button>
                    <button class="tablinks basis-1/2 border-b-[2px] border-solid border-transparent py-4 font-bold last:mr-0 sm:mr-4 lg:mr-8 2xl:mr-16 2xl:text-[1.25rem]" data-electronic="tab-lesson-4">Hỏi đáp cùng giảng viên</button>
                </div>
                <div class="wrapper_tabcontent mb-4">
                    <div class="tabcontent active px-4 2xl:px-10" id="tab-lesson-1">
                        <div class="s-content">
                            Chào mừng bạn đến Khóa học "Nhà Môi Giới Chuyên Nghiệp"
                            Toàn đã tốn nhiều thời gian, xương máu trong suốt 10 năm mò mẫm để kiếm được 1 triệu đô đầu
                            tiên trong lĩnh vực BĐS, Toàn hiểu chính sự không chuyên nghiệp khiến cho các nhà môi giới
                            không có thu nhập ổn định và có sự đột phá trong nghề.
                            Vì vậy, mong muốn lớn nhất của Toàn là giúp anh em môi giới sớm đạt được 1 triệu đô mà
                            không, không phải mất tận 10 năm và chật vật như Toàn nữa, bằng con đường trở thành nhà Môi
                            Giới Chuyên NghiệpNếu bạn vẫn đang loay hoay, chật vật với nghề môi giới BĐS, nhất là trong
                            mùa dịch này!
                            Nếu bạn vẫn chưa xác định rõ ràng mục tiêu, đích đến trên con đường Môi giới BĐS?
                            Nếu như bạn chưa biết thế nào là Nhà môi giới chuyên nghiệp?
                            Bạn đang hoang mang không biết công việc, dự án bạn đang lựa chọn có đúng đắn?
                            Bạn đang làm việc mỗi ngày không có năng lượng, mục tiêu...?
                            Thì khóa học này là dành cho bạn!
                            Lợi ích từ khóa học
                            Trong khóa học này, Toàn sẽ giúp bạn
                            Bạn sẽ hiểu thế nào là Nhà môi giới chuyên nghiệp, hiểu rõ về bản thân
                            Bạn sẽ xác định được mục tiêu rõ ràng về tài chính, tạo lập được những mô hình kinh doanh,
                            thị trường
                            Bạn sẽ biết được lợi thế, sản phẩm phù hợp với mình
                            Bạn sẽ có được những kỹ năng hẹn gặp và chốt khách hàng online trong thời kỳ chuyển đổi số
                            do
                            dịch Covid - 19
                        </div>
                    </div>
                    <div class="tabcontent px-4 2xl:px-10" id="tab-lesson-2">
                        <div class="grid gap-4 md:grid-cols-1 lg:grid-cols-5">
                            <div class="col-span-1 lg:col-span-3">
                                <div class="module-info-teacher">
                                    <div class="info-teacher mb-4 flex items-center gap-4">
                                        <span class="ava block h-14 w-14 shrink-0 overflow-hidden rounded-full lg:h-20 lg:w-20 2xl:h-28 2xl:w-28">
                                            <img src="theme/frontend/images/ava-teacher.jpg" alt="">
                                        </span>
                                        <div class="info-content">
                                            <p class="name mb-1 font-bold text-[#252525] 2xl:text-[1.25rem]">Mr. Chu
                                                Quang
                                                Thuận</p>
                                            <p class="desc text-[#CD272F]">Giám Đốc Điều Hành Times Pro</p>
                                        </div>
                                    </div>
                                    <div class="s-content mb-4 text-justify 2xl:mb-6">
                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Dignissim sit ut lorem
                                        odio
                                        ultrices sed massa pharetra. Lacus auctor accumsan, odio tincidunt facilisis
                                        lorem.
                                        Adipiscing arcu velit sem pharetra ipsum justo, vitae. Sit elementum, nisi cum
                                        habitant aliquam. Et at eu quis in. Iaculis porttitor tristique purus augue.
                                        Amet
                                        scelerisque orci, interdum tempor tempor arcu. Morbi nullam aenean adipiscing
                                        dictum
                                        at nunc. Sed id id placerat aliquam suspendisse faucibus nisl, quis accumsan.
                                    </div>
                                    <div class="statis ml-0 mr-auto mb-4 grid max-w-[25rem] grid-cols-3 gap-4 rounded border-[1px] border-solid border-[#ebebeb] py-4 px-4 lg:px-6 2xl:mb-6 2xl:px-9">
                                        <div class="col-span-1 text-center">
                                            <p class="title mb-2 text-[0.75rem] font-semibold text-[#252525]">Số khóa
                                                học</p>
                                            <span class="count inline-block rounded bg-[#E27B76] px-2 py-1 font-semibold text-white">10</span>
                                        </div>
                                        <div class="col-span-1 text-center">
                                            <p class="title mb-2 text-[0.75rem] font-semibold text-[#252525]">Tổng giờ
                                                giảng</p>
                                            <span class="count inline-block rounded bg-[#E27B76] px-2 py-1 font-semibold text-white">699</span>
                                        </div>
                                        <div class="col-span-1 text-center">
                                            <p class="title mb-2 text-[0.75rem] font-semibold text-[#252525]">Lượt đánh
                                                giá</p>
                                            <span class="count inline-block rounded bg-[#E27B76] px-2 py-1 font-semibold text-white">4.6/5</span>
                                        </div>
                                    </div>
                                    <ul class="social-teacher">
                                        <li class="mr-4 inline-block last:mr-0 2xl:mr-6">
                                            <a href="#" title="" class="flex h-8 w-8 items-center justify-center rounded-full bg-[#D2D2D2] text-white">
                                                <i class="fa fa-phone" aria-hidden="true"></i>
                                            </a>
                                        </li>
                                        <li class="mr-4 inline-block last:mr-0 2xl:mr-6">
                                            <a href="#" title="" class="flex h-8 w-8 items-center justify-center rounded-full bg-[#D2D2D2] text-white">
                                                <i class="fa fa-envelope-o" aria-hidden="true"></i>
                                            </a>
                                        </li>
                                        <li class="mr-4 inline-block last:mr-0 2xl:mr-6">
                                            <a href="#" title="" class="flex h-8 w-8 items-center justify-center rounded-full bg-[#D2D2D2] text-white">
                                                <i class="fa fa-facebook" aria-hidden="true"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>


                            </div>
                            <div class="col-span-1 lg:col-span-2">
                                <div class="form-rating__teacher rounded-lg border-[1px] border-solid border-[#ebebeb] p-4 lg:p-6 2xl:py-10 2xl:px-7">
                                    <p class="title mb-2 text-center text-[1rem] font-bold text-[#252525] 2xl:text-[1.3rem]">
                                        Đánh giá giảng viên
                                    </p>
                                    <p class="desc mb-6 text-center text-[0.875rem]">
                                        Vui lòng để lại cảm nghĩ của bạn nhé! Đánh giá của bạn góp phần cải thiện chất
                                        lượng giảng dạy của giảng viên chúng tôi.
                                    </p>
                                    <form action="" method="" class="form">
                                        <textarea class="form-control mb-4 h-24 w-full resize-none rounded-lg bg-[#F5F5F5] p-3 outline-none" name="" placeholder="Nhập ghi chú và nhấn Enter để lưu lại "></textarea>
                                        <button class="btn btn-red-gradien mx-auto flex w-fit items-center justify-center rounded bg-gradient-to-r from-[#F44336] to-[#C62828] py-2 px-4 font-semibold uppercase text-white shadow-[0_6px_20px_rgba(178,30,37,.4)]">GỬI ĐÁNH GIÁ</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tabcontent px-4 2xl:px-10" id="tab-lesson-3">
                        <div class="item-document mb-4 block items-center justify-between gap-4 rounded-lg border-[1px] border-solid border-[#ebebeb] p-2 transition-all duration-300 last:mb-0 hover:border-transparent hover:bg-[#f5f5f5] sm:flex md:p-4 2xl:p-6">
                            <div class="item mb-2 flex items-center gap-2 sm:mb-0">
                                <span class="icon block h-12 w-12 shrink-0">
                                    <img src="theme/frontend/images/icon-doc.png" class="h-full w-full object-contain" alt="">
                                </span>
                                <div class="content">
                                    <p class="title mb-1 font-bold text-[#252525] 2xl:text-[1.125rem]">Chân dung một nhà môi giới chuyên nghiệp</p>
                                    <p class="desc text-[0.75rem]">chandungmotnhamoigioichuyennghiep.pdf</p>
                                </div>
                            </div>
                            <a href="" title="" class="btn btn-red-gradien mx-auto flex w-fit items-center justify-center rounded bg-gradient-to-r from-[#F44336] to-[#C62828] py-2 px-4 font-semibold text-white shadow-[0_6px_20px_rgba(178,30,37,.4)] sm:mr-0 sm:inline-flex">
                                <img src="theme/frontend/images/icon-download.svg" class="mr-2 h-5 w-5 object-contain" alt="">
                                Download
                            </a>
                        </div>
                        <div class="item-document mb-4 block items-center justify-between gap-4 rounded-lg border-[1px] border-solid border-[#ebebeb] p-2 transition-all duration-300 last:mb-0 hover:border-transparent hover:bg-[#f5f5f5] sm:flex md:p-4 2xl:p-6">
                            <div class="item mb-2 flex items-center gap-2 sm:mb-0">
                                <span class="icon block h-12 w-12 shrink-0">
                                    <img src="theme/frontend/images/icon-doc.png" class="h-full w-full object-contain" alt="">
                                </span>
                                <div class="content">
                                    <p class="title mb-1 font-bold text-[#252525] 2xl:text-[1.125rem]">Chân dung một nhà môi giới chuyên nghiệp</p>
                                    <p class="desc text-[0.75rem]">chandungmotnhamoigioichuyennghiep.pdf</p>
                                </div>
                            </div>
                            <a href="" title="" class="btn btn-red-gradien mx-auto flex w-fit items-center justify-center rounded bg-gradient-to-r from-[#F44336] to-[#C62828] py-2 px-4 font-semibold text-white shadow-[0_6px_20px_rgba(178,30,37,.4)] sm:mr-0 sm:inline-flex">
                                <img src="theme/frontend/images/icon-download.svg" class="mr-2 h-5 w-5 object-contain" alt="">
                                Download
                            </a>
                        </div>
                    </div>
                    <div class="tabcontent px-4 2xl:px-10" id="tab-lesson-4"></div>
                </div>
            </div>
            <div class="col-span-1 lg:ml-[-2px]">
                <div class="button-tabs tab-sidebar__lesson flex">
                    <button class="tablinks active inline-flex flex-1 items-center justify-center bg-[#ebebeb] p-3 font-semibold text-[#888] transition-all duration-300" data-electronic="tab-sidebar-1">
                        <i class="fa fa-file-text-o mr-2" aria-hidden="true"></i> Nội dung bài học
                    </button>
                    <button class="tablinks inline-flex flex-1 items-center justify-center bg-[#ebebeb] p-3 font-semibold text-[#888] transition-all duration-300" data-electronic="tab-sidebar-2">
                        <i class="fa fa-pencil-square-o mr-2" aria-hidden="true"></i>
                        Ghi chú
                    </button>
                </div>
                <div class="wrapper_tabcontent py-3 px-4 lg:px-6 2xl:py-6 2xl:px-10">
                    <div class="tabcontent active" id="tab-sidebar-1">
                        <p class="title mb-4 text-[1rem] font-bold text-[#252525] 2xl:text-[1.25rem]">Nội dung bài học
                        </p>
                        <div class="list-lesson__item mb-10 border-b-[1px] border-solid border-[#ebebeb] pb-4 2xl:mb-20">
                            @foreach ($videos as $video)
                                <div class="item-lesson active mb-2 flex cursor-pointer items-center justify-between gap-4 rounded-md p-2 transition-all duration-300 last:mb-0" data-link="">
                                    <span class="title relative pl-2 font-semibold text-[#252525] after:absolute after:top-1/2 after:left-0 after:h-1 after:w-1 after:-translate-y-1/2 after:rounded-full after:bg-[#252525]">{{ Support::show($video, 'name') }}</span>
                                    <span class="time">{{ Support::show($video, 'duration') }}</span>
                                </div>
                            @endforeach
                        </div>
                        <form action="" method="" class="form-note">
                            <textarea class="form-control h-24 w-full resize-none rounded-lg bg-[#F5F5F5] p-3 outline-none" name="" placeholder="Nhập ghi chú và nhấn Enter để lưu lại "></textarea>
                        </form>
                    </div>
                    <div class="tabcontent" id="tab-sidebar-2">

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('js')
    <script type="module" src="{'video/js/app.js'}" defer></script>
@endsection

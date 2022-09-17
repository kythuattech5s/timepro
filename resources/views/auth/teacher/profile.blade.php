@extends('index')
@section('main')
<section class="2xl:py-8 py-6 bg-[#EEEAEA]">
    <div class="container">
        <div class="grid grid-cols-1 lg:grid-cols-4 2xl:gap-8 gap-4">
            <div class="col-span-1">
                @include('auth.teacher.sidebar')
            </div>
            <div class="col-span-1 lg:col-span-3">
                @include('auth.teacher.notification_exam')
                <div class="box-content bg-white p-4 rounded 2xl:mb-6 mb-4 last:mb-0">
                    <p class="title text-center font-bold text-[#252525] 2xl:text-[1.6rem] lg:text-[1.25rem] text-[1rem] mb-4">
                        Thông tin cá nhân
                    </p>
                    <div class="grid grid-cols-1 lg:grid-cols-6 gap-4">
                        <div class="col-span-1 lg:col-span-5">
                            <form action="{{\VRoute::get('my_profile')}}" method="POST" class="formValidation" absolute data-success="NOTIFICATION.toastrMessageRedirect" accept-charset="utf8">
                                <p class="text-[#252525] text-[0.875rem] mb-1">Họ và tên *</p>
                                <input type="text" name="name" placeholder="Họ và tên ..."  rules="required" value="{{Support::show($user,'name')}}" class="form-control w-full py-2 px-4 border-[1px] border-solid border-[#ebebeb] rounded-lg outline-none mb-4">
                                <p class="text-[#252525] text-[0.875rem] mb-1">Ngày sinh</p>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                                	<input type="hidden" name="birthday">
                                    <div class="col-span-1">
                                        <select class="form-control w-full py-2 px-4 border-[1px] border-solid border-[#ebebeb] rounded-lg outline-none">
                                            <option>Ngày</option>
                                        </select>
                                    </div>
                                    <div class="col-span-1">
                                        <select class="form-control w-full py-2 px-4 border-[1px] border-solid border-[#ebebeb] rounded-lg outline-none">
                                            <option>Tháng</option>
                                            @for($i = 1; $i <= 12; $i++)
                                            <option value="{{$i}}">{{$i}}</option>
                                            @endfor
                                        </select>
                                    </div>
                                    <div class="col-span-1">
                                        <select class="form-control w-full py-2 px-4 border-[1px] border-solid border-[#ebebeb] rounded-lg outline-none">
                                            <option>Năm</option>
                                            @for($i = 1960; $i <= $year; $i++)
                                            <option value="{{$i}}">{{$i}}</option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>  
                                <p class="text-[#252525] text-[0.875rem] mb-1">Giới tính</p>
                                <select name="gender" class="form-control w-full py-2 px-4 border-[1px] border-solid border-[#ebebeb] rounded-lg outline-none mb-4">
                                    <option value="{{Support::show($user,'gender') == 1?'selected':''}}">Nam</option>
                                    <option value="{{Support::show($user,'gender') == 2?'selected':''}}">Nữ</option>
                                    <option value="{{Support::show($user,'gender') == 3?'selected':''}}">Khác</option>
                                </select>
                                <p class="text-[#252525] text-[0.875rem] mb-1">Số điện thoại *</p>
                                <input type="text" name="phone" placeholder="Số điện thoại..." value="{{Support::show($user,'phone')}}" rules="required" class="form-control w-full py-2 px-4 border-[1px] border-solid border-[#ebebeb] rounded-lg outline-none mb-4">
                                <p class="text-[#252525] text-[0.875rem] mb-1">Email *</p>
                                <input type="text" name="email" placeholder="Cập nhật..." rules="required" rules="required||email" value="{{Support::show($user,'email')}}" class="form-control w-full py-2 px-4 border-[1px] border-solid border-[#ebebeb] rounded-lg outline-none mb-4">
                                <p class="text-[#252525] text-[0.875rem] mb-1">Chuyên gia về</p>
                                <input type="text" name="teacher_job" placeholder="Cập nhật..." value="" class="form-control w-full py-2 px-4 border-[1px] border-solid border-[#ebebeb] rounded-lg outline-none mb-4">
                                <p class="text-[#252525] text-[0.875rem] mb-1">Thông tin giảng viên</p>
                                <textarea name="teacher_description" placeholder="Viết vài dòng về bản thân..." class="form-control w-full py-2 px-4 border-[1px] border-solid border-[#ebebeb] rounded-lg outline-none mb-6 h-32 resize-none"></textarea>
                                <button type="submit" class="btn btn-red-gradien inline-flex w-full items-center justify-center font-semibold text-white py-2 px-4 rounded bg-gradient-to-r from-[#F44336] to-[#C62828] shadow-[0_6px_20px_rgba(178,30,37,.4)]">
                                    Cập nhật
                                </button>
                            </form>
                        </div>
                        <div class="col-span-1 order-first lg:order-last">
                            <div class="avatar-group w-28 h-28 rounded-full overflow-hidden relative mx-auto mb-4">
                                <img src="theme/frontend/images/ava-info.jpg" id="output" alt="">
                                <input type="file" class="input-avatars opacity-0 absolute top-0 left-0 w-full h-full" id="avatar" name="avatar" accept="image/*" onchange="document.getElementById('output').src = window.URL.createObjectURL(this.files[0])">
                            </div>
                            <div
                                class="btn-update__avatars w-fit mx-auto relative text-center py-3 px-6 border-[1px] border-dashed border-[#F44336] rounded mb-6">
                                <label for="avatar" class="text color-gradient font-semibold text-[0.875rem]">Thay đổi ảnh</label>
                            </div>
                            <a href="{{\VRoute::get('logout')}}" title="Đăng xuất" class="link block w-fit mx-auto font-semibold text-[0.875rem] color-gradient">Đăng xuất</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
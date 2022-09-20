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
                    <p class="title text-center font-bold text-[#252525] 2xl:text-[1.6rem] lg:text-[1.25rem] text-[1rem] mb-4">Thông tin cá nhân</p>
                    <div class="grid grid-cols-1 lg:grid-cols-6 gap-4">
                        <div class="col-span-1 lg:col-span-5">
                            <form action="{{\VRoute::get('my_profile')}}" method="POST" class="formValidation" absolute data-success="NOTIFICATION.toastrMessageRedirect" accept-charset="utf8" enctype="multipart/form-data">
                                @csrf
                                <p class="text-[#252525] text-[0.875rem] mb-1">Họ và tên *</p>
                                <input type="text" name="name" placeholder="Họ và tên ..." rules="required" value="{{Support::show($user,'name')}}" class="form-control w-full py-2 px-4 border-[1px] border-solid border-[#ebebeb] rounded-lg outline-none mb-4">
                                <p class="text-[#252525] text-[0.875rem] mb-1">Ngày sinh</p>
                                <input type="hidden" name="birthday">
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                                    <?php 
                                        $year = (int)date('Y', time()); 
                                        $birhday = Support::show($user,'birthday')!=''?new \Datetime(Support::show($user,'birthday')):null;
                                    ?>
                                    <div class="col-span-1">
                                        <select class="form-control w-full py-2 px-4 border-[1px] border-solid border-[#ebebeb] rounded-lg outline-none" onchange="MORE_FUNCTION.changeBirthDayProfile(this)" data-type="year">
                                            <option value="0">Năm</option>
                                            @for($i = 1960; $i <= $year; $i++)
                                            <option value="{{$i}}" {{isset( $birhday )?($birhday->format('Y') == $i?'selected':''):''}}>Năm {{$i}}</option>
                                            @endfor
                                        </select>
                                    </div>
                                    <div class="col-span-1">
                                        <select class="form-control w-full py-2 px-4 border-[1px] border-solid border-[#ebebeb] rounded-lg outline-none" onchange="MORE_FUNCTION.changeBirthDayProfile(this)" data-type="month">
                                            <option value="0">Tháng</option>
                                            @for($i = 1; $i <= 12; $i++)
                                            <option value="{{$i}}" {{isset( $birhday )?($birhday->format('m') == $i?'selected':''):''}}>Tháng {{$i}}</option>
                                            @endfor
                                        </select>
                                    </div>
                                    <div class="col-span-1">
                                        <select class="form-control w-full py-2 px-4 border-[1px] border-solid border-[#ebebeb] rounded-lg outline-none" data-day="{{isset( $birhday )?$birhday->format('d'):''}}" onchange="MORE_FUNCTION.changeBirthDayProfile(this)" data-type="day">
                                            <option value="0">Ngày</option>
                                        </select>
                                    </div>
                                </div>
                                <p class="text-[#252525] text-[0.875rem] mb-1">Địa chỉ</p>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                                    <div class="col-span-1">
                                        <select name="province_id" province class="form-control w-full py-2 px-4 border-[1px] border-solid border-[#ebebeb] rounded-lg outline-none">
                                            <option>Tỉnh/Thành phố</option>
                                            @foreach($provinces as $province)
                                            <option value="{{Support::show($province,'id')}}" {{Support::show($user,'province_id') == Support::show($province,'id')?'selected':''}}>{{Support::show($province,'name')}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-span-1">
                                        <select name="district_id" data-value="{{Support::show($user,'district_id')}}" district class="form-control w-full py-2 px-4 border-[1px] border-solid border-[#ebebeb] rounded-lg outline-none">
                                            <option>Quận/Huyện</option>
                                        </select>
                                    </div>
                                    <div class="col-span-1">
                                        <select name="ward_id" ward data-value="{{Support::show($user,'ward_id')}}" class="form-control w-full py-2 px-4 border-[1px] border-solid border-[#ebebeb] rounded-lg outline-none">
                                            <option>Phường/Xã</option>
                                        </select>
                                    </div>
                                </div>
                                <p class="text-[#252525] text-[0.875rem] mb-1">Địa chỉ cụ thể</p>
                                <input type="text" name="address" placeholder="Cập nhật..." value="{{Support::show($user,'address')}}" class="form-control w-full py-2 px-4 border-[1px] border-solid border-[#ebebeb] rounded-lg outline-none mb-4">
                                <?php $genders = App\Models\Gender::all(); ?>
                                @if(count($genders) > 0)
                                <p class="text-[#252525] text-[0.875rem] mb-1">Giới tính</p>
                                <select name="gender" class="form-control w-full py-2 px-4 border-[1px] border-solid border-[#ebebeb] rounded-lg outline-none mb-4">
                                    @foreach($genders as $gender)
                                    <option value="{{Support::show($gender,'id')}}" {{Support::show($user,'gender_id') == Support::show($gender,'id')?'selected':''}}>{{Support::show($gender,'name')}}</option>
                                    @endforeach
                                </select>
                                @endif
                                <p class="text-[#252525] text-[0.875rem] mb-1">Số điện thoại *</p>
                                <input type="text" name="phone" placeholder="Số điện thoại..." value="{{Support::show($user,'phone')}}" rules="required" class="form-control w-full py-2 px-4 border-[1px] border-solid border-[#ebebeb] rounded-lg outline-none mb-4">
                                <p class="text-[#252525] text-[0.875rem] mb-1">Email *</p>
<<<<<<< HEAD
                                <input type="file" name="avatar" class="d-none" id="avatar" accept="image/*" onchange="document.getElementById('output').src = window.URL.createObjectURL(this.files[0])">
=======
>>>>>>> 38213b2a1180c7b3bf9ed8ddb52b466c74263402
                                <input type="text" name="email" placeholder="Cập nhật..." rules="required" rules="required||email" value="{{Support::show($user,'email')}}" class="form-control w-full py-2 px-4 border-[1px] border-solid border-[#ebebeb] rounded-lg outline-none mb-6">
                                <button type="submit" class="btn btn-red-gradien inline-flex w-full items-center justify-center font-semibold text-white py-2 px-4 rounded bg-gradient-to-r from-[#F44336] to-[#C62828] shadow-[0_6px_20px_rgba(178,30,37,.4)]">
                                    Cập nhật
                                </button>
                            </form>
                        </div>
                        <div class="col-span-1 order-first lg:order-last">
                            <div class="avatar-group w-28 h-28 rounded-full overflow-hidden relative mx-auto mb-4">
                            <input type="file" name="avatar" class="input-avatars opacity-0 absolute top-0 left-0 w-full h-full d-none" id="avatar" accept="image/*" onchange="document.getElementById('output').src = window.URL.createObjectURL(this.files[0])">

                                @if(Support::show($user,'img'))
                                    <img src="{%IMGV2.user.img.150x0%}" id="output" alt="">
                                @else
                                    <img src="{Ilogo_mobile.imgI}" id="output" alt="">
                                @endif
                            </div>
                            <div class="btn-update__avatars w-fit mx-auto relative text-center py-3 px-6 border-[1px] border-dashed border-[#F44336] rounded mb-6">
                                <label for="avatar" class="text color-gradient font-semibold text-[0.875rem]">Thay đổi ảnh</label>
                                <input type="file" name="avatar" class="input-avatars opacity-0 absolute top-0 left-0 w-full h-full d-none" id="avatar" accept="image/*" onchange="document.getElementById('output').src = window.URL.createObjectURL(this.files[0])">

                            </div>
                            <a href="{{\VRoute::get('change_password')}}" title="Đổi mật khẩu" class="link block w-fit mx-auto font-semibold text-[0.875rem] color-gradient mb-4">Đổi mật khẩu</a>
                            <a href="{{\VRoute::get('logout')}}" title="Đăng xuất" class="link block w-fit mx-auto font-semibold text-[0.875rem] color-gradient">Đăng xuất</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
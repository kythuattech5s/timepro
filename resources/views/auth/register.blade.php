@extends('index')
@section('main')
<section class="pages" style=" background-image: url('{Ibg_page_auth.imgI}'); background-repeat: no-repeat;background-position: bottom;">
    <div class="main-breadcrumb py-4">
        <div class="container">
            {{Breadcrumbs::render('static',trans('fdb::register'),\VRoute::get('register'))}}
        </div>
    </div>
    <div class="container mx-auto 2xl:pt-[5rem] pb-[3.4375rem] lg:pt-[4.625rem] md:pt-[3.625rem] pt-[2.625rem]">
        <div class="form-login">
            <form action="{{\VRoute::get('register')}}" method="POST" class="formValidation bg-[#fff] frm-login max-w-[31.25rem] w-full ml-auto shadow-xl rounded rounded-[0.625rem] overflow-hidden lg:py-[2.5rem] py-[1.25rem] lg:px-[1.25rem] px-[0.75rem]" absolute data-success="NOTIFICATION.toastrMessageRedirect" accept-charset="utf8">
                @csrf
                <p class="title 2xl:text-[1.625rem] md:text-[1.325rem] text-[1.125rem] font-semibold text-[#252525] mb-1 text-center">
                    {:title_register_time_pro:}
                </p>
                <div class="desc text-base text-[#454545] lg:mb-5 mb-3 text-center">
                    {:content_register_time_pro:}
                </div>
                <label for="#inputname" class="block text-[#252525] mb-2">Họ và tên *</label>
                <input type="text" placeholder="Nhập..." name="name" id="inputname" rules="required" class="placeholder-[#888888] text-base h-[3rem] border-[1px] border-[#EBEBEB] rounded rounded-[5px] overflow-hidden w-full h-[3rem] md:px-4 px-3 mb-[1.25rem] md:text-base text-sm"/>

                <label for="#inputphone" class="block text-[#252525] mb-2">Số điện thoại *</label>
                <input type="text" placeholder="Nhập..." name="phone" id="inputphone" rules="required||phone"  class="placeholder-[#888888] text-base h-[3rem] border-[1px] border-[#EBEBEB] rounded rounded-[5px] overflow-hidden w-full h-[3rem] md:px-4 px-3 mb-[1.25rem] md:text-base text-sm"/>

                <label for="#inputemail" class="block text-[#252525] mb-2">Email</label>
                <input type="text" placeholder="Nhập..." name="email" id="inputemail" rules="required||email" class="placeholder-[#888888] text-base h-[3rem] border-[1px] border-[#EBEBEB] rounded rounded-[5px] overflow-hidden w-full h-[3rem] md:px-4 px-3 mb-[1.25rem] md:text-base text-sm"/>

                <label for="#inputpassword" class="block text-[#252525] mb-2">Mật khẩu *</label>
                <input type="password" placeholder="Nhập..." name="password"  id="inputpassword" rules="required" class="placeholder-[#888888] text-base h-[3rem] border-[1px] border-[#EBEBEB] rounded rounded-[5px] overflow-hidden w-full h-[3rem] md:px-4 px-3 mb-[1.25rem] md:text-base text-sm"/>

                <label for="#inputpassword_confirmation" class="block text-[#252525] mb-2">Nhập lại mật khẩu *</label>
                <input type="password" placeholder="Nhập..." name="password_confirmation" id="inputpassword_confirmation" rules="required" class="placeholder-[#888888] text-base h-[3rem] border-[1px] border-[#EBEBEB] rounded rounded-[5px] overflow-hidden w-full h-[3rem] md:px-4 px-3 mb-[1.25rem] md:text-base text-sm"/>

                <div class="flex flex-wrap justify-between lg:mb-[1.875rem] mb-[1.25rem]">
                    <label for="accept_policy" class="inline-block check text-[#454545] text-sm">
                        <input type="checkbox" checked id="accept_policy" name="accept_policy" value="1"/>
                        <span>Đồng ý các điều khoản chính sách và dịch vụ của chúng tôi.</span>
                    </label>
                    <a href="javascript:void(0)" onclick="MORE_FUNCTION.showModal(this);" data-modal="forgotPassword" title="Quên mật khẩu?" class="inline-block text-[#17B06B] text-sm">Quên mật khẩu?</a>
                </div>

                <button type="submit" class="rounded rounded-[0.3125rem] overflow-hidden px-[0.625rem] py-[0.825rem] bg-gradient-to-r from-[#F44336] to-[#C62828] text-white w-full">Đăng ký</button>
                <div class="flex items-center justify-between lg:mt-[1.875rem] mt-[0.9375rem]">
                    <div class="w-[40%] bg-[#EBEBEB] h-[1px]"></div>
                    <span class="inline-block bg-[#fff]">Hoặc</span>
                    <div class="w-[40%] bg-[#EBEBEB] h-[1px]"></div>
                </div>
                <div class="text-center lg:mt-[1.875rem] md:mt-[1.25rem] mt-[1rem] text-[#454545]">
                    <span>Bạn đã có tài khoản?</span>
                    <a href="{{\VRoute::get('login')}}" title="Đăng ký ngay" class="text-[#17B06B] font-semibold inline-block">Đăng nhập ngay</a>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection
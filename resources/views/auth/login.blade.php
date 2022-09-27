@extends('index')
@section('main')
<section class="pages" style="background-image: url({Ibg_page_auth.imgI});background-repeat: no-repeat;background-position: left;background-size:100%;">
    <div class="main-breadcrumb py-4">
        <div class="container">
            {{Breadcrumbs::render('static',trans('fdb::login'),\VRoute::get('login'))}}
        </div>
    </div>
    <div class="container mx-auto 2xl:pt-[5rem] pb-[3.4375rem] lg:pt-[4.625rem] md:pt-[3.625rem] pt-[2.625rem]">
        <div class="form-login">
            <form action="{{\VRoute::get('login')}}" method="post" class="formValidation bg-[#fff] frm-login max-w-[31.25rem] w-full ml-auto shadow-xl rounded rounded-[0.625rem] overflow-hidden lg:py-[2.5rem] py-[1.25rem] lg:px-[1.25rem] px-[0.75rem]" absolute data-success="NOTIFICATION.toastrMessageRedirect" accept-charset="utf8">
                @csrf
                <p class="title 2xl:text-[1.625rem] md:text-[1.325rem] text-[1.125rem] font-semibold text-[#252525] mb-1 text-center">
                    {:title_login_time_pro:}
                </p>
                <div class="desc text-base text-[#454545] lg:mb-5 mb-3 text-center">
                    {:content_login_time_pro:}
                </div>
                <label for="#phone" class="block text-[#252525] mb-2">Số điện thoại *</label>
                <input type="text" placeholder="Nhập..." name="username" id="phone" rules="required" class="placeholder-[#888888] text-base border-[1px] border-[#EBEBEB] rounded rounded-[5px] overflow-hidden w-full h-[3rem] md:px-4 px-3 mb-[1.25rem] md:text-base text-sm"
                />
                <label for="#password" class="block text-[#252525] mb-2">Mật khẩu *</label>
                <input type="password" placeholder="Nhập..." name="password" id="password" class="placeholder-[#888888] text-base border-[1px] border-[#EBEBEB] rounded rounded-[5px] overflow-hidden w-full h-[3rem] md:px-4 px-3 mb-[1.25rem] md:text-base text-sm"/>
                <div class="flex flex-wrap justify-between lg:mb-[1.875rem] mb-[1.25rem]">
                    <label for="remember" class="inline-block check text-[#454545] text-sm">
                        <input type="checkbox" name="remember" value="1" id="remember" />
                        <span>Ghi nhớ mật khẩu</span>
                    </label>
                    <a href="javascript:void(0)" onclick="MORE_FUNCTION.showModal(this);" data-modal="forgotPassword" title="Quên mật khẩu?" class="inline-block text-[#17B06B] text-sm">Quên mật khẩu?</a>
                </div>
                <button type="submit" class="rounded rounded-[0.3125rem] overflow-hidden px-[0.625rem] py-[0.825rem] bg-gradient-to-r from-[#F44336] to-[#C62828] text-white w-full">
                    Đăng nhập
                </button>
                <div class="flex items-center justify-between lg:mt-[1.875rem] mt-[0.9375rem]">
                    <div class="w-[40%] bg-[#EBEBEB] h-[1px]"></div>
                    <span class="inline-block bg-[#fff]">Hoặc</span>
                    <div class="w-[40%] bg-[#EBEBEB] h-[1px]"></div>
                </div>
                <div class="flex flex-wrap justify-between items-center mt-[1rem]">
                    <a href="{{\VRoute::get('login_social')}}/google" title="Đăng nhập bằng Google" class="social sm:inline-flex flex sm:w-auto w-full items-center justify-center border-[1px] border-[#EBEBEB] p-[0.625rem] text-sm rounded rounded-[0.3125rem] overflow-hidden sm:mb-0 mb-3">
                        @include('svg.icon_login_google')
                        <span>Đăng nhập bằng Google</span>
                    </a>
                    <a href="{{\VRoute::get('login_social')}}/facebook" title="Đăng nhập bằng Facebook" class="social sm:inline-flex flex sm:w-auto w-full items-center justify-center border-[1px] border-[#EBEBEB] p-[0.625rem] text-sm rounded rounded-[0.3125rem] overflow-hidden">
                        @include('svg.icon_login_facebook')
                        <span>Đăng nhập bằng Facebook</span>
                    </a>
                </div>
                <div class="text-center lg:mt-[1.875rem] md:mt-[1.25rem] mt-[1rem] text-[#454545]">
                    <span>Bạn chưa có tài khoản?</span>
                    <a href="{{\VRoute::get('register')}}" title="Đăng ký ngay" class="text-[#17B06B] font-semibold inline-block">Đăng ký ngay</a>
                </div>
            </form>
        </div>
    </div>
</section>
<div id="forgotPassword" modal tabindex="-1" aria-hidden="true" class="overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 w-full md:inset-0 h-modal md:h-full d-none">
    <div class="relative p-4 w-full max-w-[34rem] h-full md:h-auto mx-auto">
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <button type="button" class="absolute top-[0.625rem] right-[0.625rem] z-10 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="defaultModal" button_close_modal>
                @include('svg.icon_close')
                <span class="sr-only">Close modal</span>
            </button>
            <h3 class="lg:text-[1.625rem] md:text-[1.225rem] text-[1.1rem] lg:pt-[2.5rem] md:pt-[2rem] pt-[1.5rem] font-semibold text-gray-900 dark:text-white text-center mb-1">
                Quên mật khẩu
            </h3>
            <div class="desc text-[#454545] text-center lg:mb-[1.875rem] md:mb-[1.575rem] mb-[1.25rem] px-4">
                {:content_form_forgot_password:}
            </div>
            <div class="p-6 space-y-6 pt-0">
                <form action="{{\VRoute::get('forgot-password')}}" method="POST" class="frm formValidation" absolute data-success="NOTIFICATION.toastrMessageRedirect" accept-charset="utf8">
                    @csrf
                    <label for="#username_forgot_password" class="block text-[#252525] mb-2">Địa chỉ email đăng ký *</label>
                    <input type="text" placeholder="Nhập..." name="email" rules="required" id="username_forgot_password" class="placeholder-[#888888] text-base border-[1px] border-[#EBEBEB] rounded rounded-[5px] overflow-hidden w-full h-[3rem] md:px-4 px-3 mb-[1.25rem] md:text-base text-sm"/>
                    <button type="submit" class="rounded rounded-[0.3125rem] overflow-hidden px-[0.625rem] py-[0.825rem] bg-gradient-to-r from-[#F44336] to-[#C62828] text-white w-full md:mb-[1.5rem] mb-[1rem]">Lấy lại mật khẩu</button>
                </form>
                <div class="text-center lg:mt-[1.875rem] md:mt-[1.25rem] mt-[1rem] text-[#454545]">
                    <span>Bạn chưa có tài khoản?</span>
                    <a href="{{\VRoute::get('register')}}" title="Đăng ký ngay" class="text-[#17B06B] font-semibold inline-block">Đăng ký ngay</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
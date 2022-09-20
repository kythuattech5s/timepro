@extends('index')
@section('main')
<section class="pages">
    <div class="main-breadcrumb py-4">
        <div class="container">
            {{Breadcrumbs::render('static',trans('fdb::login'),\VRoute::get('login'))}}
        </div>
    </div>
    <div class="container mx-auto 2xl:pt-[5rem] pb-[3.4375rem] lg:pt-[4.625rem] md:pt-[3.625rem] pt-[2.625rem]">
        <div class="md:max-w-[50%] mx-auto">
            <form action="{{\VRoute::get('reset-password')}}" method="POST" class="frm formValidation" absolute data-success="NOTIFICATION.toastrMessageRedirect" accept-charset="utf8">
                @csrf
                <input type="hidden" name="token" value="{{request()->input('token')}}">
                <input type="hidden" name="email" value="{{request()->input('email')}}">
                <label for="#inputpassword" class="block text-[#252525] mb-2">Mật khẩu *</label>
                <input type="password" placeholder="Nhập..." name="password"  id="inputpassword" rules="required" class="placeholder-[#888888] text-base h-[3rem] border-[1px] border-[#EBEBEB] rounded rounded-[5px] overflow-hidden w-full h-[3rem] md:px-4 px-3 mb-[1.25rem] md:text-base text-sm"/>

                <label for="#inputpassword_confirmation" class="block text-[#252525] mb-2">Nhập lại mật khẩu *</label>
                <input type="password" placeholder="Nhập..." name="password_confirmation" id="inputpassword_confirmation" rules="required" class="placeholder-[#888888] text-base h-[3rem] border-[1px] border-[#EBEBEB] rounded rounded-[5px] overflow-hidden w-full h-[3rem] md:px-4 px-3 mb-[1.25rem] md:text-base text-sm"/>

                <button type="submit" class="rounded rounded-[0.3125rem] overflow-hidden px-[0.625rem] py-[0.825rem] bg-gradient-to-r from-[#F44336] to-[#C62828] text-white w-full md:mb-[1.5rem] mb-[1rem]">Đặt lại mật khẩu</button>
            </form>
        </div>
    </div>
</section>
@endsection
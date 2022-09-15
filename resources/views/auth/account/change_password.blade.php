@extends('index')
@section('main')
<section class="2xl:py-8 py-6 bg-[#EEEAEA]">
    <div class="container">
        <div class="grid grid-cols-1 lg:grid-cols-4 2xl:gap-8 gap-4">
            <div class="col-span-1">
                @include('auth.account.sidebar')
            </div>
            <div class="col-span-1 lg:col-span-3">
                @include('auth.account.notification_exam')
                <div class="box-content bg-white p-4 rounded 2xl:mb-6 mb-4 last:mb-0">
                    <p class="title text-center font-bold text-[#252525] 2xl:text-[1.6rem] lg:text-[1.25rem] text-[1rem] mb-4">Đổi mật khẩu</p>
                    <form action="{{\VRoute::get('change_password')}}" method="POST" class="formValidation" absolute data-success="NOTIFICATION.toastrMessageRedirect" accept-charset="utf8">
                    	@csrf
                        <p class="text-[#252525] text-[0.875rem] mb-1">Mật khẩu hiện tại*</p>
                        <input type="text" name="current_password" placeholder="Nhập..." rules="required" class="form-control w-full py-2 px-4 border-[1px] border-solid border-[#ebebeb] rounded-lg outline-none mb-4">
                        <p class="text-[#252525] text-[0.875rem] mb-1">Mật khẩu mới*</p>
                        <input type="text" name="password" placeholder="Nhập..." rules="required" class="form-control w-full py-2 px-4 border-[1px] border-solid border-[#ebebeb] rounded-lg outline-none mb-4">
                        <p class="text-[#252525] text-[0.875rem] mb-1">Nhập lại mật khẩu mới*</p>
                        <input type="text" name="password_confirmation" placeholder="Nhập..." rules="required" class="form-control w-full py-2 px-4 border-[1px] border-solid border-[#ebebeb] rounded-lg outline-none mb-4">
                        <div class="flex gap-4">
                            <a href="javascript:history.back();" title="Quay lại" class="btn btn-border__red flex-1 inline-flex w-full items-center justify-center font-semibold text-[#F44336] py-2 px-4 rounded bg-white border-[1px] border-solid border-[#F44336] hover:bg-[#F44336] hover:text-white">
                                Quay lại
                            </a>
                            <button type="submit" class="btn btn-red-gradien flex-1 inline-flex w-full items-center justify-center font-semibold text-white py-2 px-4 rounded bg-gradient-to-r from-[#F44336] to-[#C62828] shadow-[0_6px_20px_rgba(178,30,37,.4)]">
                                Cập nhật
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
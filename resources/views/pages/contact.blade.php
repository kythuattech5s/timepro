@extends('index')
@section('main')
<div class="banner-pages ">
    <div class="link img_full block">
        @include('image_loader.config.all',['config_key'=>'banner_page_contact'])
    </div>
</div>
<div class="main-breadcrumb py-4 hidden">
    <div class="container">
        {{Breadcrumbs::render('static',trans('fdb::contact'),\VRoute::get('contact'))}}
    </div>
</div>
<section class="section-contact 2xl:py-14 py-6 bg-no-repeat" style="background-image: url('theme/frontend/images/bg-contact.png');">
    <div class="container">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 2xlmb-10 mb-6">
            <div class="col-span-1">
                <h2 class="title font-bold text-[#252525] 2xl:text-[2rem] lg:text-[1.5rem] text-[1.125rem] mb-4">
                    {!! nl2br(SettingHelper::getSetting('company_name')) !!}
                </h2>
                <p class="font-bold text-[#252525] 2xl:text-[1.125rem] mb-2">Địa chỉ</p>
                <?php $addresses = Support::extractJson(SettingHelper::getSetting('addresses')); ?>
                @foreach($addresses as $address)
                <p class="contact mb-2">
                    <img src="theme/frontend/images/location-red.svg" class="inline-block mr-2 w-6 h-6 object-contain" alt="icon">
                    <span class="text">
                        {{Support::show($address,'address')}}
                    </span>
                </p>
                @endforeach
                <p class="font-bold text-[#252525] 2xl:text-[1.125rem] mb-2">Hotline</p>
                <p class="contact mb-2">
                    <img src="theme/frontend/images/phone-red.svg" class="inline-block mr-2 w-6 h-6 object-contain"
                        alt="icon">
                    <a href="tel:{[hotline]}" title="phone" class="text">
                        {[hotline]}
                    </a>
                </p>
                <p class="contact mb-2">
                    <img src="theme/frontend/images/hotline-red.svg" class="inline-block mr-2 w-6 h-6 object-contain" alt="icon">
                    <a href="tel:{[hotline_cskh]}" title="phone" class="text">
                        Tổng đài CSKH: {[email_support]}
                    </a>
                </p>
                <p class="font-bold text-[#252525] 2xl:text-[1.125rem] mb-2">Email</p>
                <p class="contact mb-2">
                    <img src="theme/frontend/images/email-red.svg" class="inline-block mr-2 w-6 h-6 object-contain" alt="icon">
                    <a href="mailto:{[email]}" title="email" class="text">
                        {[email]}
                    </a>
                </p>
                <p class="contact mb-2">
                    <img src="theme/frontend/images/email-red.svg" class="inline-block mr-2 w-6 h-6 object-contain" alt="icon">
                    <a href="mailto:{[email_support]}" title="email" class="text">
                        {[email_support]}
                    </a>
                </p>
                <ul class="social-contact flex items-center mt-6">
                    <li class="inline-block 2xl:mr-6 mr-4 last:mr-0">
                        <a href="{[facebook]}" rel="noopener" title="Facebook" target="_blanl" class="flex items-center justify-center w-10 h-10 rounded-full bg-[#888] text-white hover:bg-[#0969AE] hover:text-white text-[1.25rem]">
                            <i class="fa fa-facebook" aria-hidden="true"></i>
                        </a>
                    </li>
                    <li class="inline-block 2xl:mr-6 mr-4 last:mr-0">
                        <a href="{[youtube]}" rel="noopener" title="Youtube" target="_blank" class="flex items-center justify-center w-10 h-10 rounded-full bg-[#888] text-white hover:bg-[#0969AE] hover:text-white text-[1.25rem]">
                            <i class="fa fa-youtube-play" aria-hidden="true"></i>
                        </a>
                    </li>

                     <li class="inline-block 2xl:mr-6 mr-4 last:mr-0">
                        <a href="{[tiktok]}" rel="noopener" title="Tiktok" target="_blank" class="flex items-center justify-center w-10 h-10 rounded-full bg-[#888] text-white hover:bg-[#0969AE] hover:text-white text-[1.25rem]">
                            <img src="theme/frontend/images/icon-tiktok.svg" class="w-6 h-6 object-contain" alt="" />
                        </a>
                    </li>
                    <li class="inline-block 2xl:mr-6 mr-4 last:mr-0">
                        <a href="{[instagram]}" rel="noopener" title="Instagram" target="_blank" class="flex items-center justify-center w-10 h-10 rounded-full bg-[#888] text-white hover:bg-[#0969AE] hover:text-white text-[1.25rem]">
                            <img src="theme/frontend/images/icon-ins.svg" class="w-6 h-6 object-contain" alt="" />
                        </a>
                    </li>
                </ul>
            </div>
            <div class="col-span-1">
                <form action="{{\VRoute::get('send_contact')}}" method="POST" class="formValidation form-contact rounded-lg 2xl:p-10 lg:p-6 p-4 border-[1px] border-solid border-[#F44336]" absolute data-success="NOTIFICATION.toastrMessageRedirect" accept-charset="utf8">
                    <p class="title text-center font-bold text-[#252525] uppercase 2xl:text-[1.6rem] lg:text-[1.3rem] text-[1.125rem] mb-2">{:title_form_contact:}</p>
                    <p class="subtitle text-center mb-4">{:content_form_contact:}</p>
                    <div class="box-input relative mb-4 text-[#888]">
                        <span class="icon absolute top-1/2 -translate-y-1/2 left-4">
                            <i class="fa fa-user-o" aria-hidden="true"></i>
                        </span>
                        <input type="text" name="name" rules="required" placeholder="Họ và tên..." class="form-control w-full py-3 px-4 pl-10 border-[1px] border-solid border-[#ebebeb] outline-none">
                    </div>
                    <div class="box-input relative mb-4 text-[#888]">
                        <span class="icon absolute top-1/2 -translate-y-1/2 left-4">
                            <i class="fa fa-phone" aria-hidden="true"></i>
                        </span>
                        <input type="text" name="phone" rules="required||phone" placeholder="Số điện thoại..." class="form-control w-full py-3 px-4 pl-10 border-[1px] border-solid border-[#ebebeb] outline-none">
                    </div>
                    <div class="box-input relative mb-4 text-[#888]">
                        <span class="icon absolute top-1/2 -translate-y-1/2 left-4">
                            <i class="fa fa-envelope-o" aria-hidden="true"></i>
                        </span>
                        <input type="text" name="email" placeholder="Địa chỉ email..." class="form-control w-full py-3 px-4 pl-10 border-[1px] border-solid border-[#ebebeb] outline-none">
                    </div>
                    <div class="box-input relative mb-4 text-[#888]">
                        <span class="icon absolute top-1/2 -translate-y-1/2 left-4">
                            <i class="fa fa-pencil" aria-hidden="true"></i>
                        </span>
                        <input type="text" name="note" placeholder="Ghi chú..." class="form-control w-full py-3 px-4 pl-10 border-[1px] border-solid border-[#ebebeb] outline-none">
                    </div>
                    <button type="submit" class="btn btn-red-gradien uppercase inline-flex w-full items-center justify-center font-semibold text-white py-3 px-4 rounded bg-gradient-to-r from-[#F44336] to-[#C62828]">
                        <i class="fa fa-paper-plane-o mr-2" aria-hidden="true"></i>
                        <span>Gửi thông tin</span>
                    </button>
                </form>
            </div>
        </div>
        <div class="2xl:h-[700px] lg:h-[550px] h-[250px]" id="map" data-map="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3723.969021700268!2d105.7602401152675!3d21.03392548599555!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x313454be90584183%3A0x75acde08f88f5d7c!2zU3BhIFRodSBIxrDGoW5n!5e0!3m2!1svi!2s!4v1639585480266!5m2!1svi!2s">
        	
        </div>
    </div>
</section>
@endsection
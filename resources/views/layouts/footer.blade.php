<div id="getCode" modal tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 w-full md:inset-0 h-modal md:h-full">
    <div class="relative p-4 w-full max-w-[34rem] h-full md:h-auto mx-auto">
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700" >
            <button type="button" class="absolute top-[0.625rem] right-[0.625rem] z-10 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="defaultModal" button_close_modal>
                @include('svg.icon_close')
                <span class="sr-only">Close modal</span>
            </button>
            <h3 class="lg:text-[1.625rem] md:text-[1.225rem] text-[1.1rem] lg:pt-[2.5rem] md:pt-[2rem] pt-[1.5rem] font-semibold text-gray-900 dark:text-white text-center mb-1">Vui lòng nhập mã xác nhận</h3>
            <div class="desc text-[#454545] text-center lg:mb-[1.875rem] md:mb-[1.575rem] mb-[1.25rem] px-4">
                {:content_form_otp:}
            </div>
            <div class="p-6 space-y-6 pt-0">
                <form action="{{$actionFormOtpCode ?? ''}}" class="frm" method="post" absolute data-success="NOTIFICATION.toastrMessageRedirect" accept-charset="utf8">
                    <input type="hidden" name="otp" main-otp-rs="">
                    <div class="otp-rs flex lg:gap-[1rem] gap-[0.5rem] justify-center items-center mb-[1rem]">
                        <input type="text" name="fake[]" class="sub-otp-rs w-[3rem] h-[3rem] border-[1px] border-[#EBEBEB] rounded rounded-[0.3125rem] overflow-hidden text-xl font-semibold text-center text-[#252525]" rules="required"/>
                        <input type="text" name="fake[]" class="sub-otp-rs w-[3rem] h-[3rem] border-[1px] border-[#EBEBEB] rounded rounded-[0.3125rem] overflow-hidden text-xl font-semibold text-center text-[#252525]" rules="required"/>
                        <input type="text" name="fake[]" class="sub-otp-rs w-[3rem] h-[3rem] border-[1px] border-[#EBEBEB] rounded rounded-[0.3125rem] overflow-hidden text-xl font-semibold text-center text-[#252525]" rules="required"/>
                        <input type="text" name="fake[]" class="sub-otp-rs w-[3rem] h-[3rem] border-[1px] border-[#EBEBEB] rounded rounded-[0.3125rem] overflow-hidden text-xl font-semibold text-center text-[#252525]" rules="required"/>
                        <input type="text" name="fake[]" class="sub-otp-rs w-[3rem] h-[3rem] border-[1px] border-[#EBEBEB] rounded rounded-[0.3125rem] overflow-hidden text-xl font-semibold text-center text-[#252525]" rules="required"/>
                        <input type="text" name="fake[]" class="sub-otp-rs w-[3rem] h-[3rem] border-[1px] border-[#EBEBEB] rounded rounded-[0.3125rem] overflow-hidden text-xl font-semibold text-center text-[#252525]" rules="required"/>
                    </div>
                    <div class="text-center lg:mb-[2.5rem] md:mb-[1.75rem] mb-[1.25rem]">
                        <span>Bạn chưa nhận được mã?</span>
                        <a href="javascript:void(0);" button_resend_code title="Yêu cầu gửi lại" class="text-[#17B06B] inline-block text-base">Yêu cầu gửi lại</a>
                    </div>
                    <button type="submit" class="rounded rounded-[0.3125rem] overflow-hidden px-[0.625rem] py-[0.825rem] bg-gradient-to-r from-[#F44336] to-[#C62828] text-white w-full">
                        Đồng ý
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
<footer class="footer">
    <div class="footer-top bg-no-repeat bg-cover relative after:absolute after:w-full after:h-full after:top-0 after:left-0 after:bg-[rgba(33,33,33,.95)]"
        style="background-image: url({Ibg_footer.imgI})">
        <div class="container relative z-[1]">
            <div class="footer-nav 2xl:py-14 py-6 grid grid-cols-1 lg:grid-cols-3 gap-4 border-b-[1px] border-solid border-[rgba(255,255,255,.5)]">
                <div class="col-span-1">
                    <a href="{{\VRoute::get("home")}}" title="Trang chủ" class="logo-footer-mobile block lg:hidden mb-4 max-w-[200px]">
                        @include('image_loader.config.big',['config_key'=>'logo_footer'])
                    </a>
                    <h2 class="name-company w-fit ml-0 font-bold text-white lg:text-[1.125rem] uppercase relative after:block after:mt-2 after:w-full after:h-[1px] after:bg-[rgba(255,255,255,.5)] mb-4">{[company_name]}</h2>
                    <?php $listAddress = Support::extractJson(SettingHelper::getSetting('addresses'),false); ?>
                    @foreach ($listAddress as $itemAddress)
                    <p class="footer-contact relative text-white mb-4 last:mb-0 pl-8">
                        <img src="theme/frontend/images/location.svg" class="w-6 h-6 object-contain absolute top-0 left-0" alt="Location">
                        <span class="text">{{Support::show($itemAddress,'address')}}</span>
                    </p>
                    @endforeach
                    <p class="footer-contact relative text-white mb-4 last:mb-0 pl-8">
                        <img src="theme/frontend/images/phone.svg" class="w-6 h-6 object-contain absolute top-0 left-0" alt="Phone">
                        <a href="tel:{[phone]}" class="phone">{[phone]}</a>
                    </p>
                    <p class="footer-contact relative text-white mb-4 last:mb-0 pl-8">
                        <img src="theme/frontend/images/mail.svg" class="w-6 h-6 object-contain absolute top-0 left-0" alt="Email">
                        <a href="mailto:{[email]}" class="phone">{[email]}</a>
                    </p>
                </div>
                <div class="col-span-1 lg:col-span-2 lg:pl-10">
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                        <div class="col-span-1">
                            <p class="title-footer font-bold lg:text-[1.125rem] text-white uppercase lg:mb-6 mb-4">Hướng dẫn</p>
                            <div class="nav-footer text-white">
                                <?php $menus = Support::getMenuRecursive(2); ?>
                                {{Support::showMenuRecursive($menus,0)}}
                            </div>
                        </div>
                        <div class="col-span-1">
                            <p class="title-footer font-bold lg:text-[1.125rem] text-white uppercase lg:mb-6 mb-4">Quy định</p>
                            <div class="nav-footer text-white">
                                <?php $menus = Support::getMenuRecursive(3); ?>
                                {{Support::showMenuRecursive($menus,0)}}
                            </div>
                        </div>
                        <div class="col-span-2 md:col-span-1">
                            <p class="title-footer font-bold lg:text-[1.125rem] text-white uppercase lg:mb-6 mb-4">Tổng đài hỗ trợ</p>
                            <p class="footer-contact relative text-white mb-4 pl-8">
                                <img src="theme/frontend/images/tong-dai.svg" class="w-6 h-6 object-contain absolute top-0 left-0" alt="Hotline">
                                <span class="text">Tổng đài CSKH: <a href="tel:{[hotline]}" class="phone">{[hotline]}</a> </span>
                            </p>
                            <p class="footer-contact relative text-white mb-8 pl-8">
                                <img src="theme/frontend/images/mail.svg" class="w-6 h-6 object-contain absolute top-0 left-0" alt="Email">
                                <a href="mailto:{[email_support]}" class="phone">{[email_support]}</a>
                            </p>
                            <div class="flex flex-wrap gap-2 items-center">
                                <?php $list_certicate_footer = Support::extractJson(SettingHelper::getSetting('certicate_footer'),false); ?>
                                @foreach($list_certicate_footer as $certicate)
                                <a href="{{Support::show($certicate,'link')}}" title="DCMA" class="icon" target="_blank" rel="noopener">
                                    @include('image_loader.tiny',['keyImage'=>'image','itemImage'=>$certicate])
                                </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="f-menu 2xl:py-8 py-4 flex items-center justify-center lg:justify-start">
                <a href="{{\VRoute::get("home")}}" title="Trang chủ" class="logo-footer hidden lg:block shrink-0 max-w-[15rem] 2xl:mr-20 lg:mr-10 relative after:w-[1px] after:h-full after:bg-[rgba(255,255,255,.5)] after:absolute after:top-0 2xl:after:right-[-2.5rem] lg:after:right-[-1.25rem]">
                    @include('image_loader.config.big',['config_key'=>'logo_footer'])
                </a>
                <div class="menu-footer hidden lg:block flex-1 text-white font-bold 2xl:text-[1.125rem]">
                    @php
                        $menus = Support::getMenuRecursive(1);
                    @endphp
                    {{Support::showMenuRecursive($menus,0)}}
                </div>
                <ul class="social-footer">
                    <li class="inline-block mr-4 2xl:mr-8 last:mr-0">
                        <a href="{[facebook]}" title="Facebook" rel="noopener" target="_blank">
                            <img src="theme/frontend/images/icon_fb.svg" class="w-6 h-6 object-contain" alt="Facebook">
                        </a>
                    </li>
                    <li class="inline-block 2xl:mr-8 last:mr-0 mr-4">
                        <a href="{[youtube]}" title="Youtube" rel="noopener" target="_blank">
                            <img src="theme/frontend/images/icon_yt.svg" class="w-6 h-6 object-contain" alt="Youtube">
                        </a>
                    </li>
                    <li class="inline-block 2xl:mr-8 last:mr-0 mr-4">
                        <a href="{[tiktok]}" title="Tiktok" rel="noopener" target="_blank">
                            <img src="theme/frontend/images/icon-tiktok.svg" class="w-6 h-6 object-contain" alt="Tiktok">
                        </a>
                    </li>
                    <li class="inline-block 2xl:mr-8 last:mr-0 mr-4">
                        <a href="{[instagram]}" title="Instagram" rel="noopener" target="_blank">
                            <img src="theme/frontend/images/icon-ins.svg" class="w-6 h-6 object-contain" alt="Instagram">
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="bg-[#111] py-3 text-center text-white text-[0.875rem] copyright">
        <div class="container">{[copy_right]}</div>
    </div>
</footer>
<div class="widget fixed">
    <a href="{[zalo]}" target="_blank" title="Zalo" class="item zalo">
        <img src="theme/frontend/images/zalo-new.png" alt="Icon Zalo">
    </a>
    <a href="tel:{[hotline]}" title="Hotline" class="item hotline">
        <img src="theme/frontend/images/phone.png" alt="Icon phone">
    </a>
</div>
<div id="modal_intro" modal tabindex="-1" aria-hidden="true" class="overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 w-full md:inset-0 h-modal md:h-full d-none">
    <div class="relative p-4 w-full max-w-[34rem] h-full md:h-auto mx-auto">
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <button type="button" class="absolute top-[0.625rem] right-[0.625rem] z-10 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="defaultModal" button_close_modal>
                @include('svg.icon_close')
                <span class="sr-only">Close modal</span>
            </button>
            <div class="content">
                alo1234455667
            </div>
        </div>
    </div>
</div>
<button type="button" onclick="MORE_FUNCTION.showModal(this);" data-modal="modal_intro"></button>
<footer class="footer">
    <div class="footer-top bg-no-repeat bg-cover relative after:absolute after:w-full after:h-full after:top-0 after:left-0 after:bg-[rgba(33,33,33,.95)]"
        style="background-image: url(theme/frontend/images/bg-footer.jpg)">
        <div class="container relative z-[1]">
            <div class="footer-nav 2xl:py-14 py-6 grid grid-cols-1 lg:grid-cols-3 gap-4 border-b-[1px] border-solid border-[rgba(255,255,255,.5)]">
                <div class="col-span-1">
                    <a href="{{\VRoute::get("home")}}" title="Trang chủ" class="logo-footer-mobile block lg:hidden mb-4 max-w-[200px]">
                        @include('image_loader.config.big',['config_key'=>'logo'])
                    </a>
                    <h2 class="name-company w-fit ml-0 font-bold text-white lg:text-[1.125rem] uppercase relative after:block after:mt-2 after:w-full after:h-[1px] after:bg-[rgba(255,255,255,.5)] mb-4">{[company_name]}</h2>
                    @php
                        $listAddress = Support::extractJson(SettingHelper::getSetting('addresses'),false);
                    @endphp
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
                                @php
                                    $menus = Support::getMenuRecursive(2);
                                @endphp
                                {{Support::showMenuRecursive($menus,0)}}
                            </div>
                        </div>
                        <div class="col-span-1">
                            <p class="title-footer font-bold lg:text-[1.125rem] text-white uppercase lg:mb-6 mb-4">Quy định</p>
                            <div class="nav-footer text-white">
                                @php
                                    $menus = Support::getMenuRecursive(3);
                                @endphp
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
                            <div class="flex flex-wrap 2xl:gap-8 gap-4 items-center">
                                <a href="{[dcma_link]}" title="DCMA" class="icon" target="_blank" rel="noopener">
                                    <img src="theme/frontend/images/dmca.png" alt="" />
                                </a>
                                <a href="{[bct_link]}" title="Đã đăng ký bộ công thương" class="icon" target="_blank" rel="noopener">
                                    <img src="theme/frontend/images/bct.png" alt="" />
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="f-menu 2xl:py-8 py-4 flex items-center justify-center lg:justify-start">
                <a href="{{\VRoute::get("home")}}" title="Trang chủ" class="logo-footer hidden lg:block shrink-0 max-w-[15rem] 2xl:mr-20 lg:mr-10 relative after:w-[1px] after:h-full after:bg-[rgba(255,255,255,.5)] after:absolute after:top-0 2xl:after:right-[-2.5rem] lg:after:right-[-1.25rem]">
                    @include('image_loader.config.big',['config_key'=>'logo'])
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
                            <img src="theme/frontend/images /icon_fb.svg" class="w-6 h-6 object-contain" alt="Facebook">
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

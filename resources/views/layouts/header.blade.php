<header class="header py-2 lg:py-0 bg-white shadow-[0_4px_48px_rgba(0,0,0,.08)]">
    <div class="container flex justify-between lg:flex-start items-center gap-4">
        <div class="flex items-center gap-2">
            <span class="show-menu-mobile flex items-center justify-center text-white lg:hidden text-[1.25rem] w-8 h-8 rounded-full bg-gradient-to-r from-[#F44336] to-[#C62828]">
                <i class="fa fa-bars" aria-hidden="true"></i>
            </span>
            <a href="{{\VRoute::get("home")}}" title="Trang chủ" class="logo-header block shrink-0 md:max-w-[208px] max-w-[150px]">
                @include('image_loader.config.big',['config_key'=>'logo','noLazyLoad'=>1])
            </a>
        </div>
        <div class="menu flex-1 justify-center flex items-center 2xl:gap-8 gap-4">
            <a href="{{\VRoute::get("home")}}" title="Trang chủ" class="logo-mobile block lg:hidden text-center py-3">
                @include('image_loader.config.big',['config_key'=>'logo','noLazyLoad'=>1])
            </a>
            @php
                $menus = Support::getMenuRecursive(1);
            @endphp
            {{Support::showMenuRecursive($menus,0)}}
            <span class="show-form-search cursor-pointer">
                @include('icon_svgs.icon_search')
            </span>
        </div>
        <div class="over-lay block lg:hidden fixed top-0 right-[-100%] w-full h-full bg-[rgba(0,0,0,.6)] z-[50] transition-all duration-300"></div>
        <div class="h-action items-center flex 2xl:-gap-8 gap-4">
            <a href="{{\VRoute::get("viewCart")}}" title="Giỏ hàng" class="h-cart relative block">
                @include('icon_svgs.icon_cart')
                <span class="count count-item-cart absolute top-[-5px] right-[-5px] font-bold text-[8px] text-white min-w-[12px] h-3 rounded-full bg-gradient-to-r from-[#F44336] to-[#C62828] z-[1] text-center leading-3">0</span>
            </a>
            @if (Auth::check())
            @else
                <div class="h-auth font-semibold bg-gradient-to-r from-[#F44336] to-[#C62828] rounded-md py-2 sm:px-5 px-3 text-white">
                    <i class="fa fa-user-circle-o mr-2 hidden lg:inline-block" aria-hidden="true"></i>
                    <a href="{{\VRoute::get("login")}}" title="Đăng nhập" class="link">Đăng nhập</a>
                    <span class="hidden lg:inline-block">/</span>
                    <a href="{{\VRoute::get("register")}}" title="Đăng ký" class="link hidden lg:inline-block">Đăng ký</a>
                </div>
            @endif
        </div>
    </div>
    <div class="container block lg:hidden py-2">
        <form action="{{\VRoute::get("search")}}" method="get" class="form-search-mobile relative" accept-charset="utf-8">
            <button type="submit" class="btn btn-orange absolute top-0 left-0 h-full inline-flex items-center justify-center p-2 px-3 rounded bg-gradient-to-r from-[#F44336] to-[#C62828] text-white">
                <i class="fa fa-search" aria-hidden="true"></i>
            </button>
            <input type="text" name="q" placeholder="Nhập từ khoá tìm kiếm ..." class="form-control w-full py-2 px-4 outline-none border-[1px] border-solid border-[#ebebeb] rounded-lg pl-12">
        </form>
    </div>
</header>
<!DOCTYPE html>
<html itemscope="" itemtype="http://schema.org/WebPage" lang="vi">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {!! SEOHelper::HEADER_SEO(@$currentItem ? $currentItem : null) !!}
    <link rel="stylesheet" href="{{ Support::asset('theme/frontend/css/animate.min.css')}}"/>
    <link rel="stylesheet" href="{{ Support::asset('theme/frontend/css/font-awesome.min.css')}}"/>
    <link rel="stylesheet" href="{{ Support::asset('theme/frontend/css/swiper-bundle.min.css')}}"/>
    <link rel="stylesheet" href="{{ Support::asset('theme/frontend/css/lightbox.css')}}"/>
    <link rel="stylesheet" href="{{ Support::asset('theme/frontend/css/main.css')}}"/>
    <link rel="stylesheet" href="{{ Support::asset('theme/frontend/css/toastify.css')}}"/>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'Averta': ['"Averta"'],
                    },
                    screens: {
                        'sm': '576px',
                        'md': '768px',
                        'lg': '1024px',
                        'xl': '1280px',
                        '2xl': '1408px',

                    },
                    container: {
                        center: true,
                    },
                }
            }
        }
    </script>
    @yield('cssl')
    @yield('css')
    <script type="text/javascript">
        var showNotify = "";
        var messageNotify = "{{ Session::get('messageNotify', '') }}";
        var typeNotify = "{{ Session::get('typeNotify', '') }}";
        var typePopup = "{{ Session::get('type', '') }}";
        var emailSocial = "{{ Session::get('emailSocial', '') }}";
        var auth = "{{ Session::get('auth', '') }}";
        var redirect = "{{ Session::get('redirect', '') }}";
    </script>
    {[CMS_HEADER]}
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'Averta': ['"Averta"'],
                    },
                    screens: {
                        'sm': '576px',
                        'md': '768px',
                        'lg': '1024px',
                        'xl': '1280px',
                        '2xl': '1408px',

                    },
                    container: {
                        center: true,
                    },
                }
            }
        }
    </script>
</head>
<body class="wrapper mx-auto xxl:text-[16px] sm:text-[14px] text-[12px] text-[#454545] leading-snug overflow-x-hidden bg-[#EEEAEA]">
    @include('layouts.header')
    @yield('main')
    @include('layouts.footer')
    {[CMS_FOOTER]}
    <script src="theme/frontend/tech5s_js/tech5s_base.min.js" defer></script>
    <script src="theme/frontend/tech5s_js/libraries/Tech.js" defer></script>
    <script src="theme/frontend/tech5s_js/libraries/BackToTop.js" defer></script>
    <script src="theme/frontend/js/wow.min.js" defer></script>
    <script src="theme/frontend/js/fslightbox.js" defer></script>
    <script src="theme/frontend/js/swiper-bundle.min.js" defer></script>
    <script src="theme/frontend/js/tabs.js" defer></script>
    <script src="{{ Support::asset('theme/frontend/js/xhr.js') }}" defer></script>
    <script src="{{ Support::asset('theme/frontend/js/validator.js') }}" defer></script>
    <script src="{{ Support::asset('theme/frontend/js/toastify.js') }}" defer></script>
    <script src="{{ Support::asset('theme/frontend/tech5s_js/tech5s_base.min.js') }}" defer></script>
    <script src="{{ Support::asset('theme/frontend/tech5s_js/libraries/Tech.js') }}" defer></script>
    <script src="{{ Support::asset('theme/frontend/tech5s_js/libraries/BackToTop.js') }}" defer></script>
    <script src="{{ Support::asset('theme/frontend/js/wow.min.js') }}" defer></script>
    <script src="{{ Support::asset('theme/frontend/js/fslightbox.js') }}" defer></script>
    <script src="{{ Support::asset('theme/frontend/js/swiper-bundle.min.js') }}" defer></script>
    <script src="{{ Support::asset('theme/frontend/js/tabs.js') }}" defer></script>
    @yield('jsl')
    <script src="{{ Support::asset('theme/frontend/js/base.js') }}" defer></script>
    <script src="{{ Support::asset('theme/frontend/js/cart.js') }}" defer></script>
    <script src="{{ Support::asset('theme/frontend/js/slider.js') }}" defer></script>
    <script src="{{ Support::asset('theme/frontend/js/script.js') }}" defer></script>
    @yield('js')
    <script src="{{ Support::asset('theme/frontend/js/add/script.js') }}" defer></script>
</body>

</html>

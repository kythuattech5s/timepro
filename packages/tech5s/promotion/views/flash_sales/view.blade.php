@extends('tp::master')
@section('tp_css')
    <link rel="stylesheet" type="text/css" href="{'admin/promotion/assets/plugins/pg-calendar/css/pignose.calendar.min.css'}">
    <link rel="stylesheet" href="{'admin/promotion/assets/css/flash_sales.css'}">
    @yield('tp_css_end')
@endsection
@section('tp_main')
    @yield('tp_content')
@endsection
@section('tp_js')
    <script src="{'admin/promotion/assets/js/Promotion.js'}" defer></script>
    <script src="{'admin/promotion/assets/js/FlashSale.js'}" defer></script>
    <script src = "{'admin/promotion/assets/plugins/moment/moment.min.js'}" defer></script>
    <script src="{'admin/promotion/assets/plugins/pg-calendar/js/pignose.calendar.full.min.js'}" defer></script>
    @yield('tp_js_end')
@endsection 
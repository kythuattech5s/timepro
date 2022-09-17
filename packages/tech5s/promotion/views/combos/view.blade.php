@extends('tp::master')
@section('tp_css')
    <link rel="stylesheet" href="{'admin/promotion/assets/css/base.css'}">
    <link rel="stylesheet" href="{'admin/promotion/assets/css/combo.css'}">
    @yield('tp_css_end')
@endsection
@section('tp_main')
    @yield('tp_content')
@endsection
@section('tp_js')
    <script src="{'admin/promotion/assets/js/Promotion.js'}" defer></script>
    <script src="{'admin/promotion/assets/js/Combo.js'}" defer></script>
    @yield('tp_js_end')
@endsection 
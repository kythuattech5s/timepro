@extends('vh::master')
@section('start_css')
    <link rel="stylesheet" href="{'assets/promotion/voucher/css/style.css'}">
    <link rel="stylesheet" href="{'assets/promotion/voucher/css/base.css'}">
@endsection
@section('css')
    <link rel="stylesheet" href="{'assets/css/Checkbox.css'}">
    @yield('tp_css')
@endsection
@section('content')
    @yield('tp_main')
@endsection
@section('js')
    <script src="{'assets/js/ValidateForm.js'}" defer></script>
    <script src="{'assets/js/XHR.js'}" defer></script>
    <script src="{'assets/js/Storage.js'}" defer></script>
    <script src="{'assets/js/Checkbox.js'}" defer></script>
    <script src="{'assets/js/FormData.js'}" defer></script>
    <script type="module" src="{'assets/promotion/voucher/js/voucher.js'}" defer></script>
@endsection
